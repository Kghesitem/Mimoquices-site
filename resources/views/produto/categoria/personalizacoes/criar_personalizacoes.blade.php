@include('partial.header')

<head>
    <title>Criar Personalizações - Mimoquices</title>
</head>

<a class="btn botao-voltar mt-4 text-decoration-none d-flex justify-content-center" href="{{ url('/dashboard') }}">
        ← Voltar
    </a>

<main class="profile-page py-5">
    <div class="container">
        
        <div class="form-container">
            <h1>➕ Criar Personalizações</h1>

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

            <form method="post" enctype="multipart/form-data" action="{{ route('personalizacao.store') }}">
                @csrf
                @method('post')

                <div class="form-group">
                    <label for="Nome">Nome da Personalização</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="nome" 
                        placeholder="Ex.: Papelaria, Agendas..." 
                        required
                        value="{{ old('nome') }}"
                    />
                </div>

                <div class="form-group">
                    <label for="Descricao">Breve Descrição</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="descricao" 
                        placeholder="Ex.: Pode ser personalizada com nome, data ou frase..." 
                        required
                        value="{{ old('descricao') }}"
                    />
                </div>

                <div class="form-group">
                    <label for="PDF">PDF</label>
                    <input 
                        type="file" 
                        class="form-control" 
                        name="pdf" 
                        accept=".pdf"
                        value="{{ old('pdf') }}"
                    />
                </div>


                <div class="form-group">
                    <label for="categoria">O Utilizador intruduz dados</label>
                    <select id="categoria" class="form-select" name="tipo_de_input" onchange="verificaCategoria()" required="">
                        <option value="texto">
                            Em forma de texto
                        </option>
                        <option value="select">
                            Seleciona apenas uma opção entre várias possíveis
                        <option value="checkbox">
                            Seleciona uma ou mais opções entre várias possíveis 
                        </option>
                    </select>
                </div>

                <div id="texto" name="texto" class="border rounded p-3 bg-light">
                    <h5>O Utilizador pode introduzir dados em forma de texto</h5>
                </div>
                <div id="select" class="hidden border rounded p-3 bg-light">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 fw-semibold">Opções</h6>

                        <div class="gap-1">
                            <button type="button" id="add-input" class="btn btn-success btn-sm">
                                <strong>+</strong> Adicionar
                            </button>

                            <button type="button" id="remove-input" class="btn btn-danger btn-sm">
                                <strong>-</strong> Remover
                            </button>
                        </div>                        
                    </div>

                    <div id="inputs-container">
                        <div class="input-group mb-2">
                            <span class="input-group-text fw-semibold">Opção 1</span>
                            <input
                                type="text"
                                name="campos[]"
                                class="form-control"
                                placeholder="Texto da opção"
                            >
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn-submit">💾 Guardar Personalização</button>
            </form>
        </div>
    </div>
</main>

@include('partial.footer')

<script>
    function verificaCategoria() {
            const select = document.getElementById('categoria');
            const blocoTexto = document.getElementById('texto');
            const blocoSelect = document.getElementById('select');

            if (select.value === "texto" ) {
                blocoTexto.classList.remove('hidden');
                blocoSelect.classList.add('hidden');
            }
            else if (select.value === "select" || select.value === "checkbox") {
                blocoTexto.classList.add('hidden');
                blocoSelect.classList.remove('hidden');
            }
        }


        let contador =1;

    document.getElementById('add-input').addEventListener('click', function () {
        contador++;

        const container = document.getElementById('inputs-container');

        const div = document.createElement('div');
        div.className = 'input-group mb-2';

        const label = document.createElement('span');
        label.className = 'input-group-text fw-semibold';
        label.innerText = 'Opção ' + contador;

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'campos[]';
        input.className = 'form-control';
        input.placeholder = 'Texto';

        div.appendChild(label);
        div.appendChild(input);
        container.appendChild(div);
    });
    document.getElementById('remove-input').addEventListener('click', function () {
        if (contador > 1) {
            contador--;
            const container = document.getElementById('inputs-container');
            const divs = container.querySelectorAll('.input-group');
            if (divs.length > 0) {
                container.removeChild(divs[divs.length - 1]);
            }
        }
    });
</script>