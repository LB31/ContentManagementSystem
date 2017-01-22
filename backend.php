<?php 
include 'connect.php'; 

$formularfeld = "<h3>Beitrag schreiben:</h3>
					<form method='post' action='$ziel'>
					<input type='text' name='ueberschrift' value='{UEBERSCHRIFT}' /> Überschrift 
					<input type='text' name='navipunkt' value='{NAVIPUNKT}' /> Navigationspunkt <br />
					<input type='text' name='parent' value='{PARENT}'/> Parent
					<input type='text' name='position' value='{POSITION}' /> Position <br />
					<p><textarea name='inhalt' >{CONTENT}</textarea></p>
					<input type='text' name='sendestatus' value='{STATUS}' /> Status <br />
					<input type='hidden' name='id' value='{ID}'>
					<input type='submit' name='senden' value='Beitrag erstellen'>
					</form>";
					
$editor = "<script type='text/javascript' src='tinymce/tinymce.min.js'></script>
		<script type='text/javascript'>
		tinymce.init({
		selector: 'textarea',
		theme: 'modern',
		width: 715,
		height: 300,
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern'
		],
		toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		toolbar2: 'print preview media | forecolor backcolor emoticons',
		image_advtab: true,
		templates: [
			{title: 'Test template 1', content: 'Test 1'},
			{title: 'Test template 2', content: 'Test 2'}
		]
		});
		</script>";
		
$template = str_replace("<!-- Plugin -->", $editor, $template);					
$template = str_replace("{CONTENT}", $formularfeld, $template);

$ueberschrift ='';	
$navipunkt ='';	
$parent ='';	
$position ='';	
$inhalt ='';
$id = "0";			
$status = 'insert';


if (isset($_POST['senden'])) {
			$status = $_POST['sendestatus'];
			$ueberschrift = $_POST['ueberschrift'];
			$navipunkt = $_POST['navipunkt'];
			$parent = $_POST['parent'];
			$position = $_POST['position'];
			$inhalt = $_POST['inhalt'];
			if ($status == 'insert') {
			$befehl = "INSERT INTO posts (topic, navigation, parent, position, content, datum) ";
			$befehl .= "VALUES ('$ueberschrift', '$navipunkt', '$parent', '$position', '$inhalt', now())";
			$ergebnis = mysql_query($befehl);		
			}
			
			if ($status == 'update') {
			$id = $_POST['id'];
			$loesch = $navipunkt == "" && $inhalt == "";
			if ($loesch) {
			$befehl = "DELETE FROM posts WHERE id='$id' OR parent='$id'";
			} else {			
			$befehl = "UPDATE posts SET topic='$ueberschrift', navigation='$navipunkt', parent='$parent', ";
			$befehl .= "position='$position', content='$inhalt' WHERE id='$id'";
			}
			mysql_query($befehl);
			}
			$ueberschrift ='';	
			$navipunkt ='';	
			$parent ='';	
			$position ='';	
			$inhalt ='';			
			$status = 'insert';
	
			
}


if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$befehl = "SELECT * FROM posts  WHERE id=$id";
			$ergebnis = mysql_query($befehl);
			$auslese = mysql_fetch_array($ergebnis);
			$ueberschrift = $auslese['topic'];
			$navipunkt = $auslese['navigation'];
			$parent = $auslese['parent'];
			$position = $auslese['position'];
			$inhalt = $auslese['content'];
			$status = 'update';
  }

if($ort == 0){$klasse = 'navilinks current';} else{$klasse = 'navilinks';}
$navigation .= "<a href='backend.php' class='".$klasse."'>Back-End</a>";
$navigation .= "<a href='index.php?id=1' class='navilinks'>Index</a>";

$template = str_replace("{NAVIGATION}", $navigation, $template);
$template = str_replace("{UEBERSCHRIFT}", $ueberschrift, $template);
$template = str_replace("{NAVIPUNKT}", $navipunkt, $template);
$template = str_replace("{PARENT}", $parent, $template);
$template = str_replace("{POSITION}", $position, $template);
$template = str_replace("{CONTENT}", $inhalt, $template);
$template = str_replace("{CONTENT}", $inhalt, $template);  
$template = str_replace("{ID}", $id, $template);
$template = str_replace("{STATUS}", $status, $template);
if (!isset($_GET['id'])) {$navipunkt = 'Back-End';};
$template = str_replace("{TITLE}", $ueberschrift, $template);



echo $template;


mysql_close($verbindung);
?>
