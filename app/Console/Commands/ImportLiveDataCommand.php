<?php

namespace App\Console\Commands;

use App\Models\Appliance;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Compressor;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\ErrorCode;
use App\Models\Product;
use App\Models\Refrigerant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportLiveDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toolkit:import-live {--limit= : Limit the number of records imported per module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import live data from https://node.technicianstoolkit.com into MySQL';

    /**
     * Base URL for the legacy Node.js API.
     */
    protected string $baseUrl = 'https://node.technicianstoolkit.com';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting live data import from Technician\'s Toolkit API...');

        // 1. Ensure Admin User exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('nasruddin@#321@#'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
        $this->info("Admin user verified: {$admin->email}");

        // 2. Authenticate with legacy API
        $loginRes = Http::post("{$this->baseUrl}/login-admin", [
            'email' => 'admin@gmail.com',
            'password' => 'nasruddin@#321@#',
        ]);

        if (! $loginRes->successful() || empty($loginRes->json('data'))) {
            $this->error('Failed to authenticate with legacy API: '.$loginRes->body());

            return self::FAILURE;
        }

        $token = $loginRes->json('data');
        $this->info('Legacy API authentication successful.');

        $client = Http::withToken($token);

        // 3. Import Appliances
        $this->importAppliances($client);

        // 4. Import Brands
        $this->importBrands($client);

        // 5. Import Error Codes
        $this->importErrorCodes($client);

        // 6. Import Refrigerants
        $this->importRefrigerants($client);

        // 7. Import Compressors
        $this->importCompressors($client);

        // 8. Import Products & Categories
        $this->importProducts($client);

        // 9. Import Courses & Videos
        $this->importCourses($client);

        // 10. Import Articles
        $this->importArticles($client);

        // 11. Import Banners
        $this->importBanners($client);

        $this->info('✓ All live data has been imported successfully into MySQL!');

        return self::SUCCESS;
    }

    /**
     * Import appliances categories.
     */
    protected function importAppliances($client): void
    {
        $this->line('Importing Appliances...');
        $res = $client->get("{$this->baseUrl}/get-all-appliance-error-code-list");
        $data = $res->json('data') ?? [];

        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            Appliance::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'image' => $item['image'] ?? null,
                    'is_active' => true,
                ]
            );
        }

        $this->info('Appliances imported: '.count($data));
    }

    /**
     * Import brands.
     */
    protected function importBrands($client): void
    {
        $this->line('Importing Brands...');
        $res = $client->get("{$this->baseUrl}/get-all-brand-name-error-code-list");
        $data = $res->json('data') ?? [];

        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            Brand::firstOrCreate(
                ['title' => $title],
                [
                    'slug' => Str::slug($title),
                    'logo' => $item['image'] ?? null,
                    'is_active' => true,
                ]
            );
        }

        $this->info('Brands imported: '.count($data));
    }

    /**
     * Import error codes.
     */
    protected function importErrorCodes($client): void
    {
        $this->line('Importing Error Codes...');
        $res = $client->get("{$this->baseUrl}/get-all-error-codes-list");
        $data = $res->json('data') ?? [];

        $count = 0;
        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            ErrorCode::create([
                'title' => $title,
                'code' => $item['errorCode'] ?? null,
                'description' => $item['description'] ?? null,
                'cause' => $item['cause'] ?? null,
                'solution' => $item['solution'] ?? null,
                'pdf_url' => $item['pdf'] ?? null,
                'is_active' => true,
            ]);

            $count++;
        }

        $this->info("Error codes imported: {$count}");
    }

    /**
     * Import refrigerants.
     */
    protected function importRefrigerants($client): void
    {
        $this->line('Importing Refrigerants...');
        $res = $client->get("{$this->baseUrl}/get-all-refrigerant");
        $data = $res->json('data') ?? [];

        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            Refrigerant::firstOrCreate(
                ['title' => $title],
                [
                    'image' => $item['image'] ?? null,
                    'pdf' => $item['pdf'] ?? null,
                    'standing_pressure_psi' => $item['standingPressure'] ?? null,
                    'suction_pressure_psi' => $item['suctionPressure'] ?? null,
                    'discharge_pressure_psi' => $item['dischargePressure'] ?? null,
                    'is_active' => true,
                ]
            );
        }

        $this->info('Refrigerants imported: '.count($data));
    }

    /**
     * Import compressors.
     */
    protected function importCompressors($client): void
    {
        $this->line('Importing Compressors...');
        $res = $client->get("{$this->baseUrl}/get-all-compressor");
        $data = $res->json('data') ?? [];

        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            Compressor::create([
                'title' => $title,
                'brand_name' => $item['brandName'] ?? null,
                'model_number' => $item['modelNumber'] ?? null,
                'hp_capacity' => $item['hp'] ?? null,
                'image' => $item['image'] ?? null,
                'pdf' => $item['pdf'] ?? null,
                'is_active' => true,
            ]);
        }

        $this->info('Compressors imported: '.count($data));
    }

    /**
     * Import products.
     */
    protected function importProducts($client): void
    {
        $this->line('Importing Products...');
        $res = $client->get("{$this->baseUrl}/get-all-products");
        $data = $res->json('data') ?? [];

        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            Product::create([
                'title' => $title,
                'slug' => Str::slug($title).'-'.Str::random(5),
                'description' => $item['description'] ?? null,
                'price' => (float) ($item['price'] ?? 0),
                'images' => $item['images'] ?? [],
                'buy_url' => $item['buyLink'] ?? null,
                'is_trending' => (bool) ($item['isTrending'] ?? false),
                'is_active' => true,
            ]);
        }

        $this->info('Products imported: '.count($data));
    }

    /**
     * Import courses & videos.
     */
    protected function importCourses($client): void
    {
        $this->line('Importing Courses...');
        $res = $client->get("{$this->baseUrl}/get-all-course-list");
        $data = $res->json('data') ?? [];

        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            $course = Course::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => $item['description'] ?? null,
                'image' => $item['image'] ?? null,
                'asset_type' => $item['assetType'] ?? 'image',
                'icon_code_point' => $item['iconCodePoint'] ?? null,
                'color' => $item['color'] ?? null,
                'is_active' => true,
            ]);

            // Videos
            $videoRes = $client->get("{$this->baseUrl}/admin-get-all-course-videos-list");
            $videos = $videoRes->json('data') ?? [];

            foreach ($videos as $vid) {
                CourseVideo::create([
                    'course_id' => $course->id,
                    'title' => $vid['title'] ?? 'Tutorial Video',
                    'description' => $vid['description'] ?? null,
                    'video_url' => $vid['CourseVideoUrl'] ?? '',
                    'thumbnail_url' => $vid['thumbnailUrl'] ?? null,
                    'views' => (int) ($vid['views'] ?? 0),
                    'is_master_video' => (bool) ($vid['isMasterVideo'] ?? false),
                ]);
            }
        }

        $this->info('Courses imported: '.count($data));
    }

    /**
     * Import technical articles.
     */
    protected function importArticles($client): void
    {
        $this->line('Importing Articles...');
        $res = $client->get("{$this->baseUrl}/get-all-articals");
        $data = $res->json('data') ?? [];

        foreach ($data as $item) {
            $title = trim($item['title'] ?? '');
            if (empty($title)) {
                continue;
            }

            Article::create([
                'title' => $title,
                'slug' => Str::slug($title).'-'.Str::random(5),
                'description' => $item['description'] ?? '',
                'image' => $item['image'] ?? null,
                'is_active' => true,
            ]);
        }

        $this->info('Articles imported: '.count($data));
    }

    /**
     * Import banners.
     */
    protected function importBanners($client): void
    {
        $this->line('Importing Banners...');
        $res = $client->get("{$this->baseUrl}/get-all-banner");
        $data = $res->json('data') ?? [];

        $bannerGroup = $data[0] ?? [];
        $images = $bannerGroup['images'] ?? [];

        foreach ($images as $img) {
            if (empty($img['url'])) {
                continue;
            }

            Banner::create([
                'title' => 'Promotional Banner',
                'image_url' => $img['url'],
                'link_url' => $img['linkForImage'] ?? null,
                'is_active' => true,
            ]);
        }

        $this->info('Banners imported: '.count($images));
    }
}
