<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'poli';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function dokter(): HasMany
    {
        return $this->hasMany(Dokter::class);
    }

    public function antrian(): HasMany
    {
        return $this->hasMany(Antrian::class);
    }

    public function antrianHariIni(): HasMany
    {
        return $this->hasMany(Antrian::class)
            ->whereDate('tanggal', today());
    }
}
