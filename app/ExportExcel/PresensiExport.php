<?php

namespace App\ExportExcel;

use DB;
use App\Pegawai;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class PresensiExport implements FromView, WithEvents, ShouldAutoSize
{

    protected $id, $tgl_awal, $tgl_akhir;

    public function __construct($id, $tgl_awal, $tgl_akhir)
    {
        $this->id = $id;
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function view(): View
    {
        $pegawai = Pegawai::join('jabatan','jabatan.id','=','pegawai.id_jabatan')->where('id_pegawai',$this->id)->first();
        if($this->tgl_awal == "" || $this->tgl_akhir == ""){
            $log = DB::table('presensi')
                ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
                ->leftJoin('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                ->where('presensi.tipe_izin',null)
                ->where('presensi.pegawai_id',$this->id)
                ->groupBy('presensi.tgl_presensi')
                ->select('presensi.*','pegawai.*','rule_presensi.*')
                ->get();
        }else{
            $log = DB::table('presensi')
                ->join('pegawai','pegawai.id_pegawai','=','presensi.pegawai_id')
                ->leftJoin('rule_presensi','rule_presensi.id','=','presensi.id_rulepresensi')
                ->whereBetween('presensi.tgl_presensi',array($this->tgl_awal, $this->tgl_akhir))
                ->where('presensi.tipe_izin',null)
                ->where('presensi.pegawai_id',$this->id)
                ->groupBy('presensi.tgl_presensi')
                ->select('presensi.*','pegawai.*','rule_presensi.*')
                ->get();
        }
        return view('presensi.log_presensi.print_presensi_excel', [
            'presensi' => $log,
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
                $event->sheet->getDelegate()->getStyle('A1:G1')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $styleHeader = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
                $event->sheet->getStyle('A1:G1')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A7:G7')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A8:G8')->applyFromArray($styleHeader);
                $event->sheet->getDelegate()->getStyle('A7:G7')->getFont()->setSize(14);
            }
        ];
    }


}