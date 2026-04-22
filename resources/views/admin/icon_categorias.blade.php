<div class="dash-card-admin" style="padding: 2rem; max-width: 65%; margin: 2rem auto; background-color: #ffffff; border-radius: 1.5rem;">
    <h1> 🗂️ Gestão de Categorias</h1>

    @if ($errors->any())
    <div style="padding: 0 2rem; padding-top: 1.5rem;">
        <div class="error-container">
            <strong>⚠️ Erro nas categorias</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    
    <div class="opcoes-grid" id="gridPersonalizacoes" style="display: flex; flex-direction: row; gap: 2rem; margin-top: 3rem">
        @foreach($tipos as $tipo)     
            <div class="opcao-item" style="max-width: 25%;">
                <div class="opcao-descricao">
                    <label for="{{ $tipo->id }}">
                        {{ $tipo->Categoria }}
                    </label>
                    <a href="{{ route('categoria.edit', ['id' => $tipo->id]) }}" class="btn btn-sm btn-outline-primary" title="Editar categoria" style="margin-top: 0.5rem;">
                        ✏️ Editar
                    </a>
                    <form action="{{ route('categoria.destroy', ['id' => $tipo->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Excluir categoria" style="margin-top: 0.5rem;" onclick="if(confirm('Tem certeza que deseja excluir esta categoria?'))">
                            🗑️ Excluir
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>