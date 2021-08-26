<?php

namespace App\ExportExcel;

use DB;
use App\Pegawai;
use App\Periode;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class PresensiAllExport implements FromView, WithEvents, ShouldAutoSize
{

    protected $id_tipe, $tgl_awal, $tgl_akhir;

    public function __construct($id_tipe, $tgl_awal, $tgl_akhir)
    {
        $this->id_tipe = $id_tipe;
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        $pegawai = Pegawai::join('tipe_pegawai','tipe_pegawai.id','=','pegawai.id_tipepeg')
            ->join('jabatan','jabatan.id','=','pegawai.id_jabatan')
            ->where('pegawai.id_tipepeg',$this->id_tipe)
            ->select("pegawai.*")
            ->get();
        return view('presensi.log_presensi.all_print_presensi_excel', [
            'pegawai' => $pegawai,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W100'; // All headers
                $event->sheet->getDelegate()->getStyle('A1:N1')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A1:N1')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $styleHeader = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
                $event->sheet->getStyle('A3:N3')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A4:N4')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A5:N3000')->applyFromArray($styleHeader);
            }
        ];
    }


}