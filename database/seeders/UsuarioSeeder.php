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

        // Conectar ao banco MySQL e inserir os dados
        foreach ($usuarios as $usuario) {
            $guidUsuario = $this->generateGuid($usuario->id_usuario);
            $guidUnidade = $this->generateGuid($usuario->id_unidade);

            // Inserir ou atualizar a unidade
            Unidade::updateOrCreate(
                [
                    'id' => $guidUnidade,
                ],
                [
                    'nome' => $usuario->descricao_unidade,
                    'sigla' => $usuario->sigla_unidade,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Inserir ou atualizar o usuário
            Usuario::updateOrCreate(
                [
                    'email' => $usuario->email,
                ],
                [
                    'id' => $guidUsuario,
                    'nome' => $usuario->nome,
                    'password' => Hash::make($usuario->senha),
                    'cpf' => $usuario->cpf_cnpj,
                    'matricula' => $usuario->matricula_disc,
                    'apelido' => $usuario->login,
                    'perfil_id' => '5bdc583a-d0f4-7e03-401e-939cefa4df6e',
                    'situacao_funcional' => 'ATIVO_PERMANENTE',
                    'unidade_id' => $guidUnidade,
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
        // Aqui estamos gerando um UUID aleatório e ajustando ele com base no id
        $uuid = (string) Str::uuid();
        $hash = substr(md5($id), 0, 8);
        $guid = substr($uuid, 0, 28) . $hash;
        return $guid;
    }
}
