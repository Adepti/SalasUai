<?php
include('simple_html_dom.php');
$url = 'http://agenda.uai.cl/clasesRotativa.aspx?codUbicacion=131o132o133&bannerWidth=0&tamanoLetra=10px&numFilas=600&frecuenciaSegundosHorarios=10&diasAdelanto=0&mostrarFinalizados=false&codUso=53o55o57o60o61o63o66o67o69o70';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$output = preg_replace('/.*(<div id="profile"[^>]+>)/msi','$1',$output);
$output = preg_replace('/<hr.>.*/msi','',$output);
$fp = fopen("horario_temp_all.html", "w");
// Create DOM from URL or file
$html = str_get_html($output);
// Buscar Horas
foreach($html->find('span[id*=Label1]') as $element) {
        $modulo[]='<li data-role="list-divider">Modulo: '.$element->plaintext.'</li>';				
}
if ($modulo == null) {
	exit;
}
// Buscar Ramos
foreach($html->find('span[id*=Label2]') as $element) 
		$ramo[]='<li><font size="2" color="black">'.$element->plaintext.' ';		
// Buscar Profesores
//foreach($html->find('span[id*=Label4]') as $element) 
	//	$profe[]='Prof. '.$element->plaintext;
// Buscar Salas
foreach($html->find('span[id*=Label3]') as $element) 
		$sala[]='<br>Sala: </font><font size="2" color="blue">'.$element->plaintext.'</font></li>';
$j=1; //indice aux
fwrite($fp,$modulo[0].$ramo[0].$sala[0]);
$modulonorep=array_unique($modulo);
if(count($modulo)>1){
		while($j<count($modulo)) {
		 if ($modulo[$j]!=$modulo[$j-1]) {
					fwrite($fp,$modulo[$j].$ramo[$j].$sala[$j]);
			 $k++;
		 }
		 else {     			 			
					fwrite($fp,$ramo[$j].$sala[$j]);
		 }
		 		 $j++;
		}
}
		fclose($fp);
		echo count($ramo);
?>
</html>