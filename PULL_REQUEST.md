# Pull Request - Backend

## Descrição
Mantive o ambiente em Laravel, somente atualizando as dependências e adicionando a biblioteca `tymon/jwt-auth` para autenticação via JWT. Em seguida, criei as migrations e os models necessários para a estruturação e integração das tabelas "users" e "notes" do banco de dados.

Desenvolvi as rotas de autenticação (`api/login` e `api/register`) e o CRUD das notas (`api/notes`), protegendo-as rotas das notas com autenticação JWT. Para facilitar a execução da aplicação, criei um `Dockerfile` para a API e um `docker-compose` que inclui uma instância do MySQL com o Dockerfile da API devidamente configurado e mais detalhado nos arquivos README.md e Leiame.md.

Por fim, realizei uma modificação no middleware de autenticação para garantir que requisições com tokens inválidos ou ausentes retornem corretamente o erro `401`.