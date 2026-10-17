<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'logo',
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
     * Appliances this brand manufactures.
     *
     * @return BelongsToMany<Appliance, $this>
     */
    public function appliances(): BelongsToMany
    {
        return $this->belongsToMany(Appliance::class, 'appliance_brand');
    }

    /**
     * Error codes for this brand.
     *
     * @return HasMany<ErrorCode, $this>
     */
    public function errorCodes(): HasMany
    {
        return $this->hasMany(ErrorCode::class);
    }
}
