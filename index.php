<?php 


include 'connect.php'; 


if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$befehl = "SELECT * FROM posts WHERE id=$id";
			$ergebnis = mysql_query($befehl);
			$auslese = mysql_fetch_array($ergebnis);
			$ueberschrift = $auslese['topic'];
			$navipunkt = $auslese['navigation'];
			$parent = $auslese['parent'];
			$position = $auslese['position'];
			$inhalt = $auslese['content'];
			$status = 'update';
  }


$template = str_replace("{NAVIGATION}", $navigation, $template);
$template = str_replace("{UEBERSCHRIFT}", $ueberschrift, $template);
$template = str_replace("{NAVIPUNKT}", $navipunkt, $template);
$template = str_replace("{PARENT}", $parent, $template);
$template = str_replace("{POSITION}", $position, $template);
$template = str_replace("{CONTENT}", $inhalt, $template);
$template = str_replace("{CONTENT}", $inhalt, $template);  
$template = str_replace("{ID}", $id, $template);
$template = str_replace("{STATUS}", $status, $template);
if (!isset($_GET['id'])) {$navipunkt = 'Startseite';};
$template = str_replace("{TITLE}", $ueberschrift, $template);



echo $template;


mysql_close($verbindung);
?>