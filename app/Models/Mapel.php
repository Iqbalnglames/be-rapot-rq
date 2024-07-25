<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kategoriMapel()
    {
        return $this->belongsTo(KategoriMapel::class);
    }

    public function santri()
    {
        return $this->belongsToMany(Rapot::class, 'rapots');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
