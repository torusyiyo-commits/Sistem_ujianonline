<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    protected $fillable = [
        'user_id', 'ujian_id', 'skor', 'jawaban_siswa', 'jumlah_pelanggaran'
    ];

    protected $casts = [
        'jawaban_siswa' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}
