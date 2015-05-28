<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * 
 *
 * @package    local
 * @subpackage reservasalas
 * @copyright  2013 Marcelo Epuyao
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php'); //obligatorio
require_once($CFG->dirroot.'/local/reservasalas/forms.php');
require_once($CFG->dirroot.'/local/reservasalas/tablas.php');

//cÃ³digo para setear contexto, url, layout
global $PAGE, $CFG, $OUTPUT, $DB;
require_login();
$url = new moodle_url('/local/reservasalas/historial.php'); 
$context = context_system::instance();//context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');



if(!has_capability('local/reservasalas:bockinginfo', $context)) {
	// TODO: Log unsuccessful attempts for security

	print_error(get_string('INVALID_ACCESS','Reserva_Sala'));

}

$action = optional_param('action', 'ver', PARAM_TEXT);

//Implementacion action comentario
// permite a un administrador agregar un comentario en una reserva
if($action == "comentario"){
	$reservaid = required_param('reserva', PARAM_INT);
	$comentarform = new comentarioAdmin(null, array('reservaid'=>$reservaid));
	
	if($comentarform->is_cancelled()){
		$action = "ver";
	}else if($fromform = $comentarform->get_data()){
		$reserva = $DB->get_record('reservasalas_reservas', array('id'=>$reservaid));
		$reserva->comentario_admin = $fromform->comentario;
		$DB->update_record('reservasalas_reservas', $reserva);
		$action = "ver";
		
	}
}
// implementacion del action ver
// Muestra una tabla por paginas de todas las reservas activas en orden decreciente de fecha
// con un enlace que permite agregar un comentario o ver, si tuviera, el comentario existente
if($action == "ver"){
	$max = 15;
	$page = optional_param('page', 0, PARAM_INT);
	//$reservas = $DB->get_records('reservasalas_reservas');
	$reservas = $DB->get_records_sql('select * from {reservasalas_reservas} where activa = 1 order by fecha_reserva desc');
	$count = count($reservas);
	$totalpages = ceil($count/$max);
	$tabla = tablas::datosTodasReservas($reservas,$max, $page);
}



//Vistas de los ACTION: ver y comentario
$o = '';
$title = get_string('bookinghistory', 'local_reservasalas');
$PAGE->navbar->add(get_string('admin', 'local_reservasalas'), 'admin.php');
$PAGE->navbar->add($title, 'historial.php');


if($action == "ver"){

	$PAGE->set_title($title);
	$PAGE->set_heading($title);
	$o.= $OUTPUT->header();
	$o.= $OUTPUT->heading($title);
	$o.= "versiÃ³n 2013031400";
	$o.= "<right><h4> ".get_string('totalreserves', 'local_reservasalas')." ".$count."  </h4></right>";
	$o.= "<div class='no-overflow'>";
	$o .= html_writer::table($tabla);
	$o.= "</div>";
	
	$o .= $OUTPUT->paging_bar($count, $page, $max, 'historial.php?ver=1&page=');
	
}else if($action == "comentario"){
	
	$newtitle = get_string('admincomment', 'local_reservasalas');
	$PAGE->navbar->add($newtitle, '');
	$PAGE->set_title($newtitle);
	$PAGE->set_heading($newtitle);
	$o.= $OUTPUT->header();
	$o.= $OUTPUT->heading($newtitle);
	ob_start();
    $comentarform->display();
    $o .= ob_get_contents();
    ob_end_clean();
}
$o .= $OUTPUT->footer();
echo $o;
