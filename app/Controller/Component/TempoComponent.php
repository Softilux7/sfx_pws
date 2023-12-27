<?php
/*------------------------------------------------------------------------------}
{ 05.11.2012     510   Wagner    Tempo Resposta e Tempo de solução no fechamento}
{                                 da O.S                                        }
{------------------------------------------------------------------------------*/
class TempoComponent extends Component
{
    public static  function m2h($mins)
    {
        // Se os minutos estiverem negativos
        if ($mins < 0)
            $min = abs($mins);
        else
            $min = $mins;

        // Arredonda a hora
        $h = floor($min / 60);
        $m = ($min - ($h * 60)) / 100;
        $horas = $h + $m;

        // Matemática da quinta série
        // Detalhe: Aqui também pode se usar o abs()
        if ($mins < 0)
            $horas *= -1;

        // Separa a hora dos minutos
        $sep = explode('.', $horas);
        $h = $sep[0];
        if (empty($sep[1]))
            $sep[1] = 00;

        $m = $sep[1];

        // Aqui um pequeno artifício pra colocar um zero no final
        if (strlen($m) < 2)
            $m = $m . 0;

        return sprintf('%02d:%02d', $h, $m);
    }

    public static function dia_semana_extenso($weekn)
    {
        /*
           $weekn é um inteiro de 0 a 6
           inicio em domingo = 0
           retorna dia da semana por extenso
        */
        switch ($weekn) {
            case 0 :
                $weekn = 'Domingo';
                break;
            case 1 :
                $weekn = 'Segunda';
                break;
            case 2 :
                $weekn = 'Terça';
                break;
            case 3 :
                $weekn = 'Quarta';
                break;
            case 4 :
                $weekn = 'Quinta';
                break;
            case 5 :
                $weekn = 'Sexta';
                break;
            case 6 :
                $weekn = 'Sábado';
                break;

        }
        return ($weekn);
    } // ------------ fim funcao dia_semana_extenso

    public static function converterdx($time)
    {
        //date("w", mktime(0, 0, 0, $x_mes, $x_dia , $x_ano))
        return date("dm", $time);
    } // ------------ fim funcao converterdx

    public static function easter_dates($Year)
    {

        /*
        G is the Golden Number-1
        H is 23-Epact (modulo 30)
        I is the number of days from 21 March to the Paschal full moon
        J is the weekday for the Paschal full moon (0=Sunday,
        1=Monday, etc.)
        L is the number of days from 21 March to the Sunday on or before
        the Paschal full moon (a number between -6 and 28)
        */

        $G = $Year % 19;
        $C = (int)($Year / 100);
        $H = (int)($C - (int)($C / 4) - (int)((8 * $C + 13) / 25) + 19 * $G + 15) % 30;
        $I = (int)$H - (int)($H / 28) * (1 - (int)($H / 28) * (int)(29 / ($H + 1)) * ((int)
                    (21 - $G) / 11));
        $J = ($Year + (int)($Year / 4) + $I + 2 - $C + (int)($C / 4)) % 7;
        $L = $I - $J;
        $m = 3 + (int)(($L + 40) / 44);
        $d = $L + 28 - 31 * ((int)($m / 4));
        $y = $Year;
        $E = mktime(0, 0, 0, $m, $d, $y);

        return $E;

    } // ------------ fim funcao easter_dates

    //function FeriadoDia($di, $me, $an)   {
    public static  function FeriadoDia($datas)
    {

        $qt_dia_feriado = 0;
        $dia_semana = date("w", $datas);
        if (($dia_semana == 0) || ($dia_semana == 6)) {
            //echo " é feriado !!!! <br> ";
            return (1);
            exit;
        } else {

            $str_dia = date('d', $datas);
            $str_mes = date('m', $datas);
            $str_ano = date('Y', $datas);

            $x_ano = $str_ano + 0;
            $x_mes = $str_mes + 0;
            $x_dia = $str_dia + 0;

            $fm2 = array();
            $fm2['pascoa'] = (self::easter_dates($x_ano)); //Páscoa
            $fm2['carnaval'] = self::converterdx($fm2['pascoa'] - (47 * 86400)); //Carnaval
            $fm2['corpus_christi'] = self::converterdx($fm2['pascoa'] + (60 * 86400)); //Corpus Christi
            $fm2['paixao_de_cristo'] = self::converterdx($fm2['pascoa'] - (2 * 86400)); //Paixão de Cristo

            $fm2['pascoa'] = self::converterdx(self::easter_dates($x_ano)); //Páscoa

            if (($dia_semana > 0) || ($dia_semana < 6)) {
                //   feriados nacionais e florianopolis
                switch ($str_dia . $str_mes) {
                    // FERIADOS VARIAVEIS
                    case ($fm2['pascoa']):              // pascoa
                    case ($fm2['carnaval']):            // carnaval
                    case ($fm2['corpus_christi']):      // corpus_christi
                    case ($fm2['paixao_de_cristo']):    // paixao_de_cristo
                        // FERIADOS FIXOS
                    case ("0101"):   // Confraternização Universal
                    case ("2303"):   // Dia de Florianopolis
                    case ("2104"):   // Tiradentes cívica
                    case ("0105"):   // Dia do Trabalhador social
                    case ("0709"):   // Independência do Brasil cívica
                    case ("1210"):   // Nossa Senhora Aparecida religiosa (católica)
                    case ("0211"):   // Finados religiosa
                    case ("1511"):   // Proclamação da República cívica
                    case ("2512"):   // Natal religiosa (cristã)

                        $qt_dia_feriado++;
                        break;
                }
            }
        }
        return ($qt_dia_feriado);
    } // ------------ fim funcao FeriadoDia


    public static  function qtDias($dia_ini, $dia_fim, $tem_feriado)
    {

        $totalDias = $dia_fim - $dia_ini;
        $totalDias = floor($totalDias / (60 * 60 * 24));
        $totalFeriado = 0;

        if ($tem_feriado == 'S') {
            $dia_ini_aux = $dia_ini;
            $dia_ini_aux = mktime(0, 0, 0, date("m", $dia_ini_aux), date("d", $dia_ini_aux), date("Y", $dia_ini_aux));
            for ($i = 0; $i < $totalDias; $i++) {
                $totalFeriado += self::FeriadoDia($dia_ini_aux);
                //echo ("<br> 8 volta : $i total de dias feriados: $totalFeriado ". dia_semana_extenso(date("w", $dia_ini_aux)). " > " . date("w", $dia_ini_aux) ." : ".date("d", $dia_ini_aux) . " - " . date('d/m/Y',$dia_ini_aux) . "<br>");
                $dia_ini_aux = mktime(0, 0, 0, date("m", $dia_ini_aux), date("d", $dia_ini_aux) + 1, date("Y", $dia_ini_aux));
            }
        }

        return $totalDias - $totalFeriado;
    } // ------------ fim funcao qtDias


    public static  function difHoras($hora1, $hora2, $tempoTotal, $horaUteis, $HORAINI1, $HORAINI2, $HORAFIN1, $HORAFIN2, $t24h, $t00h)
    {

        $tempo24h = (strtotime($t24h) - strtotime($t00h)) / 60;
        $calculoIntervalo = round((strtotime($HORAINI2) - strtotime($HORAFIN1)) / 60); // Quantas horas de Intervalo
        $calculoExpediente = round((strtotime($HORAFIN2) - strtotime($HORAINI1)) / 60); // Total de horas do dia
        $expediente = $calculoExpediente - $calculoIntervalo; // Total de Horas com Intervalo


        if ($horaUteis == 'S') {

            if (strtotime($hora1) >= strtotime($HORAINI1) and strtotime($hora1) <= strtotime($HORAFIN1)) {
                $horaAbOs = (strtotime($HORAFIN1) - strtotime($hora1)) / 60;

            } elseif (strtotime($hora1) >= strtotime($HORAINI2) and strtotime($hora1) <= strtotime($HORAFIN2)) {
                $horaAbOs = (strtotime($hora1) - strtotime($HORAINI1)) / 60;
                $horaAbOs = $horaAbOs - $calculoIntervalo; // verificar..

            }

            if (strtotime($hora2) >= strtotime($HORAINI1) and strtotime($hora2) <= strtotime($HORAFIN1)) {
                $horaAt1 = (strtotime($HORAFIN1) - strtotime($hora2)) / 60;

            } elseif (strtotime($hora2) >= strtotime($HORAINI2) and strtotime($hora2) <= strtotime($HORAFIN2)) {
                $horaAt1 = (strtotime($HORAFIN2) - strtotime($hora2)) / 60;
            }

            $hTotal = $horaAt1 + $horaAbOs; // Total de Horas
            $hdia = $expediente * $tempoTotal;

        } else {

            $horaAbOs = (strtotime($t24h) - strtotime($hora1)) / 60;
            $horaAt1 = (strtotime($hora2) - strtotime($t00h)) / 60;
            $hTotal = $horaAt1 + $horaAbOs; // Total de Horas

            $hdia = $tempo24h * $tempoTotal;

        }


        $hTotal1 = $hdia + $hTotal;
        return self::m2h($hTotal1);

    }

    public static function calcularSLA($chamado, $preAtendimento){


        $id = $chamado['Chamado']['id'];

        // define a data de abertura do chamado
        $openingDate = strtotime("{$chamado['Chamado']['DTPREVENTREGA']} {$chamado['Chamado']['HRPREVENTREGA']}");
        $sumTime = 0;

        if($preAtendimento != null){
            
            // define o tamanho do array
            $size = count($preAtendimento) - 1;
            
            // a primeira pergunta sempre será da revenda, então só começará a contabilizar quando o cliente responder
            if($size >= 1){

                $count = 0;

                foreach($preAtendimento as $data){

                    // verifica se é do tipo usuário
                    if($data['u']['group_id'] == '3'){
                        
                        // pega a data e hora de interação do cliente
                        $dateClient = strtotime($data['m']['created_at']);

                        // verifica se possui a próxima interação
                        if($count + 1 <= $size){
                            // define a data da revenda
                            $dateResale = strtotime($preAtendimento[$count + 1]['m']['created_at']);
                        }else{
                            // pega a data e hora atual
                            $dateResale = strtotime(date("Y-m-d H:i:s"));
                        }

                        // calcula diferença em timestamp
                        $dateDiff = $dateResale - $dateClient;

                        // adiciona a soma total
                        $sumTime += $dateDiff;

                    }

                    $count++;
                }
                
            }
        }

        return date("d/m/Y H:i",($openingDate + $sumTime));

    }
}



?>