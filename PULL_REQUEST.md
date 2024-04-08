# O Projeto Core Note

## Uma Introdução ao Desenvolvimento

O Projeto Core Note é uma plataforma de notas desenvolvida com o framework Laravel em PHP, oferecendo uma solução eficiente para a criação, armazenamento e gerenciamento de notas pessoais ou profissionais. Esta explicação destaca os aspectos fundamentais do desenvolvimento, incluindo a execução do projeto, o uso do framework Laravel, PHP, middleware, manipulação e de requisições.

## Como Executar o Projeto

Para executar o projeto Core Note, siga os seguintes passos:

Instale as Dependências: Utilize o Composer para instalar todas as dependências necessárias. Isso pode ser feito executando o comando composer install no terminal, na raiz do projeto.

Inicialize o Servidor: Após instalar as dependências, inicie o servidor utilizando o comando php artisan serve. Isso iniciará um servidor local para que você possa acessar a plataforma através de um navegador web. Rodando `php artisan serve`.

Você pode migrar o banco de dados usando `php artisan migrate`.
Banco de dados configurado: PostgreSQL (PSQL).

## Laravel

O Laravel é um dos frameworks PHP mais populares e poderosos, utilizado no desenvolvimento do Core Note. Ele oferece uma estrutura robusta e elegante para a construção de aplicações web, facilitando tarefas comuns como roteamento, autenticação, manipulação de banco de dados e muito mais. O Core Note aproveita ao máximo as funcionalidades oferecidas pelo Laravel para proporcionar uma experiência de desenvolvimento e uso fluida e eficiente.

## PHP

O PHP é a linguagem de programação na qual o Laravel é construído e, consequentemente, é a base do Core Note. Com sua ampla adoção e comunidade ativa, o PHP oferece uma vasta gama de recursos e bibliotecas que são essenciais para o desenvolvimento de aplicações web dinâmicas e escaláveis. No contexto do Core Note, o PHP é utilizado para implementar a lógica de negócios, manipulação de dados e interação com o framework Laravel.

## Uso de Middleware

O middleware é uma parte crucial do pipeline de requisições do Laravel e desempenha um papel importante no processamento de solicitações HTTP. No Core Note, o middleware é utilizado para aplicar filtros, autenticação, controle de acesso e outras operações intermediárias antes que uma requisição atinja as rotas definidas na aplicação. Isso permite uma maior modularidade, segurança e controle sobre o fluxo de solicitações na plataforma.

## Arquitetura MVC no Projeto Core Note

No projeto Core Note, a arquitetura Modelo-Visão-Controlador (MVC) ou Model, View e Controller (MVC) em inglês é adotada para separar as preocupações e organizar o código de forma mais clara e modular. Esta abordagem permite uma melhor manutenção, escalabilidade e testabilidade da aplicação. Exemplo de como o MVC é implementado:

### Modelo (Model)

No padrão MVC, o modelo representa a camada de dados da aplicação. Ele encapsula a lógica de negócios e os dados do aplicativo. No Core Note, os modelos são responsáveis por interagir com o banco de dados e representar os objetos de domínio.

Exemplo de um modelo no Core Note:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['title', 'content'];
}
```

Neste exemplo, Note é um modelo que representa uma nota na aplicação. Ele estende a classe Model do Laravel e define quais campos podem ser preenchidos em massa ($fillable), garantindo a segurança e integridade dos dados.

### Visão (View)

A camada de visão é responsável por apresentar os dados ao usuário e responder às interações do usuário. No Core Note, as visões são implementadas usando o sistema de templates Blade do Laravel. As visões são responsáveis por exibir a interface do usuário, formatar os dados e interagir com o usuário.

Exemplo de uma visão no Core Note:

```php
<!-- resources/views/notes/index.blade.php -->

@foreach ($notes as $note)
    <div>
        <h2>{{ $note->title }}</h2>
        <p>{{ $note->content }}</p>
    </div>
@endforeach
```

Neste exemplo, a visão exibe uma lista de notas, iterando sobre cada nota e exibindo seu título e conteúdo.
Neste caso estamos usando o conceito de APIs REST e não há necessidade e recomendação para uso de views. E somente uma possibilidade que o Laravel oferece.

### Controlador (Controller)

A camada de controlador é responsável por receber as requisições do usuário, processá-las e retornar uma resposta apropriada. No Core Note, os controladores são responsáveis por orquestrar as interações entre as visões e os modelos. Eles contêm métodos que correspondem às diferentes ações que o usuário pode realizar na aplicação.

Exemplo de um controlador no Core Note:

```php
namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all();
        return view('notes.index', ['notes' => $notes]);
    }

    // Outros métodos do controlador para criar, atualizar, exibir e excluir notas
}
```

Neste exemplo, o controlador NoteController possui um método index() que retorna a visão notes.index com todas as notas recuperadas do modelo Note.

### Benefícios da Arquitetura MVC

A adoção da arquitetura MVC no Core Note traz diversos benefícios:

- Separação de Preocupações: O MVC divide a aplicação em três componentes distintos, facilitando a manutenção e o desenvolvimento separado de cada parte do sistema.
- Reutilização de Código: Com a separação clara de responsabilidades, é mais fácil reutilizar e compartilhar componentes entre diferentes partes da aplicação.
- Testabilidade: A separação de responsabilidades facilita a escrita de testes unitários e de integração para cada componente individual da aplicação.
Em resumo, a arquitetura MVC no projeto Core Note promove uma estrutura organizada e modular, facilitando o desenvolvimento, a manutenção e a escalabilidade da aplicação ao longo do tempo.

## Requisições

O Core Note lida com uma variedade de requisições HTTP, incluindo solicitações para criar, visualizar, atualizar e excluir notas. Essas requisições são roteadas para controladores específicos no Laravel, onde a lógica de negócios correspondente é executada. As rotas são definidas de forma clara e organizada, seguindo as práticas recomendadas do Laravel, garantindo assim um fluxo suave e previsível de interações entre o usuário e a aplicação.

## Validação de Dados

A validação de dados é essencial para garantir que as informações inseridas na aplicação estejam corretas e consistentes. No Core Note, a validação é realizada principalmente através dos recursos fornecidos pelo Laravel.

## Laravel Validation

O Laravel oferece uma poderosa funcionalidade de validação de dados. No Core Note, isso é feito através de regras de validação definidas nos controladores ou nos formulários de requisição. Por exemplo, ao criar ou atualizar uma nota, podemos validar se os campos obrigatórios foram preenchidos, se os tipos de dados estão corretos e até mesmo criar regras personalizadas para validar informações específicas.
Benefícios da Abordagem
A combinação de validação de dados e orientação a objetos traz diversos benefícios para o projeto Core Note:

- Integridade dos Dados: A validação de dados garante que apenas informações válidas e consistentes sejam inseridas na aplicação, evitando problemas de integridade nos dados.

- Manutenibilidade: A orientação a objetos promove um código bem estruturado e modular, facilitando a manutenção e a evolução do sistema ao longo do tempo.

- Flexibilidade: Através dos recursos oferecidos pelo Laravel, como validação de dados e relacionamentos de eloquent, podemos adaptar facilmente o sistema às necessidades do usuário e aos requisitos do negócio.

Em resumo, a validação de dados e a orientação a objetos são elementos essenciais no projeto Core Note, contribuindo para a construção de uma aplicação robusta, flexível e de fácil manutenção.

## REST

REST (Representational State Transfer) é um estilo de arquitetura de software que define um conjunto de princípios para a criação de serviços web escaláveis e interoperáveis. Ele foi descrito pela primeira vez por Roy Fielding em sua dissertação de doutorado em 2000 e desde então se tornou uma abordagem popular para projetar sistemas distribuídos na web.

A principal ideia por trás do REST é que os sistemas devem ser projetados em torno de recursos, que são entidades identificáveis e manipuláveis por meio de um identificador global único, como um URL. As operações em recursos são realizadas através de um conjunto de verbos HTTP padronizados, que incluem GET, POST, PUT, DELETE, entre outros.

Principais conceitos do REST:

- Recursos (Resources): Recursos são entidades de dados identificáveis que podem ser acessadas e manipuladas através de URLs. Por exemplo, em um sistema de gerenciamento de usuários, os recursos podem incluir usuários, posts, comentários, etc.

- URI (Uniform Resource Identifier): Cada recurso é identificado por um URI único. Este URI é usado para acessar e manipular o recurso. Por exemplo, /users/123 pode ser o URI para acessar o usuário com o ID 123.

- Operações CRUD (Create, Read, Update, Delete): As operações básicas em recursos seguem o padrão CRUD. Os verbos HTTP GET, POST, PUT e DELETE são usados para realizar essas operações. Por exemplo, GET para recuperar um recurso, POST para criar um novo recurso, PUT para atualizar um recurso existente e DELETE para excluir um recurso.

- Representações: Os recursos podem ter várias representações, como JSON, XML, HTML, etc. Dependendo do tipo de solicitação (como cabeçalhos de solicitação "Accept"), o servidor pode retornar a representação apropriada do recurso.

- Statelessness (Sem estado): O REST é baseado no princípio de que as solicitações de um cliente para um servidor devem conter todas as informações necessárias para entender e processar a solicitação. O servidor não mantém estado da sessão do cliente entre as solicitações. Cada solicitação é independente e autocontida.

- HATEOAS (Hypermedia as the Engine of Application State): Esse princípio sugere que as respostas da API devem conter links ou referências para outros recursos relacionados. Isso permite uma navegação mais dinâmica e descoberta de recursos por parte dos clientes da API.

Em resumo, REST é um estilo de arquitetura de software que promove a construção de sistemas distribuídos na web de forma escalável, interoperável e flexível, usando os padrões da web, como HTTP e URIs. Ele se concentra em recursos identificáveis, operações padronizadas e comunicação sem estado entre clientes e servidores.
