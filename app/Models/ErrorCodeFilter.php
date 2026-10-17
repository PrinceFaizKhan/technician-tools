<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ErrorCodeFilter extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'appliance_id',
        'brand_id',
        'title',
    ];

    /**
     * Appliance associated with this filter.
     *
     * @return BelongsTo<Appliance, $this>
     */
    public function appliance(): BelongsTo
    {
        return $this->belongsTo(Appliance::class);
    }

    /**
     * Brand associated with this filter.
     *
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Error codes using this filter.
     *
     * @return HasMany<ErrorCode, $this>
     */
    public function errorCodes(): HasMany
    {
        return $this->hasMany(ErrorCode::class, 'filter_id');
    }
}
