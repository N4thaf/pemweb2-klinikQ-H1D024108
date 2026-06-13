<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';

    protected $fillable = [
        'poli_id',
        'pasien_id',
        'nomor_antrian',
        'tanggal',
        'status',
        'waktu_panggil',
        'waktu_selesai',
        'estimasi_menit',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_panggil' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIPANGGIL = 'dipanggil';
    const STATUS_SEDANG_DILAYANI = 'sedang_dilayani';
    const STATUS_SELESAI = 'selesai';

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public static function generateNomor(int $poliId): int
    {
        $last = static::where('poli_id', $poliId)
            ->whereDate('tanggal', today())
            ->max('nomor_antrian');
        return ($last ?? 0) + 1;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'dipanggil' => 'Dipanggil',
            'sedang_dilayani' => 'Sedang Dilayani',
            'selesai' => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'badge-gray',
            'dipanggil' => 'badge-blue',
            'sedang_dilayani' => 'badge-orange',
            'selesai' => 'badge-green',
            default => 'badge-gray',
        };
    }

    public function getEstimasiAttribute(): ?string
    {
        if (!$this->estimasi_menit) return null;
        return $this->estimasi_menit . ' menit';
    }
}
