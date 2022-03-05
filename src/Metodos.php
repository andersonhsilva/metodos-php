<?php

namespace Andersonhsilva\MetodosPhp;

class Metodos
{

    public static function teste()
    {
        echo 'Teste...ok ';
    }

    // -------------------tratamento de strings-----------------------------------
    public static function double_base($value)
    {
        if ($value !== null) {
            if (!is_float($value)) {
                $value = str_replace(array("R$ ", "%", "."), "", $value);
                $value = floatval(str_replace(",", ".", $value));
            }
        }
        return $value ?? null;
    }

    public static function zero_esquerda($value, $tamanho = 6)
    {
        return str_pad($value, $tamanho, '0', STR_PAD_LEFT);
    }

    public static function exibir_double($value)
    {
        return $value === null ? null : number_format($value, 2, ',', '.');
    }

    public static function exibir_double_format_int($value)
    {
        return (int) number_format($value, 2, '', '');
    }

    public static function exibir_int_format_double($value)
    {
        return floatval(substr($value, 0, -2) . '.' . substr($value, -2));
    }

    public static function mascara_string($value, $mask)
    {
        return (isset($value)) ? self::mask($value, $mask) : null;
    }

    public static function mascara_data($value, $mask)
    {
        $result = (isset($value)) ? date($mask, strtotime($value)) : null;
        return $result;
    }

    public static function converte_data_bd($data_br)
    {
        $result = (isset($data_br)) ? implode("-", array_reverse(explode("/", $data_br))) : null;
        return $result;
    }

    // $periodo = minutes, hours, day, week, month, year
    // exemplo de uso para somar um mes na data de hoje: $data = incluir_em_data('+1', 'month', date('Y-m-d'));
    public static function incluir_em_data($numero, $periodo, $data_informada)
    {
        try {
            return date('Y-m-d', strtotime($numero . ' ' . $periodo, strtotime($data_informada)));
        } catch (\Exception $e) {
            return $data_informada;
        }
    }

    // exemplo de uso: ultimo_dia_mes(date('Y-m'))
    public static function ultimo_dia_mes($periodo)
    {
        try {
            return date("t", mktime(0, 0, 0, explode('-', $periodo)[1], '01', explode('-', $periodo)[0]));
        } catch (\Exception $e) {
            return date('Y-m-d');
        }
    }

    public static function round_up($number, $precision = 2)
    {
        try {
            $fig = (int) str_pad('1', ($precision + 1), '0');
            return (ceil($number * $fig) / $fig);
        } catch (\Exception $e) {
            return  $number;
        }
    }

    public static function round_down($number, $precision = 2)
    {
        try {
            $fig = (int) str_pad('1', ($precision + 1), '0');
            return (floor($number * $fig) / $fig);
        } catch (\Exception $e) {
            return  $number;
        }
    }

    public static function somente_numero($value)
    {
        $result = preg_replace("/[^0-9]/", "", $value);
        return (!empty($result)) ? $result : null;
    }

    public static function somente_letras_numero($value)
    {
        $result = preg_replace("/[^A-Za-z0-9]/", "", $value);
        return (!empty($result)) ? $result : null;
    }

    public static function letras_menusculas($value)
    {
        return (!empty($value)) ? strtolower($value) : null;
    }

    public static function letras_maiusculas($value)
    {
        return (!empty($value)) ? strtoupper($value) : null;
    }

    public static function primeira_letra_maiuscula($value)
    {
        return (!empty($value)) ? ucfirst($value) : null;
    }

    public static function primeiras_letras_maiusculas($value)
    {
        return (!empty($value)) ? ucwords($value) : null;
    }

    public static function somente_primeiro_nome($value)
    {
        return (!empty($value)) ? explode(" ", $value)[0] : '';
    }

    public static function contains($palavra, $frase)
    {
        return strpos($frase, $palavra) !== false;
    }

    public static function limpa_string_chars($text)
    {
        return preg_replace('/[^0-9a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ\/\.]/', ' ', $text);
    }

    public static function somente_nome_sobrenome($value)
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
    public static function validar_vazio($field, $value)
    {
        if (empty($value)) {
            throw new \Exception("O campo " . $field . " não pode ficar em branco!");
        }
    }

    public static function validar_cpf($value)
    {
        if (!empty($value)) {
            if (!self::isCpfValid($value)) {
                throw new \Exception("O CPF informado está inválido!");
            }
        }
    }

    public static function validar_cnpj($value)
    {
        if (!empty($value)) {
            if (!self::isCnpjValid($value)) {
                throw new \Exception("O CNPJ informado está inválido!");
            }
        }
    }

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

    public static function validar_email($value)
    {
        if (!empty($value)) {
            if (!self::isEmailValid($value)) {
                throw new \Exception("O e-mail informado está inválido!");
            }
        }
    }

    public static function url_atual()
    {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    // ----------------------------------------------F U N C O E S---------------------------------------------

    public static function saudacao()
    {
        $hora = date('H');
        if ($hora >= 6 && $hora <= 12)
            return 'bom dia';
        else if ($hora > 12 && $hora <= 18)
            return 'boa tarde';
        else
            return 'boa noite';
    }

    public static function adiciona_9_digito($tel)
    {

        // retirando espaços
        $tel = trim($tel);
        $tamanho = strlen($tel);
        $telefone = '';

        // se maior não faz nada
        if ($tamanho  > '10') {
            $telefone = $tel;
        }

        // se igual adiciona o nono digito caso o numero seja um celular
        if ($tamanho == '10') {
            $verificando_celular = substr($tel, 2, 1);
            // verifica se é um numero de celular
            if (in_array($verificando_celular, array("9", "8", "7"))) {
                $telefone .= substr($tel, 0, 2);
                $telefone .= "9"; // nono digito
                $telefone .= substr($tel, 2);
            } else {
                $telefone = $tel;
            }
        }

        // se menor não faz nada
        if ($tamanho < '10') {
            $telefone = $tel;
        }

        return $telefone;
    }

    // exemplo de uso: diferenca_meses('2021-04-01', '2021-06-30');
    public static function diferenca_anos($data_inicial, $data_final)
    {
        try {
            $data_inicial = new \DateTime($data_inicial);
            $diferenca = $data_inicial->diff(new \DateTime($data_final));
            $result = (int) $diferenca->format('%y');
            return $result;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // exemplo de uso: diferenca_meses('2021-04-01', '2021-06-30');
    public static function diferenca_meses($data_inicial, $data_final)
    {
        try {
            $data_inicial = new \DateTime($data_inicial);
            $diferenca = $data_inicial->diff(new \DateTime($data_final));
            $result = (int) $diferenca->format('%m');
            return $result;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // exemplo de uso: diferenca_meses('2021-04-01', '2021-06-30');
    public static function diferenca_dias($data_inicial, $data_final)
    {
        try {
            $data_inicial = new \DateTime($data_inicial);
            $diferenca = $data_inicial->diff(new \DateTime($data_final));
            $result = (int) $diferenca->format('%d');
            return $result;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // exemplo de uso: gera_variacao(300, 5, 3);
    public static function gera_variacao($montante, $pctVariacao, $qtdParcelas)
    {

        // array com todas as parcelas variadas
        $listaVariacoes = array();

        // variaveis de inicio
        $totalVariacoes = 0;
        $valorParcela = ($montante / $qtdParcelas);
        $decimalVariacao = ($pctVariacao / 100);
        $variacaoMin = ($valorParcela - ($valorParcela * $decimalVariacao));
        $variacaoMax = ($valorParcela + ($valorParcela * $decimalVariacao));

        // gera as variações com base nos valores minimo = (valor parcela - variacao) e o valor maximo = valor parcela
        for ($i = 1; $i < $qtdParcelas; $i++) {
            // variação em floatval diferente do rand que só aceita intervalos int
            $variacao = number_format(($variacaoMin + ($variacaoMax - $variacaoMin) * (mt_rand() / mt_getrandmax())), 2, '.', '');
            $totalVariacoes += floatval($variacao);
            array_push($listaVariacoes, floatval($variacao));
        }

        // pega o restante final do que sobrou das variações para completar o valor do periodo
        $restoVariacao = ($montante - $totalVariacoes);
        array_push($listaVariacoes, $restoVariacao);

        return $listaVariacoes;
    }

    /*
  $cnpj = "11222333000199";
  $cpf = "00100200300";
  $cep = "08665110";
  $data = "10102010";
  $hora = "021050";

  echo mask($cnpj,'##.###.###/####-##');
  echo mask($cpf,'###.###.###-##');
  echo mask($cep,'#####-###');
  echo mask($data,'##/##/####');
  echo mask($hora,'Agora são ## horas ## minutos e ## segundos');
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
    } // mascara



    /*
  if (!isCpfValid($cpf)){ echo 'cpf invalido'}
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

    //função para validar e-mail
    private static function isEmailValid($email)
    {
        $result = true;
        if (!preg_match("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email)) {
            $result = false;
        }
        return $result;
    }

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

    public function imagem_thumbnails($new_width, $new_height, $source_file, $dst_file, $quality = 60)
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

    public static function converte_cores_hex_rgb($hex, $alpha = false)
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

    public static function converte_cores_rgb_hex($rgb)
    {
        $color = explode(',', $rgb);
        return sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
    }

    public static function sanitizeString($string)
    {
        // matriz de entrada
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');
        // matriz de saída
        $by   = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');
        // devolver a string
        return str_replace($what, $by, $string);
    }

    public static function cnpjRandom($mascara = "1")
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
        if ($mascara == 1) {

            $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $n10 . $n11 . $n12 . $d1 . $d2;
        } else {
            $retorno = '' . $n1 . $n2 . "." . $n3 . $n4 . $n5 . "." . $n6 . $n7 . $n8 . "/" . $n9 . $n10 . $n11 . $n12 . "-" . $d1 . $d2;
        }
        return $retorno;
    }

    public static function cpfRandom($mascara = "1")
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
        if ($mascara == 1) {
            $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
        } else {
            $retorno = '' . $n1 . $n2 . $n3 . "." . $n4 . $n5 . $n6 . "." . $n7 . $n8 . $n9 . "-" . $d1 . $d2;
        }
        return $retorno;
    }

    private static function mod($dividendo, $divisor)
    {
        return round($dividendo - (floor($dividendo / $divisor) * $divisor));
    }

    public static function dataExtensoBR(): String
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Recife');
        return strftime('%A, %d de %B de %Y', strtotime('today'));
    }


    public static function extenso($value, $uppercase = 0)
    {
        if (strpos($value, ",") > 0) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
        }
        $singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
        $plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];

        $c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
        $d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
        $d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];
        $u = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];

        $z = 0;

        $value = number_format($value, 2, ".", ".");
        $integer = explode(".", $value);
        $cont = count($integer);
        for ($i = 0; $i < $cont; $i++)
            for ($ii = strlen($integer[$i]); $ii < 3; $ii++)
                $integer[$i] = "0" . $integer[$i];

        $fim = $cont - ($integer[$cont - 1] > 0 ? 1 : 2);
        $rt = '';
        for ($i = 0; $i < $cont; $i++) {
            $value = $integer[$i];
            $rc = (($value > 100) && ($value < 200)) ? "cento" : $c[$value[0]];
            $rd = ($value[1] < 2) ? "" : $d[$value[1]];
            $ru = ($value > 0) ? (($value[1] == 1) ? $d10[$value[2]] : $u[$value[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($value > 1 ? $plural[$t] : $singular[$t]) : "";
            if (
                $value == "000"
            )
                $z++;
            elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($integer[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                    ($integer[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        if (!$uppercase) {
            return trim($rt ? $rt : "zero");
        } elseif ($uppercase == "2") {
            return trim(strtoupper($rt) ? strtoupper(strtoupper($rt)) : "Zero");
        } else {
            return trim(ucwords($rt) ? ucwords($rt) : "Zero");
        }
    }
}
