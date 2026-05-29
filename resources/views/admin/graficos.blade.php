<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; max-width: 1200px; margin: 0 auto 2rem;">
    <h1 style="color: var(--color1); margin: 0;">
        <x-heroicon-c-shopping-bag style="width: 3rem; height: 3rem; color:var(--main_color);"/> 
        Gestão de Produtos
    </h1>
</div>

<div style="max-width: 1200px; margin: 2rem auto; display: flex; flex-wrap: wrap; gap: 2rem; width: 100%;">
    
    <div class="mimo-chart-card" style="margin: 0; flex: 1; min-width: 300px;">
        <div class="mimo-chart-header">
            <h2>
                <x-heroicon-s-heart style="color: var(--main_color); width: 1.5rem; height: 1.5rem;"/> 
                Produtos Favoritos
            </h2>
            <p>Os artigos mais desejados pelos teus clientes</p>
        </div>
        <div class="mimo-chart-body" style="padding: 1rem 1.5rem 1.5rem;">
            <div class="mimo-chart-wrapper" style="width: 100%; height: 250px; margin: auto; position: relative;">
                <canvas id="chartFavoritos"></canvas>
            </div>
        </div>
    </div>

    <div class="mimo-chart-card" style="margin: 0; flex: 1; min-width: 300px;">
        <div class="mimo-chart-header">
            <h2>
                <x-heroicon-s-tag style="color: var(--main_color); width: 1.5rem; height: 1.5rem;"/> 
                Produtos por Categoria
            </h2>
            <p>Distribuição do catálogo por tipo de produto</p>
        </div>
        <div class="mimo-chart-body" style="padding: 1rem 1.5rem 1.5rem;">
            <div class="mimo-chart-wrapper" style="width: 100%; height: 250px; margin: auto; position: relative;">
                <canvas id="chartTipos"></canvas>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Definição da Paleta de Cores base original
        const paletaCores = [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', 
            '#6610f2', '#fd7e14', '#20c997', '#0dcaf0', '#d941ff',
            '#5a5c69', '#f4a261', '#e76f51', '#2a9d8f', '#264653'
        ];

        // 2. Dados do Laravel (Ajustado para ler Favoritos e as novas Variáveis de Tipos)
        const labelsFavoritos = @json($labels ?? []);
        const valoresFavoritos = @json($valores ?? []);
        const labelsTipos = @json($labelsTipos ?? []);
        const valoresTipos = @json($valoresTipos ?? []);

        // 3. Gerar arrays de cores específicos com base na tua paleta
        const coresGraficoFavoritos = labelsFavoritos.map((_, index) => paletaCores[index % paletaCores.length]);
        const coresGraficoTipos = labelsTipos.map((_, index) => paletaCores[(index + 3) % paletaCores.length]); // (+3) para baralhar as cores entre gráficos

        // --- 1. GRÁFICO DE FAVORITOS (Gráfico de Pizza original) ---
        const ctxFav = document.getElementById('chartFavoritos').getContext('2d');
        new Chart(ctxFav, {
            type: 'pie',
            data: {
                labels: labelsFavoritos.length > 0 ? labelsFavoritos : ["Sem Dados"],
                datasets: [{
                    data: valoresFavoritos.length > 0 ? valoresFavoritos : [0],
                    backgroundColor: coresGraficoFavoritos,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // --- 2. GRÁFICO DE PRODUTOS POR CATEGORIA (Doughnut/Donut) ---
        const ctxTipos = document.getElementById('chartTipos').getContext('2d');
        new Chart(ctxTipos, {
            type: 'doughnut',
            data: {
                labels: labelsTipos.length > 0 ? labelsTipos : ["Sem Categorias"],
                datasets: [{
                    data: valoresTipos.length > 0 ? valoresTipos : [0],
                    backgroundColor: coresGraficoTipos,
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '65%' // Dá o efeito oco de rosca/donut ao gráfico
            }
        });
    });
</script>