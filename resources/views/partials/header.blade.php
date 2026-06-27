<header 
    x-data="{ userDropdownOpen: false, languageOpen: false }" 
    x-effect="if ($store.theme.darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark');"
    {{-- 
       ចំណុចសំខាន់ដែលកែប្រែ៖
       1. ប្រើ bg-header-bg (ជំនួសឱ្យ bg-white dark:bg-gray-900) ដើម្បីឱ្យវាចាប់យកពណ៌ពី var(--header-bg)
       2. ប្រើ border-border-color (ជំនួសឱ្យ border-gray-200) ដើម្បីឱ្យបន្ទាត់បាតចាប់យកពណ៌ពី var(--custom-border) ផងដែរ
    --}}
    class="bg-header-bg border-b border-bor-color h-16 flex items-center justify-between px-6 shadow-sm z-10 sticky top-0 transition-colors duration-300">

    <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 transition-colors flex items-center justify-center">
        <x-ri-menu-2-line class="w-6 h-6 text-gray-500" />
    </button>

    <div class="flex items-center gap-4">
        
        {{-- Theme Toggle --}}
        <button type="button" @click="$store.theme.setMode($store.theme.darkMode ? 'light' : 'dark')" class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900" :class="!$store.theme.darkMode ? 'bg-gray-200' : ''" :style="$store.theme.darkMode ? 'background-color: var(--primary, #308D71)' : ''">
            <span class="sr-only">Toggle Dark Mode</span>
            <span class="inline-block h-6 w-6 transform rounded-full bg-white shadow-md transition duration-300 ease-in-out flex items-center justify-center" :class="$store.theme.darkMode ? 'translate-x-7' : 'translate-x-1'">
                {{-- បានប្តូរពី <i> មកជា SVG Component វិញ --}}
                <x-ri-sun-fill x-show="!$store.theme.darkMode" class="w-4 h-4 text-yellow-500" />
                <x-ri-moon-fill x-show="$store.theme.darkMode" class="w-4 h-4" :style="'color: var(--primary, #308D71)'" />
            </span>
        </button>

        {{-- Language Switcher --}}
        <div class="relative">
            <button @click="languageOpen = !languageOpen" class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 transition-colors">
                @if(App::getLocale() == 'km')
                    <img src="https://flagcdn.com/w40/kh.png" alt="Khmer" class="w-6 h-auto rounded-sm shadow-sm object-cover">
                    <span class="text-sm font-medium hidden sm:block">KH</span>
                @else
                    <img src="https://flagcdn.com/w40/us.png" alt="English" class="w-6 h-auto rounded-sm shadow-sm object-cover">
                    <span class="text-sm font-medium hidden sm:block">EN</span>
                @endif
                
                {{-- បានប្តូរពី ::class មកប្រើ x-bind:class វិញការពារ Error កូដ Blade --}}
                <x-ri-arrow-down-s-line class="w-5 h-5 transition-transform duration-200" x-bind:class="{'rotate-180': languageOpen}" />
            </button>

            <div x-show="languageOpen" 
                 @click.outside="languageOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 border border-gray-100 dark:border-gray-700 z-50 origin-top-right"
                 style="display: none;">
                
                <a href="{{ route('switch.language', 'km') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ App::getLocale() == 'km' ? 'bg-gray-50 dark:bg-gray-700/50 text-blue-600 font-semibold' : '' }}">
                    <img src="https://flagcdn.com/w40/kh.png" alt="Khmer" class="w-5 h-auto rounded-sm shadow-sm">
                    <span>ភាសាខ្មែរ</span>
                    @if(App::getLocale() == 'km') <x-ri-check-line class="w-4 h-4 ml-auto text-blue-600" /> @endif
                </a>

                <a href="{{ route('switch.language', 'en') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ App::getLocale() == 'en' ? 'bg-gray-50 dark:bg-gray-700/50 text-blue-600 font-semibold' : '' }}">
                    <img src="https://flagcdn.com/w40/us.png" alt="English" class="w-5 h-auto rounded-sm shadow-sm">
                    <span>English</span>
                    @if(App::getLocale() == 'en') <x-ri-check-line class="w-4 h-4 ml-auto text-blue-600" /> @endif
                </a>
            </div>
        </div>

        {{-- Notification --}}
        <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 relative flex items-center justify-center">
            <x-ri-notification-3-line class="w-5 h-5 text-gray-500" />
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-gray-900"></span>
        </button>

        {{-- User Dropdown --}}
        <div class="relative">
           <button @click="userDropdownOpen = !userDropdownOpen" 
                   class="h-8 w-8 rounded-full flex items-center justify-center text-primary font-bold text-sm shadow-md cursor-pointer focus:outline-none ring-2 ring-secondary focus:ring-primary transition-all p-0 overflow-hidden
                   {{ Auth::user()->avatar ? 'bg-transparent' : 'bg-gradient-to-tr' }}">
                
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                        alt="{{ Auth::user()->name }}" 
                        class="h-full w-full object-cover">
                @else
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                @endif

            </button>

            <div x-show="userDropdownOpen" 
                 @click.outside="userDropdownOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 border border-gray-100 dark:border-gray-700 z-50 origin-top-right"
                 style="display: none;">
                
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>

                {{-- បានប្តូរ class ពី block ទៅជា flex items-center ដើម្បីឱ្យ Icon និងអក្សរស្ថិតនៅមួយជួរស្មើគ្នា --}}
                <a href="{{ route('admin.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <x-ri-user-line class="w-4 h-4 mr-2" /> {{ __('messages.profile') }}
                </a>

                <a href="{{ route('admin.password') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <x-ri-lock-password-line class="w-4 h-4 mr-2" /> {{ __('messages.change_password') }}
                </a>

                <button 
                    @click.prevent="logoutUser()" 
                    type="button" 
                    class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                    
                    <x-ri-logout-box-line class="w-4 h-4 mr-2" /> Logout
                </button>

                <script>
                    function logoutUser() {
                        fetch("{{ route('logout') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.redirect_url) {
                                Livewire.navigate(data.redirect_url);
                            } else {
                                window.location.href = '/login';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            window.location.reload(); 
                        });
                    }
                </script>
            </div>
        </div>

    </div>
</header>