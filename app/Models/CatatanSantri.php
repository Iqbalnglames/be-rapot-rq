<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanSantri extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
