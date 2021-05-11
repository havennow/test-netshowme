# Setup

- DDD com Symfony Kernel + Symfony Bundles
- PHP8, Nginx com Php-fpm

##### Requesitos: 
- Docker
- Docker Compose
- Bash
- Make ( Linux e macOS/BSD ) ou Git CLI no Windows  [Download do upgrade de Git CLI](https://github.com/havennow/upgrade-git-cli)

---

#### Rodar os seguintes comandos, para iniciar o projeto:
    
1) ``make build``  - esse comando constrói os containers do Docker
2) ``make install`` - esse comando instala dependências, executa migrate e data fixture
3) ``make start`` - esse comando sobe todos containers
4) ``make shell`` - esse comando entra no shell/bash do container principal "backend", acesso ao php cli e composer  
5) ``make stop`` - esse comando para todos containers
6) ``make tests`` - esse comando executa todos testes 

---

### Rotas:

1) ``http://localhost/api/v1/email`` - Parâmetros multipart [name, email, phone, message, file_attach]
2) ``http://localhost/api/v1/email/{\d+}`` - Recupera dados da tabela buscando o "id"

---

### Uso real

Para simular o envio de e-mail, saida e visualização de fato, foi utilizado o ``mailhog``
para testar, só acessar ``http://localhost:8025``, e assim vai ser possível ver o email que foi enviado

---