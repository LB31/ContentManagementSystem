<?php

$template = file_get_contents("designs/design14/template.html");
$servername = "localhost";
$benutzer = "root";
$passwort = "";
$datenbank = "cms";

$verbindung = mysql_connect($servername, $benutzer, $passwort) or die("<h3>Verbindung zum Server gescheitert</h3>");
$dbzugriff = mysql_select_db($datenbank) or die("<h3>Verbindung zur Datenbank gescheitert</h3>");
$ziel = $_SERVER['PHP_SELF'];
if(isset($_GET['id'])){
$ort = $_GET['id'];
} else { $ort = 0;}

	
	
// NAVIGATION 
// Oberpunkte
$navigation = "";

$befehl = "SELECT * FROM posts WHERE parent=0 ORDER BY position";
$ergebnisOber = mysql_query($befehl);
while($auslese = mysql_fetch_array($ergebnisOber))
   {
		
		$linktext = $auslese['navigation'];
		$linkIdOben = $auslese['id'];
		if($ort == $linkIdOben){
		$klasse = 'navilinks current';
		} else { $klasse = 'navilinks'; }
		$navigation .= "<a href='".$ziel."?id=".$linkIdOben."' class='".$klasse."'>".$linktext."</a>";
		// Unterpunkte
		$befehl = "SELECT * FROM posts WHERE parent=$linkIdOben ORDER BY position";
		$ergebnisUnter = mysql_query($befehl);
		$duDarfst = false;
		while($auslese = mysql_fetch_array($ergebnisUnter))
		{
		$linkIdUnten = $auslese['id'];
		if($ort == $linkIdUnten){$duDarfst = true;}
		}
		$befehl = "SELECT * FROM posts WHERE parent=$linkIdOben ORDER BY position";
		$ergebnisUnter = mysql_query($befehl);
		while($auslese = mysql_fetch_array($ergebnisUnter))
		{
			$linkIdUnten = $auslese['id'];
			$linktext = $auslese['navigation'];
			if($ort == $linkIdUnten){
			$klasse = 'navilinksUnter currentUnter';
			} else { $klasse = 'navilinksUnter'; }
			if($ort == $linkIdOben || $duDarfst){
			$navigation .= "<a href='".$ziel."?id=".$linkIdUnten."' class='".$klasse."'>".$linktext."</a>";
			}
		}
   }



   
   
   
  

?>