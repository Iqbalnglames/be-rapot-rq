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

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_mapels');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mapels');
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
