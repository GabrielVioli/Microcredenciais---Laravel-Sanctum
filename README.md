# Microcredenciais API

API RESTful desenvolvida em Laravel para o gerenciamento de estudantes, cursos e emissão de microcredenciais digitais. O sistema utiliza o Laravel Sanctum para autenticação segura de rotas através de tokens.

---

## Estrutura do Banco de Dados

Baseado nas migrations e modelos do projeto, o sistema possui as seguintes entidades principais:

### Users (Instituições)
Gerenciamento de usuários e autenticação da API. Representa as instituições de ensino que emitem as credenciais.
- `id`
- `name`
- `email`
- `password`
- `remember_token`
- `timestamps`

### Students (Estudantes)
Armazena os dados dos estudantes matriculados:
- `id`
- `name`
- `email`
- `phone`
- `address`
- `gender`
- `timestamps`

### Courses (Cursos)
Armazena os cursos oferecidos pelas instituições:
- `id`
- `name`
- `description`
- `workload`
- `user_id` (Vínculo com a instituição que criou o curso)
- `timestamps`

### Credentials (Badges/Certificados)
Tabela que gerencia o vínculo entre aluno e curso, registrando a emissão da microcredencial:
- `id`
- `student_id` (Vínculo com o estudante)
- `course_id` (Vínculo com o curso)
- `user_id` (Vínculo com a instituição emissora)
- `token` (Hash UUID gerado automaticamente para verificação do badge)
- `timestamps`

---

## Rotas da API

O sistema é dividido entre rotas públicas e rotas restritas às instituições autenticadas. O acesso protegido é feito via `Bearer Token`.

### Rotas Públicas
- `POST /api/cadastro`: Cadastra uma nova instituição.
- `POST /api/login`: Autentica a instituição e retorna o token de acesso.
- `GET /api/verify-badge/{hash}`: Verifica a autenticidade de um badge gerado e retorna os dados públicos do aluno e do curso.

### Rotas Autenticadas (Sanctum)
Requerem o envio do Token no header `Authorization`.

**Instituição:**
- `GET /api/user`: Retorna os dados da instituição autenticada.

**Alunos:**
- `POST /api/student`: Cadastra um novo aluno no ecossistema.
- `GET /api/students/{id}`: Retorna os dados detalhados de um aluno específico.
- `PUT /api/students/{id}`: Atualiza os dados cadastrais de um aluno.

**Cursos:**
- `GET /api/courses`: Lista todos os cursos cadastrados.
- `GET /api/courses/{id}`: Detalha as informações de um curso específico.
- `GET /api/courses/{id}/students`: Lista todos os estudantes que possuem uma credencial (badge) válida para aquele curso.

**Credenciais:**
- `POST /api/credentials`: Vincula um aluno a um curso e gera a credencial/token exclusivo.

---

## Telas e Funcionamento

Abaixo algumas demonstrações do sistema e da estrutura do banco em funcionamento:

### Banco de Dados (SQLite)
Estrutura das tabelas sendo preenchidas via Tinker e Seeders.
![Banco de Dados](images/database.png)

### Consultas na API (Postman)
Retorno das requisições e estrutura do JSON.
![Testes no Postman](images/postman.png)

### Estrutura do Repositório
![Repositório GitHub](images/github.png)