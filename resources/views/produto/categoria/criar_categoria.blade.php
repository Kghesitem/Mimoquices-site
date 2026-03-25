@include('partial.header')

<head>
    <title>Criar Categoria - Mimoquices</title>
</head>

<a class="btn btn-outline-primary mt-4 text-decoration-none d-flex justify-content-center" href="{{ url('/dashboard') }}" style="width: 150px; margin: 0 auto;">
    ← Voltar
</a>

<main class="profile-page py-5">
    <div class="container">
        
        <div class="form-container">
            <h1>➕ Criar Categoria</h1>

            @if($errors->any())
            <div class="alert-errors">
                <strong>Erros encontrados:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="post" action="{{ route('categoria.store') }}">
                @csrf
                @method('post')

                <div class="form-group"id="inputCategoria">
                    <label for="Categoria">Título da Categoria</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        
                        name="Categoria" 
                        placeholder="Ex.: Papelaria, Agendas..." 
                        required
                        value="{{ old('Categoria') }}"
                    />
                </div>

                <hr style="border-top: 1px dashed var(--main_color); margin: 2rem 0;">

                <div class="form-group">
    <div class="d-flex justify-content-between align-items-center gap-2">
        <div>
            <label class="mb-0">Selecione as Personalizações Permitidas</label>
        <small class="text-muted d-block mb-3">
            Os produtos desta categoria poderão usar as opções selecionadas abaixo.
        </small>
        </div>
        <a href="{{ route('personalizacao.criar') }}">
            <button type="button" class="btn btn-sm btn-outline-primary" title="Adicionar personalização" style="margin-top: -1.5rem;">
                ➕
            </button>
        </a>
        <button type="button" class="btn btn-sm btn-outline-primary" title="Remover personalização" style="margin-top: -1.5rem;" id="remove">
            ➖
        </button>
               
    </div>

    
        <div class="opcoes-grid" id="gridPersonalizacoes">
            @foreach($todas_personalizações as $personalizacao)     
                <div class="opcao-item">
                    <input
                        type="checkbox"
                        id="{{ $personalizacao->id }}"
                        name="personalizacoes[]"
                        value="{{ $personalizacao->id }}"
                    >
                <div class="opcao-descricao">
                    <label for="{{ $personalizacao->id }}">
                        {{ $personalizacao->titulo }}
                    </label>
                    <small>{{ $personalizacao->descricao }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>  
    <button type="submit" class="btn-submit" id="btnGuardar">💾 Guardar Categoria</button>
        </form>

            <form method="POST" action="{{ route('personalizacao.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="opcoes-grid" id="gridEliminar">
                    @foreach($todas_personalizações as $personalizacao)     
                        <div class="opcao-item">
                            <input
                                type="checkbox"
                                name="personalizacoes[]"
                                value="{{ $personalizacao->id }}"
                                id="personalizacao-{{ $personalizacao->id }}"
                            >
                            <div class="opcao-descricao">
                                <label for="personalizacao-{{ $personalizacao->id }}">
                                    {{ $personalizacao->titulo }}
                                </label>
                                <small>{{ $personalizacao->descricao }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn-submit" id="btnEliminar">Eliminar Personalizações</button>
            </form>

        </div>
    </div>
</main>

<script>
const removeBtn = document.getElementById("remove");
const btnEliminar = document.getElementById("btnEliminar");
const btnGuardar = document.getElementById("btnGuardar");
const inputCategoria = document.getElementById("inputCategoria");
const gridPersonalizacoes = document.getElementById("gridPersonalizacoes");
const gridEliminar = document.getElementById("gridEliminar");
let ativo = false;

// começa escondido
btnEliminar.style.display = "none";
gridEliminar.style.display = "none";

removeBtn.addEventListener("click", function () {
    ativo = !ativo;

    if (ativo) {
        btnEliminar.style.display = "inline-block";
        btnGuardar.style.display = "none";
        inputCategoria.style.display = "none";
        gridPersonalizacoes.style.display = "none";
        gridEliminar.style.display = "grid";
    } else {
        btnEliminar.style.display = "none";
        btnGuardar.style.display = "inline-block";
        inputCategoria.style.display = "block";
        gridPersonalizacoes.style.display = "grid";
        gridEliminar.style.display = "none";
    }
});
</script>


@include('partial.footer')