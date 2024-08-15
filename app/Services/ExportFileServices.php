<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class ExportServices
{
    /**
     * Generates a CSV file and emails it as an attachment.
     *
     * @param  array  $headers  The CSV header row.
     * @param  array  $data  The array of data for CSV rows.
     * @param  string  $filename  The filename for the CSV file.
     * @param  string  $recipient  The email recipient's address.
     * @return void
     */
    public function sendCSVByEmail(array $headers, array $data, string $filename, string $recipient)
    {
        // Open a memory stream
        $handle = fopen('php://memory', 'r+');

        // Add the header row
        fputcsv($handle, $headers);

        // Add the data rows
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        // Rewind the file pointer
        rewind($handle);

        // Capture the CSV output as a string
        $csvContent = stream_get_contents($handle);

        // Close the memory stream
        fclose($handle);

        // Send the CSV as an email attachment
        Mail::raw('Please find the attached CSV file.', function ($message) use ($recipient, $csvContent, $filename) {
            $message->to($recipient)
                ->subject('CSV Export')
                ->attachData($csvContent, $filename, [
                    'mime' => 'text/csv',
                ]);
        });
    }
}
