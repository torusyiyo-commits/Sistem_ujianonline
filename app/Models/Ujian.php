<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $fillable = [
        'judul',
        'mata_pelajaran',
        'kelas',
        'durasi',
        'jumlah_soal_ditampilkan',
        'file_sumber',
        'tanggal_ujian',
        'jam_mulai',
        'jam_selesai',
        'guru_id'
    ];

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function hasilUjians()
    {
        return $this->hasMany(HasilUjian::class);
    }
}
