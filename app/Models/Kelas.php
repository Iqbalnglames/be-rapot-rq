<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function santri()
    {
        return $this->hasMany(Santri::class);
    }

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'kelas_mapels');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
