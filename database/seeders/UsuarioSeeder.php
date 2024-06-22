<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\Unidade;
use App\Models\Perfil;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = DB::connection('sigaa')->table('vw_usuarios_catraca')->where('id_status_servidor', 1)->get();

        $entidade = DB::connection('petrvs')->table('entidades')->first();
        if (!$entidade) {
            $entidadeId = '52d78c7d-e0c1-422b-b094-2ca5958d5ac1';
            DB::connection('petrvs')->table('entidades')->insert([
                'id' => $entidadeId,
                'nome' => 'Nome da Entidade',
                'sigla' => 'ENT',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $entidade = (object) ['id' => $entidadeId];
        }

        $perfis = Perfil::all();

        foreach ($usuarios as $usuario) {
            $guidUsuario = $this->generateGuid($usuario->id_usuario);
            $guidUnidade = $this->generateGuid($usuario->id_unidade);
            $cpfFormatado = str_pad($usuario->cpf_cnpj, 11, '0', STR_PAD_LEFT);

            Unidade::updateOrCreate(
                ['id' => $guidUnidade],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => NULL,
                    'codigo' => '1',
                    'sigla' => $usuario->sigla_unidade,
                    'nome' => $usuario->descricao_unidade,
                    'instituidora' => 0,
                    'informal' => 0,
                    'path' => NULL,
                    'texto_complementar_plano' => NULL,
                    'atividades_arquivamento_automatico' => 0,
                    'atividades_avaliacao_automatico' => 0,
                    'planos_prazo_comparecimento' => 10,
                    'planos_tipo_prazo_comparecimento' => 'DIAS',
                    'data_inativacao' => NULL,
                    'distribuicao_forma_contagem_prazos' => 'DIAS_UTEIS',
                    'entrega_forma_contagem_prazos' => 'HORAS_UTEIS',
                    'autoedicao_subordinadas' => 1,
                    'etiquetas' => NULL,
                    'checklist' => NULL,
                    'notificacoes' => NULL,
                    'expediente' => NULL,
                    'cidade_id' =>  '16ae6e67-b993-f5f7-470f-859e4ba7e99c',
                    'unidade_pai_id' => NULL,
                    'entidade_id' => $entidade->id,
                ]
            );

            Usuario::updateOrCreate(
                ['email' => $usuario->email],
                [
                    'id' => $guidUsuario,
                    'nome' => $usuario->nome,
                    'password' => null,
                    'cpf' => $cpfFormatado,
                    'matricula' => $usuario->siape,
                    'apelido' => $usuario->login,
                    'perfil_id' => $perfis->where('nome', 'Perfil Participante')->first()->id,
                    'situacao_funcional' => 'ATIVO_PERMANENTE',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::connection('petrvs')->table('unidades_integrantes')->updateOrInsert(
                ['usuario_id' => $guidUsuario],
                [
                    'id' => $guidUsuario,
                    'unidade_id' => $guidUnidade,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            DB::connection('petrvs')->table('unidades_integrantes_atribuicoes')->updateOrInsert(
                ['unidade_integrante_id' => $guidUsuario],
                [
                    'id' => $guidUsuario,
                    'atribuicao' => 'LOTADO',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    private function generateGuid($id)
    {
        $hash = md5($id);
        $guid = substr($hash, 0, 8) . '-' .
                substr($hash, 8, 4) . '-' .
                substr($hash, 12, 4) . '-' .
                substr($hash, 16, 4) . '-' .
                substr($hash, 20, 12);
        return $guid;
    }

}
