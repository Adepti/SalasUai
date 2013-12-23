<?php
include('simple_html_dom.php');
$url = 'http://agenda.uai.cl/clasesRotativa.aspx?codUbicacion=131o132&bannerWidth=0&tamanoLetra=24px&numFilas=600&frecuenciaSegundosHorarios=10&diasAdelanto=0&mostrarFinalizados=false&codUso=53o55o57o60o61o63o66o67o69o70';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$output = preg_replace('/.*(<div id="profile"[^>]+>)/msi','$1',$output);
$output = preg_replace('/<hr.>.*/msi','',$output);
$fp = fopen("horario_temp_pre.html", "w");
// Create DOM from URL or file
$html = str_get_html($output);
// Buscar Horas
foreach($html->find('span[id*=Label1]') as $element) {
        $modulo[]='<li data-role="list-divider">Modulo: '.$element->plaintext.'</li>';				
}
if ($modulo == null) {
	fwrite($fp,'<li>No hay horarios disponibles aun.<br>Ultima actualización : <font color=blue>'.date("H:i:s d-m", strtotime("+1 hour")).'</font></li>');
	fclose($fp);;
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
$j=0; //indice aux
$k=0;
$modulonorep=array_unique($modulo);
		while($j<count($modulo)) {
		 if ($modulorep[$j]!=$modulo[$j+1]) {
					fwrite($fp,$modulonorep[$k].$ramo[$j].$sala[$j]);
			 $k++;
		 }
		 else {   
		 		    fwrite($fp,$modulonorep[$k].$ramo[$j].$sala[$j]);
		 }
		 		 $j++;
		}
		fclose($fp);
?>
</html>