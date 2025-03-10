<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title')</title>
</head>

<body class="flex min-h-screen bg-black">

    <!-- Sidebar -->
    @include('Components.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 text-white ml-64 lg:ml-0">
        {{-- header --}}
        <div class="header mb-5">
            <h1 class="text-xl font-bold">@yield('content-title')</h1>
        </div>

        @yield('content')
    </div>

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


</body>


</html>
