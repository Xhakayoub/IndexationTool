<?php

include 'bibliotheque-fonctions.inc.php';


function lire_corpus($dossier)
{
	
	if ($dir = opendir($dossier))
	{ 

		while(false !== ($file = readdir($dir))) 
		{
			
			if ($file == '.' || $file == '..') 
			{
				continue;
			} 
			
			if (is_dir($dossier . '/' . $file)) 
			{
				
				
				lire_corpus($dossier . '/' . $file);
			}
			else 
			{
				$source = $dossier . '/' . $file;

			    if( strpos($source,'.htm') )
				{
					main($source);
				}
				
			}
		}
		closedir($dir);  
	}

}

function main($source)
 {


				// lecture d'une source Html
				$chaine_html = implode( file($source),' ');
				
				//-------------------------------- Traitement Body -----------------------

				//recup�ration du body du corps du document
				$modele = "/<body[^>]*>(.*)<\/body>/is";
				$chaine_body_html = get_body($modele,$chaine_html);

				//suppression du javascript du body
				$modele = "/<script[^>]*?>.*?<\/script>/is";
				$chaine_html_sans_script = preg_replace($modele,"",$chaine_html);

				//suppression de balises html du body -> body en texte brute
				$chaine_body_texte = strip_tags($chaine_html_sans_script);

				//mise en minuscule du texte avant traitement
				$chaine_body_texte = strtolower($chaine_body_texte);

				// segmentation du texte en mots
				$separateurs = ",.;\'()/\n/\S/\t/\r 0123456789�\?\!:{}_\"";
				$tab_mots_body = explode_bis($separateurs, $chaine_body_texte);


				//filtrage de doublons et obtention de nombre d'occurrences
				$tab_mots_occurrences_body = array_count_values($tab_mots_body);

				//-------------------------------- Traitement Head -----------------------

				// recouperation du descriptif
				$description = get_description($source);

				// recuperation des keywords
				$keywords = get_keywords($source);

				// recuperation du title
				$modele2 = "/<title>(.*)<\/title>/i";
				$title = get_title($modele2,$chaine_html);

				// construction de la chaine head
				$chaine_head = strtolower($title." ".$description." ".$keywords);

				// segmentation du texte en mots
				$tab_mots_head = explode_bis($separateurs, $chaine_head);

				//print_array($tab_mots_head);

				//filtrage de doublons et obtention de nombre d'occurrences
				$tab_mots_occurrences_head = array_count_values($tab_mots_head);





				//-------------------------Poids-------------------------------------

				$tab_mots_poids_head = occurrence2Poids($tab_mots_occurrences_head, 2);
				$tab_mots_poids_body = occurrence2Poids($tab_mots_occurrences_body, 1);

				//---------------------------Fusionner Head et Body-------------------------------------



				 foreach ( $tab_mots_poids_head as $mot => $occurrence)
					{

						if(array_key_exists($mot, $tab_mots_poids_body)) 
											{	
										
												
												$ancien_occurence = $tab_mots_poids_body[$mot];
												$new_occuence = $occurrence + $ancien_occurence;
												$tab_mots_poids_body[$mot] = $new_occuence;
												
											}
											else 
												$tab_mots_poids_body = array_merge($tab_mots_poids_body, array($mot => $occurrence));
					}
					
					
		//--------------------------------------------------Partie Data Base------------------------------------------
		
		//Connexion
		$bdd = mysqli_connect('localhost', 'root', '', 'tiw');
		$title = Unaccent($title);
		$description = Unaccent($description);
		// insertion source dans la table document
		$sql = "INSERT INTO document (document,titre,description) VALUES('$source','$title','$description')";
		mysqli_query($bdd, $sql);	
		$id_document = mysqli_insert_id($bdd);
		
		
		//Insertion des Mots
		foreach ( $tab_mots_poids_body as $mot => $poids)
		{
			// on teste si le mot existe dans la table : Select 
			$sql2 = "SELECT id FROM mot WHERE EXISTS (SELECT * FROM mot WHERE mot = $mot)";
			$result = mysqli_query($bdd, $sql2);
			// si existe on recupere id
			if ($result !== false) {
				$id_mot = mysqli_fetch_field($result);
				
			}
			// sinon on fait l insertion
			else {
			
				
				$mot = Unaccent($mot);
				
				
					// insertion mot dans la table mot	
					$sql3 = "INSERT INTO mot (mot) VALUES ('$mot')";
					mysqli_query($bdd, $sql3);
					$id_mot = mysqli_insert_id($bdd);  //recuperation de la derniere ID
			
			}
			
			// mise relation ID_mot avec id_document et le poids
			$sql4 = "INSERT INTO mot_document (id_mot,id_document,poids) VALUES ($id_mot,$id_document,$poids)";
			mysqli_query($bdd, $sql4);
		}
		
		
		
}

?>