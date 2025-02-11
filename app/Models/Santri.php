<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function rapot()
    {
        return $this->belongsTo(Rapot::class);
    }

    public function nilai()
    {
        return $this->belongsToMany(Nilai::class, 'rapots');
    }

    public function catatan()
    {
        return $this->hasMany(CatatanSantri::class);
    }
}
