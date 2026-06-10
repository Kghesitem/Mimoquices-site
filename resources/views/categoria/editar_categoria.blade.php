<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>

@include('partial.header')

<main style="padding: 1rem 1rem;">
<div class="auth-container auth-container-full">

    {{-- Botão Voltar --}}
    <div class="d-flex justify-content-center" style="margin-bottom: 1.5rem;">
        <a class="btn botao-voltar text-decoration-none d-inline-flex align-items-center" href="{{ url('/dashboard') }}" style="gap: 0.5rem;">
            ← Voltar para o Dashboard
        </a>
    </div>

    {{-- CABEÇALHO DA PÁGINA (Dinâmico para os dois modos) --}}
    <div class="auth-header rounded" style="text-align: left; margin-bottom: 2.5rem;">
        <h1>
            <x-heroicon-m-folder-open id="iconTitulo" style="width: 2.5rem; height: 2.5rem; vertical-align: middle;"/>
            <span id="textoTitulo">Editar Categoria</span>
        </h1>
        <p id="descricaoPagina" style="text-align: center;">Gerencie a estrutura do catálogo configurando as opções e permissões de categorias abaixo</p>
    </div>

    {{-- TRATAMENTO DE ERROS VIA SWEETALERT --}}
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

    {{-- FORMULÁRIO 1: EDIÇÃO DE CATEGORIA --}}
    <form method="post" action="{{ route('categoria.update', ['id' => $categoria->id]) }}" id="formEditar" class="auth-form" style="max-width: 100%;">
        @csrf
        @method('put')

        <div class="form-grid-layout" style="display: block;">

            {{-- Campo Nome da Categoria --}}
            <div class="form-group" id="inputCategoria">
                <label for="Categoria" class="form-label">Título da Categoria</label>
                <input
                    type="text"
                    id="Categoria"
                    class="form-input {{ $errors->has('Categoria') ? 'is-invalid' : '' }}"
                    name="Categoria"
                    placeholder="Ex.: Papelaria, Agendas..."
                    required
                    value="{{ old('Categoria', $categoria->Categoria) }}"
                />
            </div>

            <hr style="border-top: 1px dashed var(--main_color); margin: 2rem 0;">

            {{-- Secção de Seleção de Personalizações --}}
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center gap-2" style="flex-wrap: wrap; margin-bottom: 1rem;">
                    <div>
                        <span class="form-label fw-bold" style="margin-bottom: 0; display: block;">Selecione as Personalizações Permitidas</span>
                        <small class="text-muted" style="display: block; font-size: 0.85rem;">
                            Os produtos desta categoria poderão usar as opções selecionadas abaixo.
                        </small>
                    </div>
                    <div class="d-flex gap-2">
                        {{-- Botão Adicionar (Link) --}}
                        <a href="{{ route('personalizacao.criar') }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center justify-content-center" style="padding: 0.25rem;" title="Adicionar nova personalização ao sistema">
                            <x-heroicon-c-plus style="width: 1.5rem; height: 1.5rem; color: var(--main_color);" />
                        </a>
                        {{-- Botão Menos (Alternar Modo) --}}
                        <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center justify-content-center" style="padding: 0.25rem;" title="Eliminar personalizações do sistema" id="remove">
                            <x-heroicon-c-minus style="width: 1.5rem; height: 1.5rem;" />
                        </button>
                    </div>
                </div>

                {{-- Grid de Checkboxes com verificação de itens associados --}}
                <div class="opcoes-grid" id="gridPersonalizacoes" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 0.75rem;">
                    @foreach($todas_personalizacoes as $personalizacao)
                        <div class="opcao-item border rounded-3 p-3 mb-3 shadow-sm bg-white d-flex align-items-start gap-3">

                            {{-- Checkbox --}}
                            <div class="form-check" style="padding-left: 0;">
                                <input
                                type="checkbox"
                                id="p-{{ $personalizacao->id }}"
                                name="personalizacoes[]"
                                value="{{ $personalizacao->id }}"
                                @foreach($associados as $associado)
                                    @if($associado->id_todas == $personalizacao->id)
                                        checked
                                    @endif
                                @endforeach
                            >
                            </div>

                            {{-- Conteúdo --}}
                            <div class="flex-grow-1">

                                <label
                                    for="p-{{ $personalizacao->id }}"
                                    class="fw-semibold mb-1 d-block"
                                    style="cursor: pointer;"
                                >
                                    {{ $personalizacao->titulo }}
                                </label>

                                <small class="text-muted d-block mb-2">
                                    {{ $personalizacao->descricao }}
                                </small>

                                {{-- Botão editar redirecionando para a rota correta configurada --}}
                                <a
                                    href="{{ route('personalizacao.edit', ['id' => $personalizacao->id]) }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                    title="Editar personalização"
                                >
                                    <x-heroicon-s-pencil style="width: 0.9rem; height: 0.9rem;" />
                                    Editar
                                </a>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Campo de Opções Dinâmicas (Ajustado para usar $respostas do Controller sem gerar erro) --}}
            <div class="form-group" id="opcoes-wrapper" style="{{ in_array($personalizacao->tipo_de_input, ['select', 'checkbox']) ? 'display: block;' : 'display: none;' }}">

                {{-- Alterado de <label> para <span> para passar na validação do SonarQube --}}
                <span class="form-label fw-bold" style="display: block; margin-bottom: 0.5rem;">Opções Disponíveis para Escolha</span>

                <div id="inputs-container">
                    @if(isset($respostas) && $respostas->isNotEmpty())
                        @foreach($respostas as $index => $campo)
                            <div class="input-group mb-2" style="display: flex; gap: 0.25rem;">
                                <span class="input-group-text fw-semibold" style="background: #e9ecef; padding: 10px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px; font-size: 0.9rem;">Opção {{ $index + 1 }}</span>
                                <input
                                    type="text"
                                    name="campos[]"
                                    class="form-input"
                                    value="{{ $campo->resposta }}"
                                    placeholder="Texto da opção (ex: Dourado)"
                                    style="margin: 0; border-radius: 0 4px 4px 0; flex: 1;"
                                >
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Botão Submit --}}
            <div class="grid-full-width">
                <button type="submit" class="btn-submit" id="btnGuardar" style="margin-top: 2rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <x-heroicon-c-bookmark style="width: 1.25rem; height: 1.25rem;"/> Guardar Categoria
                </button>
            </div>
        </div>
    </form>

    {{-- FORMULÁRIO 2: ELIMINAÇÃO DE PERSONALIZAÇÕES (Oculto por Padrão) --}}
    <form method="POST" action="{{ route('personalizacao.destroy') }}" id="formEliminar" class="auth-form" style="max-width: 100%; display: none;">
        @csrf
        @method('DELETE')

        <div class="alert alert-warning d-flex align-items-center" style="padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404; gap: 0.5rem;">
            <x-heroicon-o-exclamation-triangle style="width: 1.5rem; height: 1.5rem; flex-shrink: 0;" />
            <span><strong>Modo de Exclusão:</strong> Selecione as personalizações que deseja apagar permanentemente do sistema.</span>
        </div>

        <div class="opcoes-grid" id="gridEliminar" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 0.75rem;">
            @foreach($todas_personalizacoes as $personalizacao)
                <div class="opcao-item border-danger" style="display: flex; gap: 0.5rem; align-items: flex-start; padding: 0.5rem; border: 1px solid #dc3545; border-radius: 0.25rem; background: #fffdfd;">
                    <input type="checkbox" name="personalizacoes[]" value="{{ $personalizacao->id }}" id="del-{{ $personalizacao->id }}">
                    <div class="opcao-descricao">
                        <label for="del-{{ $personalizacao->id }}" class="text-danger" style="font-weight: 700; cursor: pointer; display: block; font-size: 0.9rem;">
                            {{ $personalizacao->titulo }}
                        </label>
                        <small style="color: #666; display: block; line-height: 1.2; font-size: 0.8rem;">{{ $personalizacao->descricao }}</small>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Grupo de Botões do Modo de Exclusão --}}
        <div class="d-flex gap-3 mt-4" style="margin-top: 2rem; display: flex; gap: 1rem; width: 100%;">
            <button type="submit" class="btn-submit bg-danger flex-grow-1" id="btnConfirmarEliminar" style="background-color: #dc3545; flex: 1;" onclick="return confirm('Tem a certeza que deseja eliminar permanentemente as personalizações selecionadas?');">
                Eliminar Permanentemente
            </button>
            <button type="button" class="btn-submit bg-secondary flex-grow-1" id="btnVoltarModo" style="background-color: #6c757d; flex: 1;">
                Cancelar / Voltar
            </button>
        </div>
    </form>

</div>
</main>

@include('partial.footer')

{{-- Lógica de Interatividade dos Modos Editar/Eliminar --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const removeBtn = document.getElementById("remove");
    const btnVoltarModo = document.getElementById("btnVoltarModo");
    const formEditar = document.getElementById("formEditar");
    const formEliminar = document.getElementById("formEliminar");
    const textoTitulo = document.getElementById("textoTitulo");
    const descricaoPagina = document.getElementById("descricaoPagina");

    function toggleModo() {
        const isEliminar = formEliminar.style.display === "none";

        if (isEliminar) {
            formEditar.style.display = "none";
            formEliminar.style.display = "block";
            textoTitulo.innerText = "Eliminar Personalizações";
            descricaoPagina.innerText = "Selecione abaixo quais os elements de personalização serão banidos de todo o ecossistema.";
            removeBtn.classList.replace("btn-outline-danger", "btn-danger");
        } else {
            formEditar.style.display = "block";
            formEliminar.style.display = "none";
            textoTitulo.innerText = "Editar Categoria";
            descricaoPagina.innerText = "Gerencie a estrutura do catálogo configurando as opções e permissões de categorias abaixo";
            removeBtn.classList.replace("btn-danger", "btn-outline-danger");
        }
    }

    removeBtn.addEventListener("click", toggleModo);
    btnVoltarModo.addEventListener("click", toggleModo);
});
</script>

</body>
</html>s
