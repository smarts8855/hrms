<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackController extends Controller
{
    public function verifyAccount(Request $request)
    {
        $accountNumber = $request->account_number;
        $bankCode = $request->bank_code;



        // Make the API request to Paystack
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('app.paystack_secret_key'),
            ])->get("https://api.paystack.co/bank/resolve", [
                'account_number' => $accountNumber,
                'bank_code' => $bankCode,
            ]);

            // Log::info('paystack_secret_key Data: ' . config('app.paystack_secret_key'));
            // Log::info('Paystack Response: ' . $response->body());

            // If Paystack returns a valid response
            if ($response->successful() && isset($response->json()['data'])) {
                return response()->json([
                    'account_name' => $response->json()['data']['account_name'],
                    'status' => true,
                ]);
            }

            return response()->json(['message' => 'Unable to verify account details'], 400);
        } catch (\Exception $e) {
            Log::info('Paystack API Error: ' . $e->getMessage());
            // Handle errors, such as failed request
            return response()->json(['message' => 'Something went wrong. Please try again later.'], 500);
        }
    }
}
