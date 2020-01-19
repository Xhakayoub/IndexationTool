<?php

$bdd = mysqli_connect('localhost', 'root', '', 'tiw');
$query_artists = "select m.mot as text, md.poids as size from mot m, mot_document md, document d where m.id = md.id_mot and md.id_document = d.id and d.id = '$_GET[q]' and m.mot is not null";
$artists = mysqli_query($bdd, $query_artists);
$result = array();

if (mysqli_num_rows($artists) > 0) {
		
		while($row = mysqli_fetch_assoc($artists)) {
		
		$row["text"] = str_replace("’","", $row["text"]);
		
		
		$result[] = array( 'text' => $row["text"], 'size' => (int)$row["size"] );	
		}
	}

echo json_encode($result);



?>