<aside id="default-sidebar" class="fixed top-[70px] left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 mt-2 font-medium">
            <li>
                <x-layout.sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-slot name="icon">
                        <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                            <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M9 4.025A7.5 7.5 0 1 0 16.975 12H9V4.025Z"/>
                                <path d="M12.5 1c-.169 0-.334.014-.5.025V9h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 12.5 1Z"/>
                            </g>
                        </svg>
                    </x-slot>
                    Dashboard
                </x-layout.sidebar-link>
            </li>
            @can('lihat-absensi')
            <li>
                <x-layout.sidebar-link href="{{ route('absences.index') }}" :active="request()->routeIs('absences.*')">
                    <x-slot name="icon">
                        <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.109 17H1v-2a4 4 0 0 1 4-4h.87M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm7.95 2.55a2 2 0 0 1 0 2.829l-6.364 6.364-3.536.707.707-3.536 6.364-6.364a2 2 0 0 1 2.829 0Z"/>
                        </svg>
                    </x-slot>
                    Absensi
                </x-layout.sidebar-link>
            </li>
            @endcan
            @can('lihat-penggajian')
            <li>
                <x-layout.sidebar-link href="{{ route('payments.index') }}" :active="request()->routeIs('payments.*')">
                    <x-slot name="icon">
                        <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                        </svg>
                    </x-slot>
                    Penggajian
                </x-layout.sidebar-link>
            </li>
            @endcan
            @can('lihat-pengeluaran')
            <li>
                <x-layout.sidebar-link href="{{ route('cashflows.index') }}" :active="request()->routeIs('cashflows.*')">
                    <x-slot name="icon">
                        <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.905 1.316 15.633 6M18 10h-5a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h5m0-5a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1m0-5V7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h15a1 1 0 0 0 1-1v-3m-6.367-9L7.905 1.316 2.352 6h9.281Z"/>
                        </svg>
                    </x-slot>
                    Pengeluaran
                </x-layout.sidebar-link>
            </li>
            @endcan
            @can('lihat-pegawai')
            <li>
                <x-layout.sidebar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                    <x-slot name="icon">
                        <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3a3 3 0 1 1-1.614 5.53M15 12a4 4 0 0 1 4 4v1h-3.348M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM5 11h3a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
                        </svg>
                    </x-slot>
                    Pegawai
                </x-layout.sidebar-link>
            </li>
            @endcan
            @can('lihat-jabatan')
            <li>
                <x-layout.sidebar-link href="{{ route('roles.index') }}" :active="request()->routeIs('roles.*')">
                    <x-slot name="icon">
                        <svg class="w-4 h-4 text-gray-600 dark:text-white rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10v5m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 0v3a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V5m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                        </svg>
                    </x-slot>
                    Jabatan
                </x-layout.sidebar-link>
            </li>
            @endcan
        </ul>
    </div>
</aside>
