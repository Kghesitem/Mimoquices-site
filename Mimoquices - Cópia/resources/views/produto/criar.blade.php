<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Produtos</title>
    <style>
        /* Pré-visualização das imagens */
        .preview img {
            max-width: 150px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Criar Produtos</h1>
    <form method="post" action="{{route('produto.store')}}" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div>
            <label>Titulo</label>
            <input type="text" name="titulo" placeholder="Caderno"/> <br><br>

            <label>Descrição do Produto</label>
            <input type="text" name="descricao" placeholder="Produto A5 com ..."><br><br>

            <label>Categoria</label>
            <select name="tipo_prod">
                @foreach($tipos as $tipo)
                <option value="{{$tipo->id}}">{{$tipo->Categoria}}</option>
                @endforeach
            </select><br><br>

            <label>Imagens do Produto</label>
            <input type="file" id="images" name="nome_original[]" accept="image/*" multiple onchange="previewImages(this)">
            <div class="preview" id="preview"></div>
        </div>


        <div>
            <input type="submit" value="Guardar Produto">
        </div>
    </form>

    <!-- Erros -->
    <div> 
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>

    <script>
        function previewImages(input) {
            const preview = document.getElementById('preview');
            preview.innerHTML = ''; // limpa a pré-visualização

            const files = input.files;

            if(files.length > 6){
                alert("Só pode enviar até 6 imagens!");
                input.value = ""; // limpa seleção
                return;
            }

            for(let i = 0; i < files.length; i++){
                const file = files[i];

                if(file.type.startsWith('image/')){
                    const reader = new FileReader();
                    reader.onload = function(e){
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</body>
</html>
