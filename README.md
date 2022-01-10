# Alguns metodos elaborado em php para uso diário em qualquer projeto

Este é um projeto totalmente *OpenSource*, para usa-lo, copia-lo e modifica-lo você não paga absolutamente nada. Porém para continuarmos a mante-lo de forma adequada aceito sugestões e/ou contrubuições de códigos na realização de testes e identificação de possíveis falhas e BUGs.

**Projeto atualizado para o PHP 7.2, utilize sempre a última versão do PHP**

## Instalação e configuração

1 - digite o comando a baixo na raiz do seu projeto pelo terminal de comandos:

composer require andersonhsilva/metodos-php

2 - para que a chamada dos métodos fiquem de forma global em todo o projeto laravel:
2.1 - edita o arquivo \config\app.conf
2.2 - adiciona no final do array  'aliases' => [] o seguinte: 'Metodos' => Andersonhsilva\MetodosPhp\Metodos::class,

**Seguindo todos esses passos, basta utilizar os diversos metodos de qualquer lugar do seu projeto.**

Execute o metodo conforme segue para nível de teste em seu projeto: Metodos::teste(); voce terá o seguinte resultado: Teste...ok.
