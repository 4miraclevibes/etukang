<!-- Status Bar -->
<div class="status-bar">
    <div class="flex items-center">
        <span class="text-xs">{{ date('H:i') }}</span>
    </div>
    <div class="flex items-center space-x-1">
        <i class="fas fa-signal text-xs"></i>
        <i class="fas fa-wifi text-xs"></i>
        <i class="fas fa-battery-three-quarters text-xs"></i>
    </div>
</div>

<!-- Header -->
<div class="bg-white border-b border-gray-200 px-4 py-3">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-store text-white text-sm"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-gray-900">{{ $headerTitle ?? 'Merchant Dashboard' }}</h1>
                <p class="text-xs text-gray-500">{{ Auth::user()->merchant->name ?? 'Sportlodek Merchant' }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="showNotifications()" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-bell text-gray-600 text-sm"></i>
            </button>
            <button onclick="showProfile()" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user text-gray-600 text-sm"></i>
            </button>
        </div>
    </div>
</div>
