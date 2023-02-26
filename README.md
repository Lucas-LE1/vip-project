# VIP PROJECT - Lucas Eduardo

---

## Introdução

Avaliação técnica para admissã
o de estágiario. A aplicação foi produzida utilizando os frameworks Laravel (Back-End) e
Vue Js (Front-End) com autenticação JWT nas rotas e armazenamento local em arquivos JSON mantendo a estrutra de tabelas
SQL.

### Frameworks e Linguagens

    Laravel - 10x | PHP >=8
    Vue JS - 3x   | JavaScript

## Instalação e Teste

Para iniciar a instalação da aplicação e seus teste, faça os seguintes comandos.

> Observação: Antes de iniciar, confirme que você tenha instalado PHP versão 8 ou posterior, composer, NodeJS e Git.

Retomando, atendendo os requisitos acima:

``
git clone https://github.com/Lucas-LE1/vip-project.git
``

Após isso, entre na pasta do projeto com o comando `cd vip-project`.

---

### Configurando o Back End

Abra a pasta do projeto e configure o back end executando no console:

```
cd back-vip
composer install
npm install
```

Neste momento, permancendo na pasta do Back End, se você estiver no Windows, desabilite a verificação
de `SSL Certificate` do `guzzle` acessando o diretório e alterando o especificado:

``
back-vip/vendor/guzzlehttp/guzzle/src/Client.php
``

```php
private function configureDefaults(array $config): void
    {
        $defaults = [
            'allow_redirects' => RedirectMiddleware::$defaultSettings,
            'http_errors'     => true,
            'decode_content'  => true,
            'verify'          => true, // Altere este parametro para false
            'cookies'         => false,
            'idn_conversion'  => false,
        ];
```

Retornando à pasta raiz, `back-vip`, execute o comando `php artisan serve` para iniciar o servidor em desenvolvimento e
siga os proximos passos.

>Observação: Abra outra instância do terminal para prosseguir!

### Configurando o Front End

Abra a pasta do projeto e configure o front end executando no console:

```
cd front-vip
npm install
```

Mantendo a pasta raiz, `front-vip`, execute o comando `npm run dev` para iniciar o servidor em desenvolvimento.

> Agora abra em seu navegador o link apresentado no terminal, como por exemplo: http://localhost:5173/#/

## Back End - Detalhamento de Código

O Laravel dispõe de middlewares, controllers e models, com os ultimos fazendo parte da arquitetura de software MVC -
Model, View, Controller.

### Arquivos de Banco de Dados

A aplicação se divide em dois arquivos (tabelas) de armazenamento, encontrados no diretorio ``back-vip/database/temp``,
sendo eles `users.json` e `favorites.json`seguindo modelos de tabela padrão SQL.

### Rotas da API

Seguindo ao acesso do front end à aplicação Laravel, as rotas se encontram no arquivo `back-vip/routes/api.php`,
organizadas com de forma genérica com o prefixo `api`, sendo subdivididas nos prefixos: `users`,`items`.

- Lista de rotas e seus respectivos métodos HTTP:

| Método HTTP | Rotas - PATH       |
|-------------|--------------------|
| POST        | `api/users/insert` |
| POST        | `api/users/login`  |
| POST        | `api/items/insert` |
| POST        | `api/items/serch`  |

### Middlewares

Para filtagrem de rotas, os middlewares estão de prontidão, criados com o
comando `php artisan make:middleware name-middleware`, todos se localizam no diretorio `back-vip/app/Http/Middleware` e
tomam como suas funções definerem se os parametros correspondem para permitir acesso ao sistema.

- Lista de middlewares:

| Middlewares     | Funcionalidades no Sistema                                       |
|-----------------|------------------------------------------------------------------|
| `fileExists`    | Criar e verificar existência de arquivos de banco de dados.      |
| `userExists`    | Verificar uso de endereço de email enviado na requisição post.   |
| `validateToken` | Validação de token de acesso do usuario com autenticação JWT     |
| `checkAdmin`    | Checagem de autorização administrador para inserção de favoritos |

Todos os Middlewares se encontram listados com seus respectivos alias no arquivo ``back-vip/app/Http/Kernel.php``:

```php
protected $routeMiddleware = [
        ...
        'fileExists' => \App\Http\Middleware\filesExists::class,
        'userExists' => \App\Http\Middleware\userExists::class,
        'validateToken' => \App\Http\Middleware\validateToken::class,
        'checkAdmin' => \App\Http\Middleware\checkAdmin::class,
]
```

### Models

Os models são responsáveis por fazer a comunicação entre servidor e a base de dados, sendo criados com o
comando ``php artisan make:model nome-model``, localizados em `back-vip/app/Models/api` e sendo dividos em dois models,
responsáveis pelos arquivos de banco de dados `users.json` e `favorites.json`

- Lista de models:

| Nome Model      | Arquivo Responsável | Métodos                                      |
|-----------------|---------------------|----------------------------------------------|
| `Users.php`     | `users.json`        | `insert` `email_in_use` `is_user` `is_admin` |` 
| `Favorites.php` | `favorites.json`    | ``updDoc`` ``select``                        |

### Controllers

Os Controllers são os responsáveis pela comunicação entre o Front e o Back, manipulando e retornando parametros. Os controller se encontram no diretorio ``back-vip/app/Http/Controllers/api``, sendo dividos em:

| Controllers               | Funcionalidades no Sistema                           |
|---------------------------|------------------------------------------------------|
| `UsersController.php`     | Responder as questões referente ao usuario.          |
| `JWTController.php`       | Responder as questões referente à autenticação JWT    |
| `FavoritesController.php` | Responder as questões referente ao Items e Favoritos |

## Front End - Detalhamento de Código

O Vue JS como front end dispõe de uma organização mais simples, que é responsável pela execução da aplicação.

### Rotas da Aplicação

Para permitir a navegação, utiliza-se do `vue-router`, estando presente o seu arquivo de configuração em: `front-vip/src/routes.js`, `front-vip/src/main.js` e `front-vip/src/App.vue`.

### Componentes e Estilização

No diretorio `front-vip/src/components`,encontra-se os arquivos que fazem a composição das views.

- Lista de Views no diretorio `front-vip/src/components/views`:

| Views             | Descrição                                                                     |
|-------------------|-------------------------------------------------------------------------------|
| `HeaderLoRe.vue`  | Cabeçalho de descrição do desenvolvedor e Titulo de paginas Login e Registro. |
| `Login.vue`       | Tela de login de usuário para ingresso no sistema.                            |
| `Register.vue`    | Tela de registro de usuário para ingresso no sistema.                         |
| `ItemsSearch.vue` | Tela de items para pesquisar, favoritar e listar.                             |
| `NotFound.vue`    | Tela padrão de rotas não listadas com link para as rotas existentes.          |
| `Modal.vue`       | Tela modal para descrever exito ou error em processos.                        |
