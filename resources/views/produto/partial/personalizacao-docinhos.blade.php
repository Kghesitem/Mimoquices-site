{{-- DOCINHOS: Tipo de chocolate --}}
@if(in_array('tipo_de_chocolate', $opcoesDisponiveis))
    <div class="form-group-personalizacao">
        <label><strong>🍫 Tipo de chocolate</strong></label>
        <div class="radio-group">
            <label class="radio-label">
                <input
                    type="radio"
                    name="tipo_de_chocolate"
                    value="Chocolate negro"
                    {{ old('tipo_de_chocolate') == 'Chocolate negro' ? 'checked' : '' }}
                    required
                />
                Chocolate negro
            </label>
            <label class="radio-label">
                <input
                    type="radio"
                    name="tipo_de_chocolate"
                    value="Chocolate branco"
                    {{ old('tipo_de_chocolate') == 'Chocolate branco' ? 'checked' : '' }}
                    required
                />
                Chocolate branco
            </label>
            <label class="radio-label">
                <input
                    type="radio"
                    name="tipo_de_chocolate"
                    value="Chocolate de leite"
                    {{ old('tipo_de_chocolate') == 'Chocolate de leite' ? 'checked' : '' }}
                    required
                />
                Chocolate de leite
            </label>
        </div>
    </div>
@endif

{{-- DOCINHOS: Nome na embalagem --}}
@if(in_array('embalagem', $opcoesDisponiveis))
    <div class="form-group-personalizacao">
        <label for="nome_embalagem">
            🏷️ <strong>Nome na embalagem</strong>
        </label>
        <input
            type="text"
            id="nome_embalagem"
            name="nome_embalagem"
            class="form-control-personalizacao"
            placeholder="Máximo 30 caracteres"
            maxlength="30"
            value="{{ old('nome_embalagem') }}"
            required
        />
        <small class="texto-contador">
            <span id="contador-embalagem">0</span>/30 caracteres
        </small>
    </div>
@endif