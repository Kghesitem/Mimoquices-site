{{-- Texto da Capa --}}
@if(in_array('texto_capa', $opcoesDisponiveis))
    <div class="form-group-personalizacao">
        <label for="texto_capa">
            📝 <strong>Texto da Capa</strong>
        </label>
        <input
            type="text"
            id="texto_capa"
            name="texto_capa"
            class="form-control-personalizacao"
            placeholder="Máximo 30 caracteres"
            maxlength="30"
            value="{{ old('texto_capa') }}"
            required
        />
        <small class="texto-contador">
            <span id="contador-capa">0</span>/30 caracteres
        </small>
    </div>
@endif

{{-- Formato da Agenda --}}
@if(in_array('formato', $opcoesDisponiveis))
    <div class="form-group-personalizacao">
        <label><strong>📅 Formato da Agenda</strong></label>
        <a href="{{ asset('frontend/assets/pdf/modelos-agendas-26.pdf') }}"
            target="_blank"
            class="btn btn-sm btn-outline-secondary">
            Abrir PDF
        </a>
        <div class="radio-group mt-3">
            <label class="radio-label">
                <input
                    type="radio"
                    name="formato_agenda"
                    value="Com horas"
                    {{ old('formato_agenda') == 'Com horas' ? 'checked' : '' }}
                    required
                />
                Com horas
            </label>
            <label class="radio-label">
                <input
                    type="radio"
                    name="formato_agenda"
                    value="Sem horas"
                    {{ old('formato_agenda') == 'Sem horas' ? 'checked' : '' }}
                    required
                />
                Sem horas
            </label>
        </div>
    </div>
@endif

{{-- Páginas Especiais --}}
@if(in_array('paginas', $opcoesDisponiveis))
    <div class="form-group-personalizacao">
        <label><strong>📄 Páginas no Final de Cada Mês</strong></label>
        <div class="checkbox-group">
            <label class="checkbox-label">
                <input
                    type="checkbox"
                    name="paginas_especiais[]"
                    value="Anotacoes"
                    {{ in_array('Anotacoes', old('paginas_especiais', [])) ? 'checked' : '' }}
                />
                📌 Anotações
            </label>
            <label class="checkbox-label">
                <input
                    type="checkbox"
                    name="paginas_especiais[]"
                    value="Objetivos"
                    {{ in_array('Objetivos', old('paginas_especiais', [])) ? 'checked' : '' }}
                />
                🎯 Objetivos
            </label>
            <label class="checkbox-label">
                <input
                    type="checkbox"
                    name="paginas_especiais[]"
                    value="Habitos"
                    {{ in_array('Habitos', old('paginas_especiais', [])) ? 'checked' : '' }}
                />
                ⭐ Hábitos
            </label>
            <label class="checkbox-label">
                <input
                    type="checkbox"
                    name="paginas_especiais[]"
                    value="Financeiro"
                    {{ in_array('Financeiro', old('paginas_especiais', [])) ? 'checked' : '' }}
                />
                💰 Financeiro
            </label>
        </div>
    </div>
@endif

{{-- Acessório --}}
@if(in_array('acessorio', $opcoesDisponiveis))
    <div class="form-group-personalizacao">
        <label for="acessorio"><strong>⭕ Acessório do Elástico</strong></label>
        <select
            id="acessorio"
            name="acessorio"
            class="form-select-personalizacao"
            required
        >
            <option value="">Selecione uma opção...</option>
            <option value="Metálico" {{ old('acessorio') == 'Metálico' ? 'selected' : '' }}>
                ✨ Metálico
            </option>
            <option value="Acrílico" {{ old('acessorio') == 'Acrílico' ? 'selected' : '' }}>
                💎 Acrílico
            </option>
        </select>
    </div>
@endif

{{-- Cor das Argolas --}}
@if(in_array('cor_argolas', $opcoesDisponiveis))
    <div class="form-group-personalizacao">
        <label><strong>🎨 Cor das Argolas</strong></label>
        <div class="cores-grid">
            @php
                $cores = [
                    ['valor' => 'Prata', 'emoji' => '🤍', 'cor' => '#c0c0c0'],
                    ['valor' => 'Ouro', 'emoji' => '💛', 'cor' => '#ffd700'],
                    ['valor' => 'Preto', 'emoji' => '🖤', 'cor' => '#000000'],
                    ['valor' => 'Rose Gold', 'emoji' => '🌹', 'cor' => '#b76e79'],
                    ['valor' => 'Cobre', 'emoji' => '🧡', 'cor' => '#b87333'],
                ];
            @endphp
            @foreach($cores as $cor)
                <label class="cor-opcao">
                    <input
                        type="radio"
                        name="cor_argolas"
                        value="{{ $cor['valor'] }}"
                        {{ old('cor_argolas') == $cor['valor'] ? 'checked' : '' }}
                    />
                    <div class="cor-botao"
                            style="background-color: {{ $cor['cor'] }}"
                            title="{{ $cor['valor'] }}">
                        <span class="cor-emoji">{{ $cor['emoji'] }}</span>
                    </div>
                    <span class="cor-nome">{{ $cor['valor'] }}</span>
                </label>
            @endforeach
        </div>
    </div>
@endif