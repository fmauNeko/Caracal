<?php

include("config.php");
include("bordel.php");

$fichiers = get_fichiers();


if(isset($_FILES['file']))
{
	$sha1sum = sha1_file($_FILES['file']['tmp_name']);
	$extension = "." . end(explode(".", $_FILES['file']['name']));
	$name = basename($_FILES['file']['name'], $extension);
	$fullname = $name . $extension;

	if(move_uploaded_file($_FILES['file']['tmp_name'], $stockage . $sha1sum . $extension))
	{
		$success_alert = "Le fichier " . $fullname . " a bien été uploadé";
	} else {
		$error_alert = "Le fichier " . $fullname . " n'a PAS été uploadé, veuillez réessayer";
	}

	array_unshift($fichiers, array("nom" => $name, "chemin" => $sha1sum . $extension, "type" => "image", "timestamp" => time()));

	file_put_contents('liste.json', json_encode($fichiers));

	// Pour ne pas reposter le fichier en actualisant la page
	header("Location: .");

	exit();

}

# Fonction trop bien reprise de jyraphe
$taille_max_upload = jyraphe_get_max_upload_size();

include("template.php");

?>
