<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Refrigerant extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'chemical_name',
        'image',
        'pdf',
        'standing_pressure_psi',
        'suction_pressure_psi',
        'discharge_pressure_psi',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Compressors using this refrigerant.
     *
     * @return HasMany<Compressor, $this>
     */
    public function compressors(): HasMany
    {
        return $this->hasMany(Compressor::class);
    }
}
