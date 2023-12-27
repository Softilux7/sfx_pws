<?php

/**
 * Convorte uma data e hora para o timezone informado
 * @author Gustavo Silva
 * @since 02/07/2020
 */

class DateHourTimezoneComponent extends Component {

    public static function get($dateTime, $format = 'd-m-Y H:i:s'){
        
        // define o timezone
        $timezone = isset($_SESSION['auth_user']['EmpresaSelected']['Empresa']['fuso_horario']) ? 
                          $_SESSION['auth_user']['EmpresaSelected']['Empresa']['fuso_horario'] :
                          'America/Sao_Paulo';

        
        $date = new DateTime();
        
        // converte para o timezone so sistema
        $date->setTimezone(new DateTimeZone($timezone));

        // formata a data e retorna
        return $date->format($format);
    }

}