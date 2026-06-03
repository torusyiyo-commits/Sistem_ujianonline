<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasUjian extends Model
{
    protected $table = 'aktivitas_ujians';
    
    protected $fillable = [
        'user_id', 'ujian_id', 'tipe', 'data'
    ];

    protected $casts = [
        'data' => 'array',
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
