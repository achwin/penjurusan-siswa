<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
	protected $table = 'students';    
	protected $primaryKey = 'id';   
   public $timestamps = true;
	protected $fillable = [
		'nama',
		'nilai_un',
		'nilai_test_penempatan',
		'nilai_ujian_sekolah',
		'minat_siswa',
		'hasil',
        'jurusan',
        'period_id',
	]; 	
}