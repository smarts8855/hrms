<?php
// app/Mail/ContractLetterMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContractLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contract;
    public $letter;
    public $letterType;
    public $contractor;

    public function __construct($contract, $letter, $letterType, $contractor)
    {
        $this->contract = $contract;
        $this->letter = $letter;
        $this->letterType = $letterType;
        $this->contractor = $contractor;
    }

    public function build()
    {
        $subject = $this->letterType == 'recommendation' 
            ? 'Recommendation Letter for Contract ' . $this->contract->contract_name
            : 'Award Letter for Contract ' . $this->contract->contract_name;

        Log::info('Building email for letter ID: ' . ($this->letter->letter_id ?? 'unknown'));

        $email = $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($subject)
            ->view('emails.contract_letter')
            ->with([
                'contractorName' => $this->contractor->company_name ?? $this->contractor->contact_person,
                'contractName' => $this->contract->contract_name,
                'lotNumber' => $this->contract->lot_number,
                'letterType' => $this->letterType,
                'awardedAmount' => $this->contract->awarded_amount,
                'date' => now()->format('d M, Y'),
                'contractId' => $this->contract->contract_biddingID,
                'letter' => $this->letter
            ]);

        // CORRECT PATH BASED ON YOUR FILE STRUCTURE
        if ($this->letter && !empty($this->letter->file_name)) {
            // Files are in public/uploads/letters/{type}/filename
            $filePath = public_path('uploads/letters/' . $this->letter->letter_type . '/' . $this->letter->file_name);
            
            Log::info('Checking path: ' . $filePath);
            
            if (file_exists($filePath)) {
                Log::info('File found, attaching...');
                
                $email->attach($filePath, [
                    'as' => $this->letter->original_file_name ?: $this->letter->file_name,
                    'mime' => mime_content_type($filePath)
                ]);
                
                Log::info('File attached successfully');
            } else {
                Log::error('File NOT found at: ' . $filePath);
                
                // Try without the type subfolder as fallback
                $fallbackPath = public_path('uploads/letters/' . $this->letter->file_name);
                if (file_exists($fallbackPath)) {
                    $email->attach($fallbackPath, [
                        'as' => $this->letter->original_file_name ?: $this->letter->file_name,
                        'mime' => mime_content_type($fallbackPath)
                    ]);
                    Log::info('File attached from fallback path');
                }
            }
        }

        return $email;
    }
}           