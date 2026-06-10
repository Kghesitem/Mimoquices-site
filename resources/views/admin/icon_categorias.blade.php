<div class="dash-card-admin" style="padding: 2rem; max-width: 65%; margin: 2rem auto; background-color: #ffffff; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
    <h1 style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.75rem; margin-bottom: 0;">
        <x-heroicon-m-folder-open style="width: 3rem; height: 3rem; color:var(--main_color);" />
        Gestão de Categorias
    </h1>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Erro!',
                    html: "{!! implode('<br>', array_map('e', $errors->all())) !!}",
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <div class="opcoes-grid" id="gridPersonalizacoes" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem; margin-top: 2.5rem;">
        @foreach($tipos as $tipo)
            <div class="opcao-item" style="border: 1px solid #ebdada; border-radius: 0.75rem; padding: 1rem; background-color: #fdfbfb; display: flex; flex-direction: column; justify-content: space-between; min-height: 150px;">
                <div class="opcao-descricao" style="display: flex; flex-direction: column; height: 100%; justify-content: space-between; text-align: center;width: 100%;">

                    <label for="{{ $tipo->id }}" style="font-weight: 700; font-size: 1.05rem; color: #111; margin-bottom: 0.75rem; word-break: break-word; text-align: center; width: 100%;">
                        {{ $tipo->Categoria }}
                    </label>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%; align-items: center; justify-content: center; margin-top: auto;">
                        <a href="{{ route('categoria.edit', ['id' => $tipo->id]) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" title="Editar categoria" style="gap: 0.25rem; font-weight: 600; width: 100%; box-sizing: border-box;">
                            <x-heroicon-s-pencil style="width: 0.9rem; height: 0.9rem; color:blue"/> Editar
                        </a>

                        <form action="{{ route('categoria.destroy', ['id' => $tipo->id]) }}" method="POST" style="display: block; width: 100%; margin: 0;" class="form-eliminar-categoria">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar-categoria d-flex align-items-center justify-content-center" title="Excluir categoria" style="gap: 0.25rem; font-weight: 600; width: 100%; box-sizing: border-box;">
                                <x-heroicon-c-trash style="width: 0.9rem; height: 0.9rem; color:red"/> Excluir
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>

<script src="{{ asset('frontend/assets/js/sweetalert2.all.min.js') }}"></script>

<script>
$(document).ready(function() {
    $(document).on('click', '.btn-eliminar-categoria', function(e) {
        e.preventDefault();
        const form = $(this).closest('.form-eliminar-categoria');

        Swal.fire({
            title: 'Excluir categoria?',
            text: "Se esta categoria contiver produtos ou pedidos associados, esta ação poderá causar erros de integridade ou apagar dados dependentes!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
