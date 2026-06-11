# Mimoquices

A Mimoquices é um site dinâmico.
Funciona como uma montra digital (portefólio), permitindo a apresentação das imagens dos produtos,
acompanhadas das respetivas descrições. personalizações de cada produto e, quando necessário, de detalhes técnicos


## 🚀 Requisitos de Sistema

Antes de começar, certifica-te de que tens instalado:
* PHP 8.2 ou superior
* Composer
* Node.js & NPM
* Servidor de Base de Dados (MySQL / PostgreSQL / SQLite)

Se Não estiver instalado não tem problema, pois iremos instalar as dependencias em baixo 

## 🛠️ Instalação e Configuração

Segue estes passos para configurar o projeto localmente:


1- abrir repositório mimoquises site e download em zip

2- instalar o node.js - link - https://nodejs.org/en/download/current
istalar o .msi

3-Instalar xampp - link - https://www.apachefriends.org/download.html
pelo menos no xampp reparei que é necessario abrir o ficheiro xampp/php/php.ini e procure  a linha com ;extension=zip e remova o ponto e virgula (;) 

4-Instalar o composer - link - https://getcomposer.org/download/

Instalamos o composer-setup.exe
No instalador onde diz "command-line php you want to use" coloque o xampp/php/php.exe ou Wampp/php/php.ini a perferencia do utilizador
descomprime o .zip e coloque a pasta do projeto dentro da pasta C:\xampp\htdocs ou no caso do Wampp dentro do C:\Wampp\www


5-em seguida abra o cmd dentro da pasta C:\xampp\htdocs\mimoquices e utilize o comando 

    composer require laravel/installer

6
Configurar o Ambiente:

    copy .env.example .env

7-Gerar a chave da aplicação:

    php artisan key:generate

8-Executar as Migrations:

    php artisan migrate --seed      

9-Criar o link simbólico para o armazenamento:

    php artisan storage:link

10-Adicionar icons 

    composer require blade-ui-kit/blade-heroicons

💻 Execução
Para iniciar o servidor de desenvolvimento abra o cmd e coloque:

    php artisan serve
    
e outro cmd para o envio de emails:

    php artisan queue:work

A aplicação estará disponível em: http://localhost:8000


