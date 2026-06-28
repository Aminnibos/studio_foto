<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $output = [];
        foreach ($this->data as $row) {
            $output[] = [
                $row['no'],
                $row['nota'],
                $row['pelanggan'],
                $row['paket'],
                $row['tanggal'],
                $row['metode'],
                $row['jumlah']
            ];
        }
        return $output;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Nota',
            'Nama Pelanggan',
            'Paket Pilihan',
            'Tanggal Selesai',
            'Metode Bayar',
            'Jumlah Uang (Rp)'
        ];
    }

    public function title(): string
    {
        return 'Laporan Pendapatan';
    }
}