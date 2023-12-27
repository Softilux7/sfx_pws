<?php
//date_default_timezone_set ( 'America/Bahia' ); 
class HorasDiasUteisComponent extends Component {

	// alteramos o timezone para nao dar um monte de warnings

	/**
	 * Calculadora Horas Dias Uteis
	 *
	 * Exemplo de como fazer calculos somente com
	 * horas uteis.
	 *
	 * @author Hugo Ferreira da Silva
	 * @link http://www.hufersil.com.br/
	 *       @edit Wagner Martins
	 *
	 */
	public static $HORAFIN1;
	public static $HORAFIN2;
	public static $HORAINI1;
	public static $HORAINI2;

	// hora de inicio do almoco
	static $inicioAlmoco;
	// hora de termino do almoco
	static $terminoAlmoco;
	// hora de inicio do expediente
	static $inicioExpediente;
	// hora de termino do expediente
	static $terminoExpediente;

	/**
	 * Seta os valores padroes
	 *
	 * Iremos sempre trabalhar com minutos
	 */
	public static function setDefaults() {
		self::$inicioAlmoco = self::hora2min ( self::$HORAFIN1 );
		self::$terminoAlmoco = self::hora2min ( self::$HORAINI2 );
		self::$inicioExpediente = self::hora2min ( self::$HORAINI1 );
		self::$terminoExpediente = self::hora2min ( self::$HORAFIN2 );
	}

	/**
	 * Converte as horas em minutos
	 * descartamos os segundos
	 *
	 * @param string $strHora
	 *        	String de hora e minutos
	 * @return int valor da hora em minutos
	 */
	public static function hora2min($strHora) {
		$min = 0;
		if (preg_match ( '@^(\d{2}):(\d{2})(:(\d{2}))?@', $strHora, $reg )) {
			$min = $reg [1] * 60 + $reg [2];
		}

		return $min;
	}

	/**
	 * Calcula a data final
	 *
	 * @param string $data
	 *        	Data e hora inicial
	 * @param string $prazo
	 *        	Prazo em horas (exemplo: 05:37)
	 * @return int Timestamp da data final
	 */
	public static function calculaPrazoFinal($data, $prazo) {
		// seta os valores padroes
		self::setDefaults ();

		// verifica a data informada
		$res = preg_match ( '@^((\d{2}/\d{2}/\d{4})|(\d{4}-\d{2}-\d{2})) (\d{2}):(\d{2})(:\d{2})?$@', $data, $reg );
		// se nao esta no padrao
		if ($res == false) {
			throw new Exception ( 'Formato de data invalida' );
		}

		// se for data no formato com barras - 25/07/2010
		if (! empty ( $reg [2] )) {
			$arr = explode ( '/', $reg [2] );
			$data = mktime ( 0, 0, 0, $arr [1], $arr [0], $arr [2] );

			// se for data no formato do banco - 2010-07-25
		} else {
			$arr = explode ( '-', $reg [3] );
			$data = mktime ( 0, 0, 0, $arr [1], $arr [2], $arr [0] );
		}

		// valor de um dia em segundos
		$day = 3600 * 24;

		// calcula o prazo em minutos
		$prazotime = self::hora2min ( $prazo );
		// hora informada na data inicial em minutos
		$hora = self::hora2min ( $reg [4] . ':' . $reg [5] );

		// enquanto houver prazo
		while ( $prazotime > 0 ) {
			// incrementa a hora
			$hora ++;
			// decrementa o prazo
			$prazotime --;

			// se a hora for maior que o expediente
			if ($hora > self::$terminoExpediente) {
				// adiciona um dia
				$data += $day;
				// volta para o inicio do expediente
				$hora = self::$inicioExpediente + 1;

				// se a hora for maior que o inicio do almoco e menor que o termino do almoco
			} else if ($hora > self::$inicioAlmoco && $hora < self::$terminoAlmoco) {
				// coloca para depois do almoco
				$hora = self::$terminoAlmoco + 1;
			}
		}

		// adiciona a hora encontrada (em segundos) na data final
		$data += $hora * 60;

		// retorna o timestamp da data
		return $data;
	}

	/* Abaixo criamos um array para registrar todos os feriados existentes durante o ano. */
	public static function Feriados($ano, $posicao) {
		$dia = 86400;
		$datas = array ();
		$datas ['pascoa'] = easter_date ( $ano );
		$datas ['sexta_santa'] = $datas ['pascoa'] - (2 * $dia);
		$datas ['carnaval'] = $datas ['pascoa'] - (47 * $dia);
		$datas ['corpus_cristi'] = $datas ['pascoa'] + (60 * $dia);
		$feriados = array (
			'01/01',
			'02/02', // Navegantes
			date ( 'd/m', $datas ['carnaval'] ),
			date ( 'd/m', $datas ['sexta_santa'] ),
			date ( 'd/m', $datas ['pascoa'] ),
			'21/04',
			'01/05',
			date ( 'd/m', $datas ['corpus_cristi'] ),
			'20/09', // Revolu��o Farroupilha \m/
			'12/10',
			'02/11',
			'15/11',
			'25/12'
		);

		return $feriados [$posicao] . "/" . $ano;
	}

	// Função soma mais um dia
	public static function Soma1dia($data) {
		 $dia = substr ( $data, 8, 2 );
		 $mes = substr ( $data, 5, 2 );
		 $ano = substr ( $data, 0, 4 );
		return date ( "Y-m-d", mktime ( 0, 0, 0, $mes, $dia + 1, $ano ) );
	}
}