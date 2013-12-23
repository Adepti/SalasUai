<?php
// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
// The JSON standard MIME header.
header('Content-type: application/json');
include('simple_html_dom.php');
$key = $_GET['key'];
if ($key != "q1w2e3r4") {
	echo json_encode(Array("status"=>"bad key"));
	exit();
}
$ub=$_GET['cub'];
function getSalas($ubicacion) {
$output = @file_get_contents('/get/horario_temp_'.$ubicacion.'.html', FILE_USE_INCLUDE_PATH);
if ($output == null) {
		echo json_encode(Array("status"=>"missing cub"));
	exit;
	}
//$output = preg_replace('/.*(<div id="profile"[^>]+>)/msi','$1',$output);
//$output = preg_replace('/<hr.>.*/msi','',$output);
// Create DOM from URL or file
$html = str_get_html($output);
// Buscar Horas
foreach($html->find('span[id*=Label1]') as $element) {
        $modulo[]=$element->plaintext;			
}
if ($modulo == null) {
		echo json_encode(Array("status"=>"empty data"));
	exit;
	}
// Buscar Ramos
foreach($html->find('span[id*=Label2]') as $element) 
		$ramo[]=$element->plaintext;		
// Buscar Profesores[POR IMPLEMENTAR]
// Buscar Salas
foreach($html->find('span[id*=Label3]') as $element) 
		$sala[]=$element->plaintext;
$j=0; //indice aux
$k=0;
$row=0;
$modulonorep=array_unique($modulo);
		while($j<count($modulo)) {
		 if ($modulorep[$j]!=$modulo[$j+1]) {
			 if ($modulonorep[$k] == "" ) {
				 $modulogroup[$modulo[$k]][$row]["ramo"]=$ramo[$j];
				 $modulogroup[$modulo[$k]][$row]["profe"]="NN";
				 $modulogroup[$modulo[$k]][$row]["sala"]=$sala[$j];
			 }
			 else {
				 $row=0;
					$modulogroup[$modulonorep[$k]][$row]["ramo"]=$ramo[$j];
				    $modulogroup[$modulonorep[$k]][$row]["profe"]="NN";
					$modulogroup[$modulonorep[$k]][$row]["sala"]=$sala[$j];
			 }
			 $k++;
			 $row++;
		 }
		 else {   
		 if ($j+1!=count($modulo)) {
			 $row=0;
		 }
					$modulogroup[$modulo[$k]][$row]["ramo"]=$ramo[$j];
					$modulogroup[$modulo[$k]][$row]["profe"]="NN";		
					$modulogroup[$modulo[$k]][$row]["sala"]=$sala[$j];		 
					
			   }
		 		 $j++;
		}
		return $modulogroup;
}
$modulos = getSalas($ub);
echo json_encode($modulos,true);
?>