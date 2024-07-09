<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    public function rapot()
    {
        return $this->belongsToMany(Nilai::class, 'rapots');
    }
}
