## Passo a passo para testar o programa:

Este guia detalha os passos necessários para configurar o ambiente de desenvolvimento para um projeto web utilizando TailwindCSS e PHP 8.

**Pré-requisitos:**

* Computador com sistema operacional Windows
* Navegador web (Chrome ou Firefox recomendado)

**Dependências:**

* **TailwindCSS:** Uma biblioteca CSS para criar interfaces responsivas rapidamente.
* **Wampserver:** Um servidor web local para executar o código PHP.
* **PHP 8:** A versão mais recente do PHP para executar o código do back-end.

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

1. **Instalação do Wampserver:**

    * Baixe e instale o Wampserver a partir do site oficial
    * Siga as instruções de instalação durante o processo de configuração.
    * Certifique-se de que o Wampserver esteja instalado e em execução após a conclusão da instalação.
    * Esta aplicação usa MySQL.

2. **Verificação do Driver PDO:**

    * O PHP Data Objects (PDO) é uma extensão PHP necessária para se conectar a bancos de dados.
    * Para verificar se o driver PDO está instalado, abra o arquivo `php.ini` do Wampserver (geralmente localizado em `C:\wamp64\php\php.ini`).
    * Procure pela linha `extension=pdo_mysql`.
    * Se a linha estiver presente e não comentada, o driver PDO está instalado corretamente.
    * Caso contrário, remova o comentário da linha `extension=pdo_mysql` e salve o arquivo `php.ini`.
    * Reinicie o Wampserver para que as alterações tenham efeito.

3. **Executando o Servidor PHP:**

    * Para executar o servidor PHP, abra o Wampserver e clique no botão "Iniciar" ao lado do ícone do PHP.
    * Certifique-se de que o status do PHP esteja indicado como "Executando".
    * No seu navegador web, acesse o endereço `http://localhost:8000` para verificar se o servidor PHP está funcionando corretamente.
