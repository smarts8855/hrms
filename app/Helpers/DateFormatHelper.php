<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (!function_exists('formatDate')) {
    /**
     * Format any date into Day-Month-Year (e.g., 05-02-2025)
     * Returns "—" for null, empty, or invalid dates.
     *
     * @param  string|null  $date
     * @return string
     */
    function formatDate($date)
    {
        if (empty($date) || $date === '0000-00-00') {
            return '—';
        }

        try {
            return Carbon::parse($date)->format('d-m-Y');
        } catch (\Exception $e) {
            return '—'; // Return dash if parsing fails
        }
    }
}



if (!function_exists('generateSivAndSrvNo')) {
    function generateSivAndSrvNo($type)
    {
        $year = date('Y');

        $counter = DB::table('document_counters')
            ->where('document_type', $type)
            ->lockForUpdate()
            ->first();

        if (!$counter) {
            DB::table('document_counters')->insert([
                'document_type' => $type,
                'last_number' => 123, // change this to the last number they gave you
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $counter = DB::table('document_counters')
                ->where('document_type', $type)
                ->lockForUpdate()
                ->first();
        }

        $nextNumber = ((int) $counter->last_number) + 1;

        DB::table('document_counters')
            ->where('document_type', $type)
            ->update([
                'last_number' => $nextNumber,
                'updated_at' => now(),
            ]);

        return $nextNumber . '/' . $year;
    }
}

