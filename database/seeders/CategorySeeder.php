<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BLOCO DO MOTOR
        if (!Category::where('name', 'BLOCO DO MOTOR')->first()) {
            Category::create([
                'name' => 'BLOCO DO MOTOR',
                'shard_code' => '01'
            ]);
        }

        // ÓRGÃOS MOTORES
        if (!Category::where('name', 'ÓRGÃOS MOTORES')->first()) {
            Category::create([
                'name' => 'ÓRGÃOS MOTORES',
                'shard_code' => '03'
            ]);
        }

        // DISTRIBUIÇÃO
        if (!Category::where('name', 'DISTRIBUIÇÃO')->first()) {
            Category::create([
                'name' => 'DISTRIBUIÇÃO',
                'shard_code' => '05'
            ]);
        }

        // LISTAGEM OPCIONAIS
        if (!Category::where('name', 'LISTAGEM OPCIONAIS')->first()) {
            Category::create([
                'name' => 'LISTAGEM OPCIONAIS',
                'shard_code' => '06'
            ]);
        }

        // BOMBA INJETORA
        if (!Category::where('name', 'BOMBA INJETORA')->first()) {
            Category::create([
                'name' => 'BOMBA INJETORA',
                'shard_code' => '07'
            ]);
        }

        // FILTRO COMBUSTÍVEL, SOBREALIMENTAÇÃO
        if (!Category::where('name', 'FILTRO COMBUSTÍVEL, SOBREALIMENTAÇÃO')->first()) {
            Category::create([
                'name' => 'FILTRO COMBUSTÍVEL, SOBREALIMENTAÇÃO',
                'shard_code' => '09'
            ]);
        }

        // COMPRESSOR DO AR
        if (!Category::where('name', 'COMPRESSOR DO AR')->first()) {
            Category::create([
                'name' => 'COMPRESSOR DO AR',
                'shard_code' => '13'
            ]);
        }

        // COLETORES DE ADMISSÃO E DE ESCAPE
        if (!Category::where('name', 'COLETORES DE ADMISSÃO E DE ESCAPE')->first()) {
            Category::create([
                'name' => 'COLETORES DE ADMISSÃO E DE ESCAPE',
                'shard_code' => '14'
            ]);
        }

        // EQUIPAMENTO ELÉTRICO
        if (!Category::where('name', 'EQUIPAMENTO ELÉTRICO')->first()) {
            Category::create([
                'name' => 'EQUIPAMENTO ELÉTRICO',
                'shard_code' => '15'
            ]);
        }

        // LUBRIFICAÇÃO DO MOTOR
        if (!Category::where('name', 'LUBRIFICAÇÃO DO MOTOR')->first()) {
            Category::create([
                'name' => 'LUBRIFICAÇÃO DO MOTOR',
                'shard_code' => '18'
            ]);
        }

        // REFRIGERAÇÃO DO MOTOR
        if (!Category::where('name', 'REFRIGERAÇÃO DO MOTOR')->first()) {
            Category::create([
                'name' => 'REFRIGERAÇÃO DO MOTOR',
                'shard_code' => '20'
            ]);
        }

        // SUSPENSÃO DO MOTOR (METAL)
        if (!Category::where('name', 'SUSPENSÃO DO MOTOR (METAL)')->first()) {
            Category::create([
                'name' => 'SUSPENSÃO DO MOTOR (METAL)',
                'shard_code' => '22'
            ]);
        }

        // PEÇAS COMPLEMENTARES ESPECIAIS
        if (!Category::where('name', 'PEÇAS COMPLEMENTARES ESPECIAIS')->first()) {
            Category::create([
                'name' => 'PEÇAS COMPLEMENTARES ESPECIAIS',
                'shard_code' => '23'
            ]);
        }

        // SUSPENSÃO DO MOTOR (BORRACHA)
        if (!Category::where('name', 'SUSPENSÃO DO MOTOR (BORRACHA)')->first()) {
            Category::create([
                'name' => 'SUSPENSÃO DO MOTOR (BORRACHA)',
                'shard_code' => '24'
            ]);
        }

        // EMBREAGEM
        if (!Category::where('name', 'EMBREAGEM')->first()) {
            Category::create([
                'name' => 'EMBREAGEM',
                'shard_code' => '25'
            ]);
        }

        // CÂMBIO
        if (!Category::where('name', 'CÂMBIO')->first()) {
            Category::create([
                'name' => 'CÂMBIO',
                'shard_code' => '26'
            ]);
        }

        // CÂMBIO AUTOMÁTICO
        if (!Category::where('name', 'CÂMBIO AUTOMÁTICO')->first()) {
            Category::create([
                'name' => 'CÂMBIO AUTOMÁTICO',
                'shard_code' => '27'
            ]);
        }

        // CONJUNTO DOS PEDAIS
        if (!Category::where('name', 'CONJUNTO DOS PEDAIS')->first()) {
            Category::create([
                'name' => 'CONJUNTO DOS PEDAIS',
                'shard_code' => '29'
            ]);
        }

        // QUADRO DO CHASSI
        if (!Category::where('name', 'QUADRO DO CHASSI')->first()) {
            Category::create([
                'name' => 'QUADRO DO CHASSI',
                'shard_code' => '31'
            ]);
        }

        // MOLAS E SUSPENSÃO
        if (!Category::where('name', 'MOLAS E SUSPENSÃO')->first()) {
            Category::create([
                'name' => 'MOLAS E SUSPENSÃO',
                'shard_code' => '32'
            ]);
        }

        // EIXO DIANTEIRO
        if (!Category::where('name', 'EIXO DIANTEIRO')->first()) {
            Category::create([
                'name' => 'EIXO DIANTEIRO',
                'shard_code' => '33'
            ]);
        }

        // EIXO TRASEIRO
        if (!Category::where('name', 'EIXO TRASEIRO')->first()) {
            Category::create([
                'name' => 'EIXO TRASEIRO',
                'shard_code' => '35'
            ]);
        }

        // RODAS
        if (!Category::where('name', 'RODAS')->first()) {
            Category::create([
                'name' => 'RODAS',
                'shard_code' => '40'
            ]);
        }

        // ÁRVORE DE TRANSMISSÃO
        if (!Category::where('name', 'ÁRVORE DE TRANSMISSÃO')->first()) {
            Category::create([
                'name' => 'ÁRVORE DE TRANSMISSÃO',
                'shard_code' => '41'
            ]);
        }

        // FREIOS
        if (!Category::where('name', 'FREIOS')->first()) {
            Category::create([
                'name' => 'FREIOS',
                'shard_code' => '42'
            ]);
        }

        // FREIO MOTOR
        if (!Category::where('name', 'FREIO MOTOR')->first()) {
            Category::create([
                'name' => 'FREIO MOTOR',
                'shard_code' => '43'
            ]);
        }

        // DIREÇÃO
        if (!Category::where('name', 'DIREÇÃO')->first()) {
            Category::create([
                'name' => 'DIREÇÃO',
                'shard_code' => '46'
            ]);
        }

        // SISTEMA DO COMBUSTÍVEL
        if (!Category::where('name', 'SISTEMA DO COMBUSTÍVEL')->first()) {
            Category::create([
                'name' => 'SISTEMA DO COMBUSTÍVEL',
                'shard_code' => '47'
            ]);
        }

        // SISTEMA DE ESCAPE
        if (!Category::where('name', 'SISTEMA DE ESCAPE')->first()) {
            Category::create([
                'name' => 'SISTEMA DE ESCAPE',
                'shard_code' => '49'
            ]);
        }

        // RADIADOR
        if (!Category::where('name', 'RADIADOR')->first()) {
            Category::create([
                'name' => 'RADIADOR',
                'shard_code' => '50'
            ]);
        }

        // FILTRO DE AR
        if (!Category::where('name', 'FILTRO DE AR')->first()) {
            Category::create([
                'name' => 'FILTRO DE AR',
                'shard_code' => '52'
            ]);
        }

        // EQUIPAMENTO ELÉTRICO E INSTRUMENTOS
        if (!Category::where('name', 'EQUIPAMENTO ELÉTRICO E INSTRUMENTOS')->first()) {
            Category::create([
                'name' => 'EQUIPAMENTO ELÉTRICO E INSTRUMENTOS',
                'shard_code' => '54'
            ]);
        }

        // FERRAMENTAS E ACESSÓRIOS
        if (!Category::where('name', 'FERRAMENTAS E ACESSÓRIOS')->first()) {
            Category::create([
                'name' => 'FERRAMENTAS E ACESSÓRIOS',
                'shard_code' => '58'
            ]);
        }

        // ESTRUTURA SUPERIOR
        if (!Category::where('name', 'ESTRUTURA SUPERIOR')->first()) {
            Category::create([
                'name' => 'ESTRUTURA SUPERIOR',
                'shard_code' => '60'
            ]);
        }

        // ESTRUTURA INFERIOR
        if (!Category::where('name', 'ESTRUTURA INFERIOR')->first()) {
            Category::create([
                'name' => 'ESTRUTURA INFERIOR',
                'shard_code' => '61'
            ]);
        }

        // PAREDE DIANTEIRA
        if (!Category::where('name', 'PAREDE DIANTEIRA')->first()) {
            Category::create([
                'name' => 'PAREDE DIANTEIRA',
                'shard_code' => '62'
            ]);
        }

        // PAREDE TRASEIRA
        if (!Category::where('name', 'PAREDE TRASEIRA')->first()) {
            Category::create([
                'name' => 'PAREDE TRASEIRA',
                'shard_code' => '64'
            ]);
        }

        // TETO
        if (!Category::where('name', 'TETO')->first()) {
            Category::create([
                'name' => 'TETO',
                'shard_code' => '65'
            ]);
        }

        // PEÇAS COMPLEMENTARES
        if (!Category::where('name', 'PEÇAS COMPLEMENTARES')->first()) {
            Category::create([
                'name' => 'PEÇAS COMPLEMENTARES',
                'shard_code' => '66'
            ]);
        }

        // ARMAÇÃO DAS JANELAS
        if (!Category::where('name', 'ARMAÇÃO DAS JANELAS')->first()) {
            Category::create([
                'name' => 'ARMAÇÃO DAS JANELAS',
                'shard_code' => '67'
            ]);
        }

        // REVESTIMENTO E FORRAMENTO
        if (!Category::where('name', 'REVESTIMENTO E FORRAMENTO')->first()) {
            Category::create([
                'name' => 'REVESTIMENTO E FORRAMENTO',
                'shard_code' => '68'
            ]);
        }

        // PORTAS
        if (!Category::where('name', 'PORTAS')->first()) {
            Category::create([
                'name' => 'PORTAS',
                'shard_code' => '72'
            ]);
        }

        // EQUIPAMENTO
        if (!Category::where('name', 'EQUIPAMENTO')->first()) {
            Category::create([
                'name' => 'EQUIPAMENTO',
                'shard_code' => '81'
            ]);
        }

        // INSTALAÇÃO ELÉTRICA
        if (!Category::where('name', 'INSTALAÇÃO ELÉTRICA')->first()) {
            Category::create([
                'name' => 'INSTALAÇÃO ELÉTRICA',
                'shard_code' => '82'
            ]);
        }

        // AQUECIMENTO E VENTILAÇÃO
        if (!Category::where('name', 'AQUECIMENTO E VENTILAÇÃO')->first()) {
            Category::create([
                'name' => 'AQUECIMENTO E VENTILAÇÃO',
                'shard_code' => '83'
            ]);
        }

        // LAVA-PARABRISAS, EQUIPAMENTOS EMERGÊNCIA
        if (!Category::where('name', 'LAVA-PARABRISAS, EQUIPAMENTOS EMERGÊNCIA')->first()) {
            Category::create([
                'name' => 'LAVA-PARABRISAS, EQUIPAMENTOS EMERGÊNCIA',
                'shard_code' => '86'
            ]);
        }

        // PEÇAS APLICÁVEIS
        if (!Category::where('name', 'PEÇAS APLICÁVEIS')->first()) {
            Category::create([
                'name' => 'PEÇAS APLICÁVEIS',
                'shard_code' => '88'
            ]);
        }

        // ACESSÓRIOS DO VEÍCULO
        if (!Category::where('name', 'ACESSÓRIOS DO VEÍCULO')->first()) {
            Category::create([
                'name' => 'ACESSÓRIOS DO VEÍCULO',
                'shard_code' => '89'
            ]);
        }

        // ARMAÇÃO DOS ASSENTOS
        if (!Category::where('name', 'ARMAÇÃO DOS ASSENTOS')->first()) {
            Category::create([
                'name' => 'ARMAÇÃO DOS ASSENTOS',
                'shard_code' => '91'
            ]);
        }

        // ACESSÓRIOS DOS ASSENTOS
        if (!Category::where('name', 'ACESSÓRIOS DOS ASSENTOS')->first()) {
            Category::create([
                'name' => 'ACESSÓRIOS DOS ASSENTOS',
                'shard_code' => '97'
            ]);
        }
    }
}
