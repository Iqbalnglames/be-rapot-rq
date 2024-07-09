<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'rapots');
    }

    public function nilai()
    {
        return $this->belongsToMany(Nilai::class, 'rapots');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    
}
