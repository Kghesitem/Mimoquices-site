@include('partial.header')
<head>
    <title>Editar Categoria - Mimoquices</title>
</head>

<a class="btn botao-voltar mt-4 text-decoration-none d-flex justify-content-center" href="{{ url('/dashboard') }}">
        ← Voltar
    </a>

<main class="profile-page py-5">
    <div class="container">
        
        <div class="form-container">
            <h1><x-heroicon-m-folder-open style=" width: 3rem; height: 3rem; color:var(--main_color);" /> Editar Categoria</h1>

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

            <form method="post" action="{{ route('categoria.update', ['id' => $categoria->id]) }}">
                @csrf
                @method('put')

                <div class="form-group"id="inputCategoria">
                    <label for="Categoria">Título da Categoria</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="Categoria" 
                        placeholder="Ex.: Papelaria, Agendas..." 
                        required
                        value="{{ $categoria->Categoria }}"
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
                <x-heroicon-c-plus style=" width: 1.5rem; height: 1.5rem; color:var(--main_color);" />
            </button>
        </a>               
    </div>

    
        <div class="opcoes-grid" id="gridPersonalizacoes">
            @foreach($todas_personalizações as $personalizacao)     
                <div class="opcao-item">
                    <input
                        type="checkbox"
                        id="{{ $personalizacao->id }}"
                        name="personalizacoes[]"
                        value="{{ $personalizacao->id }}"

                        @foreach($associados as $associado)
                                    @if($associado->id_todas == $personalizacao->id)
                                        checked
                                    @endif
                                @endforeach
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
    <button type="submit" class="btn-submit" id="btnGuardar"><x-heroicon-c-bookmark style="1.5rem; height: 1.5rem;"/> Guardar Categoria</button>
        </form>

        </div>
    </div>
</main>




@include('partial.footer')