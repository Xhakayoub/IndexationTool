<?php

//----------Chargement de dictionnaire-----------------
$tableau_mots_vides = file('dictionnaire.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


//---------- -----------------
function get_body($modele,$chaine_html){

        preg_match($modele,$chaine_html,$tableau_res);

        if($tableau_res[1])
            return $tableau_res[1];
        else return "";
                    
}

//-------------------------------------------
function explode_bis($separateurs, $chaine ){
	
	global $tableau_mots_vides;
	
	
                $tab = array();
                $tok = strtok($chaine, $separateurs);
				
                    if (strlen($tok) > 2) $tab[] = $tok;

                    while ( $tok !== false )
                        {
                            
                            $tok = strtok($separateurs);
                            if (strlen($tok) > 2 && !in_array($tok, $tableau_mots_vides)) 
							{	
								
									$tab[] = $tok;
								
							}
                        }
                    return $tab;
}


//----------Poids  -----------------        


function occurrence2Poids($tabl_occurrences, $coeficient){
	
            $tabl_poids = array();
            foreach ( $tabl_occurrences as $mot => $occurrence)
			{
                $poid = $occurrence * $coeficient;
				
				$tabl_poids[$mot] = $poid;
				
			}
			return $tabl_poids;
}

//-------------------------------------------
function get_description($source){
	
		$table_metas = get_meta_tags($source);

		if(  $table_metas['description'] )
			 return $table_metas['description'];
		else return "";
	
}


//-------------------------------------------
function get_keywords($source){
	
		$table_metas = get_meta_tags($source);

		if(  $table_metas['keywords'] )
			 return $table_metas['keywords'];
		else return "";
	
}

//-------------------------------------------
function get_title($modele,$chaine){
	
	
	preg_match($modele,$chaine,$tableau_res);

	if($tableau_res[1])
		return $tableau_res[1];
	else return "";
	
	
}
//----------Parcourir un tableau et afficher les elements -----------------        
function print_array($Token){
            
            foreach ( $Token as $cle => $valeur)
                
                echo "[ $cle ]=",$valeur,"<br>";
}

//---------- Enlever Les accent -----------------   
function Unaccent($txt) {
    $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'a' => 'a', 'A' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'a' => 'a', 'A' => 'A', 'a' => 'a', 'A' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', '?' => 'b', '?' => 'B', 'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'ç' => 'c', 'Ç' => 'C', 'd' => 'd', 'D' => 'D', '?' => 'd', '?' => 'D', 'd' => 'd', 'Ð' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'e' => 'e', 'E' => 'E', 'ê' => 'e', 'Ê' => 'E', 'e' => 'e', 'E' => 'E', 'ë' => 'e', 'Ë' => 'E', 'e' => 'e', 'E' => 'E', 'e' => 'e', 'E' => 'E', 'e' => 'e', 'E' => 'E', '?' => 'f', '?' => 'F', 'ƒ' => 'f', 'ƒ' => 'F', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'g' => 'g', 'G' => 'G', 'h' => 'h', 'H' => 'H', 'h' => 'h', 'H' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'i' => 'i', 'I' => 'I', 'j' => 'j', 'J' => 'J', 'k' => 'k', 'K' => 'K', 'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L', 'l' => 'l', 'L' => 'L', '?' => 'm', '?' => 'M', 'n' => 'n', 'N' => 'N', 'n' => 'n', 'N' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'n' => 'n', 'N' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'o' => 'o', 'O' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'o' => 'o', 'O' => 'O', 'o' => 'o', 'O' => 'O', 'ö' => 'oe', 'Ö' => 'OE', '?' => 'p', '?' => 'P', 'r' => 'r', 'R' => 'R', 'r' => 'r', 'R' => 'R', 'r' => 'r', 'R' => 'R', 's' => 's', 'S' => 'S', 's' => 's', 'S' => 'S', 'š' => 's', 'Š' => 'S', '?' => 's', '?' => 'S', 's' => 's', 'S' => 'S', '?' => 's', '?' => 'S', 'ß' => 'SS', 't' => 't', 'T' => 'T', '?' => 't', '?' => 'T', 't' => 't', 'T' => 'T', '?' => 't', '?' => 'T', 't' => 't', 'T' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'u' => 'u', 'U' => 'U', 'û' => 'u', 'Û' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'u' => 'u', 'U' => 'U', 'ü' => 'ue', 'Ü' => 'UE', '?' => 'w', '?' => 'W', '?' => 'w', '?' => 'W', 'w' => 'w', 'W' => 'W', '?' => 'w', '?' => 'W', 'ý' => 'y', 'Ý' => 'Y', '?' => 'y', '?' => 'Y', 'y' => 'y', 'Y' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'z' => 'z', 'Z' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'z' => 'z', 'Z' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', '?' => 'a', '?' => 'a', '?' => 'b', '?' => 'b', '?' => 'v', '?' => 'v', '?' => 'g', '?' => 'g', '?' => 'd', '?' => 'd', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'zh', '?' => 'zh', '?' => 'z', '?' => 'z', '?' => 'i', '?' => 'i', '?' => 'j', '?' => 'j', '?' => 'k', '?' => 'k', '?' => 'l', '?' => 'l', '?' => 'm', '?' => 'm', '?' => 'n', '?' => 'n', '?' => 'o', '?' => 'o', '?' => 'p', '?' => 'p', '?' => 'r', '?' => 'r', '?' => 's', '?' => 's', '?' => 't', '?' => 't', '?' => 'u', '?' => 'u', '?' => 'f', '?' => 'f', '?' => 'h', '?' => 'h', '?' => 'c', '?' => 'c', '?' => 'ch', '?' => 'ch', '?' => 'sh', '?' => 'sh', '?' => 'sch', '?' => 'sch', '?' => '', '?' => '', '?' => 'y', '?' => 'y', '?' => '', '?' => '', '?' => 'e', '?' => 'e', '?' => 'ju', '?' => 'ju', '?' => 'ja', '?' => 'ja');
    return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
}


?>
