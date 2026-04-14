<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class S3UploadController extends Controller
{

    public function generate(Request $request)
    {
        $request->validate([
            'files' => 'required|array'
        ]);

        // Log::info($request->all());

        $disk = Storage::disk('s3');

        $results = [];

        // Use input() instead of files()
        $files = $request->input('files', []);


        foreach ($files as $file) {

            // Log::info($file['type']);
            // Determine folder
            $folder = $file['fieldType'] === 'education'
                ? 'CertificatesHeld'
                : 'staffattachments';

            $key = $folder . '/' . Str::uuid() . '-' . $file['name'];

            // Generate presigned URL
            $client = $disk->getDriver()->getAdapter()->getClient(); // 👈 correct way
            $command = $client->getCommand('PutObject', [
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $key,
                // 'ACL' => 'public-read',
                'ContentType' => $file['type'] ?? 'application/octet-stream',
            ]);

            $presignedRequest = $client->createPresignedRequest($command, '+10 minutes');

            // Full public URL
            $fullUrl = $disk->url($key);

            $results[] = [
                'uploadUrl' => (string) $presignedRequest->getUri(),
                'fileUrl' => $fullUrl,
            ];
        }


        // Log::info($results);
        // dd(56789);
        return response()->json($results);
    }
}
