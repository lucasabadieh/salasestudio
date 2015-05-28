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

//Esta página contiene las acciones que pueden realizar en la página de reuniones.

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
$url = new moodle_url('/local/reservasalas/admin.php');
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
$title = get_string('reunion', 'local_reservasalas');
//$PAGE->navbar->add(get_string('roomsreserve', 'local_reservasalas'));
//$PAGE->navbar->add(get_string('adjustments', 'local_reservasalas'));
//A continuación se crean los navbar ejemplo: ( Home -> Administración ).
$PAGE->navbar->add(get_string('admin', 'local_reservasalas'), 'admin.php');
$PAGE->navbar->add(get_string('reunion', 'local_reservasalas'), 'reuniones.php');
$PAGE->set_title($title);
$PAGE->set_heading($title);
//Aquí se crea el header de la página y se definen variables que pueden
// ser utiles, como la fecha y la hora.
$o.= $OUTPUT->header();
$o.= $OUTPUT->heading($title);
$ahora = time();
$fechahoy = date('Y-m-d'); 
$modulo = modulo_hora($ahora);
$table = new html_table();

//De aquí en adelante se crea el menú del administrador.
//Se define un icono y un link que usa el icono anterior.
//Todo se imprime en una tabla.
//Ejmplo: $reservar = $OUTPUT->action_link(new moodle_url("/local/reservasalas/reservar.php", array('id'=>666)), "Reservas");


//Reservar reunion
$string ='reunionreserve';
$pixicon = new pix_icon('i/siteevent', get_string($string, 'local_reservasalas'));
$link = $OUTPUT->action_icon(new moodle_url("/local/reservasalas/reunion.php"), $pixicon);
$table->data[] = array(get_string($string, 'local_reservasalas'), $link);

//Mis reuniones
$string = 'reunionmyreunions';
$pixicon = new pix_icon('i/scheduled', get_string($string, 'local_reservasalas'));
$link = $OUTPUT->action_icon(new moodle_url("/local/reservasalas/misreuniones.php"), $pixicon);
$table->data[] = array(get_string($string, 'local_reservasalas'), $link);

	


//Imprime la tabla y termina.
$o.= html_writer::table($table);
$o .= $OUTPUT->footer();
echo $o;

?>
