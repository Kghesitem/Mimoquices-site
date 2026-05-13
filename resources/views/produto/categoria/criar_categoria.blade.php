@include('partial.header')

<head>
    <title>Criar Categoria - Mimoquices</title>
</head>

<a class="btn botao-voltar mt-4 text-decoration-none d-flex justify-content-center" href="{{ url('/dashboard') }}">
    ← Voltar
</a>

<main class="profile-page py-5">
    <div class="container">
        <div class="form-container">
            <!-- Título Dinâmico -->
            <h1 id="tituloPagina">
                <x-heroicon-c-plus id="iconTitulo" style="width: 4rem; height: 4rem; color:var(--main_color);" /> 
                <span id="textoTitulo">Criar Categoria</span>
            </h1>

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

            <!-- FORMULÁRIO DE CRIAÇÃO -->
            <form method="post" action="{{ route('categoria.store') }}" id="formCriar">
                @csrf
                <div class="form-group" id="inputCategoria">
                    <label for="Categoria">Título da Categoria</label>
                    <input type="text" class="form-control" name="Categoria" placeholder="Ex.: Papelaria, Agendas..." required value="{{ old('Categoria') }}" />
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
                        <div class="d-flex gap-2" style="margin-top: -1.5rem;">
                            <!-- Botão Adicionar (Link) -->
                            <a href="{{ route('personalizacao.criar') }}" class="btn btn-sm btn-outline-primary" title="Adicionar nova personalização ao sistema">
                                <x-heroicon-c-plus style="width: 1.5rem; height: 1.5rem; color:var(--main_color);" />
                            </a>
                            <!-- Botão Menos (Alternar Modo) -->
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar personalizações do sistema" id="remove">
                                <x-heroicon-c-minus style="width: 1.5rem; height: 1.5rem;" />
                            </button>
                        </div>
                    </div>

                    <div class="opcoes-grid" id="gridPersonalizacoes">
                        @foreach($todas_personalizações as $personalizacao)     
                            <div class="opcao-item">
                                <input type="checkbox" id="p-{{ $personalizacao->id }}" name="personalizacoes[]" value="{{ $personalizacao->id }}">
                                <div class="opcao-descricao">
                                    <label for="p-{{ $personalizacao->id }}"> {{ $personalizacao->titulo }} </label>
                                    <small>{{ $personalizacao->descricao }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn-submit" id="btnGuardar">
                    <x-heroicon-c-bookmark style="width: 1.5rem; height: 1.5rem;"/> Guardar Categoria
                </button>
            </form>

         <!-- FORMULÁRIO DE ELIMINAÇÃO (Dentro da <main>) -->
<form method="POST" action="{{ route('personalizacao.destroy') }}" id="formEliminar" style="display: none;">
    @csrf
    @method('DELETE')
    
    <div class="alert alert-warning d-flex align-items-center">
        <x-heroicon-o-exclamation-triangle style="width: 1.5rem; height: 1.5rem; margin-right: 10px;" />
        <span><strong>Modo de Exclusão:</strong> Selecione as personalizações que deseja apagar do sistema.</span>
    </div>

    <div class="opcoes-grid" id="gridEliminar">
        @foreach($todas_personalizações as $personalizacao)     
            <div class="opcao-item border-danger">
                <input type="checkbox" name="personalizacoes[]" value="{{ $personalizacao->id }}" id="del-{{ $personalizacao->id }}">
                <div class="opcao-descricao">
                    <label for="del-{{ $personalizacao->id }}" class="text-danger font-weight-bold"> {{ $personalizacao->titulo }} </label>
                    <small>{{ $personalizacao->descricao }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <!-- GRUPO DE BOTÕES -->
    <div class="d-flex gap-3 mt-4">
        <button type="button" class="btn-submit bg-danger flex-grow-1" id="btnConfirmarEliminar">
            Eliminar Permanentemente
        </button>
        
        <!-- NOVO BOTÃO PARA VOLTAR -->
        <button type="button" class="btn-submit bg-secondary flex-grow-1" id="btnVoltarModo">
            Cancelar / Voltar
        </button>
    </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const removeBtn = document.getElementById("remove");
    const btnVoltarModo = document.getElementById("btnVoltarModo");
    const formCriar = document.getElementById("formCriar");
    const formEliminar = document.getElementById("formEliminar");
    const textoTitulo = document.getElementById("textoTitulo");
    
    // Função única para alternar os modos
    function toggleModo() {
        const isEliminar = formEliminar.style.display === "none";

        if (isEliminar) {
            formCriar.style.display = "none";
            formEliminar.style.display = "block";
            textoTitulo.innerText = "Eliminar Personalizações";
            removeBtn.classList.replace("btn-outline-danger", "btn-danger");
        } else {
            formCriar.style.display = "block";
            formEliminar.style.display = "none";
            textoTitulo.innerText = "Criar Categoria";
            removeBtn.classList.replace("btn-danger", "btn-outline-danger");
        }
    }
    

    // Evento no ícone de "menos"
    removeBtn.addEventListener("click", toggleModo);

    // Evento no novo botão "Voltar"
    btnVoltarModo.addEventListener("click", toggleModo);

    
});

</script>
@include('partial.footer')