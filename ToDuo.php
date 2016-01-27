<?php
class ToDuo {

	private $calendar;

	function __construct( $year = NULL ) {
		if ( $year != NULL ) {
			$data_inicio = new DateTime( $year . "-01-01" );
			$data_fim = new DateTime( $year+1 . "-01-01" );
			$intervalo = new DateInterval( "P1D" );
			$periodo = new DatePeriod( $data_inicio, $intervalo, $data_fim );

			$calendario = array();
			$semana_atual = 0;
			$i = 0;

			foreach ( $periodo as $data ) {
				$dia_mes = $data->format( "Ymd" );
				$dia_semana = $data->format( "w" );

				if ( $dia_semana != 0 ) {
					$calendario[$semana_atual][$i]['dia_mes'] = $dia_mes;
					$calendario[$semana_atual][$i]['dia_semana'] = $dia_semana;
					$calendario[$semana_atual][$i]['eventos'] = array();
					$i++;
				} else {
					$calendario[$semana_atual][$i]['dia_mes'] = $dia_mes;
					$calendario[$semana_atual][$i]['dia_semana'] = $dia_semana;
					$calendario[$semana_atual][$i]['eventos'] = array();
					$semana_atual++;
					$i = 0;
				}
			}

			$this->calendar = $calendario;
		} else {
			$this->load_calendar();
		}
	}

	private function save_calendar() {
		file_put_contents( 'calendar.bin', serialize( $this->calendar ) );
	}

	private function load_calendar() {
		$this->calendar = unserialize( file_get_contents( 'calendar.bin' ) );
	}

	function get_calendar() {
		return $this->calendar;
	}

    function get_week( $week ) {
        $calendario = $this->calendar;

		for ( $i = 0; $i < count($calendario); $i++ ) {
            if ( $week == $i+1 ) {
                $week = $calendario[$i];
            }
		}

        return $week;
    }

	function set_event( $date, $event ) {
		$calendario = $this->calendar;

		for ( $i = 0; $i < count($calendario); $i++ ) {
			for ( $j = 0; $j < count($calendario[$i]); $j++ ) {
				if ( $calendario[$i][$j]['dia_mes'] == $date ) {
					$calendario[$i][$j]['eventos'][] = $event;
				}
			}
		}

		$this->calendar = $calendario;
		//$this->save_calendar();
	}

	function get_event( $date ) {
		$calendario = $this->calendar;
		$eventos = array();

		for ( $i = 0; $i < count($calendario); $i++ ) {
			for ( $j = 0; $j < count($calendario[$i]); $j++ ) {
				if ( $calendario[$i][$j]['dia_mes'] == $date ) {
					$eventos = $calendario[$i][$j]['eventos'];
				}
			}
		}

		return $eventos;
	}

	function get_all_events() {
		$calendario = $this->calendar;
		$eventos = array();
		$y = 0;

		for ( $i = 0; $i < count($calendario); $i++ ) {
			for ( $j = 0; $j < count($calendario[$i]); $j++ ) {
				if ( count( $calendario[$i][$j]['eventos'] ) != 0 ) {
					$eventos[$y]['dia_mes'] = $calendario[$i][$j]['dia_mes'];
					$eventos[$y]['dia_semana'] = $calendario[$i][$j]['dia_semana'];
					$eventos[$y]['eventos'] = $calendario[$i][$j]['eventos'];
					$y++;
				}
			}
		}

		return $eventos;
	}

}
?>
