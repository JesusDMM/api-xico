<?php

// composer require barryvdh/laravel-dompdf
namespace App\Classes;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class GeneratePDFClass
{
    public static function generatePdf($data)
    {
        $htmlContent = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <title></title>
                <style>
                </style>
            </head>
            <body>

            </body>
            </html>";

        $pdf = Pdf::loadHTML($htmlContent);
        $filename = "file.pdf";
        $filename = Str::ascii($filename);
        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
