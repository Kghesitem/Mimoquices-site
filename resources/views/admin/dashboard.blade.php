@include('partial.header')
<head>
    <title>Dashboard Admin - Mimoquices</title>
</head>
    <div class="py-12 dashboard-mimo">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Saudação --}}
            <div class="welcome-banner mb-8">
                <h1>Olá, Admin {{ Auth::user()->name }}!</h1>
            </div>

            {{-- Grelha de Atalhos --}}
            <div class="d-flex justify-content-center">    
                <div class="d-flex flex-column justify-content-center flex-md-row gap-3 max"style="width:65%">
                    
                    {{-- Card: Perfil --}}
                    <a href="{{ route('produto.criar') }}" class="dash-card-admin" style="flex: 1;">
                        <div class="dash-icon"><x-heroicon-s-tag style="width: 3rem; height: 3rem; color:var(--main_color);" /></div>
                        <h3>Adicionar Produto</h3>
                        <p>Cria um novo produto</p>
                        <span class="dash-link">Adicionar Produto →</span>
                    </a>
                    <a href="{{ route('categoria.criar') }}" class="dash-card-admin"style="flex: 1;">
                        <div class="dash-icon"><x-heroicon-m-folder-plus style="width: 3rem; height: 3rem; color:var(--main_color);" /></div>
                        <h3>Adicionar Categoria</h3>
                        <p>Cria uma nova Categoria</p>
                        <span class="dash-link">Adicionar Categoria →</span>
                    </a>
                    <a href="{{ route('tabelaPedidos') }}" class="dash-card-admin"style="flex: 1;">
                        <div class="dash-icon"><x-heroicon-c-clipboard-document-list style=" width: 3rem; height: 3rem; color:var(--main_color);" /></div>
                        <h3>Lista de Pedidos</h3>
                        <p>Visualiza todos os pedidos</p>
                        <span class="dash-link">Ver Pedidos →</span>
                    </a>                  
                </div>
            </div>
            
            
            {{-- Seção de Categorias --}}
            @include('admin.icon_categorias')

            {{-- Seção de graficos --}}
            @include('admin.grafico_favoritos')

            {{-- Card: Personalizações --}}
            @include('admin.tabela_produtos')
        </div>
    </div>
@include('partial.footer')


@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Sucesso!',
            toast: true,
            position: 'top-end',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
        });
    });
</script>
@endif

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