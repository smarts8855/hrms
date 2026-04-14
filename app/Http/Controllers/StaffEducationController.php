<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StaffEducationController extends Controller
{

    public function staffList()
    {
        $staffs = DB::table('tblper')
            ->select('ID', 'fileNo', 'title', 'surname', 'first_name', 'othernames')
            ->orderBy('surname')
            ->get();


        return view('staff.index', compact('staffs'));
    }


    /**
     * Show staff education & attachments
     */
    public function index($staffId)
    {
        $educations = DB::table('tbleducations')
            ->join(
                'tbleducation_category',
                'tbleducation_category.edu_categoryID',
                '=',
                'tbleducations.categoryID'
            )
            ->where('tbleducations.staffid', $staffId)
            ->select(
                'tbleducations.*',
                'tbleducation_category.category'
            )
            ->get();

        $categories = DB::table('tbleducation_category')->get();

        $attachments = DB::table('tblstaffAttachment')
            ->where('staffID', $staffId)
            ->get();

        return view('staff.documents', compact(
            'staffId',
            'educations',
            'categories',
            'attachments'
        ));
    }

    /**
     * Store education (manual upload)
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|integer',
            'educations' => 'required|array',
            'educations.*.categoryID' => 'required|integer',
            'educations.*.document' => 'nullable|file|max:5120',
        ]);

        foreach ($request->educations as $index => $edu) {

            // Prevent duplicate category per staff
            $exists = DB::table('tbleducations')
                ->where('staffid', $request->staff_id)
                ->where('categoryID', $edu['categoryID'])
                ->exists();

            if ($exists) {
                return back()->with(
                    'error',
                    'This education category already exists for this staff.'
                );
            }

            $documentPath = null;

            if ($request->hasFile("educations.$index.document")) {
                $documentPath = $request
                    ->file("educations.$index.document")
                    ->store('CertificatesHeld', 'public');
            }

            DB::table('tbleducations')->insert([
                'staffid'             => $request->staff_id,
                'categoryID'          => $edu['categoryID'],
                'degreequalification' => $edu['degreequalification'] ?? null,
                'schoolattended'      => $edu['schoolattended'] ?? null,
                'schoolfrom'          => $edu['schoolfrom'] ?? null,
                'schoolto'            => $edu['schoolto'] ?? null,
                'certificateheld'     => $edu['certificateheld'] ?? null,
                'document'            => $documentPath
                    ? Storage::url($documentPath)
                    : null,
                'checkededucation'    => 0,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        return back()->with('success', 'Education saved successfully.');
    }

    /**
     * Verify education (Admin)
     */
    public function verify($educationId)
    {
        DB::table('tbleducations')
            ->where('id', $educationId)
            ->update([
                'checkededucation' => 1,
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Education verified.');
    }



    public function storeAttachment(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|integer',
            'filedesc' => 'required|string',
            'filepath' => 'required|file|max:5120',
        ]);

        $path = $request
            ->file('filepath')
            ->store('staffattachments', 'public');

        DB::table('tblstaffAttachment')->insert([
            'staffID'  => $request->staff_id,
            'filedesc' => $request->filedesc,
            'filepath' => Storage::url($path),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Attachment uploaded.');
    }
}
