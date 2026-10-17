<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrorCode extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'appliance_id',
        'brand_id',
        'filter_id',
        'title',
        'code',
        'description',
        'cause',
        'solution',
        'pdf_url',
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
     * Appliance associated with this error code.
     *
     * @return BelongsTo<Appliance, $this>
     */
    public function appliance(): BelongsTo
    {
        return $this->belongsTo(Appliance::class);
    }

    /**
     * Brand associated with this error code.
     *
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Optional filter associated with this error code.
     *
     * @return BelongsTo<ErrorCodeFilter, $this>
     */
    public function filter(): BelongsTo
    {
        return $this->belongsTo(ErrorCodeFilter::class, 'filter_id');
    }
}
