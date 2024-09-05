<?php

namespace Andersonhsilva\MetodosPhp;

class Metodos
{

    public static function teste()
    {
        echo 'Teste...ok ';
    }

    // -------------------tratamento de strings-----------------------------------

    /**
     * Converte um valor para float, removendo símbolos de moeda e formatação comuns.
     *
     * Esta função aceita um valor, remove símbolos de moeda e caracteres de formatação comuns,
     * e o converte para um float. Se o valor já for um float, ele é retornado como está.
     * Se o valor for `null`, a função retorna `null`.
     *
     * @param mixed $value O valor a ser convertido. Pode ser uma string ou um float.
     * 
     * @return float|null Retorna o valor convertido em float, ou `null` se o valor de entrada for `null`.
     */
    public static function doubleBase($value)
    {
        if ($value !== null) {
            if (!is_float($value)) {
                $value = str_replace(array("R$ ", "%", "."), "", $value);
                $value = floatval(str_replace(",", ".", $value));
            }
        }
        return $value ?? null;
    }

    /**
     * Adiciona zeros à esquerda de um valor até atingir o comprimento especificado.
     *
     * @param string $value O valor a ser preenchido com zeros.
     * @param int $length O comprimento desejado da string final.
     * @return string O valor preenchido com zeros à esquerda.
     */
    public static function padLeftWithZeroes($value, $length = 6)
    {
        return str_pad($value, $length, '0', STR_PAD_LEFT);
    }

    /**
     * Formata um valor numérico para exibição com duas casas decimais, usando vírgula como separador decimal e ponto como separador de milhar.
     *
     * @param float|null $value O valor a ser formatado.
     * @return string|null O valor formatado como string ou null se o valor for null.
     */
    public static function showDouble($value)
    {
        return $value === null ? null : number_format($value, 2, ',', '.');
    }

    /**
     * Formata um valor numérico como um inteiro, removendo as casas decimais.
     *
     * @param float $value O valor a ser formatado.
     * @return int O valor formatado como inteiro.
     */
    public static function showDoubleAsInt($value)
    {
        return (int) number_format($value, 2, '', '');
    }

    /**
     * Converte um valor inteiro para um formato decimal, assumindo que os últimos dois dígitos representam os centavos.
     *
     * @param int $value O valor inteiro a ser convertido.
     * @return float O valor convertido para decimal.
     */
    public static function showIntAsDouble($value)
    {
        return floatval(substr($value, 0, -2) . '.' . substr($value, -2));
    }

    /**
     * Aplica uma máscara a uma string.
     *
     * @param string|null $value O valor a ser maskdo.
     * @param string $mask A máscara a ser aplicada.
     * @return string|null O valor maskdo ou null se o valor não estiver definido.
     */
    public static function maskString($value, $mask)
    {
        return (isset($value)) ? self::mask($value, $mask) : null;
    }

    /**
     * Formata uma data usando a máscara especificada.
     *
     * @param string|null $value A data a ser formatada.
     * @param string $mask A máscara de data a ser usada.
     * @return string|null A data formatada ou null se o valor não estiver definido.
     */
    public static function maskDate($value, $mask)
    {
        $result = (isset($value)) ? date($mask, strtotime($value)) : null;
        return $result;
    }

    /**
     * Converte uma data do formato brasileiro (dd/mm/yyyy) para o formato de banco de dados (yyyy-mm-dd).
     *
     * @param string|null $br_date A data no formato brasileiro (dd/mm/yyyy).
     * @return string|null A data no formato de banco de dados (yyyy-mm-dd) ou null se a entrada não estiver definida.
     */
    public static function convertDateToDbFormat($br_date)
    {
        $result = (isset($br_date)) ? implode("-", array_reverse(explode("/", $br_date))) : null;
        return $result;
    }

    /**
     * Adiciona um período a uma data informada e retorna a nova data no formato yyyy-mm-dd.
     *
     * @param int $number O número a ser adicionado ao período.
     * @param string $period O período a adicionar (e.g., 'days', 'months', 'years').
     * @param string $input_date A data informada no formato yyyy-mm-dd.
     * @return string A nova data no formato yyyy-mm-dd ou a data informada em caso de erro.
     */
    public static function addPeriodToDate($number, $period, $input_date)
    {
        try {
            return date('Y-m-d', strtotime($number . ' ' . $period, strtotime($input_date)));
        } catch (\Exception $e) {
            return $input_date;
        }
    }

    /**
     * Retorna o último dia do mês para um período dado no formato yyyy-mm.
     *
     * @param string $periodo O período no formato yyyy-mm.
     * @return string O último dia do mês em formato de data.
     */
    public static function lastDayOfMonth($periodo)
    {
        try {
            return date("t", mktime(0, 0, 0, explode('-', $periodo)[1], '01', explode('-', $periodo)[0]));
        } catch (\Exception $e) {
            return date('Y-m-d');
        }
    }

    /**
     * Arredonda um número para cima até o número de casas decimais especificado.
     *
     * @param float $number O número a ser arredondado.
     * @param int $precision O número de casas decimais para arredondar.
     * @return float O número arredondado para cima.
     */
    public static function RoundUp($number, $precision = 2)
    {
        try {
            $fig = (int) str_pad('1', ($precision + 1), '0');
            return (ceil($number * $fig) / $fig);
        } catch (\Exception $e) {
            return $number;
        }
    }

    /**
     * Arredonda um número para baixo até o número de casas decimais especificado.
     *
     * @param float $number O número a ser arredondado.
     * @param int $precision O número de casas decimais para arredondar.
     * @return float O número arredondado para baixo.
     */
    public static function roundDown($number, $precision = 2)
    {
        try {
            $fig = (int) str_pad('1', ($precision + 1), '0');
            return (floor($number * $fig) / $fig);
        } catch (\Exception $e) {
            return $number;
        }
    }

    /**
     * Remove todos os caracteres não numéricos de uma string.
     *
     * @param string $value A string contendo caracteres não numéricos.
     * @return string|null A string contendo apenas números ou null se a string resultante estiver vazia.
     */
    public static function onlyNumber($value)
    {
        $result = preg_replace("/[^0-9]/", "", $value);
        return (!empty($result)) ? $result : null;
    }

    /**
     * Remove todos os caracteres que não sejam letras ou números de uma string.
     *
     * @param string $value A string contendo caracteres que não são letras ou números.
     * @return string|null A string contendo apenas letras e números ou null se a string resultante estiver vazia.
     */
    public static function onlyLettersAndNumbers($value)
    {
        $result = preg_replace("/[^A-Za-z0-9]/", "", $value);
        return (!empty($result)) ? $result : null;
    }

    /**
     * Converte todas as letras da string para minúsculas.
     *
     * @param string $value O valor a ser convertido.
     * @return string|null A string em letras minúsculas ou null se estiver vazia.
     */
    public static function lowerLetters($value)
    {
        return (!empty($value)) ? strtolower($value) : null;
    }

    /**
     * Converte todas as letras da string para maiúsculas.
     *
     * @param string $value O valor a ser convertido.
     * @return string|null A string em letras maiúsculas ou null se estiver vazia.
     */
    public static function upperLetters($value)
    {
        return (!empty($value)) ? strtoupper($value) : null;
    }

    /**
     * Converte apenas a primeira letra da string para maiúscula.
     *
     * @param string $value O valor a ser convertido.
     * @return string|null A string com a primeira letra em maiúscula ou null se estiver vazia.
     */
    public static function upperFirstLetterOnly($value)
    {
        return (!empty($value)) ? ucfirst($value) : null;
    }

    /**
     * Converte a primeira letra de cada palavra da string para maiúscula.
     *
     * @param string $value O valor a ser convertido.
     * @return string|null A string com a primeira letra de cada palavra em maiúscula ou null se estiver vazia.
     */
    public static function firstLettersOfWords($value)
    {
        return (!empty($value)) ? ucwords($value) : null;
    }

    /**
     * Retorna apenas o primeiro nome de uma string.
     *
     * @param string $value O valor contendo o nome completo.
     * @return string O primeiro nome ou uma string vazia se o valor estiver vazio.
     */
    public static function onlyFirstName($value)
    {
        return (!empty($value)) ? explode(" ", $value)[0] : '';
    }

    /**
     * Verifica se uma palavra está contida em uma frase.
     *
     * @param string $word A palavra a ser pesquisada.
     * @param string $sentence A frase onde será pesquisada a palavra.
     * @return bool Retorna true se a palavra estiver contida na frase, senão false.
     */
    public static function contains($word, $sentence)
    {
        return strpos($sentence, $word) !== false;
    }

    /**
     * Remove caracteres especiais de uma string, mantendo apenas letras, números, e alguns caracteres acentuados.
     *
     * @param string $text O texto a ser limpo.
     * @return string O texto limpo contendo apenas letras, números e caracteres válidos.
     */
    public static function cleanStringChars($text)
    {
        return preg_replace('/[^0-9a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ\/\.]/', ' ', $text);
    }

    /**
     * Retorna o primeiro e o segundo nome de uma string.
     *
     * @param string $value O valor contendo o nome completo.
     * @return string O primeiro e segundo nome ou apenas o primeiro nome em caso de erro.
     */
    public static function onlyFirstAndSecondName($value)
    {
        $value = explode(" ", $value);
        $result = '';
        try {
            $result = $value[0] . " " . $value[1];
        } catch (\Exception $e) {
            $result =  $value[0];
        } finally {
            return $result;
        }
    }

    /**
     * Gera as iniciais do nome para usar em um avatar.
     *
     * @param string $name O nome completo.
     * @return string As iniciais em letras maiúsculas.
     */
    public static function iniciais_para_avatar($name)
    {
        $value = explode(" ", preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(Ç)/", "/(ç)/", "/(Ã)/"), explode(" ", "a A e E i I o O u U n N C c A"), $name));
        $result = '';
        try {
            $result = strtoupper(substr($value[0], 0, 1) . substr($value[1], 0, 1));
        } catch (\Exception $e) {
            $result = strtoupper(substr($value[0], 0, 2));
        } finally {
            return $result;
        }
    }

    // -------------------validações----------------------------------------------

    /**
     * Valida se um campo está vazio.
     *
     * @param string $field O nome do campo.
     * @param string $value O valor do campo.
     * @throws \Exception Se o campo estiver vazio.
     */
    public static function validar_vazio($field, $value)
    {
        if (empty($value)) {
            throw new \Exception("O campo " . $field . " não pode ficar em branco!");
        }
    }

    /**
     * Valida se o CPF é válido.
     *
     * @param string $value O CPF a ser validado.
     * @throws \Exception Se o CPF for inválido.
     */
    public static function validar_cpf($value)
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
     * @param string $value O CNPJ a ser validado.
     * @throws \Exception Se o CNPJ for inválido.
     */
    public static function validar_cnpj($value)
    {
        if (!empty($value)) {
            if (!self::isCnpjValid($value)) {
                throw new \Exception("O CNPJ informado está inválido!");
            }
        }
    }

    /**
     * Valida se o CPF ou CNPJ é válido.
     *
     * @param string $value O CPF ou CNPJ a ser validado.
     * @throws \Exception Se o CPF ou CNPJ for inválido.
     */
    public static function validar_cpf_cnpj($value)
    {
        if ($value != null && !empty($value)) {
            if (strlen($value) <= 11) {
                if (!self::isCpfValid($value)) {
                    throw new \Exception("O CPF informado está inválido!");
                }
            } else {
                if (!self::isCnpjValid($value)) {
                    throw new \Exception("O CNPJ informado está inválido!");
                }
            }
        }
    }

    /**
     * Valida se o e-mail é válido.
     *
     * @param string $value O e-mail a ser validado.
     * @throws \Exception Se o e-mail for inválido.
     */
    public static function validateEmail($value)
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
     * @return string A URL completa da requisição atual.
     */
    public static function currentUrl()
    {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    // ----------------------------------------------F U N C O E S---------------------------------------------

    /**
     * Retorna uma saudação de acordo com o horário atual.
     *
     * @return string Saudação baseada na hora do dia: 'bom dia', 'boa tarde' ou 'boa noite'.
     */
    public static function greeting()
    {
        $hour = date('H');
        if ($hour >= 6 && $hour <= 12)
            return 'bom dia';
        else if ($hour > 12 && $hour <= 18)
            return 'boa tarde';
        else
            return 'boa noite';
    }

    /**
     * Adiciona o nono dígito ao número de celular, se necessário.
     *
     * @param string $phone_in O número de telefone de entrada.
     * @return string O número de telefone com o nono dígito adicionado, se aplicável.
     */
    public static function addNinthDigit($phone_in)
    {

        // retirando espaços
        $phone_in = trim($phone_in);
        $length = strlen($phone_in);
        $phone_out = '';

        // se maior não faz nada
        if ($length  > '10') {
            $phone_out = $phone_in;
        }

        // se igual adiciona o nono digito caso o numero seja um celular
        if ($length == '10') {
            $verificando_celular = substr($phone_in, 2, 1);
            // verifica se é um numero de celular
            if (in_array($verificando_celular, array("9", "8", "7"))) {
                $phone_out .= substr($phone_in, 0, 2);
                $phone_out .= "9"; // nono digito
                $phone_out .= substr($phone_in, 2);
            } else {
                $phone_out = $phone_in;
            }
        }

        // se menor não faz nada
        if ($length < '10') {
            $phone_out = $phone_in;
        }

        return $phone_out;
    }

    /**
     * Calcula a diferença em anos entre duas datas.
     * Esta função recebe duas datas e calcula a diferença em anos entre elas. 
     * Se ocorrer um erro ao criar os objetos `DateTime`, a função retorna 0.
     *
     * Esta função calcula a diferença em anos entre uma data inicial e uma data final,
     * levando em consideração o número de anos completos entre as duas datas.
     * Se a data final for anterior à data inicial, o resultado será negativo.
     * Em caso de erro na conversão das datas, a função retorna 0.
     *
     * @param string $start_date Data inicial no formato 'Y-m-d'.
     * @param string $end_date Data final no formato 'Y-m-d'.
     * @return int Diferença em anos entre as duas datas. Retorna 0 em caso de erro.
     * @throws \Exception Se a conversão de data falhar.
     */
    public static function differenceInYears($start_date, $end_date)
    {
        try {
            $start_date = new \DateTime($start_date);
            $difference = $start_date->diff(new \DateTime($end_date));
            $result = (int) $difference->format('%y');
            return $result;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Calcula a diferença em meses entre duas datas.
     * Esta função recebe duas datas e calcula a diferença em meses entre elas. 
     * Se ocorrer um erro ao criar os objetos `DateTime`, a função retorna 0.
     *
     * @param string $start_date Data inicial no formato 'Y-m-d'.
     * @param string $end_date Data final no formato 'Y-m-d'.
     * @return int Diferença em meses entre as duas datas. Retorna 0 em caso de erro.
     * @throws \Exception Se a conversão de data falhar.
     */
    public static function differenceInMonths($start_date, $end_date)
    {
        try {
            $start_date = new \DateTime($start_date);
            $difference = $start_date->diff(new \DateTime($end_date));
            $result = (int) $difference->format('%m');
            return $result;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Calcula a diferença em dias entre duas datas.
     *
     * Esta função recebe duas datas e calcula a diferença em dias entre elas. 
     * Se ocorrer um erro ao criar os objetos `DateTime`, a função retorna 0.
     *
     * @param string $start_date A data de início no formato aceito pelo construtor `DateTime`.
     * @param string $end_date A data de término no formato aceito pelo construtor `DateTime`.
     * @return int A diferença em dias entre as duas datas. Retorna 0 em caso de erro.
     *
     * @throws \Exception Se ocorrer um erro ao criar os objetos `DateTime`.
     */
    public static function differenceInDays($start_date, $end_date)
    {
        try {
            $start_date = new \DateTime($start_date);
            $difference = $start_date->diff(new \DateTime($end_date));
            $result = (int) $difference->format('%d');
            return $result;
        } catch (\Exception $e) {
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
     * @example
     * // Exemplo de uso:
     * $amount = 300;
     * $variationPct = 5;
     * $installments = 3;
     * $parcelas = generateVariation($amount, $variationPct, $installments);
     * // $parcelas pode ser algo como [95.00, 103.00, 102.00]
     */
    public static function generateVariation($amount, $variationPct, $installments)
    {

        // array com todas as parcelas variadas
        $listaVariacoes = array();

        // variaveis de inicio
        $totalVariacoes = 0;
        $valorParcela = ($amount / $installments);
        $decimalVariacao = ($variationPct / 100);
        $variacaoMin = ($valorParcela - ($valorParcela * $decimalVariacao));
        $variacaoMax = ($valorParcela + ($valorParcela * $decimalVariacao));

        // gera as variações com base nos valores minimo = (valor parcela - variacao) e o valor maximo = valor parcela
        for ($i = 1; $i < $installments; $i++) {
            // variação em floatval diferente do rand que só aceita intervalos int
            $variacao = number_format(($variacaoMin + ($variacaoMax - $variacaoMin) * (mt_rand() / mt_getrandmax())), 2, '.', '');
            $totalVariacoes += floatval($variacao);
            array_push($listaVariacoes, floatval($variacao));
        }

        // pega o restante final do que sobrou das variações para completar o valor do periodo
        $restoVariacao = ($amount - $totalVariacoes);
        array_push($listaVariacoes, $restoVariacao);

        return $listaVariacoes;
    }

    /**
     * Aplica uma máscara a um valor.
     *
     * Esta função formata um valor de acordo com um padrão de máscara fornecido. O padrão de máscara usa o caractere `#` para indicar onde os dígitos do valor devem ser inseridos, e outros caracteres na máscara são incluídos como estão. 
     * É útil para formatar números de CNPJ, CPF, CEP, datas e horas com uma máscara específica.
     *
     * @param string $val O valor a ser formatado. Deve ser uma string contendo apenas dígitos.
     * @param string $mask O padrão de máscara a ser aplicado. Deve usar `#` para representar a posição dos dígitos e outros caracteres para o formato desejado.
     * @return string O valor formatado de acordo com a máscara fornecida.
     *
     * @example
     * // Exemplo de uso:
     * $cnpj = "11222333000199";
     * $cpf = "00100200300";
     * $cep = "08665110";
     * $data = "10102010";
     * $hora = "021050";
     *
     * echo mask($cnpj, '##.###.###/####-##'); // Saída: 11.222.333/0001-99
     * echo mask($cpf, '###.###.###-##'); // Saída: 001.002.003-00
     * echo mask($cep, '#####-###'); // Saída: 08665-110
     * echo mask($data, '##/##/####'); // Saída: 10/10/2010
     * echo mask($hora, 'Agora são ## horas ## minutos e ## segundos'); // Saída: Agora são 02 horas 10 minutos e 50 segundos
     */
    private static function mask($val, $mask)
    {
        $maskared = '';
        if (!empty($val)) {
            $k = 0;
            for ($i = 0; $i <= strlen($mask) - 1; $i++) {
                if ($mask[$i] == '#') {
                    if (isset($val[$k]))
                        $maskared .= $val[$k++];
                } else {
                    if (isset($mask[$i]))
                        $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }

   /**
     * Valida um CPF.
     *
     * Esta função verifica se um CPF é válido, removendo caracteres não numéricos e aplicando o algoritmo de validação do CPF.
     * A validação inclui verificar o número de dígitos e calcular os dígitos verificadores.
     *
     * @param string $cpf O CPF a ser validado. Pode estar em diferentes formatos, como "000.000.000-00", "00000000000", "000 000 000 00", etc.
     * @return bool Retorna true se o CPF for válido, caso contrário, retorna false.
     */
    private static function isCpfValid($cpf)
    {
        //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cpf em diferentes formatos como "000.000.000-00", "00000000000", "000 000 000 00" etc...
        $j = 0;
        for ($i = 0; $i < (strlen($cpf)); $i++) {
            if (is_numeric($cpf[$i])) {
                $num[$j] = $cpf[$i];
                $j++;
            }
        }
        //Etapa 2: Conta os dígitos, um cpf válido possui 11 dígitos numéricos.
        if (count($num) != 11) {
            $isCpfValid = false;
        }
        //Etapa 3: Combinações como 00000000000 e 22222222222 embora não sejam cpfs reais resultariam em cpfs válidos após o calculo dos dígitos verificares e por isso precisam ser filtradas nesta parte.
        else {
            for ($i = 0; $i < 10; $i++) {
                if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i) {
                    $isCpfValid = false;
                    break;
                }
            }
        }
        //Etapa 4: Calcula e compara o primeiro dígito verificador.
        if (!isset($isCpfValid)) {
            $j = 10;
            for ($i = 0; $i < 9; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($dg != $num[9]) {
                $isCpfValid = false;
            }
        }
        //Etapa 5: Calcula e compara o segundo dígito verificador.
        if (!isset($isCpfValid)) {
            $j = 11;
            for ($i = 0; $i < 10; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($dg != $num[10]) {
                $isCpfValid = false;
            } else {
                $isCpfValid = true;
            }
        }

        //Etapa 6: Retorna o Resultado em um valor booleano.
        return $isCpfValid;
    }

    /**
     * Valida um endereço de e-mail.
     *
     * Esta função verifica se um e-mail está no formato correto utilizando uma expressão regular.
     * O e-mail deve seguir o padrão geral de endereços de e-mail válidos.
     *
     * @param string $email O endereço de e-mail a ser validado.
     * @return bool Retorna true se o e-mail for válido, caso contrário, retorna false.
     */
    private static function isEmailValid($email)
    {
        $result = true;
        if (!preg_match("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email)) {
            $result = false;
        }
        return $result;
    }

    /**
     * Valida um número de CNPJ (Cadastro Nacional da Pessoa Jurídica).
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
     */
    private static function isCnpjValid($cnpj)
    {
        //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
        $j = 0;
        for ($i = 0; $i < (strlen($cnpj)); $i++) {
            if (is_numeric($cnpj[$i])) {
                $num[$j] = $cnpj[$i];
                $j++;
            }
        }
        //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
        if (count($num) != 14) {
            $isCnpjValid = false;
        }
        //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
        if ($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0) {
            $isCnpjValid = false;
        }
        //Etapa 4: Calcula e compara o primeiro dígito verificador.
        else {
            $j = 5;
            for ($i = 0; $i < 4; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $j = 9;
            for ($i = 4; $i < 12; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($dg != $num[12]) {
                $isCnpjValid = false;
            }
        }
        //Etapa 5: Calcula e compara o segundo dígito verificador.
        if (!isset($isCnpjValid)) {
            $j = 6;
            for ($i = 0; $i < 5; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $j = 9;
            for ($i = 5; $i < 13; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($dg != $num[13]) {
                $isCnpjValid = false;
            } else {
                $isCnpjValid = true;
            }
        }
        //Etapa 6: Retorna o Resultado em um valor booleano.
        return $isCnpjValid;
    }

    /**
     * Redimensiona uma imagem mantendo a proporção e gera uma miniatura (thumbnail).
     *
     * @param int    $new_width  A nova largura da miniatura.
     * @param int    $new_height A nova altura da miniatura.
     * @param string $source_file O caminho completo da imagem original.
     * @param string $dst_file    O caminho completo para salvar a nova imagem.
     * @param int    $quality     A qualidade da nova imagem (padrão: 60).
     *
     * @return void
     */
    public function image_thumbnail($new_width, $new_height, $source_file, $dst_file, $quality = 60)
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
     * @param string  $hex   O valor hexadecimal da cor (com ou sem '#').
     * @param boolean $alpha Indica se a cor deve incluir valor de transparência (padrão: false).
     *
     * @return string Retorna a cor em formato RGB (por exemplo, "255,255,255").
     */
    public static function convertHexToRgb($hex, $alpha = false)
    {
        if (substr($hex, 0, 1) == '#') {
            $hex = str_replace('#', '', $hex);
            $length = strlen($hex);
            $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
            $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
            $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
            if ($alpha) {
                $rgb['a'] = $alpha;
            }
            return $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b']; // ou return $rgb;
        } else {
            return $hex;
        }
    }

    /**
     * Converte uma cor no formato RGB para hexadecimal.
     *
     * @param string $rgb A cor em formato RGB (ex: "255,255,255").
     *
     * @return string Retorna a cor em formato hexadecimal (ex: "#ffffff").
     */
    public static function convertRgbToHex($rgb)
    {
        $color = explode(',', $rgb);
        return sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
    }

    /**
     * Sanitiza uma string, removendo caracteres especiais e substituindo por equivalentes.
     *
     * @param string $string A string a ser sanitizada.
     * @return string A string sanitizada.
     * @throws \Exception Se ocorrer um erro durante a sanitização.
     */
    public static function sanitizeString($string)
    {
        // matriz de entrada
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');
        // matriz de saída
        $by   = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');
        // devolver a string
        return str_replace($what, $by, $string);
    }

    /**
     * Gera um CNPJ aleatório, com ou sem máscara.
     *
     * @param string $mask Define se o CNPJ gerado deve incluir a máscara de formatação. Valores possíveis: "1" (sem máscara) ou "0" (com máscara).
     * @return string CNPJ gerado aleatoriamente no formato definido pela máscara.
     */
    public static function randomCnpj($mask = "1")
    {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = 0;
        $n10 = 0;
        $n11 = 0;
        $n12 = 1;
        $d1 = $n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5;
        $d1 = 11 - (Self::mod($d1, 11));
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6;
        $d2 = 11 - (Self::mod($d2, 11));
        if ($d2 >= 10) {
            $d2 = 0;
        }
        $retorno = '';
        if ($mask == 1) {

            $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $n10 . $n11 . $n12 . $d1 . $d2;
        } else {
            $retorno = '' . $n1 . $n2 . "." . $n3 . $n4 . $n5 . "." . $n6 . $n7 . $n8 . "/" . $n9 . $n10 . $n11 . $n12 . "-" . $d1 . $d2;
        }
        return $retorno;
    }

    /**
     * Gera um CPF aleatório, com ou sem máscara.
     *
     * @param string $mask Define se o CPF gerado deve incluir a máscara de formatação. Valores possíveis: "1" (sem máscara) ou "0" (com máscara).
     * @return string CPF gerado aleatoriamente no formato definido pela máscara.
     */
    public static function randomCpf($mask = "1")
    {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = rand(0, 9);
        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - (Self::mod($d1, 11));
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - (Self::mod($d2, 11));
        if ($d2 >= 10) {
            $d2 = 0;
        }
        $retorno = '';
        if ($mask == 1) {
            $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
        } else {
            $retorno = '' . $n1 . $n2 . $n3 . "." . $n4 . $n5 . $n6 . "." . $n7 . $n8 . $n9 . "-" . $d1 . $d2;
        }
        return $retorno;
    }

    /**
    * Calcula o módulo de dois números.
    *
    * Esta função calcula o resto da divisão do `$dividend`` pelo `$divisor`
    * usando uma abordagem de arredondamento. Retorna o resultado da operação de módulo,
    * garantindo que o resultado seja sempre um número positivo ou zero.
    *
    * @param float $dividend` O número a ser dividido (o dividend`).
    * @param float $divisor O número pelo qual dividir (o divisor).
    *
    * @return float O resto da divisão de `$dividend` por `$divisor`.
    */
    private static function mod($dividend, $divisor)
    {
        return round($dividend - (floor($dividend / $divisor) * $divisor));
    }

    /**
    * Retorna a data atual por extenso no formato brasileiro.
    *
    * @return string A data atual formatada como "Dia, dd de Mês de yyyy".
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
     * @param float $value O valor numérico a ser convertido.
     * @param int $uppercase Define se o resultado deve ser em maiúsculas. 0 para minúsculas, 1 para maiúsculas e 2 para maiúsculas em todas as palavras.
     * @return string A representação por extenso do valor.
     */
    public static function numberInWords($value, $uppercase = 0)
    {
        if (strpos($value, ",") > 0) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
        }
        $singularUnits = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
        $pluralUnits = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];

        $hundreds = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
        $tens= ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
        $teens = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];
        $units = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];

        $zeroCount = 0;

        $value = number_format($value, 2, ".", ".");
        $integer = explode(".", $value);
        $cont = count($integer);
        for ($i = 0; $i < $cont; $i++)
            for ($ii = strlen($integer[$i]); $ii < 3; $ii++)
                $integer[$i] = "0" . $integer[$i];

        $end = $cont - ($integer[$cont - 1] > 0 ? 1 : 2);
        $resultText = '';
        for ($i = 0; $i < $cont; $i++) {
            $value = $integer[$i];
            $rc = (($value > 100) && ($value < 200)) ? "cento" : $hundreds[$value[0]];
            $rd = ($value[1] < 2) ? "" : $tens[$value[1]];
            $ru = ($value > 0) ? (($value[1] == 1) ? $teens[$value[2]] : $units[$value[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($value > 1 ? $pluralUnits[$t] : $singularUnits[$t]) : "";
            if (
                $value == "000"
            )
                $zeroCount++;
            elseif ($zeroCount > 0)
                $zeroCount--;
            if (($t == 1) && ($zeroCount > 0) && ($integer[0] > 0))
                $r .= (($zeroCount > 1) ? " de " : "") . $pluralUnits[$t];
            if ($r)
                $resultText = $resultText . ((($i > 0) && ($i <= $end) &&
                    ($integer[0] > 0) && ($zeroCount < 1)) ? (($i < $end) ? ", " : " e ") : " ") . $r;
        }

        if (!$uppercase) {
            return trim($resultText ? $resultText : "zero");
        } elseif ($uppercase == "2") {
            return trim(strtoupper($resultText) ? strtoupper(strtoupper($resultText)) : "Zero");
        } else {
            return trim(ucwords($resultText) ? ucwords($resultText) : "Zero");
        }
    }
}
