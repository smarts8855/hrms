<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadScannedDocuments extends Command
{
    protected $signature = 'scan:upload';
    protected $description = 'Upload scanned documents from scanner folder to Laravel storage';

    public function handle()
    {
        $basePath = env('SCAN_BASE_PATH');

        if (!is_dir($basePath)) {
            $this->error("Scan base path not found: $basePath");
            return 1;
        }

        // Loop through staff folders
        $staffFolders = array_filter(glob($basePath . '/*'), 'is_dir');

        foreach ($staffFolders as $folder) {
            $fileNo = basename($folder);

            // Find staff ID by fileNo
            $staff = DB::table('tblper')->where('fileNo', $fileNo)->first();
            if (!$staff) {
                $this->warn("Staff with fileNo {$fileNo} not found");
                continue;
            }

            // Scan folder for new files
            $files = array_filter(glob($folder . '/*'), 'is_file');

            foreach ($files as $filePath) {
                $fileName = basename($filePath);

                // Check if file already exists in DB
                $exists = DB::table('tblstaffattachment')
                    ->where('staffID', $staff->ID)
                    ->where('filepath', 'like', "%$fileName%")
                    ->exists();

                if ($exists) {
                    continue; // skip duplicates
                }

                // Move file to storage
                $storagePath = Storage::disk('public')->putFileAs(
                    'staffattachments',
                    new \Illuminate\Http\File($filePath),
                    $fileName
                );

                // Save to database
                DB::table('tblstaffattachment')->insert([
                    'staffID' => $staff->ID,
                    'filedesc' => pathinfo($fileName, PATHINFO_FILENAME),
                    'filepath' => Storage::url($storagePath),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Optionally, move original scanned file to a processed folder
                rename($filePath, $folder . '/processed_' . $fileName);

                $this->info("Uploaded file {$fileName} for staff {$fileNo}");
            }
        }

        $this->info("Scan upload completed.");
        return 0;
    }
}
