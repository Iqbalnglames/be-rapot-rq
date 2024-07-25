<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function santri()
    {
        return $this->belongsToMany(Santri::class, 'rapots');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'rapots');
    }
}
