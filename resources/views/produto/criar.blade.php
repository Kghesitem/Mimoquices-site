<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Produto - Mimoquices</title>
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

    {{-- CABEÇALHO DO FORMULÁRIO --}}
    <div class="auth-header rounded" style="text-align: left; margin-bottom: 2.5rem;">
        <h1>
            <x-heroicon-c-plus style="width: 2.5rem; height: 2.5rem; vertical-align: middle;"/> 
            Criar Produto
        </h1>
        <p style="text-align: center;">Adicione um novo produto ao catálogo da Mimoquices preenchendo as secções abaixo</p>
    </div>

    {{-- ERROS --}}
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

    {{-- FORMULÁRIO --}}
    <form method="post" action="{{ route('produto.store') }}" enctype="multipart/form-data" class="auth-form" style="max-width: 100%;">
        @csrf
        @method('post')

        <div class="form-grid-layout">
            
            {{-- COLUNA ESQUERDA: Dados do Produto --}}
            <div class="col-dados">
                {{-- Título --}}
                <div class="form-group">
                    <label for="titulo" class="form-label">Título do Produto</label>
                    <input 
                        type="text" 
                        id="titulo"
                        class="form-input {{ $errors->has('titulo') ? 'is-invalid' : '' }}" 
                        name="titulo" 
                        placeholder="Ex.: Caderno A5" 
                        required
                        value="{{ old('titulo') }}"
                    />
                </div>

                {{-- Categoria --}}
                <div class="form-group" style="margin-top: 1.25rem;">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select id="categoria" class="form-input" name="tipo_prod" onchange="verificaCategoria()" required>
                        <option value="">Selecione uma categoria...</option>
                        @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_prod') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->Categoria }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Descrição --}}
                <div class="form-group" style="margin-top: 1.25rem;">
                    <label for="descricao" class="form-label">Descrição do Produto</label>
                    <textarea id="descricao" class="form-input {{ $errors->has('descricao') ? 'is-invalid' : '' }} textarea-auto-expand " name="descricao" rows="4" placeholder="Descreva o produto de forma detalhada..." required>{{ old('descricao') }}</textarea>
                </div>

                {{-- Conteúdo --}}
                <div class="form-group" style="margin-top: 1.25rem;">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea id="conteudo" class="form-input textarea-auto-expand" name="conteudo" rows="3" placeholder="Conteúdo do produto...">{{ old('conteudo') }}</textarea>
                </div>

                {{-- Detalhes --}}
                <div class="form-group" style="margin-top: 1.25rem;">
                    <label for="detalhes" class="form-label">Detalhes</label>
                    <textarea id="detalhes" class="form-input textarea-auto-expand" name="detalhes" rows="3" placeholder="Detalhes do produto...">{{ old('detalhes') }}</textarea>
                </div>
            </div>

            

            {{-- COLUNA DIREITA: Imagens (Estilo Antigo) e Customizações --}}
            <div class="col-media">
                {{-- Imagens (Restaurado o comportamento CSS original) --}}
                <div class="form-group">
                    <label for="images" class="form-label">Imagens do Produto</label>
                    <input 
                        type="file" 
                        id="images" 
                        class="form-input" 
                        name="nome_original[]" 
                        accept="image/*" 
                        multiple 
                        onchange="previewImages(this)"
                        required
                    />
                    <small class="text-muted" style="display: block; margin-top: 0.25rem;">Pode selecionar várias imagens. Máx: 5MB por imagem.</small>
                    
                    {{-- Retornado exatamente à div antiga comandada pelas classes do seu CSS global --}}
                    <div class="preview" id="preview">
                        <div class="preview-empty">Nenhuma imagem selecionada</div>
                    </div>
                </div>

                {{-- BLOCO DE PERSONALIZAÇÃO (ADMIN) --}}
                <div id="bloco-personalizacao-admin" class="hidden" style="margin-top: 1.5rem; padding: 1.25rem; border: 1px dashed var(--main_color); border-radius: 0.5rem; background-color: rgba(var(--main_color_rgb), 0.03);">

                    {{-- Radio --}}
                    <div class="form-group">
                        <label class="form-label">Este produto pode ser personalizado?</label>
                        <div class="radio-personalizacao" style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 0.25rem;">
                                <input type="radio" name="pode_personalizar" value="Sim" onchange="toggleOpcoes()" {{ old('pode_personalizar') == 'Sim' ? 'checked' : '' }} />
                                Sim - permitir personalização
                            </label>
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 0.25rem;">
                                <input type="radio" name="pode_personalizar" value="Não" onchange="toggleOpcoes()" {{ old('pode_personalizar') == 'Não' || !old('pode_personalizar') ? 'checked' : '' }} />
                                Não
                            </label>
                        </div>
                    </div>

                    {{-- Opções de Personalização --}}
                    <div id="opcoes-personalizacao" class="{{ old('pode_personalizar') == 'Sim' ? 'visible' : '' }}" style="margin-top: 1.25rem;">
                        <h6 style="color: var(--main_color); margin-bottom: 1rem; font-weight: bold;">
                            <x-heroicon-c-check-circle style="width: 1.25rem; height: 1.25rem;"/> Selecione as opções válidas:
                        </h6>
                        <div id="opcoes-papelaria" class="opcoes-personalizacao">
                            <div class="opcoes-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem;">
                                @foreach($todas_personalizações as $personalizacao)
                                    <div class="opcao-item" data-categorias="{{ $personalizacao->tipos->pluck('id')->implode(',') }}" style="display: flex; gap: 0.5rem; align-items: flex-start; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem; background: #fff;">
                                        <input type="checkbox" id="personalizacao_{{ $personalizacao->id }}" name="personalizar_opcoes[]" value="{{ $personalizacao->id }}" {{ in_array($personalizacao->id, old('personalizar_opcoes', [])) ? 'checked' : '' }} />
                                        <div class="opcao-descricao">
                                            <label for="personalizacao_{{ $personalizacao->id }}" style="font-weight: 600; cursor: pointer; display: block; font-size: 0.9rem;">
                                                {{ $personalizacao->titulo }}
                                            </label>
                                            <small style="color: #666; display: block; line-height: 1.2; font-size: 0.8rem;">{{ $personalizacao->descricao }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BOTÃO SUBMIT (Ocupa as duas colunas em ecrãs grandes) --}}
            <div class="grid-full-width">
                <button type="submit" class="btn-submit" style="margin-top: 1.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onclick="this.disabled=true; this.form.submit();">
                    <x-heroicon-c-bookmark style="width: 1.25rem; height: 1.25rem;"/> Guardar Produto
                </button>
            </div>

        </div>
    </form>

    {{-- RODAPÉ --}}
    <div class="auth-footer" style="margin-top: 3rem;">
        <p>Precisa gerir as categorias existentes?</p>
        <a href="{{ route('categoria.criar') }}">Ir para Categorias →</a>
    </div>
</div>
</main>

@include('partial.footer')

<script src="{{ asset('frontend/assets/js/produto-form.js') }}"></script>
</body>
</html>