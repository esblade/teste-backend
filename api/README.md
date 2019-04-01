# Inicializar instalação frameworks usados / na pasta api
composer install

# Frameworks
@Doctrine
@Slim framework

# Configuração do DB
@src/settings.php [password] = alterar senha do banco de dados

# Erro app.log
Caso dê erro no arquivo app.log utilizando linux, chmod 777 @api/logs/

# Arquivos
@src/settings.php - usado para informações do banco

@src/dependencies.php - usado para instancias de log, view e inicialização do banco

@src/routes.php - rotas onde criei a api e a view do relatorio

@src/DB.php - classe de conexao doctrine

@controller/Service.php - classe criada para busca sql

@public/view.html - pagina de exibição de relatorio

@public/json.html - pagina da api em json

# Paginas
API - teste-backend/app/public/api

VIEW - teste-backend/app/public/
