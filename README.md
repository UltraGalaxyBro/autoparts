# Autoparts System

## Visão Geral
O Autoparts System é uma aplicação web desenvolvida utilizando o framework Laravel na sua versão 10. Este projeto tive o foco em construir um e-commerce juntamente de um ERP. Grande parte das funcionalidades sobre o que se espera de um e-commerce e ERP eu procurei construir neste projeto. Embora os dados da empresa mencionada (CO2 Peças - CO2 PECAS, COMERCIO E DISTRIBUICAO LTDA) sejam usados como exemplo, a reprodução desses dados fora do contexto deste projeto não é permitida. Certifique-se de substituir quaisquer dados de exemplo pelos dados relevantes para o seu próprio projeto.

## Índice
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Uso](#uso)
- [Testes](#testes)
- [Contribuição](#contribuição)
- [Licença](#licença)

## Instalação
Para instalar o projeto, siga os passos abaixo:

1. Clone o repositório para sua máquina local:
    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    ```

2. Navegue até o diretório do projeto:
    ```bash
    cd seu-repositorio
    ```

3. Instale as dependências do Composer:
    ```bash
    composer install
    ```

4. Instale as dependências do NPM:
    ```bash
    npm install
    ```

## Configuração
1. Copie o arquivo `.env.example` para `.env`:
    ```bash
    cp .env.example .env
    ```

2. Gere uma nova chave de aplicação:
    ```bash
    php artisan key:generate
    ```

3. Configure as informações do banco de dados no arquivo `.env` conforme necessário:
    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nome_do_banco_de_dados
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    ```

4. Execute as migrações para criar as tabelas no banco de dados:
    ```bash
    php artisan migrate
    ```

5. Você pode popular já o banco de dados com alguns exemplos:
    ```bash
    php artisan db:seed
    ```
Após isso é só consultar na UserSeeder os dois tipos de usuários que podem ser usados

## Uso
Para iniciar o servidor de desenvolvimento, execute o seguinte comando:
```bash
php artisan serve
```

Muito obrigado pela sua atenção!
