<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendFcmNotif;
use App\RulePresensi;
use App\Presensi;
use App\Periode;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;

class DashboardController extends Controller
{
    
    public function index()
    {
        $periode = Periode::first();
        $jam_masuk = $this->getChartPresensiStatus("jam_masuk",$periode->periode_awal, $periode->periode_akhir);
        $jam_pulang = $this->getChartPresensiStatus("jam_pulang",$periode->periode_awal, $periode->periode_akhir);
        $dataPresensi = $this->getChartJamresensi($periode->periode_awal, $periode->periode_akhir);
        $tugas = $this->getChartTugas();
        return view('dasboard.index',compact('jam_masuk','jam_pulang','tugas','dataPresensi'));
    }

    public function getChartPresensiStatus($status, $periodeAwal, $periodeAkhir)
    {
        $presensi = RulePresensi::leftjoin('presensi','presensi.id_rulepresensi','=','rule_presensi.id')
            ->select(\DB::raw("COUNT(presensi.id_rulepresensi) as count"), \DB::raw("rule_presensi.status_presensi as status"))
            ->where('rule_presensi.tipe_presensi',$status)
            ->whereBetween('presensi.tgl_presensi',array($periodeAwal, $periodeAkhir))
            ->groupBy("rule_presensi.status_presensi","status")
            ->orderBy("rule_presensi.status_presensi","asc")
            ->get();
        $data = [];

        foreach($presensi as $row){
            $data['label'][] = ($row->status == "-" ? "Tepat Waktu" : $row->status);
            $data['data'][] = (int) $row->count;
        }
        return json_encode($data);
    }

    public function getChartJamresensi($tglAwal, $tglAkhir)
    {
        $data = [];
        $data['label'][] = "Masuk";
        $data['data'][] = countHariMasuk($tglAwal, $tglAkhir);
        $label_tambahan = array("Izin", "Tidak Presensi");
        $data_tambahan = array(countIzinPegawai($tglAwal, $tglAkhir), 
            countIzinPegawai($tglAwal, $tglAkhir) != 0 ? (countHariMasuk($tglAwal, $tglAkhir) - countIzinPegawai($tglAwal, $tglAkhir)) : 0 
        );
        array_splice( $data['label'], 1, 0, $label_tambahan);
        array_splice( $data['data'], 1, 0, $data_tambahan);
        return json_encode($data);
    }
    public function getChartTugas()
    {
        $status = array("batal","selesai",null,"kirim");
        $data = [];
        for($i = 0; $i < count($status); $i++){
            $data['label'][] = ($status[$i] == null ? 'proses' : $status[$i]);
            $data['data'][] = countStatusTugas(null, $status[$i]);
        }
        return json_encode($data);
    }

    public function testWord($id)
    {

        $data = DB::table('surattugas')->join('pegawai', 'pegawai.id_pegawai', '=', 'surattugas.pegawai_id')
            ->where('surattugas.id', $id)
            ->select('surattugas.*', 'pegawai.*')->first();

        $styleHeader = "styleHeader";

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getSettings()->setEvenAndOddHeaders(true);
        $phpWord->addParagraphStyle($styleHeader, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0));

        $section = $phpWord->addSection();
        $header = $section->addHeader();
        $header->addImage('logo-kemenag.png',array(
            'positioning'        => 'relative',
            'marginTop'          => 10,   
            'width'              => 60,
            'height'             => 60,
            'wrappingStyle'      => 'tight',
            'wrapDistanceRight'  => Converter::cmToPoint(1),
            'wrapDistanceBottom' => Converter::cmToPoint(1),
        ));
        $header->addText("KEMENTERIAN AGAMA REPUBLIK INDONESIA",
            array('size' => 12 , 'bold' => true), $styleHeader);
        $header->addText("KANTOR KEMENTERIAN AGAMA KABUPATEN JOMBANG",
            array('size' => 12 , 'bold' => true), $styleHeader);
        $header->addText("Jalan Pattimura Nomor 26 Jombang 61416 Telepon. (0321) 861321", array('size' => 10), $styleHeader);
        $header->addText("Faxsimile. (0321) 861321 Email : kabjombang@kemenag.go.id", array('size' => 10), $styleHeader);

        $text = $section->addText("",array('size' => 10, 'bold' => true, 'spaceAfter' => 5));

        $lineStyle = array('weight' => 1, 'width' => 450, 'height' => 0, 'color' => '38c172');
        $section->addLine($lineStyle);

        $text = $section->addText("",array('size' => 10, 'bold' => true, 'spaceAfter' => 10));
        $text = $section->addText("LAPORAN PERJALANAN DINAS",array('size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0));
        $text = $section->addText("Nomor Surat : $data->no_surat",array('size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0));
        
        $text = $section->addText("",array('size' => 10, 'bold' => true, 'spaceAfter' => 20));

        // Table
        $table = $section->addTable();

        // Menimbang
        $html = ' <table style="font-size: small;">
        <tr>
            <td>Menimbang</td>
            <td>:</td>
            <td>'.$data->menimbang.'</td>
        </tr>
        </table>';

        // Menimbang
        $html = ' <table style="font-size: small;">
        <tr>
            <td>Menimbang</td>
            <td>:</td>
            <td>'.$data->menimbang.'</td>
        </tr>
        </table>';

        // Menimbang
        $html = ' <table style="font-size: small;">
        <tr>
            <td>Menimbang</td>
            <td>:</td>
            <td>'.$data->menimbang.'</td>
        </tr>
        </table>';

       // Dasar
       $html .= ' <table style="font-size: small;">
        <tr>
            <td>Dasar</td>
            <td>:</td>
            <td>'.$data->dasar.'</td>
        </tr>
        </table>';

        // Untuk
       $html .= ' <table style="font-size: small;">
       <tr>
           <td>Untuk</td>
           <td>:</td>
           <td>'.$data->perihal.'</td>
       </tr>
       </table>';

       // Pelaksanaan
       $html .= ' <table style="font-size: small;">
       <tr>
           <td>Pelaksanaan</td>
           <td>:</td>
           <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Di '.$data->tempat_tugas.'</td>
       </tr>
       </table>';

       // Hasil
       $html .= ' <table style="font-size: small;">
       <tr>
           <td>Hasil</td>
           <td>:</td>
           <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Konsolidasi berupa :</td>
       </tr>
       </table>';

       // demikian
       $html .= ' <table style="font-size: small;">
       <tr>
           <td colspan="3">Demikian laporan ini dibuat, kami sampaikan terima kasih.</td>
       </tr>
       </table>';

       // tanggal
       $html .= ' <table style="font-size: small;">
       <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right;">Jombang,&nbsp;</td>
        </tr>
       </table>';

       $html .= '<table style="font-size: small;"> 
       <tr>
            <td colspan="3" style="vertical-align:top">Pembuat laporan,</td>
        </tr>';
        foreach(getDataPegawaiSurat($data->no_surat) as $item){
            $html .= '<tr><td colspan="3">'.$item->nama.'<br/> NIP'
                   .$item->nip.'
                    </td>
                    <td>:</td>
                    <td>.............</td></tr>';  
                }
        $html .=  '</table>';

       // Mengetahui
       $html .= ' <table style="font-size: small;">
        <tr>
            <td colspan="3">Mengetahui :</td>
        </tr>
        <tr>
            <td colspan="3">Kasub Tata Usaha,</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">Dr. Emy Chulaimi, S.Ag, M.HI.</td>
        </tr>
        <tr>
            <td colspan="3">NIP. 197502021998031003</td>
        </tr>
       </table>';
       
        
        
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        //$row->addCell(7000, array('gridSpan' => 2, 'vMerge' => 'restart'))->addText('');

        // $row = $table->addRow();
        // $row->addCell(1000, array('vMerge' => 'continue'));
        // $row->addCell(1000, array('vMerge' => 'continue', 'gridSpan' => 2));
        // $row->addCell(1000)->addText('2');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Template_Penyelesaian_Tugas_'.$data->no_surat.'.docx');
        return response()->download(public_path('Template_Penyelesaian_Tugas_'.$data->no_surat.'.docx'));
    }

}
