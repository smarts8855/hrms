<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateFileFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:create-folders';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create folders on Desktop using file numbers from tblper';


    /**
     * Execute the console command.
     *
     * @return int
     */
    // public function handle()
    // {
    //     $desktop = env('USERPROFILE') . '\\Desktop\\Adams';

    //     File::ensureDirectoryExists($desktop);

    //     $numbers = DB::table('tblper')->pluck('fileno');

    //     foreach ($numbers as $no) {
    //         File::ensureDirectoryExists($desktop . '\\' . $no);
    //     }

    //     $this->info('Folders created successfully.');
    // }

    public function handle()
    {
        $desktop = rtrim(env('USERPROFILE'), '\\') . '\\Desktop\\Adams';

        // Create base folder
        File::ensureDirectoryExists($desktop);

        // Get grade + fileNo
        $records = DB::table('tblper')
            ->select('grade', 'fileNo')
            ->whereNotNull('grade')
            ->whereNotNull('fileNo')
            ->get();

        foreach ($records as $row) {

            // Grade folder (e.g. Adams/17)
            $gradePath = $desktop . '\\' . $row->grade;
            File::ensureDirectoryExists($gradePath);

            // File folder inside grade (e.g. Adams/17/4749)
            $filePath = $gradePath . '\\' . $row->fileNo;
            File::ensureDirectoryExists($filePath);
        }

        $this->info('Folders created: Adams/{grade}/{fileNo}');
    }
}
