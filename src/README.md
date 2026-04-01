# TaskFlow API - Laravel 12

API RESTful para gerenciamento de projetos, tarefas, tags e perfil de usuario, implementada em Laravel 12 com arquitetura MSC (Model-Service-Controller).

## Requisitos

- PHP 8.2+
- Composer
- Banco de dados configurado no arquivo .env

## Instalacao

1. Instale as dependencias:

composer install

2. Copie o arquivo de ambiente (caso ainda nao exista):

cp .env.example .env

3. Gere a chave da aplicacao:

php artisan key:generate

4. Configure o banco no arquivo .env (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

## Rodando migrations e seeders

Executa recriacao completa do banco e popula dados iniciais:

php artisan migrate:fresh --seed

## Subindo a API

php artisan serve

A API ficara disponivel em http://127.0.0.1:8000.

## Arquitetura MSC

- Models: acesso e relacionamento de dados com Eloquent.
- Services: regras de negocio e validacoes.
- Controllers: orquestracao HTTP e respostas JSON.

## Endpoints

### Projects

- GET /api/projects
- POST /api/projects
- GET /api/projects/{id}
- PUT /api/projects/{id}
- DELETE /api/projects/{id}

### Tasks (aninhadas em Projects)

- GET /api/projects/{id}/tasks
- POST /api/projects/{id}/tasks
- GET /api/projects/{id}/tasks/{taskId}
- PUT /api/projects/{id}/tasks/{taskId}
- DELETE /api/projects/{id}/tasks/{taskId}
- PATCH /api/projects/{id}/tasks/{taskId}/status

### Tags

- GET /api/tags
- POST /api/tags

### Associacao Task-Tag

- POST /api/tasks/{taskId}/tags/{tagId}
- DELETE /api/tasks/{taskId}/tags/{tagId}

### Profile

- GET /api/users/{id}/profile
- PUT /api/users/{id}/profile

## Padrao de respostas

### Sucesso (lista)

{
  "data": [
    {
      "id": 1,
      "name": "Meu Projeto",
      "tasks_count": 5
    }
  ]
}

### Sucesso (criacao)

{
  "data": {
    "id": 1,
    "name": "Novo Projeto"
  },
  "message": "Projeto criado com sucesso."
}

### Erro de recurso nao encontrado

{
  "message": "Projeto nao encontrado.",
  "status": 404
}

### Erro de validacao

{
  "message": "Dados invalidos.",
  "errors": {
    "name": [
      "O campo name e obrigatorio."
    ]
  }
}

## Comandos esperados de funcionamento

- composer install
- php artisan migrate:fresh --seed
- php artisan serve

É isso.