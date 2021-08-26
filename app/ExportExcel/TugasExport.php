<?php

namespace App\ExportExcel;

use DB;
use App\Surattugas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class TugasExport implements FromView, WithEvents, ShouldAutoSize
{

    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $bulan = $this->bulan;
        $tahun =  $this->tahun;
        if($tahun == "" && $bulan == ""){
            $penugasan = Surattugas::all()
                ->unique('no_surat');
        }else{
            $penugasan = Surattugas::whereMonth('tgl_kembali',$bulan)
                ->whereYear('tgl_kembali',$tahun)
                ->get()
                ->unique('no_surat');
        }
        return view('penugasan.tugas.rekap.tugas_excel', [
            'penugasan' => $penugasan,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W100'; // All headers
                $event->sheet->getDelegate()->getStyle('A1:I1')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $styleHeader = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
                $event->sheet->getStyle('A3:I3')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A4:I4')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A5:I3000')->applyFromArray($styleHeader);
            }
        ];
    }


}