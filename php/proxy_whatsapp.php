<?php
include('simple_html_dom.php');
$url = 'http://agenda.uai.cl/clasesRotativa.aspx?codUbicacion=131o132o133o147&bannerWidth=0&tamanoLetra=24px&numFilas=600&frecuenciaSegundosHorarios=10&diasAdelanto=0&mostrarFinalizados=false&codUso=53o55o57o60o61o63o66o67o69o70';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$output = preg_replace('/.*(<div id="profile"[^>]+>)/msi','$1',$output);
$output = preg_replace('/<hr.>.*/msi','',$output);
$fp = fopen("horario_whatsapp.txt", "w");
// Create DOM from URL or file
$html = str_get_html($output);
// Buscar Horas
foreach($html->find('span[id*=Label1]') as $element) {
        $modulo[]=$element->plaintext;				
}
// Buscar Ramos
foreach($html->find('span[id*=Label2]') as $element) 
        $ramo[]=$element->plaintext;		
// Buscar Sala
foreach($html->find('span[id*=Label3]') as $element) 
		$sala[]=$element->plaintext;		
		while($j<count($modulo)) { 			 			
					fwrite($fp,$modulo[$j]."/".$ramo[$j]."/".$sala[$j]."\n\n");
		 		 $j++;
		}
		fclose($fp);
?>
</html>