<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->text('conteudo')->nullable();
            $table->text('detalhes')->nullable();
            $table->string('url_completo');
            $table->unsignedBigInteger('tipo_prod');
            $table->string('nome_original');
            $table->boolean('disponivel')->default(true);
            $table->string('nome_cod');
            $table->string('pode_personalizar')->default('Não');
            $table->longText('personalizar_opcoes')->nullable();
            $table->timestamps();        
        });

        // Índice estrangeiro
        Schema::table('produto', function (Blueprint $table) {
            $table->foreign('tipo_prod')->references('id')->on('tipo');
        });

        // ✅ Inserir dados iniciais
        DB::table('produto')->insert([
            [
                'titulo' => 'Agenda A5',
                'descricao' => "Única e totalmente personalizada! É simples e funcional e adequada para qualquer pessoa.\r\nA agenda apresenta-se nas versões com e sem horas e existem várias capas disponíveis que também pode personalizar.\r\nDe Janeiro a Dezembro de 2024",
                'conteudo' => "Dados Pessoais\r\nPasswords\r\nContactos\r\nCalendários\r\nPlanificador Anual\r\nFolhas quadriculadas para notas\r\nSeparadores mensais com o nome de cada mês. O verso de cada separador contém prioridades, objetivos, notas e datas comemorativas.\r\nPlanificador Mensal\r\nVista semanal (2 páginas por semana)\r\nPáginas diferentes no final de cada mês.",
                'detalhes' => "Capa dura em cartão\r\nPáginas interiores impressas, em alta qualidade, em papel de 90gr\r\n12 separadores mensais em papel fotográfico\r\nArgolas metálicas\r\nElástico preso com ilhós",
                'url_completo' => 'Agenda A5-8',
                'tipo_prod' => 1,
                'nome_original' => '1.JPEG',
                'disponivel' => 1,
                'nome_cod' => 'uploads/d1d1989cdce8ecbbd0b85ad5f2c1b3bd.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'pode_personalizar' => 'Sim',
                'personalizar_opcoes' => json_encode(['formato','paginas','texto_capa','acessorio','cor_argolas']),
            ],
            [
                'titulo' => 'Agenda A6',
                'descricao' => "Agenda leve para poder transportar na mala.\r\nA agenda apresenta-se nas versões com e sem horas e existem várias capas disponíveis que também pode personalizar.\r\nDe Janeiro a Dezembro de 2024",
                'conteudo' => "Dados Pessoais\r\nPasswords\r\nAutomóvel\r\nConsultas\r\nCalendário 2024\r\nPlanificador Anual\r\nFolhas quadriculadas para notas\r\nSeparadores mensais com o nome de cada mês. O verso de cada separador contém prioridades, objetivos, notas e datas comemorativas.\r\nPlanificador Mensal\r\nVista semanal (2 páginas por semana)\r\nControlo financeiro",
                'detalhes' => "Capa dura em cartão\r\nPáginas interiores impressas, em alta qualidade, em papel de 90gr\r\n12 separadores mensais em papel de 200gr\r\nArgolas metálicas\r\nElástico preso com ilhós",
                'url_completo' => 'Agenda A6-9',
                'tipo_prod' => 1,
                'nome_original' => 'main.JPEG',
                'disponivel' => 1,
                'nome_cod' => 'uploads/73ab718e772278cbe98ba5164f07f1e7.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'pode_personalizar' => 'Sim',
                'personalizar_opcoes' => json_encode(['formato','paginas','texto_capa','acessorio','cor_argolas']),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('produto');
    }
};
