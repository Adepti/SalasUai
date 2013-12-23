<?php
session_start();
include('simple_html_dom.php');
$asistencia=26;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    // last request was more than 2 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
if(!isset($_SESSION['USER']) or !isset($_SESSION['QUERY'])) {
	exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>
<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Deportes UAI</title>
  <link rel="stylesheet" href="css/jquery.mobile-1.4.0-alpha.1.min.css" />
        <script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/jquery.mobile-1.4.0-alpha.1.min.js"></script>
      <script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-30603139-1']);
			  _gaq.push(['_setDomainName', 'salasuai.com']);
			  _gaq.push(['_setAllowLinker', true]);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
			
			</script>
</head>
<body>
<div data-role="page" id="first">
        <div data-role="header">
            <h1>Deportes UAI</h1>
            <a href="deportes.php" data-icon="delete" data-ajax="false" data-theme="c">Salir</a>
            <div class="ui-bar ui-bar-b">
    <h7><center>Conectado como: <?php echo $_SESSION['USER'];?></center></h7>
</div>
        </div>
        <div data-role="content" id="page">
        <div id="asistencias">
<?php
$urlPostback = 'http://deportes.uai.cl/deportes/ReservaAsistencias/ListaAsistenciasAlumno.aspx?rut='.$_SESSION['QUERY'];
function sendCurl( $pag, $ispost=false, $cookie="" )
{
	$options = array(
        CURLOPT_RETURNTRANSFER => true,             // return web page
        CURLOPT_HEADER         => false,            // don't return headers
        CURLOPT_FOLLOWLOCATION => true,             // follow redirects
       CURLOPT_ENCODING       => "",               // handle all encodings
        CURLOPT_AUTOREFERER    => true,             // set referer on redirect
       CURLOPT_CONNECTTIMEOUT => 120,              // timeout on connect
      CURLOPT_TIMEOUT        => 120,              // timeout on response
        CURLOPT_MAXREDIRS      => 10,               // stop after 10 redirects
        CURLOPT_USERAGENT      => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
       CURLOPT_REFERER        => $pag,
        CURLOPT_HTTPHEADER     => array(
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Accept-Encoding: gzip,deflate",
          "Accept-Language: en-us,en;q=0.5",
           "Connection: Keep-Alive",
           "Content-Type: text/xml; charset=utf-8",
           "Expect: 100-continue",
           "Keep-Alive: 115")
                       // These headers were extracted from a DNN POST request using Firefox's Live HTTP Headers plugin
 
    );
 $postData = 'ScriptManager1='.$ScriptManager1
          .'&__EVENTTARGET='.$EventTarget;
		  //ScriptManager1=rgReservasPanel%7CrgReservas%24ctl00%24ctl04%24lnkReservar
		  //__EVENTTARGET=rgReservas%24ctl00%24ctl04
   if($ispost) {
        $options[CURLOPT_POST] = 1;
          ;        // its a post request
     $options[CURLOPT_POSTFIELDS] = $postData;   // data for post request
   }	  
   $ch      = curl_init( $pag );
   curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
   $header  = curl_getinfo( $ch );
   curl_close( $ch );
 
    $header['errno']   = $err;
   $header['errmsg']  = $errmsg;
   $header['content'] = $content;
    return $header;
}
$postback = sendCurl($urlPostback, true,"");
if($postback['errno'] != 0 or $postback['http_code'] != 200) {
	echo 'Error Desconocido.<br>';
}
else
{	
$html = str_get_html($postback['content']);
$Asistencia['Horas'] = $html->find('#lblHorasRegistradas');
$Asistencia['Inicio'] = $html->find('#lblInicioSemestre');
$Asistencia['Fin'] = $html->find('#lblTerminoSemestre');
echo '<div data-role="header" data-theme="a" class="ui-header ui-bar ui-grid-b">
  <div class="ui-block-a" ><center>Asistencias</centetr></div>
  <div class="ui-block-b"><center>Debes llevar</center></div>
  <div class="ui-block-c"><center>Tienes Hasta</center></div>
  <div class="ui-block-a" style="color:black;""><center >'.$Asistencia['Horas'][0].'</centetr></div>
  <div class="ui-block-b" style="color:black;"><center>'.$asistencia.'</center></div>
  <div class="ui-block-c" style="color:black;"><center>'.$Asistencia['Fin'][0].'</center></div>
</div></div>';//Asistencias totales


foreach($html-> find('td[style="width:80px;"]') as $s) {
		$Mes[]=$s->plaintext;//Mes
}
foreach($html-> find('*[id*=FechaLabel]') as $s) {
		$Fecha[]= $s->plaintext;//Fecha
}
foreach($html-> find('td[style="width:150px;"]') as $s) {
		$Deporte[]= $s->plaintext;//Deporte
}
foreach($html-> find('*[id*=HoraValidaLabel]') as $s) {
		$Asistencia[]= $s->plaintext;//Asistencia
		
}
echo'<div id="lista"><div data-role="collapsible-set">';
$j=1; //indice aux
echo ' <div data-role="collapsible">
                        <h3>
                            '.$Mes[0].'
                        </h3>
                        <ul data-role="listview" data-divider-theme="a" data-inset="false">
                            <li data-role="list-divider" role="heading">
                                '.$Fecha[0].'
                            </li>
                            <li data-theme="c">
                                <b>'.$Deporte[0].'</b>
                                <span class="ui-li-count">
                                    '.$Asistencia[0].' Asistencia
                                </span>
                            </li>
                        </ul>';
$Mesnorep=array_unique($Mes);
if(count($Mes)>1){
		while($j<count($Mes)) {
		 if ($Mes[$j]!=$Mes[$j-1]) {
			 echo ' </div><div data-role="collapsible">
                        <h3>
                            '.$Mesnorep[$j].'
                        </h3>
                        <ul data-role="listview" data-divider-theme="a" data-inset="false">
                            <li data-role="list-divider" role="heading">
                                '.$Fecha[$j].'
                            </li>
                            <li data-theme="c">
                                <b>'.$Deporte[$j].'</b>
                                <span class="ui-li-count">
                                    '.$Asistencia[$j].' Asistencia
                                </span>
                            </li>
                        </ul>';					
		 }
		 else {    
		 			if($j+1==count($Mes)){
													 echo '
                        <ul data-role="listview" data-divider-theme="a" data-inset="false">
                            <li data-role="list-divider" role="heading">
                                '.$Fecha[$j].'
                            </li>
                            <li data-theme="c">
                                <b><b>'.$Deporte[$j].'</b></b>
                                <span class="ui-li-count">
                                    '.$Asistencia[$j].' Asistencia
                                </span>
                            </li>
                        </ul></div>';	}
						else { 			 				
								 echo '
                        <ul data-role="listview" data-divider-theme="a" data-inset="false">
                            <li data-role="list-divider" role="heading">
                                '.$Fecha[$j].'
                            </li>
                            <li data-theme="c">
                                <b><b>'.$Deporte[$j].'</b></b>
                                <span class="ui-li-count">
                                    '.$Asistencia[$j].' Asistencia
                                </span>
                            </li>
                        </ul>';	
						}
					
		 }
		 		 $j++;
		}
}
}
?>
</div>
</div>
    </div>
        <div data-theme="a" data-role="footer" data-position="fixed">
                <div data-role="navbar" data-iconpos="top" data-id="menu">
                    <ul>
                        <li>
                            <a href="reservar.php" rel="external" data-theme="" data-icon="home" data-transition="none">
                                Reservar
                            </a>
                        </li>
                        <li>
                            <a href="asistencias.php" rel="external" data-theme="" data-icon="info" class="ui-btn-active  ui-state-persist"  data-transition="none">
                                Asistencias
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    </div>
</body>
</html>