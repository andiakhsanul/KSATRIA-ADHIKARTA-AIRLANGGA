    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:relative top-0 left-0 z-40 min-h-screen w-64 bg-white border-r border-gray-200 shadow-sm transition-transform duration-300 ease-in-out lg:translate-x-0">

        <!-- Logo / Header -->
        <div class="flex items-center justify-center h-16 border-b border-gray-100">
            <h2 class="text-xl font-bold text-blue-600">KSATRIA ADHIKARTA</h2>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-1 overflow-y-auto max-h-[calc(100vh-4rem)]">
            <!-- Dashboard -->
            <a href="{{ url('dashboard') }}"
                class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('dashboard*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-3 {{ request()->is('dashboard*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="font-medium">Dashboard</span>
                @if (request()->is('dashboard*'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                @endif
            </a>

            @if (Auth::user()->tim_id === null && Auth::user()->role_id === 3)
                <a href="{{ route('tim.create', Auth::id()) }}"
                    class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('tim*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-3 {{ request()->is('tim*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-medium">Buat Tim</span>
                    @if (request()->is('tim*'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                </a>
            @elseif(Auth::user()->tim_id !== null)
                <a href="{{ route('tim.index', Auth::id()) }}"
                    class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('my-tim*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-3 {{ request()->is('my-tim*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-medium">Tim Saya</span>
                    @if (request()->is('my-tim*'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                </a>
            @endif

            <!-- Management Section -->
            @if (Auth::user()->role_id === 1)
                <div class="pt-5 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Manajemen
                    </p>
                </div>

                <a href="{{ route('user.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('user*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-3 {{ request()->is('user*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-medium">Manajemen User</span>
                    @if (request()->is('user*'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                </a>

                <a href="{{ route('reviewer.assignments') }}"
                    class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('reviewer*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-3 {{ request()->is('reviewer*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="font-medium">Manajemen Reviewer</span>
                    @if (request()->is('reviewer*'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                </a>

                <a href="{{ route('operator.proposal.index') }}"
                    class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('manajemen*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-3 {{ request()->is('manajemen*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium">Manajemen Proposal</span>
                    @if (request()->is('manajemen*'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                </a>
            @endif

            <!-- Proposal Section -->
            @if (!empty(Auth::user()->tim_id) || Auth::user()->role_id === 2)
                <div class="pt-5 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Proposal
                    </p>
                </div>

                @if (Auth::user()->role_id === 3)
                    <a href="{{ route('proposal.index', Auth::user()->tim_id) }}"
                        class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('proposal/index*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-3 {{ request()->is('proposal/index*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">My Proposal</span>
                        @if (request()->is('proposal/index*'))
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    </a>
                @endif

                @if (Auth::user()->role_id === 2)
                    <a href="{{ route('operator.proposal.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-md transition-colors group {{ request()->is('operator/proposal*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-3 {{ request()->is('operator/proposal*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-medium">Proposal Review</span>
                        @if (request()->is('operator/proposal*'))
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        @endif
                    </a>
                @endif


            @endif
        </nav>
    </aside>

    <!-- Mobile sidebar toggle button -->
    <button @click="sidebarOpen = !sidebarOpen"
        class="fixed top-4 left-4 z-50 p-2 rounded-md bg-white shadow-md text-gray-700 lg:hidden focus:outline-none focus:ring-2 focus:ring-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <span class="sr-only">Toggle Sidebar</span>
    </button>

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>
