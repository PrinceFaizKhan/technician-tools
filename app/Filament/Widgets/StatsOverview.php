<?php

namespace App\Filament\Widgets;

use App\Models\Appliance;
use App\Models\Brand;
use App\Models\Compressor;
use App\Models\Course;
use App\Models\ErrorCode;
use App\Models\Product;
use App\Models\Refrigerant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total Error Codes', ErrorCode::count())
                ->description('Active appliance fault codes')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('danger'),

            Stat::make('Brands & Appliances', Brand::count().' Brands / '.Appliance::count().' Categories')
                ->description('Supported equipment database')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('info'),

            Stat::make('Compressors & Gases', Compressor::count().' Units / '.Refrigerant::count().' Types')
                ->description('Technical pressure & specs')
                ->descriptionIcon('heroicon-m-fire')
                ->color('warning'),

            Stat::make('Catalog & Learning', Product::count().' Products / '.Course::count().' Courses')
                ->description('Tools, spares & video tutorials')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
        ];
    }
}
