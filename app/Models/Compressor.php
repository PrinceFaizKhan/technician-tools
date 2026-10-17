<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compressor extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'brand_name',
        'model_number',
        'refrigerant_id',
        'hp_capacity',
        'image',
        'pdf',
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
     * Refrigerant used by this compressor.
     *
     * @return BelongsTo<Refrigerant, $this>
     */
    public function refrigerant(): BelongsTo
    {
        return $this->belongsTo(Refrigerant::class);
    }
}
