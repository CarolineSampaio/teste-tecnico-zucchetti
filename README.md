<p align=center>
    <img src="frontend/src/assets/logo-clip.png" alt="Logo Go!Fit System" width="100px">
</p>

# Introdução

O sistema proporciona um ambiente completo para o gerenciamento de comércio, abrangendo clientes, produtos, métodos de pagamento e vendas. Com foco na simplificação das operações diárias, como controle de estoque, processamento de vendas e gestão de clientes, busca-se otimizar os processos comerciais de forma eficaz.

## Dependências do sistema

- [Docker](https://docs.docker.com/desktop/install/windows-install/)

## Tecnologias e técnicas utilizadas

### Back-end

- **Linguagem:** PHP
- **Banco de Dados:** PostgreSQL
- **Testes Unitários:** PHPUnit

### Front-end

- **Framework/Linguagem:** Vue JS

## Modelagem da base de dados PostgreSQL

Antes do início do projeto, foi elaborada a modelagem utilizando o [dbdiagram.io](https://dbdiagram.io/).

A imagem abaixo proporciona uma perspectiva geral da estrutura do banco de dados integrado ao sistema.

<p align=center>
    <img src="frontend/src/assets" alt="print da modelagem do banco de dados" width="900">
</p>

## Setup Docker

### Clone o projeto

```bash
cd "caminho/da/sua/pasta"
git clone https://github.com/CarolineSampaio/teste-tecnico-zucchetti.git
cd "teste-tecnico-zucchetti"
code ./ #Abrirá o Vscode na raiz do projeto
```

### Configure o ambiente

O comando abaixo, criará as imagens necessárias, configurará o banco de dados da aplicação e o de testes, executará os seeders para preenchimento inicial de dados, e inicializará tanto o servidor frontend quanto o back-end.

```sh
docker compose up  # para rodar em background adicione -d
```

## Rodando testes

### Back-end

O banco de dados para teste foi configurado no docker, por isso, após configurar o ambiente basta executar:

```bash
composer docker-test
```

## Melhorias

- [x] **Dockerizar a aplicação/ambiente de desenvolvimento:** Implementar o uso de Docker para simplificar o ambiente de desenvolvimento e garantir consistência entre diferentes máquinas.

- [x] **Utilizar a cláusula FOR UPDATE nas consultas SQL** Adotar a cláusula FOR UPDATE em consultas SQL para controlar a concorrência em operações de atualização de dados no banco de dados.

- [x] **Implementar testes unitários no back-end:** Desenvolver testes automatizados para verificar o comportamento de unidades de código no back-end, aumentando a confiabilidade e a robustez do sistema.

- **Implementar testes unitários no front-end:** Desenvolver testes automatizados para verificar o comportamento de unidades de código no front-end, garantindo o correto funcionamento da interface.

- **Autenticação:** Introduzir um sistema de autenticação robusto e seguro para controlar o acesso aos recursos da aplicação, garantindo a proteção dos dados e a segurança das operações realizadas pelos usuários.

- **Aprimorar o roteamento backend:** Simplificar e organizar o gerenciamento de rotas, melhorando a estrutura e facilitando a adição de novas rotas para uma arquitetura mais robusta e escalável.

- **Implementar cache para cliente, produto e forma de pagamento:** Desenvolver e implementar uma estratégia de cache eficiente para armazenar informações de clientes, produtos e formas de pagamento, visando melhorar o desempenho e a escalabilidade da aplicação, reduzindo a carga no banco de dados e otimizando o tempo de resposta das consultas.

- **Otimizar consultas ao banco de dados:** Aprimorar a eficiência das consultas SQL, utilizando técnicas como inserção em massa (bulk insert) e seleção otimizada (O método de atualização de estoque do produto possui complexidade de O(2N) mas pode rodar em O(2) agrupando queries).

- **Permitir edição de produtos e quantidades durante o processo de atualização de uma venda:** Implementar funcionalidades que permitam a edição de produtos e quantidades durante o processo de atualização de uma venda, oferecendo maior flexibilidade e controle aos usuários.

- **Implementar um sistema para controle de status da venda:** Desenvolver um sistema de máquina de estados finitos para controlar o status das vendas, proporcionando uma melhor organização e rastreamento do processo da venda.

- **Reforçar as validações de dados no back-end e front-end:** Fortalecer as validações de dados tanto no lado do servidor quanto no lado do cliente, garantindo uma maior integridade e consistência dos dados manipulados pela aplicação.

- **Aprimorar as respostas do back-end para incluir objetos estruturados de dados:** Melhorar as respostas do back-end para incluir objetos estruturados de dados em vez de mensagens simples, oferecendo mais informações e contexto aos clientes da API.

- **Adotar PSR-4 Imports para estruturação e importação de classes PHP:** Seguir o padrão PSR-4 para a estruturação e importação de classes PHP, garantindo uma organização clara e consistente do código.
