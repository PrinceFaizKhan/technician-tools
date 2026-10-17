<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'price',
        'buy_url',
        'whatsapp_group_url',
        'contact_number',
        'asset_type',
        'icon_code_point',
        'color',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Videos included in this course.
     *
     * @return HasMany<CourseVideo, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(CourseVideo::class);
    }
}
