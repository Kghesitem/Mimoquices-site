# Mimoquices

# Nome do Projeto

Breve descrição do que o projeto faz e qual o seu objetivo principal.

## 🚀 Requisitos de Sistema

Antes de começar, certifica-te de que tens instalado:
* PHP 8.2 ou superior
* Composer
* Node.js & NPM
* Servidor de Base de Dados (MySQL / PostgreSQL / SQLite)

## 🛠️ Instalação e Configuração

Segue estes passos para configurar o projeto localmente:

1. abrir repositório mimoquises site e download em zip


2- instalar o node.js - link - https://nodejs.org/en/download/current
istalar o .msi

3-Instalar xampp - link - https://www.apachefriends.org/download.html
abra o ficheiro xampp/php/php.ini e procure  a linha com ;extension=zip e remova o ponto e virgula (;) 

4-Instalar o composer - link - https://getcomposer.org/download/
istalamos o composer-setup.exe
no instalador onde diz command-line php you want to use coloque o xammp/php/php.exe
descomprime o .zip e coloque a pasta do projeto dentro da pasta C:\xampp\htdocs


5-em seguida abra o cmd dentro da pasta C:\xampp\htdocs\mimoquices e utilize o comando composer require laravel/installer

6
Configurar o Ambiente:
copy .env.example .env

7-Gerar a chave da aplicação:
php artisan key:generate

8-Executar as Migrations:
php artisan migrate --seed

9-Criar o link simbólico para o armazenamento:
php artisan storage:link

💻 Execução
Para iniciar o servidor de desenvolvimento:

    php artisan serve

A aplicação estará disponível em: http://localhost:8000


