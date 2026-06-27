<aside id="sidebar" class="bg-sidebar-bg text-sidebar-text w-72 h-screen flex flex-col flex-shrink-0 z-50 
              fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-all duration-300
              border-r border-bor-color">

    <div class="h-20 flex items-center justify-center bg-sidebar-bg sticky top-0 z-20 border-b border-bor-color transition-colors duration-300">
        <div class="flex items-center gap-3 w-full px-6 transition-all duration-300 menu-item-content">
            
            {{-- ១. ផ្នែក Logo --}}
            @if(isset($shop) && $shop->logo)
                {{-- បើមាន Logo ក្នុង Database --}}
                <img src="{{ asset('storage/' . $shop->logo) }}" 
                     class="w-10 h-10 rounded-xl object-cover shadow-lg border border-white/10 flex-shrink-0 bg-white" 
                     alt="Shop Logo">
            @else
                {{-- បើអត់មាន Logo ប្រើ Icon ដើម --}}
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-lg flex-shrink-0">
                    <x-ri-store-2-fill class="w-5 h-5 text-white flex-shrink-0" />
                </div>
            @endif

            {{-- ២. ផ្នែកឈ្មោះហាង --}}
            <div class="flex flex-col sidebar-text overflow-hidden whitespace-nowrap">
                {{-- បង្ហាញឈ្មោះហាង ឬដាក់ Default បើអត់ទាន់មាន --}}
                <span class="text-lg font-bold tracking-tight text-text-color truncate">
                    {{ $shop->shop_en ?? 'POS System' }}
                </span>
                {{-- បង្ហាញ Role របស់អ្នកប្រើប្រាស់ --}}
                <span class="text-[10px] font-bold text-primary uppercase tracking-widest truncate" 
                      title="{{ auth()->user()->getRoleNames()->implode(', ') }}">
                    {{ auth()->user()->getRoleNames()->first() ?? __('sidebar.staff_member') }}
                </span>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto no-scrollbar py-6 px-4 space-y-2">

        {{-- Dashboard Menu --}}
        <div class="group relative">
            <a href="{{ route('admin.dashboard') }}" wire:navigate
               class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 menu-item-content
                      {{ request()->routeIs('admin.dashboard') ? 'btn-primary shadow-lg text-white' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                
                <x-ri-dashboard-line class="w-6 h-6 flex-shrink-0 mr-3 menu-icon text-current" />
                <span class="sidebar-text font-medium">{{ __('sidebar.dashboard') }}</span>
            </a>
            <div class="tooltip hidden absolute left-[100%] top-2 ml-4 bg-gray-900 text-white text-xs px-3 py-2 rounded shadow-xl z-50 whitespace-nowrap">
                {{ __('sidebar.dashboard') }}
            </div>
        </div>
 
        {{-- ============================================= --}}
        {{--           USER MANAGEMENT SECTION               --}}
        {{-- ============================================= --}}
        @if(auth()->user()->can('user-list') || auth()->user()->can('role-list') || auth()->user()->can('permission-list') || auth()->user()->hasRole('Super Admin'))
            
            <div class="px-4 mt-6 mb-2 sidebar-text">
                <span class="text-[11px] font-bold opacity-50 uppercase tracking-wider">{{ __('sidebar.user_management') }}</span>
            </div>

            @php 
                $isUserActive = request()->routeIs('user.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') || request()->routeIs('admin.rules.*') || request()->routeIs('admin.activity_logs.*') ; 
            @endphp 
            
            <div class="group relative">
                <button onclick="toggleSubmenu(this)" 
                        class="sidebar-item w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 cursor-pointer select-none menu-item-content hover:bg-black/5 dark:hover:bg-white/5
                               {{ $isUserActive ? 'bg-black/5 dark:bg-white/10' : '' }}">
                    <div class="flex items-center">
                        <x-ri-user-settings-line class="w-6 h-6 flex-shrink-0 mr-3 menu-icon {{ $isUserActive ? 'text-primary' : '' }}" />
                        <span class="sidebar-text font-medium">{{ __('sidebar.users_access') }}</span>
                    </div>
                    
                    {{-- ដាក់ខ្នាត w-5 h-5 ការពារមិនឱ្យព្រួញលោតធំ --}}
                    <x-ri-arrow-down-s-line class="w-5 h-5 flex-shrink-0 arrow-icon transition-transform duration-300 {{ $isUserActive ? 'rotate-180' : '' }}" />
                </button>

                <div class="submenu {{ $isUserActive ? '' : 'hidden' }} transition-all duration-300">
                    <div class="tree-line absolute left-[26px] top-0 bottom-2 w-px bg-custom-border opacity-50"></div>
                    <ul class="space-y-1 mt-1">
                        
                        {{-- 1. User List --}}
                        @can('user-list')
                            <li>
                                <a href="{{ route('user.list') }}" wire:navigate
                                class="sidebar-item relative flex items-center py-2.5 rounded-lg text-sm transition-all duration-200 pl-12 pr-4 hover:bg-black/5 dark:hover:bg-white/5
                                            {{ request()->routeIs('user.list') ? 'text-primary font-bold' : 'opacity-80' }}">
                                    <span class="tree-line absolute left-[22px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-2 border-sidebar-bg 
                                                {{ request()->routeIs('user.list') ? 'bg-primary' : 'bg-gray-400' }}"></span>
                                    <span>{{ __('sidebar.user_list') }}</span>
                                </a>
                            </li>
                        @endcan

                        {{-- 2. Role & Permission --}}
                        @can('role-list')
                            <li>
                                <a href="{{ route('admin.roles.index') }}" wire:navigate
                                class="sidebar-item relative flex items-center py-2.5 rounded-lg text-sm transition-all duration-200 pl-12 pr-4 hover:bg-black/5 dark:hover:bg-white/5
                                            {{ request()->routeIs('admin.roles.*') ? 'text-primary font-bold' : 'opacity-80' }}">
                                    <span class="tree-line absolute left-[22px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-2 border-sidebar-bg 
                                                {{ request()->routeIs('admin.roles.*') ? 'bg-primary' : 'bg-gray-400' }}"></span>
                                    <span>{{ __('sidebar.role_permission') }}</span>
                                </a>
                            </li>
                        @endcan

                        {{-- 3. Permission List --}}
                        @can('permission-list')
                            <li>
                                <a href="{{ route('admin.permissions.index') }}" wire:navigate
                                class="sidebar-item relative flex items-center py-2.5 rounded-lg text-sm transition-all duration-200 pl-12 pr-4 hover:bg-black/5 dark:hover:bg-white/5
                                            {{ request()->routeIs('admin.permissions.*') ? 'text-primary font-bold' : 'opacity-80' }}">
                                    <span class="tree-line absolute left-[22px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-2 border-sidebar-bg 
                                                {{ request()->routeIs('admin.permissions.*') ? 'bg-primary' : 'bg-gray-400' }}"></span>
                                    <span>{{ __('sidebar.permission_list') }}</span>
                                </a>
                            </li>
                        @endcan

                        {{-- 4. Permission Assign --}}
                        @can('rule-list')
                            <li>
                                <a href="{{ route('admin.rules.index') }}" wire:navigate
                                class="sidebar-item relative flex items-center py-2.5 rounded-lg text-sm transition-all duration-200 pl-12 pr-4 hover:bg-black/5 dark:hover:bg-white/5
                                            {{ request()->routeIs('admin.rules.*') ? 'text-primary font-bold' : 'opacity-80' }}">
                                    <span class="tree-line absolute left-[22px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-2 border-sidebar-bg 
                                                {{ request()->routeIs('admin.rules.*') ? 'bg-primary' : 'bg-gray-400' }}"></span>
                                    <span>{{ __('sidebar.rule_list') }}</span>
                                </a>
                            </li>
                        @endcan

                        {{-- 5. User Activity --}}
                        @can('activity-list')
                            <li>
                                <a href="{{ route('admin.activity_logs.index') }}" wire:navigate
                                class="sidebar-item relative flex items-center py-2.5 rounded-lg text-sm transition-all duration-200 pl-12 pr-4 hover:bg-black/5 dark:hover:bg-white/5
                                            {{ request()->routeIs('admin.activity_logs.*') ? 'text-primary font-bold' : 'opacity-80' }}">
                                    <span class="tree-line absolute left-[22px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-2 border-sidebar-bg 
                                                {{ request()->routeIs('admin.activity_logs.*') ? 'bg-primary' : 'bg-gray-400' }}"></span>
                                    <span>{{ __('sidebar.user_action') }}</span>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </div>
                <div class="tooltip hidden absolute left-[100%] top-2 ml-4 bg-gray-900 text-white text-xs px-3 py-2 rounded shadow-xl z-50 whitespace-nowrap">
                    {{ __('sidebar.users_access') }}
                </div>
            </div>
        @endif

        {{-- ============================================= --}}
        {{--                SETTINGS SECTION               --}}
        {{-- ============================================= --}}
        @php 
            $isSettingsActive = request()->routeIs('admin.theme') || request()->routeIs('admin.shop_info.index'); 
        @endphp

        <div class="px-4 mt-6 mb-2 sidebar-text">
            <span class="text-[11px] font-bold opacity-50 uppercase tracking-wider">{{ __('sidebar.system') }}</span>
        </div>

        <div class="group relative">
            <button onclick="toggleSubmenu(this)" 
                    class="sidebar-item w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 cursor-pointer select-none menu-item-content hover:bg-black/5 dark:hover:bg-white/5
                           {{ $isSettingsActive ? 'bg-black/5 dark:bg-white/10' : '' }}">
                
                <div class="flex items-center">
                    <x-ri-settings-4-line class="w-6 h-6 flex-shrink-0 mr-3 menu-icon {{ $isSettingsActive ? 'text-primary' : '' }}" />
                    <span class="sidebar-text font-medium">{{ __('sidebar.settings') }}</span>
                </div>
                
                <x-ri-arrow-down-s-line class="w-5 h-5 flex-shrink-0 arrow-icon transition-transform duration-300 {{ $isSettingsActive ? 'rotate-180' : '' }}" />
            </button>

            <div class="submenu {{ $isSettingsActive ? '' : 'hidden' }} transition-all duration-300">
                <div class="tree-line absolute left-[26px] top-0 bottom-2 w-px bg-custom-border opacity-50"></div>
                <ul class="space-y-1 mt-1">
                    
                    {{-- Sub-menu 1: Theme & Color --}}
                    @can('theme-color') 
                    <li>
                        <a href="{{ route('admin.theme') }}" 
                           class="sidebar-item relative flex items-center py-2.5 rounded-lg text-sm transition-all duration-200 pl-12 pr-4 hover:bg-black/5 dark:hover:bg-white/5
                                  {{ request()->routeIs('admin.theme') ? 'text-primary font-bold' : 'opacity-80' }}">
                            
                            <span class="tree-line absolute left-[22px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-2 border-sidebar-bg 
                                         {{ request()->routeIs('admin.theme') ? 'bg-primary' : 'bg-gray-400' }}"></span>
                            
                            <span>{{ __('sidebar.theme_color') }}</span>
                        </a>
                    </li>
                    @endcan

                    {{-- Sub-menu 2: General --}}
                    @can('setting-shop_info')
                    <li>
                        <a href="{{ route('admin.shop_info.index') }}" 
                           class="sidebar-item relative flex items-center py-2.5 rounded-lg text-sm transition-all duration-200 pl-12 pr-4 hover:bg-black/5 dark:hover:bg-white/5
                                  {{ request()->routeIs('admin.shop_info.index') ? 'text-primary font-bold' : 'opacity-80' }}">
                            
                            <span class="tree-line absolute left-[22px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full border-2 border-sidebar-bg 
                                         {{ request()->routeIs('admin.shop_info.index') ? 'bg-primary' : 'bg-gray-400' }}"></span>
                            
                            <span>{{ __('sidebar.shop_info') }}</span>
                        </a>
                    </li>
                    @endcan

                </ul>
            </div>
            
            <div class="tooltip hidden absolute left-[100%] top-2 ml-4 bg-gray-900 text-white text-xs px-3 py-2 rounded shadow-xl z-50 whitespace-nowrap">
                {{ __('sidebar.settings') }}
            </div>
        </div>

    </nav>

    <div class="p-1 border-t border-bor-color bg-black/5 dark:bg-black/20">
        <a href="https://t.me/Vannchinh11" target="_blank" class="sidebar-item flex items-center gap-3 p-2 rounded-xl transition-colors cursor-pointer menu-item-content hover:bg-black/5 dark:hover:bg-white/5">
            
            <img src="{{ asset('storage/creater/kuytangkoan.jpg') }}" 
                class="h-10 w-10 rounded-full object-cover border-2 border-primary flex-shrink-0 shadow-sm"
                alt="Creator Profile">
            
            <div class="sidebar-text overflow-hidden">
                <p class="text-sm font-semibold truncate text-text-color">{{ __('sidebar.created_by') }}</p>
                <p class="text-xs text-primary truncate font-medium flex items-center gap-1">
                    Kuy Tangkoan
                </p>
            </div>
        </a>
    </div>

</aside>

<div id="sidebarOverlay" 
     class="fixed inset-0 bg-black/50 z-40 hidden md:hidden glass transition-opacity opacity-0"
     onclick="toggleMobileSidebar()">
</div>