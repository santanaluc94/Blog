# Blog

Projeto desenvolvido para teste.

### Serviços do ambiente
- MariaDB
- Nginx
- phpMyAdmin
- PHP 8.1

## Comandos

Para **instalar** todo o ambiente é necessário somente um passo:

```sh
bin/install
```

> Assim que a instalação é concluída o projeto já inicia automaticamente.

Para **parar** os contêiners do projeto:

```sh
bin/stop
```

Para **iniciar** os contêiners do projeto:

```sh
bin/start
```

Para acessar o terminal do contêiner PHP do projeto:

```sh
bin/bash
```

Para executar um comando no terminal do contêiner PHP do projeto:

```sh
bin/cli
```

Para **reiniciar** os contêiners do projeto:

```sh
bin/restart
```

Para **deletar** o projeto:

```sh
bin/kill
```

> Este comando inclui as seguintes funções:
> - deletar o banco de dados
> - deletar os contêiners
> - deletar o volume do container
> - deletar a rede dos contêiners
> - Remover a pasta `vendor`
> - Remover o arquivo `composer.lock`

---

## Acessos

### MariaDB

Acessos do banco de dados como administrador:

```txt
Usuário: admin
Senha: admin123
```

### Site

Para acessar o projeto, basta acessar a URL `http::localhost/`.

---

## Tabelas


### Postagens

| id          | int      |
|-------------|----------|
| title       | string   |
| category_id | int      |
| user_id     | int      |
| status      | int      |
| text        | blob     |
| created_at  | datetime |
| updated_at  | datetime |

### Categorias
### Páginas
### Usuários