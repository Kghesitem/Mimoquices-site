<!-- Inclui Alpine.js no head ou antes do fechamento do body -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<section class="space-y-6" x-data="{ open: false }">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Eliminar Conta') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Eliminar permanentemente a sua conta.') }}
        </p>
    </header>

    <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
        {{ __('Assim que a sua conta for eliminada, todos os seus recursos e dados serão permanentemente excluídos. Antes de eliminar a sua conta, por favor, transfira quaisquer dados ou informações que deseje manter.') }}
    </div>

    <!-- Botão para abrir o modal -->
    <div class="mt-5">
        <x-danger-button @click="open = true">
            {{ __('Eliminar Conta') }}
        </x-danger-button>
    </div>

    <!-- Modal pop-up -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        style="display: none;"
    >
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full"style="
    margin-top: 20px;
    border-bottom-width: 10px;
    padding-top: 10px;
    padding-left: 10px;
    padding-bottom: 10px;
    padding-right: 10px;
">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Tem a certeza?') }}
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                {{ __('Esta ação é irreversível. Todos os dados da sua conta serão permanentemente eliminados.') }}
            </p>
            <div class="flex justify-end gap-3">
                <button
                    @click="open = false"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded hover:bg-gray-300 dark:hover:bg-gray-600"
                >
                    {{ __('Cancelar') }}
                </button>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        {{ __('Eliminar Conta') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
