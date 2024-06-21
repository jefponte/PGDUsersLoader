<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\Unidade;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = DB::connection('sigaa')->table('vw_usuarios_catraca')->get();
        $entidadeId = '52d78c7d-e0c1-422b-b094-2ca5958d5ac1';


        $entidade = DB::connection('petrvs')->table('entidades')->find($entidadeId);
        if (!$entidade) {
            DB::connection('petrvs')->table('entidades')->insert([
                'id' => $entidadeId,
                'nome' => 'Nome da Entidade',
                'sigla' => 'ENT',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        foreach ($usuarios as $usuario) {
            $guidUsuario = $this->generateGuid($usuario->id_usuario);
            $guidUnidade = $this->generateGuid($usuario->id_unidade);


            Unidade::updateOrCreate(
                [
                    'id' => $guidUnidade,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => NULL,
                    'codigo' => '1',
                    'sigla' => $usuario->sigla_unidade,
                    'nome' => $usuario->descricao_unidade,
                    'instituidora' => 1,
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
                    'cidade_id' =>  '0f8264d0-acea-8733-df5a-891544a1bf64',
                    'unidade_pai_id' => NULL,
                    'entidade_id' => $entidadeId,
                ]
            );

            Usuario::updateOrCreate(
                [
                    'email' => $usuario->email,
                ],
                [
                    'id' => $guidUsuario,
                    'nome' => $usuario->nome,
                    'password' => null,
                    'cpf' => $usuario->cpf_cnpj,
                    'matricula' => $usuario->matricula_disc,
                    'apelido' => $usuario->login,
                    'perfil_id' => 'e4da3b7f-bbce-2345-d777-2b0674a318d5',
                    'situacao_funcional' => 'ATIVO_PERMANENTE',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::connection('petrvs')->table('unidades_integrantes')->updateOrInsert(
                [
                    'usuario_id' => $guidUsuario,
                    'unidade_id' => $guidUnidade,
                ],
                [
                    'id' => $guidUsuario,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Generate a GUID based on id.
     */
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
