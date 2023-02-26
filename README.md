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

>Observação: Antes de iniciar, confirme que você tenha instalado PHP versão 8 ou posterior, composer e NodeJS.

Retomando, atendendo os requisitos acima:

``
HTTPS:
git clone https://github.com/Lucas-LE1/vip-project.git
``
---
### Configurando o Back End

Abra a pasta do projeto e configure o back end executando no console:

```
cd back-vip
composer install
npm install
```
Neste momento, permancendo na pasta do Back End, se você estiver no Windows, desabilite a verificação de `SSL Certificate` do `guzzly` acessando o diretório e alterando o especificado:

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

Retornando à pasta raiz, `back-vip`, execute o comando `php artisan serve` para iniciar o servidor em desenvolvimento e siga os proximos passos.

### Configurando o Front End

Abra a pasta do projeto e configure o front end executando no console:

```
cd front-vip
npm install
```

Mantendo a pasta raiz, `front-vip`, execute o comando `npm run dev` para iniciar o servidor em desenvolvimento.

>Agora abra em seu navegador o link apresentado no terminal, como por exemplo: http://localhost:5173/#/

