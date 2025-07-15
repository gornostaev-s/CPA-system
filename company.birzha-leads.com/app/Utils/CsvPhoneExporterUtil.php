<?php

declare(strict_types=1);

namespace App\Utils;

class CsvPhoneExporterUtil
{
    public function appendPhonesToFile(array $phones, string $filePath): void
    {
        foreach ($phones as $phone) {
            file_put_contents($filePath, "$phone,\n", FILE_APPEND);
        }
    }

    public function getFileContent(string $filePath): string
    {
        return file_get_contents($filePath);
    }

    public function enableHeaders(string $fileName): void
    {
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment;filename=$fileName");
    }
}