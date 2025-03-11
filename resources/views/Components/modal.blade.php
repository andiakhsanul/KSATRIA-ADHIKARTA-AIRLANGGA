<div id="{{ $id }}" class="fixed inset-0 bg-black/30 z-40 hidden flex items-center justify-center p-4">

    <div class="bg-white rounded-xl shadow-xl border border-gray-200 w-full max-w-md mx-auto z-50 overflow-hidden transform transition-all"
        role="dialog" aria-modal="true" aria-labelledby="modal-title-{{ $id }}">

        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 id="modal-title-{{ $id }}" class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            <button type="button" onclick="closeModal('{{ $id }}')"
                class="text-gray-500 hover:text-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="px-6 py-4">
            {{ $slot }}
        </div>

    </div>
</div>
