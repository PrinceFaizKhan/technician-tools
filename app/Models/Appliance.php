<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appliance extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'image',
        'icon_code_point',
        'color',
        'sort_order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Brands associated with this appliance.
     *
     * @return BelongsToMany<Brand, $this>
     */
    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'appliance_brand');
    }

    /**
     * Error codes for this appliance.
     *
     * @return HasMany<ErrorCode, $this>
     */
    public function errorCodes(): HasMany
    {
        return $this->hasMany(ErrorCode::class);
    }

    /**
     * Filters for this appliance.
     *
     * @return HasMany<ErrorCodeFilter, $this>
     */
    public function filters(): HasMany
    {
        return $this->hasMany(ErrorCodeFilter::class);
    }
}
