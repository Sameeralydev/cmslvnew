@php
    $moduleTabs = [
        ['label' => 'DASHBOARD', 'icon' => 'fa-solid fa-desktop', 'route' => 'admin.dashboard', 'hash' => '#dashboard'],
        ['label' => 'MODULES', 'icon' => 'fa-solid fa-cubes', 'hash' => '#modules'],
        ['label' => 'REPORTS', 'icon' => 'fa-solid fa-chart-column', 'hash' => '#reports'],
        ['label' => 'CMS', 'icon' => 'fa-solid fa-building-columns', 'hash' => '#cms'],
        ['label' => 'LMS', 'icon' => 'fa-solid fa-book', 'hash' => '#lms'],
        ['label' => 'SYSTEM SETTINGS', 'icon' => 'fa-solid fa-gears', 'hash' => '#system-settings'],
    ];
@endphp

<nav class="admin-module-tabs" aria-label="Admin modules">
    @foreach ($moduleTabs as $tab)
        <a href="{{ isset($tab['hash']) ? $tab['hash'] : route($tab['route'], absolute: false) }}"
           data-admin-tab="{{ $tab['hash'] ?? '' }}"
           class="admin-module-tab {{ isset($tab['route']) && request()->routeIs($tab['route']) ? 'is-active' : '' }}">
            <i class="{{ $tab['icon'] }}"></i>
            <span>{{ $tab['label'] }}</span>
        </a>
    @endforeach
</nav>
