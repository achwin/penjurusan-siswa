<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Student;
use App\Period;
use Excel;
use Session;
use Response;
use DB;

class DataController extends Controller
{

    public function index()
    {
        $periods = DB::table('periods')->get();
        $data = [
            'page'      => 'data-siswa',
            'periods'  => $periods,
        ];
        return view('admin.data.index',$data);
    }

    public function detail($period_id)
    {
        $students = DB::table('students')->where('period_id','=',$period_id)->get();
        $data = [
            'page'      => 'data-siswa',
            'students'  => $students,
        ];
        return view('admin.data.detail',$data);
    }

    public function inputData()
    {
        $data = [
            'page' => 'data-siswa',
        ];
        return view('admin.data.tambah',$data);
    }

    public function postInputData(Request $request)
    {   
        $attributes = $request->all();
        dd($attributes);
        // Create periode
        $period = Period::create([
            'tahun'                 => $attributes['tahun'],
            'kuota_ipa'             => $attributes['kuota_ipa'],
            'nilai_un'              => $attributes['bobot_nilai_un'],
            'nilai_test_penempatan' => $attributes['bobot_nilai_test_penempatan'],
            'nilai_ujian_sekolah'   => $attributes['bobot_nilai_ujian_sekolah'],
            'minat_siswa'           => $attributes['bobot_minat_siswa'],
        ]);

        // Upload excel
        $file = $request->file('data_siswa');
        $fileName = time().'-data-siswa.'.$file->getClientOriginalExtension();
        $file->move(public_path('excel/'),$fileName);

        $results = Excel::load('excel/'.$fileName)->get();
        $max = [
            'C1' => 0,
            'C2' => 0,
            'C3' => 0,
            'C4' => 0,
        ];
        foreach ($results as $i => $result) {
            // Fuzzy number tiap Criteria
            // Criteria 1
            $students[$i]['nama'] = $result->nama;
            $students[$i]['nilai_un'] = $result->nilai_un;
            $students[$i]['nilai_test_penempatan'] = $result->nilai_test_penempatan;
            $students[$i]['nilai_ujian_sekolah'] = $result->nilai_ujian_sekolah;
            $students[$i]['minat_siswa'] = $result->minat_siswa;
            $nilai_un = round($result->nilai_un);
            if ((0 <= $nilai_un) && ($nilai_un <= 54)) {
                $students[$i]['C1'] = 0; 
            }
            elseif ((55 <= $nilai_un) && ($nilai_un <= 60)) {
                $students[$i]['C1'] = 0.25; 
            }
            elseif ((61 <= $nilai_un) && ($nilai_un <= 70)) {
                $students[$i]['C1'] = 0.5; 
            }
            elseif ((71 <= $nilai_un) && ($nilai_un <= 85)) {
                $students[$i]['C1'] = 0.75; 
            }
            elseif ((86 <= $nilai_un) && ($nilai_un <= 100)) {
                $students[$i]['C1'] = 1; 
            }

            // Check max C1
            if ($students[$i]['C1'] > $max['C1']) {
                $max['C1'] = $students[$i]['C1'];
            }

            // Criteria 2
            $nilai_test_penempatan = round($result->nilai_test_penempatan);
            if ((0 <= $nilai_test_penempatan) && ($nilai_test_penempatan <= 50)) {
                $students[$i]['C2'] = 0; 
            }
            elseif ((51 <= $nilai_test_penempatan) && ($nilai_test_penempatan <= 69)) {
                $students[$i]['C2'] = 0.5; 
            }
            elseif ((70 <= $nilai_test_penempatan) && ($nilai_test_penempatan <= 100)) {
                $students[$i]['C2'] = 1; 
            }

            // Check max C2
            if ($students[$i]['C2'] > $max['C2']) {
                $max['C2'] = $students[$i]['C2'];
            }

            // Criteria 3
            $nilai_ujian_sekolah = round($result->nilai_ujian_sekolah);
            if ((0 <= $nilai_ujian_sekolah) && ($nilai_ujian_sekolah <= 54)) {
                $students[$i]['C3'] = 0; 
            }
            elseif ((55 <= $nilai_ujian_sekolah) && ($nilai_ujian_sekolah <= 60)) {
                $students[$i]['C3'] = 0.25; 
            }
            elseif ((61 <= $nilai_ujian_sekolah) && ($nilai_ujian_sekolah <= 70)) {
                $students[$i]['C3'] = 0.5; 
            }
            elseif ((71 <= $nilai_ujian_sekolah) && ($nilai_ujian_sekolah <= 85)) {
                $students[$i]['C3'] = 0.75; 
            }
            elseif ((86 <= $nilai_ujian_sekolah) && ($nilai_ujian_sekolah <= 100)) {
                $students[$i]['C3'] = 1; 
            }

            // Check max C3
            if ($students[$i]['C3'] > $max['C3']) {
                $max['C3'] = $students[$i]['C3'];
            }

            // Criteria 4
            if ($result->minat_siswa == 1) {
                $students[$i]['C4'] = 1; 
            }
            elseif ($result->minat_siswa == 2) {
                $students[$i]['C4'] = 0.5; 
            }

            // Check max C4
            if ($students[$i]['C4'] > $max['C4']) {
                $max['C4'] = $students[$i]['C4'];
            }
        }

        // Matriks normalisasi
        for ($i=0; $i < count($students); $i++) { 
            $students[$i]['C1'] = $students[$i]['C1']/$max['C1'];
            $students[$i]['C2'] = $students[$i]['C2']/$max['C2'];
            $students[$i]['C3'] = $students[$i]['C3']/$max['C3'];
            $students[$i]['C4'] = $students[$i]['C4']/$max['C4'];
        }

        // Pembobotan
        for ($i=0; $i < count($students); $i++) { 
            $students[$i]['hasil'] = 
            ($students[$i]['C1']*$attributes['bobot_nilai_un'])+
            ($students[$i]['C2']*$attributes['bobot_nilai_test_penempatan'])+
            ($students[$i]['C3']*$attributes['bobot_nilai_ujian_sekolah'])+
            ($students[$i]['C4']*$attributes['bobot_minat_siswa']);
        }

        usort($students, function($a, $b) {
            return $a['hasil'] < $b['hasil'];
        });

        // Create siswa
        foreach ($students as $i => $student) {
            if ($i+1 <= $period->kuota_ipa) {
                $jurusan = 'IPA';
            }
            elseif($i+1 > $period->kuota_ipa){
                $jurusan = 'IPS';
            }
            Student::create([
                'nama'                  => $student['nama'],
                'nilai_un'              => $student['nilai_un'],
                'nilai_test_penempatan' => $student['nilai_test_penempatan'],
                'nilai_ujian_sekolah'   => $student['nilai_ujian_sekolah'],
                'minat_siswa'           => $student['minat_siswa'],
                'hasil'                 => $student['hasil'],
                'jurusan'               => $jurusan,
                'period_id'             => $period->id,
            ]);
        }
        Session::put('alert-success', 'Data periode '.$period->tahun.' berhasil diinputkan.');
        return Redirect::to('data-siswa');
    }

    public function delete($period_id)
    {
        $period = Period::find($period_id);
        $students = Student::where('period_id',$period_id);
        $students->delete();
        $period->delete();
        Session::put('alert-success', 'Data periode '.$period->tahun.' berhasil dihapus.');
        return Redirect::to('data-siswa');

    }

    public function export($period_id)
    {
        $period = Period::find($period_id);
        $students = Student::where('period_id',$period_id)->get();
        \Excel::create('Data siswa periode '.str_replace('/', '_', $period->tahun).' ('.date('d-m-Y').')', function($excel) use($students){
                $excel->sheet('sheet', function($sheet) use($students){
                    $studentData = array();
                    $no = 0;
                    foreach ($students as $student) {
                        $studentData[] = array(
                            ++$no,
                            $student->nama,
                            $student->nilai_un,
                            $student->nilai_test_penempatan,
                            $student->nilai_ujian_sekolah,
                            $student->hasil,
                            $student->jurusan,
                        );
                    }
                    $sheet->fromArray($studentData, null, 'A1', false, false);
                    $headings = array('No','Nama','Nilai UN','Nilai Test Penempatan','Nilai Ujian Sekolah','Hasil Perhitungan','Jurusan');
                    $sheet->prependRow(1, $headings);
                });
            })->store('xlsx',public_path('excel/'));
        return response()->download(public_path('excel/Data siswa periode '.str_replace('/', '_', $period->tahun).' ('.date('d-m-Y').').xlsx'));
    }
}