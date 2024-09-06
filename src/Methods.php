<?php

namespace Andersonhsilva\MethodsPhp;

class Methods
{
    // ----------- TRATAMENTO DE STRING -----------

    /**
     * Converte um valor monetário para float, removendo símbolos de moeda e formatação comuns.
     * 
     * Esta função aceita um valor em formato string, remove símbolos de moeda, porcentagem e 
     * formatações (pontos e vírgulas), e o converte para um número float.
     * Se o valor já for um float, ele é retornado sem modificação.
     * Se o valor for `null`, a função retorna `null`.
     *
     * Exemplo de uso:
     * 
     * ```php
     * $value = Methods::doubleBase('R$ 2.500,00');
     * // Resultado: 2500.00
     * ```
     * 
     * @param string|null $value O valor a ser convertido, pode ser uma string formatada ou `null`.
     * 
     * @return float|null Retorna o valor convertido em float, ou `null` se o valor de entrada for `null`.
     */
    public static function doubleBase(?string $value): ?float
    {
        // Verifica se o valor é nulo e retorna imediatamente se for
        if ($value === null) return null;

        // Remove símbolos de moeda, porcentagem e formatações comuns
        $value = preg_replace('/[^\d,.-]/', '', $value);

        // Substitui a vírgula por ponto e converte para float
        return floatval(str_replace(',', '.', $value));
    }



    /**
     * Adiciona zeros à esquerda de um valor até atingir o comprimento especificado.
     * 
     * Esta função preenche uma string com zeros à esquerda até que o comprimento desejado seja atingido.
     * Se o valor já for maior ou igual ao comprimento especificado, ele é retornado sem alterações.
     * 
     * Exemplo de uso:
     * 
     * ```php
     * $value = Methods::padLeftWithZeroes('123', 6);
     * // Resultado: '000123'
     * ```
     *
     * @param string $value O valor a ser preenchido com zeros.
     * @param int $length O comprimento desejado da string final (padrão é 6).
     * 
     * @return string O valor preenchido com zeros à esquerda.
     */
    public static function padLeftWithZeroes(string $value, int $length = 6): string
    {
        return str_pad($value, $length, '0', STR_PAD_LEFT);
    }



    /**
     * Formata um valor numérico para exibição com duas casas decimais.
     * 
     * Quando o parâmetro `$money` for `true`, o valor será formatado como moeda
     * no formato Real (R$), usando vírgula como separador decimal e ponto como separador de milhar.
     * Caso contrário, o valor será formatado como um número sem o símbolo de moeda.
     * Se o valor for `null`, ele retorna `null`.
     * 
     * Exemplo de uso:
     * 
     * ```php
     * // Formato moeda:
     * $formattedValue = Methods::showDouble(2500.00);
     * // Resultado: 'R$ 2.500,00'
     * 
     * // Formato numérico:
     * $formattedValue = Methods::showDouble(2500.00, false);
     * // Resultado: '2.500,00'
     * ```
     *
     * @param float|null $value O valor a ser formatado.
     * @param bool $money Indica se o valor deve ser formatado como moeda (padrão é `true`).
     * 
     * @return string|null O valor formatado como string ou null se o valor for null.
     */
    public static function showDouble(?float $value, bool $money = true): ?string
    {
        if ($value === null) return null;

        $formattedValue = number_format($value, 2, ',', '.');

        // Se $money for true, retorna o valor como formato moeda
        return $money ? "R$ $formattedValue" : $formattedValue;
    }



    /**
     * Formata um valor numérico como um inteiro, removendo as casas decimais, mas preservando o valor numérico total.
     * 
     * Esta função converte um valor `float` para um inteiro ao formatar o valor 
     * exibido, ou seja, sem arredondar, apenas removendo as casas decimais para 
     * fins de apresentação.
     * 
     * Exemplo de uso:
     * 
     * ```php
     * $formattedValue = Methods::showDoubleAsInt(2500.75);
     * // Resultado: 2500
     * ```
     *
     * @param float $value O valor a ser formatado.
     * @return int O valor formatado como inteiro, sem arredondamento.
     */
    public static function showDoubleAsInt(float $value): int
    {
        // Remove as casas decimais sem arredondar, mantendo o valor numérico
        return (int) number_format($value, 2, '', '');
    }



    /**
     * Converte um valor inteiro para um formato decimal, assumindo que os últimos dois dígitos representam os centavos.
     *
     * Esta função assume que o valor passado é um inteiro onde os dois últimos dígitos
     * representam os centavos (por exemplo, 2500 será convertido para 25.00).
     *
     * Exemplo de uso:
     * 
     * ```php
     * $valor = Methods::showIntAsDouble(2500);
     * // Resultado: 25.00
     * ```
     *
     * @param int $value O valor inteiro a ser convertido.
     * 
     * @return float O valor convertido para decimal.
     */
    public static function showIntAsDouble(int $value): float
    {
        // Converte os dois últimos dígitos em centavos e cria um valor float
        return floatval(substr($value, 0, -2) . '.' . substr($value, -2));
    }


    /**
     * Aplica uma máscara a uma string.
     *
     * Esta função formata um valor de acordo com um padrão de máscara fornecido. O padrão de máscara usa o caractere `#` para indicar onde os dígitos do valor devem ser inseridos, e outros caracteres na máscara são incluídos como estão. 
     * É útil para formatar números de CNPJ, CPF, CEP, datas e horas com uma máscara específica.
     * 
     * Exemplo de uso:
     * 
     * ```php
     * $maskedValue = Methods::maskString('11222333000199', '##.###.###/####-##');
     * // Resultado: '11.222.333/0001-99'
     * ```
     *
     * @param string|null $value O valor a ser formatado. Se `null`, a função retornará `null`.
     * @param string $mask O padrão de máscara a ser aplicado. Deve usar `#` para representar a posição dos dígitos e outros caracteres para o formato desejado.
     * @return string|null O valor formatado de acordo com a máscara fornecida, ou `null` se o valor de entrada for `null`.
     */
    public static function maskString(?string $value, string $mask): ?string
    {
        return $value !== null ? self::mask($value, $mask) : null;
    }



    /**
     * Formata uma data ou hora usando a máscara especificada.
     *
     * Esta função formata uma data ou hora de acordo com um padrão de máscara fornecido. 
     * O padrão de máscara usa os caracteres de formato da função `date` do PHP para especificar como a data ou a hora deve ser exibida.
     * 
     * Exemplos de máscaras:
     * - `'d/m/Y'`: Formata a data como '06/09/2024'.
     * - `'H:i:s'`: Formata a hora como '14:30:15'.
     * - `'g:i A'`: Formata a hora como '2:30 PM'.
     * - `'Agora são H horas i minutos'`: Formata a hora como 'Agora são 14 horas 30 minutos'.
     * 
     * @param string|null $value A data ou hora a ser formatada. Deve ser uma string reconhecível pela função `strtotime`.
     * @param string $mask A máscara de formatação a ser usada. Deve usar os caracteres de formato da função `date`.
     * @return string|null A data ou hora formatada, ou `null` se o valor não estiver definido ou se a string de entrada não for válida.
     * 
     * ```php
     * // Formatação de data
     * $formattedDate = Methods::maskDate('2024-09-06', 'd/m/Y');
     * // Resultado: '06/09/2024'
     * 
     * // Formatação de hora
     * $formattedTime = Methods::maskDate('2024-09-06 14:30:15', 'H:i:s');
     * // Resultado: '14:30:15'
     * 
     * // Formatação de hora com AM/PM
     * $formattedTime = Methods::maskDate('2024-09-06 14:30:15', 'g:i A');
     * // Resultado: '2:30 PM'
     * 
     * // Formatação de hora com texto
     * $formattedTime = Methods::maskDate('2024-09-06 14:30:15', 'Agora são H horas i minutos');
     * // Resultado: 'Agora são 14 horas 30 minutos'
     * ```
     */
    public static function maskDate(?string $value, string $mask): ?string
    {
        return $value !== null ? date($mask, strtotime($value)) : null;
    }



    /**
     * Converte uma data do formato brasileiro (dd/mm/yyyy) para o formato de banco de dados (yyyy-mm-dd).
     *
     * Esta função recebe uma data no formato brasileiro, onde o dia vem primeiro, seguido pelo mês e ano, e a converte 
     * para o formato de banco de dados mais comum (yyyy-mm-dd), onde o ano vem primeiro, seguido pelo mês e dia.
     * 
     * @param string|null $br_date A data no formato brasileiro (dd/mm/yyyy). Se `null`, a função retorna `null`.
     * @return string|null A data convertida para o formato de banco de dados (yyyy-mm-dd), ou `null` se a entrada não estiver definida.
     * 
     * ```php
     * $dbDate = Methods::convertDateToDbFormat('06/09/2024');
     * // Resultado: '2024-09-06'
     * ```
     */
    public static function convertDateToDbFormat(?string $br_date): ?string
    {
        return $br_date !== null ? implode("-", array_reverse(explode("/", $br_date))) : null;
    }



    /**
     * Adiciona um período a uma data informada e retorna a nova data no formato yyyy-mm-dd.
     *
     * Esta função adiciona um número de unidades (dias, meses ou anos) a uma data fornecida e retorna a nova data
     * no formato `yyyy-mm-dd`. Caso ocorra algum erro durante o processo, a função retorna a data informada para seguir a aplicaçao.
     *
     * @param int $number O número de unidades a ser adicionado ao período.
     * @param string $period O período a adicionar (e.g., 'days', 'months', 'years'). Deve ser uma string válida para a função `strtotime`.
     * @param string $input_date A data informada no formato `yyyy-mm-dd`.
     * @return string A nova data no formato `yyyy-mm-dd`, ou a data informada em caso de erro.
     * 
     * ```php
     * $newDate = Methods::addPeriodToDate(1, 'months', '2024-09-06');
     * // Resultado: '2024-10-06'
     * ```
     */
    public static function addPeriodToDate(int $number, string $period, string $input_date): string
    {
        try {
            return date('Y-m-d', strtotime("$number $period", strtotime($input_date)));
        } catch (\Exception $e) {
            return $input_date;
        }
    }



    /**
     * Retorna o último dia do mês para um período dado no formato yyyy-mm.
     *
     * Esta função calcula o último dia do mês para um período fornecido no formato `yyyy-mm` e retorna a data no formato `yyyy-mm-dd`.
     * Caso ocorra algum erro durante o processo, a função retorna a data atual no formato `Y-m-d` para seguir a aplicaçao.
     *
     * @param string $periodo O período no formato `yyyy-mm`.
     * @return string O último dia do mês no formato `yyyy-mm-dd` ou a data atual em caso de erro.
     * 
     * ```php
     * $lastDay = Methods::lastDayOfMonth('2024-09');
     * // Resultado: '2024-09-30'
     * ```
     */
    public static function lastDayOfMonth(string $periodo): string
    {
        try {
            [$year, $month] = explode('-', $periodo);
            return date('Y-m-d', mktime(0, 0, 0, (int)$month + 1, 0, (int)$year));
        } catch (\Exception $e) {
            return date('Y-m-d');
        }
    }



    /**
     * Arredonda um número para cima até o número de casas decimais especificado.
     *
     * Esta função utiliza a função `ceil` para arredondar o número para cima, garantindo o número de casas decimais desejado.
     * Caso ocorra algum erro durante o processo, a função retorna o número original.
     *
     * @param float $number O número a ser arredondado.
     * @param int $precision O número de casas decimais para arredondar. O valor padrão é 2.
     * @return float O número arredondado para cima.
     * 
     * ```php
     * $rounded = Methods::RoundUp(3.14159, 2);
     * // Resultado: 3.15
     * ```
     */
    public static function RoundUp(float $number, int $precision = 2): float
    {
        try {
            $factor = (int) str_pad('1', $precision + 1, '0');
            return ceil($number * $factor) / $factor;
        } catch (\Exception $e) {
            return $number;
        }
    }



    /**
     * Arredonda um número para baixo até o número de casas decimais especificado.
     *
     * Esta função utiliza a função `floor` para arredondar o número para baixo, garantindo o número de casas decimais desejado.
     * Caso ocorra algum erro durante o processo, a função retorna o número original.
     *
     * @param float $number O número a ser arredondado.
     * @param int $precision O número de casas decimais para arredondar. O valor padrão é 2.
     * @return float O número arredondado para baixo.
     * 
     * ```php
     * $rounded = Methods::roundDown(3.14159, 2);
     * // Resultado: 3.14
     * ```
     */
    public static function roundDown(float $number, int $precision = 2): float
    {
        try {
            $factor = (int) str_pad('1', $precision + 1, '0');
            return floor($number * $factor) / $factor;
        } catch (\Exception $e) {
            return $number;
        }
    }



    /**
     * Remove todos os caracteres não numéricos de uma string.
     *
     * Esta função utiliza uma expressão regular para remover todos os caracteres da string que não sejam dígitos.
     * Se a string resultante contiver apenas dígitos, ela é retornada; caso contrário, retorna `null`.
     *
     * @param string $value A string contendo caracteres não numéricos.
     * @return string|null A string contendo apenas números ou null se a string resultante estiver vazia.
     *
     * Exemplos de uso:
     * ```php
     * $value = "R$ 1.500,00";
     * $result = Methods::onlyNumber($value); 
     * // Resultado: "150000"
     *
     * $value2 = "abc";
     * $result2 = Methods::onlyNumber($value2); 
     * // Resultado: null
     * ```
     */
    public static function onlyNumber(string $value): ?string
    {
        $result = preg_replace("/[^0-9]/", "", $value);
        return (!empty($result)) ? $result : null;
    }



    /**
     * Remove todos os caracteres que não sejam letras ou números de uma string.
     *
     * Esta função utiliza uma expressão regular para remover todos os caracteres da string que não sejam letras (maiúsculas e minúsculas) ou números.
     * Se a string resultante contiver apenas letras e números, ela é retornada; caso contrário, retorna `null`.
     *
     * @param string $value A string contendo caracteres que não são letras ou números.
     * @return string|null A string contendo apenas letras e números ou null se a string resultante estiver vazia.
     *
     * Exemplos de uso:
     * ```php
     * $value = "ABC123!@#";
     * $result = Methods::onlyLettersAndNumbers($value); 
     * // Resultado: "ABC123"
     *
     * $value2 = "!@#";
     * $result2 = Methods::onlyLettersAndNumbers($value2); 
     * // Resultado: null
     * ```
     */
    public static function onlyLettersAndNumbers(string $value): ?string
    {
        $result = preg_replace("/[^A-Za-z0-9]/", "", $value);
        return (!empty($result)) ? $result : null;
    }



    /**
     * Retorna apenas o primeiro nome de uma string.
     *
     * Esta função extrai e retorna o primeiro nome de uma string que contém um nome completo.
     * Se a string estiver vazia, retorna uma string vazia.
     *
     * @param string $value O valor contendo o nome completo.
     * @return string O primeiro nome ou uma string vazia se o valor estiver vazio.
     *
     * Exemplos de uso:
     * ```php
     * $nomeCompleto = "João da Silva";
     * $primeiroNome = Methods::onlyFirstName($nomeCompleto); 
     * // Resultado: "João"
     *
     * $nomeCompleto2 = "";
     * $primeiroNome2 = Methods::onlyFirstName($nomeCompleto2); 
     * // Resultado: ""
     * ```
     */
    public static function onlyFirstName(string $value): string
    {
        return (!empty($value)) ? explode(" ", $value)[0] : '';
    }



    /**
     * Retorna o primeiro e o segundo nome de uma string.
     *
     * Esta função extrai o primeiro e o segundo nome de uma string contendo um nome completo. Se houver apenas um nome,
     * a função retorna apenas o primeiro nome. Em caso de erro, a função também retorna apenas o primeiro nome.
     *
     * @param string $value O valor contendo o nome completo.
     * @return string O primeiro e o segundo nome ou apenas o primeiro nome se houver apenas um nome.
     *
     * Exemplos de uso:
     * ```php
     * $nomeCompleto1 = "João da Silva";
     * $nomes1 = Methods::onlyFirstAndSecondName($nomeCompleto1);
     * // Resultado: 'João da'
     *
     * $nomeCompleto2 = "Ana";
     * $nomes2 = Methods::onlyFirstAndSecondName($nomeCompleto2);
     * // Resultado: 'Ana'
     * ```
     */
    public static function onlyFirstAndSecondName(string $value): string
    {
        $valueArray = explode(" ", $value);
        $result = '';

        try {
            if (isset($valueArray[1])) {
                $result = $valueArray[0] . " " . $valueArray[1];
            } else {
                $result = $valueArray[0];
            }
        } catch (\Exception $e) {
            // Em caso de erro, apenas o primeiro nome é retornado.
            $result = $valueArray[0];
        }

        return $result;
    }



    /**
     * Verifica se uma palavra está contida em uma frase.
     *
     * Esta função busca uma palavra específica dentro de uma frase e verifica se ela está presente.
     * Retorna `true` se a palavra for encontrada na frase, ou `false` caso contrário.
     *
     * @param string $word A palavra a ser pesquisada.
     * @param string $sentence A frase onde será pesquisada a palavra.
     * @return bool Retorna true se a palavra estiver contida na frase, senão false.
     *
     * Exemplos de uso:
     * ```php
     * $frase = "O sol está brilhando no céu";
     * $palavra = "sol";
     * $existe = Methods::contains($palavra, $frase);
     * // Resultado: true
     *
     * $palavra2 = "chuva";
     * $existe2 = Methods::contains($palavra2, $frase);
     * // Resultado: false
     * ```
     */
    public static function contains(string $word, string $sentence): bool
    {
        return strpos($sentence, $word) !== false;
    }



    /**
     * Remove caracteres especiais de uma string, mantendo apenas letras, números e alguns caracteres acentuados.
     *
     * Esta função remove todos os caracteres que não sejam letras, números ou caracteres acentuados
     * comuns do português, como `á`, `ç`, `ã`, além de permitir barras e pontos.
     *
     * @param string $text O texto a ser limpo.
     * @return string O texto limpo contendo apenas letras, números e caracteres válidos.
     *
     * Exemplos de uso:
     * ```php
     * $texto = "Olá, mundo! Bem-vindo à programação. Vamos codar @2024!";
     * $textoLimpo = Methods::cleanStringChars($texto);
     * // Resultado: "Olá mundo  Bem vindo à programação  Vamos codar 2024 "
     *
     * $texto2 = "Texto com caracteres % inválidos e números: 123.";
     * $textoLimpo2 = Methods::cleanStringChars($texto2);
     * // Resultado: "Texto com caracteres  inválidos e números  123."
     * ```
     */
    public static function cleanStringChars(string $text): string
    {
        return preg_replace('/[^0-9a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ\/\.]/', ' ', $text);
    }



    /**
     * Gera as letras iniciais a partir de um nome para exibir em um icone de avatar.
     *
     * This function extracts the initials from the full name, converting them to uppercase. If the full name contains more than one name,
     * it uses the initials of the first and second names. Otherwise, it uses the initial of the first name twice.
     *
     * @param string $fullName The full name.
     * @return string The initials in uppercase.
     *
     * Example usage:
     * ```php
     * $name1 = "João da Silva";
     * $initials1 = Methods::getInitialsForAvatar($name1);
     * // Output: 'JS'
     *
     * $name2 = "Ana";
     * $initials2 = Methods::getInitialsForAvatar($name2);
     * // Output: 'AA'
     * ```
     */
    public static function getInitialsForAvatar(string $fullName): string
    {
        // Replace accented characters with their non-accented versions
        $fullName = preg_replace([
            "/(á|à|ã|â|ä)/",
            "/(Á|À|Ã|Â|Ä)/",
            "/(é|è|ê|ë)/",
            "/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/",
            "/(Í|Ì|Î|Ï)/",
            "/(ó|ò|õ|ô|ö)/",
            "/(Ó|Ò|Õ|Ô|Ö)/",
            "/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/",
            "/(ñ)/",
            "/(Ñ)/",
            "/(Ç)/",
            "/(ç)/",
            "/(Ã)/"
        ], [
            'a',
            'A',
            'e',
            'E',
            'i',
            'I',
            'o',
            'O',
            'u',
            'U',
            'n',
            'N',
            'C',
            'c',
            'A'
        ], $fullName);

        $names = explode(" ", $fullName);
        $initials = '';

        try {
            // If there are at least two names, take the initial of the first and second names
            if (isset($names[1])) {
                $initials = strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
            } else {
                // If there is only one name, take the initial twice
                $initials = strtoupper(substr($names[0], 0, 1) . substr($names[0], 0, 1));
            }
        } catch (\Exception $e) {
            // In case of error, return an empty string
            $initials = '';
        }

        return $initials;
    }



    // ----------- VALIDACOES -----------

    /**
     * Valida se um campo está vazio.
     *
     * Esta função verifica se o valor fornecido para um determinado campo está vazio. Se estiver, uma exceção é lançada com uma mensagem apropriada.
     *
     * @param string $field O nome do campo.
     * @param string $value O valor do campo.
     * @throws \Exception Se o valor do campo estiver vazio.
     *
     * Exemplo de uso:
     * ```php
     * try {
     *     Methods::validateEmpty('Usuário', '');
     * } catch (\Exception $e) {
     *     echo $e->getMessage(); // Saída: "O campo Usuário não pode ficar em branco!"
     * }
     * ```
     */
    public static function validateEmpty(string $field, string $value): void
    {
        if (empty($value)) {
            throw new \Exception("O campo " . $field . " não pode ficar em branco!");
        }
    }



    /**
     * Valida se o CPF é válido.
     *
     * Esta função verifica se o CPF fornecido é válido. Se o CPF for inválido, uma exceção é lançada com uma mensagem apropriada.
     *
     * @param string $value O CPF a ser validado.
     * @throws \Exception Se o CPF for inválido.
     *
     * Exemplo de uso:
     * ```php
     * try {
     *     Methods::validateCpf('123.456.789-00');
     * } catch (\Exception $e) {
     *     echo $e->getMessage(); // Saída: "O CPF informado está inválido!"
     * }
     * ```
     */
    public static function validateCpf(string $value): void
    {
        if (!empty($value)) {
            if (!self::isCpfValid($value)) {
                throw new \Exception("O CPF informado está inválido!");
            }
        }
    }


    /**
     * Valida se o CNPJ é válido.
     *
     * Esta função verifica se o CNPJ fornecido é válido. Se o CNPJ for inválido, uma exceção será lançada com uma mensagem apropriada.
     *
     * @param string $value O CNPJ a ser validado.
     * @throws \Exception Se o CNPJ for inválido.
     *
     * Exemplo de uso:
     * ```php
     * try {
     *     Methods::validateCnpj('12.345.678/0001-95');
     * } catch (\Exception $e) {
     *     echo $e->getMessage(); // Saída: "O CNPJ informado está inválido!"
     * }
     * ```
     */
    public static function validateCnpj(string $value): void
    {
        if (!empty($value)) {
            if (!self::isCnpjValid(self::onlyNumber($value))) {
                throw new \Exception("O CNPJ informado está inválido!");
            }
        }
    }

    /**
     * Valida se o CPF ou CNPJ é válido.
     *
     * Esta função valida automaticamente se um valor fornecido é um CPF ou CNPJ com base no seu comprimento.
     * Lança uma exceção se o CPF ou CNPJ for inválido.
     *
     * @param string|null $value O CPF ou CNPJ a ser validado. Pode ser nulo.
     * @throws \InvalidArgumentException Se o CPF ou CNPJ for inválido.
     *
     * Exemplo de uso:
     * ```php
     * try {
     *     Methods::validateCpfCnpj('12345678909'); // CPF
     *     Methods::validateCpfCnpj('12.345.678/0001-95'); // CNPJ
     * } catch (\InvalidArgumentException $e) {
     *     echo $e->getMessage(); // Saída: "O CPF informado está inválido!" ou "O CNPJ informado está inválido!"
     * }
     * ```
     */
    public static function validateCpfCnpj(?string $value): void
    {
        if (!$value && !empty($value)) {
            $length = strlen($value);

            if ($length <= 11) {
                // Validando CPF
                if (!self::isCpfValid(self::onlyNumber($value))) {
                    throw new \InvalidArgumentException("O CPF informado está inválido!");
                }
            } elseif ($length > 11) {
                // Validando CNPJ
                if (!self::isCnpjValid(self::onlyNumber($value))) {
                    throw new \InvalidArgumentException("O CNPJ informado está inválido!");
                }
            }
        }
    }



    /**
     * Valida se o e-mail é válido.
     *
     * Esta função verifica se um e-mail fornecido é válido com base no formato adequado de um endereço de e-mail.
     * Lança uma exceção se o e-mail for inválido.
     *
     * @param string $value O e-mail a ser validado.
     * @throws \Exception Se o e-mail for inválido.
     *
     * Exemplo de uso:
     * ```php
     * try {
     *     Methods::validateEmail('exemplo@dominiocom');
     * } catch (\Exception $e) {
     *     echo $e->getMessage(); // Saída: "O e-mail informado está inválido!"
     * }
     * ```
     */
    public static function validateEmail(string $value): void
    {
        if (!empty($value)) {
            if (!self::isEmailValid($value)) {
                throw new \Exception("O e-mail informado está inválido!");
            }
        }
    }



    /**
     * Retorna a URL atual.
     *
     * Esta função captura a URL completa da requisição atual, incluindo o protocolo (HTTP ou HTTPS),
     * o host (domínio) e o caminho da requisição.
     *
     * @return string A URL completa da requisição atual.
     *
     * Exemplo de uso:
     * ```php
     * $url = Methods::currentUrl();
     * echo $url; // Exemplo de saída: "https://www.exemplo.com/pagina/atual"
     * ```
     */
    public static function currentUrl(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }


    // ----------- FUNCOES -----------

    /**
     * Retorna uma saudação de acordo com o horário atual.
     *
     * Esta função gera uma saudação baseada na hora atual do dia. Se a hora for entre 6h e 12h,
     * retorna 'bom dia'. Se estiver entre 12h e 18h, retorna 'boa tarde'. Caso contrário, retorna 'boa noite'.
     *
     * @return string Saudação baseada na hora do dia: 'bom dia', 'boa tarde' ou 'boa noite'.
     *
     * Exemplo de uso:
     * ```php
     * $saudacao = Methods::greeting();
     * echo $saudacao; // Exemplo de saída: "boa tarde"
     * ```
     */
    public static function greeting(): string
    {
        $hour = date('H');
        if ($hour >= 6 && $hour <= 12) {
            return 'bom dia';
        } else if ($hour > 12 && $hour <= 18) {
            return 'boa tarde';
        } else {
            return 'boa noite';
        }
    }


    /**
     * Adiciona o nono dígito ao número de celular, se necessário.
     *
     * Esta função verifica o comprimento do número de telefone fornecido. Se o número tiver 10 dígitos 
     * e for um celular, adiciona o nono dígito (9) na posição correta. Caso o número já possua mais de 10 
     * dígitos ou não seja um celular, ele permanece inalterado.
     *
     * @param string $phone_in O número de telefone de entrada.
     * @return string O número de telefone com o nono dígito adicionado, se aplicável.
     *
     * Exemplo de uso:
     * ```php
     * $phone = "1198765432";
     * $phone_com_nono = Methods::addNinthDigit($phone);
     * echo $phone_com_nono; // Exemplo de saída: "11998765432"
     * ```
     */
    public static function addNinthDigit($phone_in): string
    {
        // Removendo espaços em branco
        $phone_in = trim($phone_in);
        $length = strlen($phone_in);
        $phone_out = '';

        // Se o número já tiver mais de 10 dígitos, retorna como está
        if ($length > 10) {
            $phone_out = $phone_in;
        }

        // Se o número tiver 10 dígitos, verifica se é celular e adiciona o nono dígito
        if ($length == 10) {
            $verificando_celular = substr($phone_in, 2, 1);
            // Verifica se é um número de celular (dígito 7, 8 ou 9 na terceira posição)
            if (in_array($verificando_celular, ["7", "8", "9"])) {
                $phone_out .= substr($phone_in, 0, 2); // DDD
                $phone_out .= "9"; // Nono dígito
                $phone_out .= substr($phone_in, 2); // Restante do número
            } else {
                $phone_out = $phone_in;
            }
        }

        // Se o número tiver menos de 10 dígitos, retorna como está
        if ($length < 10) {
            $phone_out = $phone_in;
        }

        return $phone_out;
    }


    /**
     * Calcula a diferença em anos entre duas datas.
     *
     * Esta função recebe duas datas no formato 'Y-m-d' e calcula a diferença em anos completos entre elas.
     * Se a data final for anterior à data inicial, o resultado será negativo.
     * Em caso de erro na conversão das datas ou formatação incorreta, a função retorna 0.
     *
     * @param string $startDate Data inicial no formato 'Y-m-d'.
     * @param string $endDate Data final no formato 'Y-m-d'.
     * @return int Diferença em anos entre as duas datas. Retorna 0 em caso de erro.
     *
     * Exemplo de uso:
     * ```php
     * echo Methods::differenceInYears('2000-01-01', '2023-09-06'); // Saída: 23
     * ```
     */
    public static function differenceInYears(string $start_date, string $end_date): int
    {
        try {
            $start_date = new \DateTime($start_date);
            $end_date = new \DateTime($end_date);

            // Calcula a diferença entre as datas
            $interval = $start_date->diff($end_date);

            // Calcula a diferença total em anos
            $years = $interval->y;

            // Ajusta o resultado se o mês e o dia de $end_date forem anteriores ao mês e ao dia de $start_date
            if ($end_date < $start_date->modify('first day of this month')) {
                $years--;
            }

            return $years;
        } catch (\Exception $e) {
            // Retorna 0 em caso de erro na criação das datas
            return 0;
        }
    }



    /**
     * Calcula a diferença em meses entre duas datas.
     * Esta função recebe duas datas no formato 'Y-m-d' e calcula a diferença em meses entre elas.
     * Se ocorrer um erro ao criar os objetos `DateTime`, a função retorna 0.
     *
     * @param string $startDate Data inicial no formato 'Y-m-d'.
     * @param string $endDate Data final no formato 'Y-m-d'.
     * @return int Diferença em meses entre as duas datas. Retorna 0 em caso de erro.
     *
     * Exemplo de uso:
     * ```php
     * echo Methods::differenceInMonths('2023-01-01', '2024-09-06'); // Saída: 20
     * ```
     */
    public static function differenceInMonths(string $start_date, string $end_date): int
    {
        try {
            $start_date = new \DateTime($start_date);
            $end_date = new \DateTime($end_date);

            // Calcula a diferença entre as datas
            $interval = $start_date->diff($end_date);

            // Calcula a diferença total em meses
            $months = ($interval->y * 12) + $interval->m;

            // Ajusta o resultado se o dia de $end_date for antes do dia de $start_date
            if ($end_date < $start_date->modify('first day of this month')) {
                $months--;
            }

            return $months;
        } catch (\Exception $e) {
            // Retorna 0 em caso de erro na criação das datas
            return 0;
        }
    }


    /**
     * Calcula a diferença em dias entre duas datas.
     *
     * Esta função recebe duas datas e calcula a diferença total em dias entre elas. 
     * Se ocorrer um erro ao criar os objetos `DateTime`, a função retorna 0.
     *
     * @param string $start_date A data de início no formato aceito pelo construtor `DateTime`.
     * @param string $end_date A data de término no formato aceito pelo construtor `DateTime`.
     * @return int A diferença em dias entre as duas datas. Retorna 0 em caso de erro.
     *
     * @throws \Exception Se ocorrer um erro ao criar os objetos `DateTime`.
     *
     * ```php
     * $start_date = '2023-01-01';
     * $end_date = '2024-09-06';
     * $days = differenceInDays($start_date, $end_date);
     * echo $days; // Exibe o número total de dias entre as duas datas
     * ```
     */
    public static function differenceInDays($start_date, $end_date)
    {
        try {
            $start_date = new \DateTime($start_date);
            $end_date = new \DateTime($end_date);

            // Calcula a diferença entre as datas
            $difference = $start_date->diff($end_date);

            // Retorna a diferença total em dias
            return $difference->days;
        } catch (\Exception $e) {
            // Retorna 0 em caso de erro na criação das datas
            return 0;
        }
    }



    /**
     * Gera uma lista de valores de parcelas variáveis.
     *
     * Esta função calcula uma lista de parcelas com variações aleatórias com base em um montante total,
     * uma porcentagem de variação e um número de parcelas. As parcelas variam dentro do intervalo definido 
     * pela porcentagem de variação em relação ao valor inicial das parcelas.
     *
     * @param float $amount O montante total a ser dividido em parcelas.
     * @param float $variationPct A porcentagem de variação permitida em relação ao valor da parcela.
     * @param int $installments O número total de parcelas.
     * @return array Uma lista de valores de parcelas com variação.
     *
     * ```php
     * $amount = 300;
     * $variationPct = 5;
     * $installments = 3;
     * $parcelas = YourClassName::generateVariation($amount, $variationPct, $installments);
     * // $parcelas pode ser algo como [98.25, 101.50, 100.25]
     * ```
     */
    public static function generateVariation(float $amount, float $variationPct, int $installments): array
    {
        $listaVariacoes = [];
        $totalVariacoes = 0;
        $valorParcela = $amount / $installments;
        $decimalVariacao = $variationPct / 100;
        $variacaoMin = $valorParcela * (1 - $decimalVariacao);
        $variacaoMax = $valorParcela * (1 + $decimalVariacao);

        for ($i = 0; $i < $installments - 1; $i++) {
            $variacao = $variacaoMin + ($variacaoMax - $variacaoMin) * (mt_rand() / mt_getrandmax());
            $variacao = round($variacao, 2); // Arredonda para 2 casas decimais
            $totalVariacoes += $variacao;
            $listaVariacoes[] = $variacao;
        }

        // Ajusta a última parcela para garantir que o total seja exatamente o montante fornecido
        $restante = $amount - $totalVariacoes;
        $listaVariacoes[] = round($restante, 2);

        return $listaVariacoes;
    }


    /**
     * Aplica uma máscara a um valor de string.
     *
     * Esta função formata um valor de acordo com um padrão de máscara fornecido. O padrão de máscara usa o caractere `#` para indicar onde os dígitos do valor devem ser inseridos, e outros caracteres na máscara são incluídos como estão. 
     * É útil para formatar números de CNPJ, CPF, CEP, datas e horas com uma máscara específica.
     *
     * @param string $val O valor a ser formatado. Deve ser uma string contendo apenas dígitos.
     * @param string $mask O padrão de máscara a ser aplicado. Deve usar `#` para representar a posição dos dígitos e outros caracteres para o formato desejado.
     * @return string O valor formatado de acordo com a máscara fornecida.
     *
     * // Exemplo de uso:
     * ```php
     * $cnpj = "11222333000199";
     * $cpf = "00100200300";
     * $cep = "08665110";
     * $data = "10102010";
     * $hora = "021050";
     *
     * echo mask($cnpj, '##.###.###/####-##'); 
     * // Saída: 11.222.333/0001-99
     *
     * echo mask($cpf, '###.###.###-##'); 
     * // Saída: 001.002.003-00
     *
     * echo mask($cep, '##.###-###'); 
     * // Saída: 08.665-110
     *
     * echo mask($data, '##/##/####'); 
     * // Saída: 10/10/2010
     *
     * echo mask($hora, 'Agora são ## horas ## minutos e ## segundos'); 
     * // Saída: Agora são 02 horas 10 minutos e 50 segundos
     * ```
     */
    private static function mask(string $val, string $mask): string
    {
        $maskared = '';
        if (!empty($val)) {
            $k = 0;
            for ($i = 0; $i < strlen($mask); $i++) {
                if ($mask[$i] === '#') {
                    if (isset($val[$k])) {
                        $maskared .= $val[$k++];
                    }
                } else {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }


    /**
     * Função auxiliar para validar um CPF.
     *
     * Esta função verifica se um CPF é válido, removendo caracteres não numéricos e aplicando o algoritmo de validação do CPF.
     * A validação inclui verificar o número de dígitos e calcular os dígitos verificadores.
     *
     * @param string $cpf O CPF a ser validado. Pode estar em diferentes formatos, como "000.000.000-00", "00000000000", "000 000 000 00", etc.
     * @return bool Retorna true se o CPF for válido, caso contrário, retorna false.
     *
     * ```php
     * // Exemplo de uso:
     * $cpf1 = "000.000.000-00";
     * $cpf2 = "12345678909";
     * $cpf3 = "111.111.111-11";
     *
     * echo isCpfValid($cpf1); // Saída: false (CPF inválido)
     * echo isCpfValid($cpf2); // Saída: true (CPF válido)
     * echo isCpfValid($cpf3); // Saída: false (CPF inválido)
     * ```
     */
    public static function isCpfValid(string $cpf): bool
    {
        // Etapa 1: Cria um array com apenas os dígitos numéricos
        $digits = [];
        $index = 0;
        for ($i = 0; $i < strlen($cpf); $i++) {
            if (is_numeric($cpf[$i])) {
                $digits[$index] = $cpf[$i];
                $index++;
            }
        }

        // Etapa 2: Conta os dígitos
        if (count($digits) != 11) {
            return false;
        }

        // Etapa 3: Filtra combinações inválidas como 00000000000 e 22222222222
        for ($i = 0; $i < 10; $i++) {
            if (array_fill(0, 11, $i) === $digits) {
                return false;
            }
        }

        // Etapa 4: Calcula e compara o primeiro dígito verificador
        $sum = 0;
        $factor = 10;
        for ($i = 0; $i < 9; $i++) {
            $sum += $digits[$i] * $factor;
            $factor--;
        }
        $remainder = $sum % 11;
        $firstVerifier = ($remainder < 2) ? 0 : 11 - $remainder;
        if ($firstVerifier != $digits[9]) {
            return false;
        }

        // Etapa 5: Calcula e compara o segundo dígito verificador
        $sum = 0;
        $factor = 11;
        for ($i = 0; $i < 10; $i++) {
            $sum += $digits[$i] * $factor;
            $factor--;
        }
        $remainder = $sum % 11;
        $secondVerifier = ($remainder < 2) ? 0 : 11 - $remainder;
        if ($secondVerifier != $digits[10]) {
            return false;
        }

        // Etapa 6: Retorna o resultado
        return true;
    }


    /**
     * Função auxiliar para validar um endereço de e-mail.
     *
     * Esta função verifica se um e-mail está no formato correto utilizando uma expressão regular.
     * O e-mail deve seguir o padrão geral de endereços de e-mail válidos (nome de usuário seguido por "@" e domínio).
     *
     * @param string $email O endereço de e-mail a ser validado.
     * @return bool Retorna true se o e-mail for válido, caso contrário, retorna false.
     *
     * ```php
     * // Exemplo de uso:
     * $email1 = "example@example.com";
     * $email2 = "invalid-email@";
     * $email3 = "user@domain.co";
     * $email4 = "user@domain.toolong";
     *
     * echo isEmailValid($email1); // Saída: true (E-mail válido)
     * echo isEmailValid($email2); // Saída: false (E-mail inválido)
     * echo isEmailValid($email3); // Saída: true (E-mail válido)
     * echo isEmailValid($email4); // Saída: false (E-mail inválido)
     * ```
     */
    public static function isEmailValid(string $email): bool
    {
        // Define a expressão regular para validação do e-mail
        $pattern = "/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\.[A-Za-z0-9]{2,4}$/";

        // Retorna true se o e-mail corresponder ao padrão, caso contrário, retorna false
        return preg_match($pattern, $email) === 1;
    }



    /**
     * Função auxiliar para validar um número de CNPJ.
     *
     * A função verifica se o CNPJ informado é válido ao seguir as seguintes etapas:
     * - Remove caracteres não numéricos.
     * - Verifica se possui 14 dígitos.
     * - Exclui números repetidos como "00000000000000".
     * - Calcula e compara os dois dígitos verificadores do CNPJ.
     *
     * @param string $cnpj O número do CNPJ, podendo ser passado em diferentes formatos (com pontos, barras ou sem formatação).
     *
     * @return bool Retorna true se o CNPJ for válido, ou false caso contrário.
     *
     * ```php
     * // Exemplo de uso:
     * $cnpj1 = "12.345.678/0001-95";
     * $cnpj2 = "12345678000195";
     * $cnpj3 = "00.000.000/0000-00";
     * $cnpj4 = "12345678000196";
     *
     * echo isCnpjValid($cnpj1); // Saída: true (CNPJ válido)
     * echo isCnpjValid($cnpj2); // Saída: true (CNPJ válido)
     * echo isCnpjValid($cnpj3); // Saída: false (CNPJ inválido)
     * echo isCnpjValid($cnpj4); // Saída: false (CNPJ inválido)
     * ```
     */
    public static function isCnpjValid(string $cnpj): bool
    {
        // Etapa 1: Remove caracteres não numéricos
        $digits = [];
        for ($i = 0; $i < strlen($cnpj); $i++) {
            if (is_numeric($cnpj[$i])) {
                $digits[] = $cnpj[$i];
            }
        }

        // Etapa 2: Verifica se possui 14 dígitos
        if (count($digits) !== 14) {
            return false;
        }

        // Etapa 3: Exclui números repetidos
        if (count(array_unique($digits)) === 1) {
            return false;
        }

        // Etapa 4: Calcula e compara o primeiro dígito verificador
        $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += $digits[$i] * $weights[$i];
        }
        $remainder = $sum % 11;
        $firstVerifier = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($firstVerifier !== (int)$digits[12]) {
            return false;
        }

        // Etapa 5: Calcula e compara o segundo dígito verificador
        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += $digits[$i] * $weights[$i];
        }
        $remainder = $sum % 11;
        $secondVerifier = ($remainder < 2) ? 0 : 11 - $remainder;

        return $secondVerifier === (int)$digits[13];
    }


    /**
     * Redimensiona uma imagem mantendo a proporção e gera uma miniatura (thumbnail).
     *
     * Esta função ajusta a largura e a altura de uma imagem para criar uma miniatura, mantendo a proporção original da imagem. 
     * A nova imagem é salva no caminho especificado com a qualidade fornecida.
     *
     * @param int    $new_width  A nova largura da miniatura em pixels.
     * @param int    $new_height A nova altura da miniatura em pixels.
     * @param string $source_file O caminho completo da imagem original (deve ser um arquivo JPEG).
     * @param string $dst_file    O caminho completo para salvar a nova imagem (deve ser um arquivo JPEG).
     * @param int    $quality     A qualidade da nova imagem em porcentagem (0 a 100, padrão: 60).
     *
     * @return void
     *
     * @throws InvalidArgumentException Se o arquivo original não for encontrado ou não for uma imagem JPEG.
     * @throws RuntimeException Se a criação da nova imagem ou a cópia da imagem falhar.
     *
     * ```php
     * // Exemplo de uso:
     * $source = 'path/to/original/image.jpg';
     * $destination = 'path/to/thumbnail/image.jpg';
     * image_thumbnail(150, 150, $source, $destination, 75);
     * ```
     */
    public function image_thumbnail(int $new_width, int $new_height, string $source_file, string $dst_file, int $quality = 60): void
    {

        // captura a imagem e as dimensoes da mesma
        $imgsize = getimagesize($source_file);
        list($old_width, $old_height) = $imgsize;

        // calculando a proporção da imagem
        $ratio = ($old_width / $old_height);
        if ($new_width / $new_height > $ratio) {
            $new_width = ($new_height * $ratio);
        } else {
            $new_height = ($new_width / $ratio);
        }

        // define o path das imagens
        $new_image = imagecreatetruecolor($new_width, $new_height);
        $old_image = imagecreatefromjpeg($source_file);

        // cortar a imagem eixos X e Y
        imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

        // gera a nova imagem
        imagejpeg($new_image, $dst_file, $quality);

        // apaga da memoria as imagens criadas
        imagedestroy($old_image);
        imagedestroy($new_image);
    }

    /**
     * Converte uma cor hexadecimal para o formato RGB.
     *
     * Esta função converte uma cor hexadecimal para o formato RGB. Pode aceitar valores hexadecimais com ou sem o caractere '#'. 
     * Também pode incluir um valor de transparência se especificado.
     *
     * @param string  $hex   O valor hexadecimal da cor (com ou sem '#').
     * @param bool    $alpha Indica se a cor deve incluir valor de transparência (padrão: false).
     *
     * @return string Retorna a cor em formato RGB (por exemplo, "255,255,255") ou a entrada original se não for hexadecimal.
     *
     * ```php
     * // Exemplo de uso:
     * $hexColor = '#FF5733';
     * $rgbColor = convertHexToRgb($hexColor);
     * echo $rgbColor; // Saída: "255,87,51"
     *
     * $hexColorWithAlpha = '#FF5733';
     * $rgbColorWithAlpha = convertHexToRgb($hexColorWithAlpha, 0.5);
     * echo $rgbColorWithAlpha; // Saída: "255,87,51,0.5"
     * ```
     */
    public static function convertHexToRgb(string $hex, bool $alpha = false): string
    {
        // Remove o caractere '#' se estiver presente
        if (substr($hex, 0, 1) === '#') {
            $hex = substr($hex, 1);
        }

        // Verifica o comprimento do valor hexadecimal e faz o processamento adequado
        $length = strlen($hex);
        $r = $g = $b = 0;

        if ($length === 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } elseif ($length === 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        }

        // Converte para o formato RGB
        $rgb = "{$r},{$g},{$b}";

        // Adiciona valor de transparência se solicitado
        if ($alpha) {
            $rgb .= ",{$alpha}";
        }

        return $rgb;
    }


    /**
     * Converte uma cor no formato RGB para hexadecimal.
     *
     * Esta função converte uma cor especificada em formato RGB (por exemplo, "255,255,255") para o formato hexadecimal.
     *
     * @param string $rgb A cor em formato RGB (ex: "255,255,255").
     *
     * @return string Retorna a cor em formato hexadecimal (ex: "#ffffff").
     *
     * ```php
     * // Exemplo de uso:
     * $rgbColor = "255,87,51";
     * $hexColor = convertRgbToHex($rgbColor);
     * echo $hexColor; // Saída: "#ff5733"
     * ```
     */
    public static function convertRgbToHex(string $rgb): string
    {
        $color = explode(',', $rgb);
        return sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
    }


    /**
     * Sanitiza uma string, removendo caracteres especiais e substituindo por equivalentes.
     *
     * Esta função substitui caracteres especiais acentuados e outros símbolos por caracteres alfanuméricos equivalentes. 
     * Isso é útil para normalizar strings para uso em URLs ou identificadores.
     *
     * @param string $string A string a ser sanitizada.
     * @return string A string sanitizada.
     * @throws \Exception Se ocorrer um erro durante a sanitização.
     *
     * ```php
     * // Exemplo de uso:
     * $inputString = "Olá, mundo! Como vai você?";
     * $sanitizedString = sanitizeString($inputString);
     * echo $sanitizedString; // Saída: "Ola_mundo_Como_vai_voce_"
     * ```
     */
    public static function sanitizeString(string $string): string
    {
        // matriz de entrada
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');
        // matriz de saída
        $by   = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');
        // devolver a string
        return str_replace($what, $by, $string);
    }



    /**
     * Retorna a data atual por extenso no formato brasileiro.
     *
     * Esta função utiliza o `IntlDateFormatter` para formatar a data atual de acordo com o formato 
     * brasileiro, retornando a data no estilo "Dia, dd de Mês de yyyy".
     *
     * @return string A data atual formatada como "Dia, dd de Mês de yyyy".
     *
     * ```php
     * // Exemplo de uso:
     * echo getFullDateInBrazilianFormat(); 
     * // Saída esperada: "domingo, 10 de setembro de 2023" (dependendo da data atual)
     * ```
     */
    public static function getFullDateInBrazilianFormat(): string
    {
        date_default_timezone_set('America/Recife');
        $date = new \DateTime();

        $formatter = new \IntlDateFormatter(
            'pt_BR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            'America/Recife',
            \IntlDateFormatter::GREGORIAN,
            'eeee, dd \'de\' MMMM \'de\' yyyy'
        );

        return trim($formatter->format($date));
    }


    /**
     * Converte um valor numérico para sua representação monetária por extenso em português.
     *
     * Esta função transforma um valor numérico em uma string com sua representação por extenso, 
     * seguindo o formato monetário em português. O resultado pode ser retornado em maiúsculas, 
     * minúsculas ou com a primeira letra de cada palavra em maiúscula, dependendo do parâmetro 
     * `$uppercase`.
     *
     * @param float $value O valor numérico a ser convertido.
     * @param int $uppercase Define se o resultado deve ser em maiúsculas. 
     *                       0 para minúsculas, 1 para maiúsculas e 2 para maiúsculas em todas as palavras.
     * @return string A representação por extenso do valor.
     *
     * ```php
     * // Exemplo de uso:
     * echo numberInWords(1234.56); 
     * // Saída esperada: "um mil duzentos e trinta e quatro reais e cinquenta e seis centavos"
     * ```
     */
    public static function numberInWords(float $value): string
    {
        // Verifica se o valor está no formato brasileiro e o converte para o formato aceito pela função number_format
        if (strpos($value, ",") !== false) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
        }

        $singularUnits = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
        $pluralUnits = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];

        $hundreds = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
        $tens = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
        $teens = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];
        $units = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];

        $zeroCount = 0;

        // Formata o valor para garantir que tenha duas casas decimais
        $value = number_format($value, 2, ".", ".");
        $integer = explode(".", $value);
        $cont = count($integer);
        for ($i = 0; $i < $cont; $i++) {
            for ($ii = strlen($integer[$i]); $ii < 3; $ii++) {
                $integer[$i] = "0" . $integer[$i];
            }
        }

        $end = $cont - ($integer[$cont - 1] > 0 ? 1 : 2);
        $resultText = '';
        for ($i = 0; $i < $cont; $i++) {
            $value = $integer[$i];
            $rc = (($value > 100) && ($value < 200)) ? "cento" : $hundreds[$value[0]];
            $rd = ($value[1] < 2) ? "" : $tens[$value[1]];
            $ru = ($value > 0) ? (($value[1] == 1) ? $teens[$value[2]] : $units[$value[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($value > 1 ? $pluralUnits[$t] : $singularUnits[$t]) : "";
            if ($value == "000") {
                $zeroCount++;
            } elseif ($zeroCount > 0) {
                $zeroCount--;
            }
            if (($t == 1) && ($zeroCount > 0) && ($integer[0] > 0)) {
                $r .= (($zeroCount > 1) ? " de " : "") . $pluralUnits[$t];
            }
            if ($r) {
                $resultText = $resultText . ((($i > 0) && ($i <= $end) && ($integer[0] > 0) && ($zeroCount < 1)) ? (($i < $end) ? ", " : " e ") : " ") . $r;
            }
        }

        return trim($resultText ? $resultText : "zero");
    }
}
