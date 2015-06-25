*** Moodle Plugin to reserve study rooms***
This plugin contains new characteristic and function related to
The old Study rooms reservation plugin.
This is not an official Study Room reservation plugin from webcursos***

Contain:

I . Installation
II . Log version
III. Contact
————————————————————————————————————————————————————————————
I. Installation:

1. Copy/Paste or drag the folder “reservasalas” in the folder “local”  which it’s already contained in your moodle-master. 
The folder should be in C:/xampp/htdocs.

2. Copy/Paste or drag the UAI folder to “blocs” folder contained in your moddle-master. Your moldle-master folder should be in C:/xampp/htdocs.

3. After following the previous steps , enter your moodle( with xampp’s apache and mysql running), identify yourself as the admin. Go to notifications , and your moodle should recognize the plugins, accept and wait for the installation to end.

————————————————————————————————————————————————————————————
II. Log Version:

v1.0
Plugin’s original version

v1.1.310515 - 31/05/15
———————————
———————————
To this date the follows php pages have been created:
 — admin.php : Page that shows the administrator available options.

 — usurious.php : Page that shows the registered users at moodle with their name , mail, and the blocked status, also the it has the option to manage the blocked status of the user.

 — misreuniones.php , reuniones.php and reunion.php : This pages pages derivate from reserver.php and misreservas.php the difference is that in this pages shows the meeting room reservation and not the study rooms.

The next pages were updated:
 — bloquear and desbloquear.php : A series of code were add to the page that allows to change the  user blocked status in usurious.php . The original pages had a text block in were you enter the user name in which you block and unblock him. On the other hand , the page had an contradiction error in which by blocking and unblocking several times the same user it generate a table were the same user appears the same user block and unblock. This bug was fixed.

v1.2.030615 — 03/06/15
————————————
————————————
New characteristics:
 — The blocked students can’t make reservations.
 — The meeting page just shows reservations from the “salas de reunion”
 — New: Plot at the statistics page
 — Dramatic code quality improvement

——————————————————————————————————————————————————————————————————————
III. Contact:
Any consult or suggestions to:
Lucas Abadie Hagemann
labadie@alumnos.uai.cl
or
Stephano Velasquez Stocker
svelasquez@alumnos.uai.cl
or
Raul Matos
rmatos@alumnos.uai.cl















