## Passo a passo para testar o programa:

Este guia detalha os passos necessários para configurar o ambiente de desenvolvimento para um projeto web utilizando TailwindCSS e PHP 8.

**Pré-requisitos:**

* Computador com sistema operacional Windows
* Navegador web (Chrome ou Firefox recomendado)

**Dependências:**

* **TailwindCSS:** Uma biblioteca CSS para criar interfaces responsivas rapidamente.
* **PHP 8:** A versão mais recente do PHP para executar o código do back-end.
* **Live Server:** Utilizar extensão Live Server para ambiente de teste do front-end.

**Configuração do Front-end:**

1. **Instalação do TailwindCSS:**

    * Abra um terminal ou prompt de comando no diretório do seu projeto.
    * Execute os seguintes comandos:

      ```bash
      npm install
      npm install -D tailwindcss
      npx tailwindcss init
      ```

      * Isso instalará as dependências do TailwindCSS e criará os arquivos de configuração necessários.

      ** Gere o arquivo CSS inicial **:

      ```bash
      npx tailwindcss -i ./src/index.css -o ./src/output.css --watch
      ```
      *após isso abra em seu navegador de preferência ou use a extensão Live Server

**Configuração do Back-end:**

1. **Verificação do Driver PDO:**

    * O PHP Data Objects (PDO) é uma extensão PHP necessária para se conectar a bancos de dados.
    * Para verificar se o driver PDO está instalado, abra o arquivo `php.ini` do Wampserver (geralmente localizado em `C:\wamp64\php\php.ini`).
    * Procure pela linha `extension=pdo_mysql`.
    * Se a linha estiver presente e não comentada, o driver PDO está instalado corretamente.
    * Caso contrário, remova o comentário da linha `extension=pdo_mysql` e salve o arquivo `php.ini`.
    * Reinicie o Wampserver para que as alterações tenham efeito.

2. **Executando o Servidor PHP:**

    * Para executar o servidor PHP, rode:
      ```bash
         php -S localhost:8000
      ```
**Futuras atualizações:**
    * Melhorar responsividade.
    * Implementar lógica para guardar imagens no servidor