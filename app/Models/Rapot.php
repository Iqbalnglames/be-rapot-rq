<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapot extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
