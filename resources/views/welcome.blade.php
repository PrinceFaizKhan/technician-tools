<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Toolkit - Next Gen Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col justify-between selection:bg-indigo-500 selection:text-white">
    <!-- Navbar -->
    <header class="border-b border-slate-800/80 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-indigo-500/20">
                    🛠️
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight text-white">Technician Toolkit</h1>
                    <p class="text-xs text-slate-400 font-medium">Technician Toolkit Platform</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="/api/v1/settings" target="_blank" class="text-sm font-semibold text-slate-400 hover:text-white transition">API v1</a>
                <a href="/admin" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition shadow-lg shadow-indigo-600/30 hover:scale-[1.02] active:scale-[0.98]">
                    <span>Admin Panel</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow max-w-7xl mx-auto px-6 py-12 flex flex-col justify-center">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Technician Toolkit System Live</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white mb-6">
                Next-Gen Platform for <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Appliance & HVAC Technicians</span>
            </h2>
            <p class="text-slate-400 text-base sm:text-lg leading-relaxed">
                Comprehensive technical assistant for home appliances, error diagnostics, compressor specifications, and refrigerant guides.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="/admin" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-sm shadow-xl shadow-indigo-500/20 transition hover:scale-105">
                    Launch Admin Dashboard (/admin)
                </a>
                <a href="/api/v1/error-codes" target="_blank" class="px-6 py-3.5 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white font-semibold text-sm transition">
                    Test Live REST API
                </a>
            </div>
        </div>

        <!-- Live Database Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Error Codes</p>
                <div class="text-3xl font-extrabold text-white">{{ number_format($stats['error_codes']) }}</div>
                <div class="mt-2 text-xs text-rose-400 flex items-center space-x-1">
                    <span>⚡ Instant Search Enabled</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Brands & Categories</p>
                <div class="text-3xl font-extrabold text-white">{{ number_format($stats['brands']) }}</div>
                <div class="mt-2 text-xs text-sky-400 flex items-center space-x-1">
                    <span>Across {{ $stats['appliances'] }} Appliance Types</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Compressors & Gas</p>
                <div class="text-3xl font-extrabold text-white">{{ number_format($stats['compressors']) }}</div>
                <div class="mt-2 text-xs text-amber-400 flex items-center space-x-1">
                    <span>{{ $stats['refrigerants'] }} Gas Pressure Specs</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-sm">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Products & Courses</p>
                <div class="text-3xl font-extrabold text-white">{{ number_format($stats['products']) }}</div>
                <div class="mt-2 text-xs text-emerald-400 flex items-center space-x-1">
                    <span>{{ $stats['courses'] }} Courses & {{ $stats['articles'] }} Articles</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 bg-slate-900/30 py-6">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <div>
                Technician Toolkit
            </div>
            <div>
                Created by Faizan khan @2026
            </div>
        </div>
    </footer>
</body>
</html>
