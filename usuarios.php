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

//Esta página contiene las acciones de la página usuarios.

/**
 * 
 *
 * @package    local
 * @subpackage reservasalas
 * @copyright  2015 Lucas Abadie Hagemann
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php'); //obligatorio
require_once($CFG->dirroot.'/local/reservasalas/forms.php');
require_once($CFG->dirroot.'/local/reservasalas/tablas.php');

//Código para setear contexto, url, layout.
global $PAGE, $CFG, $OUTPUT, $DB;
require_login();
$url = new moodle_url('/local/reservasalas/usuarios.php');
$context = context_system::instance();//context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

//Código que verifica si el usuario tiene acceso a la página o no.
if(!has_capability('local/reservasalas:bockinginfo', $context)) {
	// TODO: Log unsuccessful attempts for security
	print_error(get_string('INVALID_ACCESS','local_reservasalas'));

}

//A continuación se define la variable que imprime diseños como
//el header, la tabla que contiene los menus como reservar, etc.
//La variable 'o' es la variable que cambia y contiene los OUTPUT
//entre otros.
$o = '';
$title = get_string('users', 'local_reservasalas');
//$PAGE->navbar->add(get_string('roomsreserve', 'local_reservasalas'));
//$PAGE->navbar->add(get_string('adjustments', 'local_reservasalas'));
//A continuación se crean los navbar ejemplo: ( Home -> Administración ).
$PAGE->navbar->add(get_string('admin', 'local_reservasalas'), 'admin.php');
$PAGE->navbar->add($title, 'usuarios.php');
$PAGE->set_title($title);
$PAGE->set_heading($title);
$title = get_string('users', 'local_reservasalas');
//Aquí se crea el header de la página y se definen variables que pueden
// ser utiles, como la fecha y la hora.
$o.= $OUTPUT->header();
$o.= $OUTPUT->heading(get_string('manageusers', 'local_reservasalas'));
$ahora = time();
$fechahoy = date('Y-m-d'); 
$modulo = modulo_hora($ahora);
$table = new html_table();

//De aquí en adelante se crea la tabla con los usuarios.
//Se define un icono y un link que usa el icono anterior.
//Todo se imprime en una tabla.
//Ejmplo: $reservar = $OUTPUT->action_link(new moodle_url("/local/reservasalas/reservar.php", array('id'=>666)), "Reservas");



//Define los iconos de bloqueo y desbloqueo.

$pixiconbloc = new pix_icon('i/permissionlock', get_string('block', 'local_reservasalas'));
$pixiconunbloc = new pix_icon('i/user', get_string('unblock', 'local_reservasalas'));

//Se crea la tabla.
$users = $DB->get_records('user');
foreach($users as $user) {
	$usuario = $user->username;
	
	//$estado = new stdClass();
	$id = $users->id;
	$alumno = $DB->get_record('reservasalas_bloqueados',array('alumno_id'=>$id));
	$estado = $alumno->estado;
	if($estado == 1){ 
		$estadofinal = get_string('blocked', 'local_reservasalas');
	}else {$estadofinal = get_string('unblocked', 'local_reservasalas');}
	
	$block = $OUTPUT->action_icon(new moodle_url("/local/reservasalas/bloquear.php", array('nombreusuario'=>$usuario)), $pixiconbloc);
	$unblock = $OUTPUT->action_icon(new moodle_url("/local/reservasalas/desbloquear.php", array('nombreusuario'=>$usuario)), $pixiconunbloc);
	$table->data[] = array($usuario, $estadofinal, $block, $unblock);

}


//Imprime la tabla y termina.
$o.= html_writer::table($table);
$o .= $OUTPUT->footer();
echo $o;

?>
