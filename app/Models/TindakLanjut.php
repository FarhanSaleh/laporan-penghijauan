<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use RecordsActivity;
    
    protected $table = 'tindak_lanjut';

    protected $fillable = [
        'catatan',
        'foto_bukti',
        'tanggal_laporan',
        'user_id',
        'laporan_id',
    ];

    protected $casts = [
        'tanggal_laporan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
