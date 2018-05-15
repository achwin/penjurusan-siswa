<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
	protected $table = 'periods';    
	protected $primaryKey = 'id';   
   	public $timestamps = true;
	protected $fillable = [
		'tahun',
		'nilai_un',
		'nilai_test_penempatan',
		'nilai_ujian_sekolah',
		'minat_siswa',
		'kuota_ipa',
	];
}