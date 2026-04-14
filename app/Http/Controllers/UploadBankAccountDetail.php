<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploadHelper;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UploadBankAccountDetail extends Controller
{

    public function uploadStaffBankDetails(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // $path = $request->file('file')->getRealPath();
        // $data = Excel::toArray([], $path)[0];
        // ✔ FIX: load file directly
        $data = Excel::toArray([], $request->file('file'))[0];

        unset($data[0]); // remove header

        $updated = 0;
        $errors = [];

        foreach ($data as $row) {

            $fileNo        = trim($row[1]);
            $employeeName  = trim($row[2]);
            $bankName      = trim($row[3]);
            $accountNumber = trim($row[4]);

            if (!$fileNo || !$accountNumber || !$bankName) {
                $errors[] = "Missing data for file no: {$fileNo}";
                continue;
            }

            // 🔥 Normalize Excel bank name
            $bankNameNormalized = strtoupper(trim($bankName));

            // 🔍 FIND STAFF IN tblper
            $staff = DB::table('tblper')->where('fileno', $fileNo)->first();

            if (!$staff) {
                Log::info("Staff not found for file number: " . $fileNo);
                continue;
            }

            // 🔍 FIND bankID with normalized search
            $bank = DB::table('tblbanklist')
                ->whereRaw("UPPER(bank) LIKE ?", ["%{$bankNameNormalized}%"])
                ->orWhereRaw("UPPER(bank_abbr) LIKE ?", ["%{$bankNameNormalized}%"])
                ->first();

            if (!$bank) {
                Log::info("Bank not found for: {$bankNameNormalized} (file no: {$fileNo})");
                continue;
            }

            // ✅ UPDATE tblper
            DB::table('tblper')
                ->where('fileno', $fileNo)
                ->update([
                    'AccNo'  => $accountNumber,
                    'bankID' => $bank->bankID
                ]);

            $updated++;
        }

        return response()->json([
            'success' => true,
            'updated_records' => $updated,
            'errors' => $errors
        ]);
    }

    public function checkStaffGradeStep(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Load Excel
        $data = Excel::toArray([], $request->file('file'))[0];

        // Remove header row
        unset($data[0]);

        $mismatches = [];

        foreach ($data as $row) {
            $fileNo = trim($row[1]);   // STAFF FILE NO
            $grade  = trim($row[4]);   // GRADE
            $step   = trim($row[5]);   // STEP
            // Fetch staff from DB
            $staff = DB::table('tblper')->where('fileno', $fileNo)->first();

            if (!$fileNo || !$grade || !$step) {
                // Log::info("Missing data for row: " . json_encode($row));
                $mismatches[] = [
                    'file_number' => $fileNo ?: '(empty)',
                    'staff_name' => null, // no name
                    'excel_grade' => $grade,
                    'excel_step' => $step,
                    'db_grade' => null,
                    'db_step' => null,
                    'issue' => 'Missing data in Excel'
                ];
                continue;
            }

            if (!$staff) {
                // Log::info("File number not found: {$fileNo}");
                $mismatches[] = [
                    'file_number' => $fileNo,
                    'staff_name' => null, // no name
                    'excel_grade' => $grade,
                    'excel_step' => $step,
                    'db_grade' => null,
                    'db_step' => null,
                    'issue' => 'File number not found in DB'
                ];
                continue;
            }

            // Adjust these field names to match your DB column names
            $dbGrade = $staff->grade;
            $dbStep  = $staff->step;

            // Compare grade and step
            if ($dbGrade != $grade || $dbStep != $step) {
                // Log::info("Mismatch for file number {$fileNo}: Excel(Grade: {$grade}, Step: {$step}) vs DB(Grade: {$staff->grade}, Step: {$staff->step})");
                $mismatches[] = [
                    'file_number' => $fileNo,
                    'staff_name' => $staff->surname . ' ' . $staff->first_name . ' ' . $staff->othernames, // 👈 ADD NAME
                    'excel_grade' => $grade,
                    'excel_step' => $step,
                    'db_grade' => $dbGrade,
                    'db_step' => $dbStep,
                    'issue' => 'Grade/Step mismatch'
                ];
            }
        }

        // Optionally, save mismatches as JSON for review
        $fileName = 'storage/staff_mismatches/mismatches_' . now()->format('Y_m_d_His') . '.json';
        if (!empty($mismatches)) {
            Storage::makeDirectory('staff_mismatches');
            Storage::put($fileName, json_encode($mismatches, JSON_PRETTY_PRINT));
        }

        // Return the view with mismatches
        return view('grade-and-step-check', [
            'mismatches' => $mismatches,
            'total_checked' => count($data),
            'json_file' => $fileName
        ]);
        return response()->json([
            'success' => true,
            'total_checked' => count($data),
            'total_mismatches' => count($mismatches),
            'json_file' => count($mismatches) ? $fileName : null
        ]);
    }


    public function compareFileNoAndGradeOLD(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Load Excel (Sheet 3 = index 2)
        $excelData = Excel::toArray([], $request->file('file'))[0];

        unset($excelData[2]); // Remove header

        // Excel lists
        $excelFileNos = [];
        $excelGrades = [];

        foreach ($excelData as $row) {
            $fileNo = trim($row[2]); // File Number
            $grade  = trim($row[3]); // Grade

            if ($fileNo) {
                $excelFileNos[] = $fileNo;
                // $excelGrades[$fileNo] = $grade;
                $excelGrades[$fileNo] = $this->normalizeGrade($grade);
            }
        }

        // Fetch staff from DB
        $dbStaff = DB::table('tblper')
            ->select('fileno', 'grade', 'surname', 'first_name', 'othernames')
            ->where("rank", '<>', 2)
            ->get();

        $dbFileNos = $dbStaff->pluck('fileno')->toArray();
        $dbGrades = $dbStaff->pluck('grade', 'fileno')->toArray();

        // Result arrays
        $missingInExcel = [];
        $missingInDb = [];
        $gradeMismatchDbVsExcel = [];

        // Staff in DB but not in Excel, and mismatched grades
        foreach ($dbStaff as $staff) {
            $fileNo = $staff->fileno;
            // $dbGrade = trim($staff->grade);
            $dbGrade = $this->normalizeGrade($staff->grade);
            $fullName = $staff->surname . ' ' . $staff->first_name . ' ' . $staff->othernames;

            if (!in_array($fileNo, $excelFileNos)) {
                $missingInExcel[] = [
                    'file_number' => $fileNo,
                    'db_grade' => $dbGrade,
                    'name' => trim($fullName)
                ];
            } else {
                $excelGrade = $excelGrades[$fileNo];

                if ($excelGrade != $dbGrade) {
                    $gradeMismatchDbVsExcel[] = [
                        'file_number' => $fileNo,
                        'db_grade' => $dbGrade,
                        'excel_grade' => $excelGrade,
                        'name' => trim($fullName)
                    ];
                }
            }
        }

        // Staff in Excel but not in DB
        foreach ($excelFileNos as $fileNo) {
            if (!in_array($fileNo, $dbFileNos)) {
                $missingInDb[] = [
                    'file_number' => $fileNo,
                    'excel_grade' => $excelGrades[$fileNo],
                ];
            }
        }

        return view('cr-excel-check', [
            'missingInExcel' => $missingInExcel,
            'missingInDb' => $missingInDb,
            'gradeMismatchDbVsExcel' => $gradeMismatchDbVsExcel,
            'total_excel' => count($excelFileNos),
            'total_db' => count($dbFileNos)
        ]);
    }

    private function normalizeGrade($grade)
    {
        if (!$grade) return '';

        $grade = trim($grade);

        // Remove ONLY leading O or o
        if (strtoupper(substr($grade, 0, 1)) === 'O') {
            $grade = substr($grade, 1);
        }

        // Remove leading zeros: 09 → 9, 007 → 7
        $grade = ltrim($grade, '0');

        // If result is empty (e.g., "O0" or "00") return "0"
        if ($grade === '') {
            return '0';
        }

        return $grade;
    }



    public function compareFileNoAndGrade(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Load Excel
        $excelData = Excel::toArray([], $request->file('file'))[0];

        unset($excelData[2]); // Remove header

        $excelFileNos = [];
        $excelGrades = [];

        foreach ($excelData as $row) {
            $fileNo = trim($row[2]);
            $grade  = trim($row[3]);

            if ($fileNo) {
                $excelFileNos[] = $fileNo;
                $excelGrades[$fileNo] = $this->normalizeGrade($grade);
            }
        }

        // Fetch database staff
        $dbStaff = DB::table('tblper')
            ->select('fileno', 'grade', 'surname', 'first_name', 'othernames')
            ->where("rank", '<>', 2)
            ->get();

        $dbFileNos = $dbStaff->pluck('fileno')->toArray();

        // Final merged result (ONE TABLE ONLY)
        $merged = [];

        // =============================
        // 1. Staff in DB
        // =============================
        foreach ($dbStaff as $staff) {
            $fileNo   = $staff->fileno;
            $dbGrade  = $this->normalizeGrade($staff->grade);
            $fullName = trim($staff->surname . ' ' . $staff->first_name . ' ' . $staff->othernames);

            if (!in_array($fileNo, $excelFileNos)) {
                // DB but not in Excel → RED
                $merged[] = [
                    'file_no'     => $fileNo,
                    'name'        => $fullName,
                    'db_grade'    => $dbGrade,
                    'excel_grade' => null,
                    'status'      => 'missing_in_excel'
                ];
            } else {
                $excelGrade = $excelGrades[$fileNo];

                if ($excelGrade != $dbGrade) {
                    // Grade mismatch → ORANGE
                    $merged[] = [
                        'file_no'     => $fileNo,
                        'name'        => $fullName,
                        'db_grade'    => $dbGrade,
                        'excel_grade' => $excelGrade,
                        'status'      => 'grade_mismatch'
                    ];
                } else {
                    // Perfect match → WHITE
                    $merged[] = [
                        'file_no'     => $fileNo,
                        'name'        => $fullName,
                        'db_grade'    => $dbGrade,
                        'excel_grade' => $excelGrade,
                        'status'      => 'match'
                    ];
                }
            }
        }

        // =============================
        // 2. Staff in Excel but NOT in DB → GREEN
        // =============================
        foreach ($excelFileNos as $fileNo) {
            if (!in_array($fileNo, $dbFileNos)) {
                $merged[] = [
                    'file_no'     => $fileNo,
                    'name'        => '(NOT FOUND IN DB)',
                    'db_grade'    => null,
                    'excel_grade' => $excelGrades[$fileNo],
                    'status'      => 'missing_in_db'
                ];
            }
        }

        // =============================
        // Sort by DB grade (numeric)
        // =============================
        // =============================
        // Sort by DB grade (numeric) DESCENDING
        // =============================
        usort($merged, function ($a, $b) {
            return intval($b['db_grade']) <=> intval($a['db_grade']);
        });

        // Save merged data in session for PDF
        session(['merged_table' => $merged]);

        return view('cr-excel-check', [
            'merged' => $merged,
        ]);
    }


    public function exportPdf()
    {
        $merged = session('merged_table', []);

        if (empty($merged)) {
            return redirect()->back()->with('error', 'Please upload Excel and search first.');
        }

        $pdf = \PDF::loadView('cr-excel-check-pdf', compact('merged'))
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'logOutputFile' => storage_path('logs/dompdf.log')]);


        return $pdf->download('excel_vs_db.pdf');
    }

    public function compareFileNoAndGrade22(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Load Excel
        $excelData = Excel::toArray([], $request->file('file'))[0];
        unset($excelData[2]); // Remove header

        $excelFileNos = [];
        $excelGrades = [];

        foreach ($excelData as $row) {
            $fileNo = trim($row[2]);
            $grade  = trim($row[3]);

            if ($fileNo) {
                $excelFileNos[] = $fileNo;
                $excelGrades[$fileNo] = $this->normalizeGrade($grade);
            }
        }

        // Fetch database staff
        $dbStaff = DB::table('tblper')
            ->select('fileno', 'grade', 'surname', 'first_name', 'othernames')
            ->where("rank", '<>', 2)
            ->get();

        $dbFileNos = $dbStaff->pluck('fileno')->toArray();

        // Only problematic records
        $issues = [];

        // 1. Staff in DB but not in Excel OR grade mismatch
        foreach ($dbStaff as $staff) {
            $fileNo   = $staff->fileno;
            $dbGrade  = $this->normalizeGrade($staff->grade);
            $fullName = trim($staff->surname . ' ' . $staff->first_name . ' ' . $staff->othernames);

            if (!in_array($fileNo, $excelFileNos)) {
                // Missing in Excel → RED
                $issues[] = [
                    'file_no'     => $fileNo,
                    'name'        => $fullName,
                    'db_grade'    => $dbGrade,
                    'excel_grade' => null,
                    'status'      => 'missing_in_excel'
                ];
            } else {
                $excelGrade = $excelGrades[$fileNo];
                if ($excelGrade != $dbGrade) {
                    // Grade mismatch → ORANGE
                    $issues[] = [
                        'file_no'     => $fileNo,
                        'name'        => $fullName,
                        'db_grade'    => $dbGrade,
                        'excel_grade' => $excelGrade,
                        'status'      => 'grade_mismatch'
                    ];
                }
            }
        }

        // 2. Staff in Excel but NOT in DB → GREEN
        foreach ($excelFileNos as $fileNo) {
            if (!in_array($fileNo, $dbFileNos)) {
                $issues[] = [
                    'file_no'     => $fileNo,
                    'name'        => '(NOT FOUND IN DB)',
                    'db_grade'    => null,
                    'excel_grade' => $excelGrades[$fileNo],
                    'status'      => 'missing_in_db'
                ];
            }
        }

        // Sort by DB grade descending (nulls last)
        usort($issues, function ($a, $b) {
            return intval($b['db_grade'] ?? 0) <=> intval($a['db_grade'] ?? 0);
        });

        // Save issues in session for PDF export
        session(['merged_table' => $issues]);

        return view('cr-excel-check', [
            'merged' => $issues,
        ]);
    }


    /**
     * Show the UI
     */
    public function create()
    {
        // If you have education categories, load them here
        $categories = DB::table('tbleducation_category')->get();

        return view('staff.education.create', compact('categories'));
    }

    /**
     * 🔍 Search staff by File Number (AJAX)
     */
    public function searchByFileNo(Request $request)
    {
        $request->validate([
            'fileNo' => 'required'
        ]);

        $staff = DB::table('tblper')
            ->where('fileNo', $request->fileNo)
            ->first();

        if (!$staff) {
            return response()->json([
                'status' => false,
                'message' => 'Staff not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $staff
        ]);
    }


    /**
     * 💾 Save Education & Attachments
     */
    public function storeOLD(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|integer',

            // Education validation
            'educations' => 'nullable|array',
            'educations.*.categoryID' => 'nullable',
            'educations.*.degreequalification' => 'nullable|string',
            'educations.*.schoolattended' => 'nullable|string',

            // Attachment validation
            'attachments' => 'nullable|array',
            'attachments.*.filedesc' => 'nullable|string',
            'attachments.*.filepath' => 'nullable|file|max:5120',
        ]);

        DB::beginTransaction();

        // Log::info($request->all());
        try {

            $educations = collect($request->input('educations', []))
                ->filter(function ($edu) {
                    return collect($edu)->filter(function ($value) {
                        return !is_null($value) && $value !== '';
                    })->isNotEmpty();
                });

            if ($educations->isNotEmpty()) {
                // Save Education Records
                foreach ($request->educations as $index => $edu) {

                    // Check if this category already exists for this staff
                    // Check if this category already exists for this staff
                    // $exists = DB::table('tbleducations')
                    //     ->where('staffid', $request->staff_id)
                    //     ->where('categoryID', $edu['categoryID'])
                    //     ->exists();

                    // if ($exists) {
                    //     // Fetch category name for descriptive error
                    //     $category = DB::table('tbleducation_category')
                    //         ->where('edu_categoryID', $edu['categoryID'])
                    //         ->value('category');

                    //     DB::rollBack();
                    //     return redirect()->back()->with(
                    //         'error',
                    //         "Education category '{$category}' already exists for this staff."
                    //     );
                    // }

                    $documentPath = null;

                    if ($request->hasFile("educations.$index.document")) {
                        $file = $request->file("educations.$index.document");
                        $customName = $this->RefNo() . '.' . $file->getClientOriginalExtension();
                        $documentPath = FileUploadHelper::upload($file, 'CertificatesHeld', $customName);
                    }

                    DB::table('tbleducations')->insert([
                        'fileNo'              => $request->file_no ?? null,
                        'staffid'             => $request->staff_id,
                        'categoryID'          => $edu['categoryID'],
                        'degreequalification' => $edu['degreequalification'],
                        'schoolattended'      => $edu['schoolattended'],
                        'schoolfrom'          => $edu['schoolfrom'] ?? null,
                        'schoolto'            => $edu['schoolto'] ?? null,
                        'certificateheld'     => $edu['certificateheld'] ?? null,
                        'document'            => $documentPath,
                        'checkededucation'    => 0,
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ]);
                }
            }

            // Save Attachments
            if ($request->has('attachments')) {
                foreach ($request->attachments as $index => $att) {

                    if ($request->hasFile("attachments.$index.filepath")) {
                        $file = $request->file("attachments.$index.filepath");
                        $customName = $this->RefNo() . '.' . $file->getClientOriginalExtension();
                        $filePath = FileUploadHelper::upload($file, 'staffattachments', $customName);

                        DB::table('tblstaffAttachment')->insert([
                            'staffID'  => $request->staff_id,
                            'filedesc' => $att['filedesc'] ?? null,
                            'filepath' => $filePath,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Staff education and attachments saved successfully');
        } catch (\Exception $e) {

            Log::info($e->getMessage());
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Error saving records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|integer',

            'attachments.*.filepath' => 'nullable|string',
            'educations.*.document' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            /*
        |------------------------------------------
        | EDUCATION
        |------------------------------------------
        */
        // log::info($request->all());

            $educations = collect($request->input('educations', []))
                ->filter(
                    fn($edu) =>
                    collect($edu)->filter(fn($v) => !is_null($v) && $v !== '')->isNotEmpty()
                );

            if ($educations->isNotEmpty()) {

                foreach ($educations as $edu) {

                    DB::table('tbleducations')->insert([
                        'fileNo'              => $request->file_no ?? null,
                        'staffid'             => $request->staff_id,
                        'categoryID'          => $edu['categoryID'] ?? null,
                        'degreequalification' => $edu['degreequalification'] ?? null,
                        'schoolattended'      => $edu['schoolattended'] ?? null,
                        'schoolfrom'          => $edu['schoolfrom'] ?? null,
                        'schoolto'            => $edu['schoolto'] ?? null,
                        'certificateheld'     => $edu['certificateheld'] ?? null,

                        // ✅ Already uploaded to S3
                        'document'            => $edu['document'] ?? null,

                        'checkededucation'    => 0,
                        'created_at'          => now(),
                        'updated_at'          => now(),
                    ]);
                }
            }

            /*
        |------------------------------------------
        | ATTACHMENTS
        |------------------------------------------
        */

            $attachments = collect($request->input('attachments', []))
                ->filter(fn($att) => !empty($att['filepath']));

            if ($attachments->isNotEmpty()) {

                foreach ($attachments as $att) {

                    DB::table('tblstaffAttachment')->insert([
                        'staffID'  => $request->staff_id,
                        'filedesc' => $att['filedesc'] ?? null,

                        // ✅ S3 KEY ONLY
                        'filepath' => $att['filepath'],
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Staff education and attachments saved successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error($e);

            return redirect()
                ->back()
                ->with('error', 'Error saving records.');
        }
    }



    public function RefNo()
    {
        $alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        //$Reference= $initcode . implode($pass);
        return implode($pass);
    }
}
