<?php
require_once 'phplot.php';
require_once(dirname(__FILE__) . '/../../config.php'); //obligatorio
require_once($CFG->dirroot.'/local/reservasalas/forms.php');
require_once($CFG->dirroot.'/local/reservasalas/tablas.php');
//Configuración:
$year = 2015; //Ingrese el año a evaluar.
$modulos = 7; //Cantidad de módulos de su horario.

//Definimos las horas potenciales: 
//Ingrese los días hábiles de los siguientes meses:
// $days01 = 20; (eso dice que tiene 20 días hábiles)
$days01 = 0; $hours01 = $days01*$modulos; //Enero  
$days02 = 0; $hours02 = $days02*$modulos; //Febrero
$days03 = 15; $hours03 = $days03*$modulos; //Marzo
$days04 = 18; $hours04 = $days04*$modulos; //Abril
$days05 = 17; $hours05 = $days05*$modulos; //Mayo
$days06 = 16; $hours06 = $days06*$modulos; //Junio
$days07 = 5; $hours07 = $days07*$modulos; //Julio
$days08 = 18; $hours08 = $days08*$modulos; //Agosto
$days09 = 16; $hours09 = $days09*$modulos; //Septiembre
$days10 = 20; $hours10 = $days10*$modulos; //Octubre
$days11 = 17; $hours11 = $days11*$modulos; //Nobiembre
$days12 = 9; $hours12 = $days12*$modulos; //Diciembre

//Horas Reales:

	//	$sqlenero = "SELECT * 
		//	FROM {reservasalas_reservas}
			//	WHERE fecha_reserva LIKE 20150625";
//$reales01 = $DB->count_records_sql($sqlenero);

$data = array(
		array('Jan', $hours01, $reales01), array('Feb', $hours02, 3), array('Mar', $hours03, 4),
		array('Apr', $hours04, 5), array('May', $hours05, 6), array('Jun', $hours06, 7),
		array('Jul', $hours07, 8), array('Aug', $hours08, 9), array('Sep', $hours09, 5),
		array('Oct', $hours10, 4), array('Nov', $hours11, 7), array('Dec', $hours12, 3),
);

// Se define la forma del gráfico:
$plot = new PHPlot(800, 600);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Título del gráfico:
$plot->SetTitle('Gráfico de horas potenciales vs horas reales del año '.$year);

# Leyenda:
$plot->SetLegend(array('Horas Potenciales', 'Horas Reales'));

# Obligatorio:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->DrawGraph();
?>
