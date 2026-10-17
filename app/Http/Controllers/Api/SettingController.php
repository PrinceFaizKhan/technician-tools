<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AppSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Inject singleton app settings service.
     */
    public function __construct(
        protected AppSettingsService $settingsService
    ) {}

    /**
     * Get application settings, support info and app version checks.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'app_name' => $this->settingsService->get('app_name', "Technician's Toolkit"),
                'whatsapp_support' => $this->settingsService->getWhatsAppSupportNumber(),
                'whatsapp_group_url' => $this->settingsService->getWhatsAppGroupUrl(),
                'version_info' => $this->settingsService->getAppVersionInfo(),
            ],
        ]);
    }
}
