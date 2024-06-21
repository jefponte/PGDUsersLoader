- Utilize este script em uma máquina com PHP 8.1

Siga o passo a passo:


Crie um arquivo .env com o conteúdo de .env.example

Ajuste as variáveis de ambiente para o banco do petrvs e o do sigaa respectivamente.

O usuário do sigaa deverá ter acesso à vw_usuarios_catraca.

        DB_PETRVS_CONNECTION=mysql
        DB_PETRVS_HOST=127.0.0.1
        DB_PETRVS_PORT=3306
        DB_PETRVS_DATABASE=petrvs_unilab
        DB_PETRVS_USERNAME=root
        DB_PETRVS_PASSWORD=rootpgd



        DB_SIGAA_CONNECTION=pgsql
        DB_SIGAA_HOST=localhost
        DB_SIGAA_PORT=5432
        DB_SIGAA_USERNAME=postgres
        DB_SIGAA_DATABASE=sigaa
        DB_SIGAA_PASSWORD=cocacola@123A


Dentro da pasta raiz,

composer install

php artisan db:seed
