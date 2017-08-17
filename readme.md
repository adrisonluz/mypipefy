# MyPipefy

## Instalação

git clone git@github.com:adrisonluz/mypipefy.git

cd mypipefy/

composer update

cp .env.example .env

php artisan key:generate


### Editar .env

É necessário criar um banco de dados com o nome de "mypipefy" ou o que desejar. Feito isto, inserir as configurações de banco nas sequintes linhas do arquivo .env:

DB_CONNECTION=mysql  	# Tipo de conexão
 
DB_HOST=127.0.0.1 		# Host

DB_PORT=3306			# Porta

DB_DATABASE=mypipefy 	# Nome do banco

DB_USERNAME=root 		# Usuário

DB_PASSWORD= 			# Senha


Adicionar Id da organização cadastrada no Pipefy, na linha:

PIPEFY_ORGANIZATION_ID=


### Voltando ao terminal

php artisan vendor:publish

php artisan migrate


### Criando seu usuário

Agora você deve acessar a url do sistema, que provavelmente será "http://localhost/mypipefy/public/", e cadastrar seu usuário. Clique em "Cadastro" no menu superior e preencha os campos do formulário. Lembrando que o email deve ser o mesmo utilizado para logar no Pipefy.