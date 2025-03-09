 <!-- Sidebar -->
 <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
     class="fixed lg:relative top-0 left-0 z-10 min-h-screen w-64 bg-black border-r-2 border-zinc-800 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 flex-shrink-0">
     <!-- Logo / Header -->
     <div class="flex items-center justify-center h-16 mt-2">
         <h2 class="text-xl font-bold">KSATRIA ADHIKARTA</h2>
     </div>

     <!-- Navigation -->
     <nav class="mt-4 px-2 space-y-1">

         <!-- Dashboard -->
         <a href="{{ url('dashboard') }}"
             class="flex items-center px-4 py-2 text-gray-300 {{ request()->is('dashboard*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }} rounded-md transition-colors group">
             <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 mr-3 {{ request()->is('dashboard*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
             </svg>
             <span>Dashboard</span>
         </a>
         @if (Auth::user()->tim_id === null && Auth::user()->role_id === 3)
             <a href="{{ route('tim.create', Auth::id()) }}"
                 class="flex items-center px-4 py-2 {{ request()->is('tim*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}  hover:text-white rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                 </svg>
                 <span>Buat Tim</span>
             </a>
         @elseif(Auth::user()->tim_id !== null)
             <a href="{{ route('tim.index', Auth::id()) }}"
                 class="flex items-center px-4 py-2 {{ request()->is('my-tim*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}  hover:text-white rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                 </svg>
                 <span>Tim Saya</span>
             </a>
         @else
         @endif


         <!-- Management Section -->
         @if (Auth::user()->role_id === 1)
             <!-- operator -->
             <div class="pt-4 pb-2">
                 <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                     Manajemen
                 </p>
             </div>

             <a href="{{ route('user.index') }}" class="flex items-center px-4 py-2 {{ request()->is('user*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }} hover:text-white rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                 </svg>
                 <span>Manajemen User</span>
             </a>

             <a href="{{ route('reviewer.assignments') }}"
                 class="flex items-center px-4 py-2 {{ request()->is('reviewer*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}  hover:text-white rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                 </svg>
                 <span>Manajemen Reviewer</span>
             </a>

             <a href="{{ route('operator.proposal.index') }}"
                 class="flex items-center px-4 py-2 {{ request()->is('manajemen*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }} rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                 </svg>
                 <span>Manajemen Proposal</span>
             </a>

             <a href=""
                 class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                 </svg>
                 <span>Manajemen Tim</span>
             </a>
         @endif

         <!-- Proposal Section -->
         @if (!empty(Auth::user()->tim_id) || Auth::user()->role_id === 2)
             <div class="pt-4 pb-2">
                 <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                     Proposal
                 </p>
             </div>
             @if (Auth::user()->role_id === 3)
                 <a href="{{ route('proposal.index', Auth::user()->tim_id) }}"
                     class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors group">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                     </svg>
                     <span>Submit Proposal</span>
                 </a>
             @endif

             <a href="{{ route('operator.proposal.index') }}"
                 class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                 </svg>
                 <span>Proposal Review</span>
             </a>

             <a href=""
                 class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md transition-colors group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                 </svg>
                 <span>Proposal Revisi</span>
             </a>
         @endif

     </nav>
 </aside>
