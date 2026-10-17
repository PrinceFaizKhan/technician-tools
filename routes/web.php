<?php

use App\Models\Appliance;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Compressor;
use App\Models\Course;
use App\Models\ErrorCode;
use App\Models\Product;
use App\Models\Refrigerant;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'error_codes' => ErrorCode::count(),
        'brands' => Brand::count(),
        'appliances' => Appliance::count(),
        'compressors' => Compressor::count(),
        'refrigerants' => Refrigerant::count(),
        'products' => Product::count(),
        'courses' => Course::count(),
        'articles' => Article::count(),
    ];

    return view('welcome', compact('stats'));
});
