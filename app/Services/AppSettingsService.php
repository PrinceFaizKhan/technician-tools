<?php

namespace App\Services;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Cache;

/**
 * Singleton service for managing and caching application settings.
 */
class AppSettingsService
{
    /**
     * In-memory cache for settings.
     *
     * @var array<string, mixed>
     */
    protected array $settings = [];

    /**
     * Whether settings have been loaded into memory.
     */
    protected bool $loaded = false;

    /**
     * Retrieve a setting by key with an optional default.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $this->ensureLoaded();

        return $this->settings[$key] ?? $default;
    }

    /**
     * Store or update a setting.
     */
    public function set(string $key, mixed $value): void
    {
        AppSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        $this->settings[$key] = $value;
        Cache::forget('app_settings_all');
    }

    /**
     * Retrieve all settings as key-value pairs.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        $this->ensureLoaded();

        return $this->settings;
    }

    /**
     * Support WhatsApp phone number.
     */
    public function getWhatsAppSupportNumber(): string
    {
        return (string) $this->get('whatsapp_support', '8860400956');
    }

    /**
     * Support WhatsApp group link.
     */
    public function getWhatsAppGroupUrl(): string
    {
        return (string) $this->get('whatsapp_group_url', 'https://chat.whatsapp.com/IQPkYqRl5bxLniZGmLFBdZ');
    }

    /**
     * App version info.
     *
     * @return array{min_version: string, current_version: string, force_update: bool}
     */
    public function getAppVersionInfo(): array
    {
        return [
            'min_version' => (string) $this->get('min_version', '1.0.0'),
            'current_version' => (string) $this->get('current_version', '1.0.0'),
            'force_update' => (bool) $this->get('force_update', false),
        ];
    }

    /**
     * Load settings from cache or database into memory once per lifecycle.
     */
    protected function ensureLoaded(): void
    {
        if ($this->loaded) {
            return;
        }

        $all = Cache::remember('app_settings_all', 3600, function (): array {
            return AppSetting::pluck('value', 'key')->toArray();
        });

        $this->settings = $all;
        $this->loaded = true;
    }
}
