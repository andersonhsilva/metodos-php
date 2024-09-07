# Métodos Elaborados em PHP para Uso Diário

Este é um projeto totalmente *Open Source*. Para utilizá-lo, copiá-lo e modificá-lo você não paga absolutamente nada. No entanto, para manter o projeto de forma adequada, aceitamos sugestões e contribuições de códigos para realização de testes e identificação de possíveis falhas e bugs.

O projeto está atualizado para o PHP 8.3.10. Utilize sempre a última versão do PHP.

## Instalação e Configuração

1. Execute o comando abaixo na raiz do seu projeto pelo terminal de comandos:

    ```bash
    composer require andersonhsilva/methods-php
    ```

2. Para que a chamada dos métodos fique disponível globalmente em todo o projeto Laravel:

    2.1. Edite o arquivo `config/app.php`.

    2.2. Adicione no final do array `'aliases' => []` o seguinte:

    ```php
    'Methods' => Andersonhsilva\MethodsPhp\Methods::class,
    ```

## Relação de Métodos e Funções Disponíveis

- Converte um valor monetário para float, removendo símbolos de moeda e formatação comuns.
- Adiciona zeros à esquerda de um valor até atingir o comprimento especificado.
- Formata um valor numérico para exibição com duas casas decimais.
- Formata um valor numérico como um inteiro, removendo as casas decimais, mas preservando o valor numérico total.
- Converte um valor inteiro para um formato decimal, assumindo que os últimos dois dígitos representam os centavos.
- Aplica uma máscara a uma string.
- Formata uma data ou hora usando a máscara especificada.
- Converte uma data do formato brasileiro (dd/mm/yyyy) para o formato de banco de dados (yyyy-mm-dd).
- Adiciona um período a uma data informada e retorna a nova data no formato yyyy-mm-dd.
- Retorna o último dia do mês para um período dado no formato yyyy-mm.
- Arredonda um número para cima até o número de casas decimais especificado.
- Arredonda um número para baixo até o número de casas decimais especificado.
- Remove todos os caracteres não numéricos de uma string.
- Remove todos os caracteres que não sejam letras ou números de uma string.
- Retorna apenas o primeiro nome de uma string.
- Retorna o primeiro e o segundo nome de uma string.
- Verifica se uma palavra está contida em uma frase.
- Remove caracteres especiais de uma string, mantendo apenas letras, números e alguns caracteres acentuados.
- Gera as letras iniciais a partir de um nome para exibir em um ícone de avatar.
- Valida se um campo está vazio.
- Valida se o CPF é válido (lança um erro ou pode chamar a função diretamente).
- Valida se o CNPJ é válido (lança um erro ou pode chamar a função diretamente).
- Valida se o CPF ou CNPJ é válido (lança um erro ou pode chamar a função diretamente).
- Valida se o e-mail é válido (lança um erro ou pode chamar a função diretamente).
- Retorna a URL atual.
- Retorna uma saudação de acordo com o horário atual.
- Adiciona o nono dígito ao número de celular, se necessário.
- Calcula a diferença em anos entre duas datas.
- Calcula a diferença em meses entre duas datas.
- Calcula a diferença em dias entre duas datas.
- Gera uma lista de valores de parcelas variáveis.
- Aplica uma máscara a um valor de string.
- Retorna a data atual por extenso no formato brasileiro.
- Converte um valor numérico para sua representação monetária por extenso em português.

## Contato

**Autor:** Anderson Henrique da Silva  
**E-mail:** [anderson.h.silva@gmail.com](mailto:anderson.h.silva@gmail.com)

**Data da última atualização:** 6 de setembro de 2024
