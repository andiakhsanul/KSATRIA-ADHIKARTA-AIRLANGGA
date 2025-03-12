<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('assets/unair.png') }}">
</head>

<body class="bg-gray-50">
    @yield('content')

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                document.body.classList.add('overflow-hidden');
                modal.classList.remove('hidden');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                document.body.classList.remove('overflow-hidden');
                modal.classList.add('hidden');
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('[id$="Modal"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const visibleModal = document.querySelector('[id$="Modal"]:not(.hidden)');
                if (visibleModal) {
                    closeModal(visibleModal.id);
                }
            }
        });

        function deleteItem() {
            alert('Item deleted successfully!');
            closeModal('exampleModal');
        }
    </script>

    <footer class="mt-4 border-t border-gray-200 bg-white py-3 h-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-row items-center justify-between">
                <!-- Logo and copyright in single line -->
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('assets/unair.png') }}" alt="Airlangga University" class="h-6 w-auto">
                    <span class="text-xs text-gray-500">© {{ date('Y') }} KSATRIA ADHIKARTA AIRLANGGA</span>
                </div>

                <!-- Credits -->
                <div class="mt-1">
                    <p class="text-xs text-gray-400">Developed by <a href="https://www.instagram.com/a.akhsanl/"
                            target="_black" class="text-[#0975cb] hover:underline">@a.akhsanl</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
