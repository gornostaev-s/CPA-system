<?php

namespace App\Utils;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporterUtil
{
    private array $data;
    private ?array $headers = null;
    private const COLUMN_MAP = [
        0 => 'A',
        1 => 'B',
        2 => 'C',
        3 => 'D',
        4 => 'E',
        5 => 'F',
        6 => 'G',
        7 => 'H',
        8 => 'I',
        9 => 'J',
        10 => 'K',
    ];

    public function __construct()
    {
    }

    /**
     * @param string $filename
     * @param $type
     * @return void
     */
    private function enableHeaders(string $filename, $type = 'xlsx'): void
    {
        if ($type === 'xlsx') {
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=$filename");
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $fileName
     * @param string $type
     * @return bool|string
     * @throws Exception
     */
    public function export(string $fileName, string $type = 'xlsx'): bool|string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $res = [];

        if (!empty($this->header)) {
            $res[] = $this->headers;
        }

        $this->prepareData($sheet, array_merge($res, $this->data));


        $writer = new Xlsx($spreadsheet);
        $this->enableHeaders($fileName, $type);
        $writer->save('php://output');

        return file_get_contents('php://output');
    }

    private function prepareData(Worksheet $sheet, array $rows)
    {
        foreach ($rows as $key => $row) {
            $this->prepareRow($sheet, $row, $key);
        }
    }

    private function prepareRow(Worksheet $sheet, array $row, int $rowIndex)
    {
        foreach ($row as $i => $col) {
            $sheet->setCellValue(self::COLUMN_MAP[$i] . $rowIndex, $col);
        }
    }
}