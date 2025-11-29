<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use RecordsActivity;
    
    protected $table = 'laporan';
    protected $fillable = [
        'judul',
        'deskripsi',
        'alamat',
        'latitude',
        'longitude',
        'foto_laporan',
        'tanggal_laporan',
        'user_id',
        'status_id',
    ];

    protected $casts = [
        'tanggal_laporan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function status()
    {
        return $this->belongsTo(StatusLaporan::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'laporan_id');
    }
}
