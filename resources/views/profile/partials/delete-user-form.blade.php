<section class="space-y-6">
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

    <div class="mt-5">
        <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <x-danger-button type="button"
                            onclick="confirmDeleteAccount()"
                            onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); confirmDeleteAccount(); }">
                {{ __('Eliminar Conta') }}
            </x-danger-button>
        </form>
    </div>
</section>

<script>
    function confirmDeleteAccount() {
        Swal.fire({
            title: '{{ __("Tem a certeza?") }}',
            text: '{{ __("Esta ação é irreversível. Todos os dados da sua conta serão permanentemente eliminados.") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("Sim, eliminar conta") }}',
            cancelButtonText: '{{ __("Cancelar") }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Se o utilizador confirmar, submete o formulário
                document.getElementById('delete-account-form').submit();
            }
        });
    }
</script>
