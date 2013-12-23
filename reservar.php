<?php
session_start();
if(!isset($_SESSION['USER']) or !isset($_SESSION['QUERY'])) {
	exit();
}
include('simple_html_dom.php');
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    // last request was more than 2 minutes ago
	$_SESSION[]= array();
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
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
<script>
 $(document).ready(function() {
	 
$('a.postback[id*="Reservar"]').click(function() {
   var postback = $(this).attr('id');
   var vw=document.getElementById('qw').value;
   var vv=document.getElementById('vv').value;
                $.ajax({
                    type: "POST",
                    url: "reservame.php",
					beforeSend: function() { $.mobile.showPageLoadingMsg("a", "Reservando Deporte..."); },
                    complete: function() { $.mobile.hidePageLoadingMsg()}, 
                    cache: false,
                    data:  { poste: postback, viewevent:vw, eventvalidation:vv},
                    success: function(data, status){location.reload( true );},
				});
});
$("a.cancelar").click(function() {
   var postback = $('a[id*=Cancelar]').attr('id');
   var vw=document.getElementById('qw').value;
   var vv=document.getElementById('vv').value;
                $.ajax({
                    type: "POST",
                    url: "reservame.php",
					beforeSend: function() { $.mobile.showPageLoadingMsg("a", "Cancelando Reserva..."); },
                    complete: function() { $.mobile.hidePageLoadingMsg()}, 
                    cache: false,
                    data:  { poste: postback, viewevent:vw, eventvalidation:vv},
                    success: function(data, status){location.reload( true );},
                });
});
});
  
</script>
<div data-role="page" id="first">
        <div data-role="header">
            <h1>Deportes UAI</h1>
            <a href="deportes.php" data-icon="delete" data-ajax="false" data-theme="c">Salir</a>
            <div class="ui-bar ui-bar-b">
    <h7><center>Conectado como: <?php echo $_SESSION['USER'];?></center></h7>
</div>
        </div>
        <div data-role="content" id="page">
<?php
$urlPostback = 'http://deportes.uai.cl/deportes/ReservaAsistencias/ReservarClase.aspx?rut='.$_SESSION['QUERY'];
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
        CURLOPT_USERAGENT      => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1",
       CURLOPT_REFERER        => $pag,
        CURLOPT_HTTPHEADER     => array(
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Accept-Encoding: gzip,deflate",
          "Accept-Language: es-es,en;q=0.5",
           "Connection: Keep-Alive",
		   "Origin: http://deportes.uai.cl".
           "Content-Type: application/x-www-form-urlencoded; charset=utf-8",
           "Expect: 100-continue",
           "Keep-Alive: 115")
                       // These headers were extracted from a DNN POST request using Firefox's Live HTTP Headers plugin
 
    );
   $ch      = curl_init( $pag );
   curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
   $header  = curl_getinfo( $ch );
 
    $header['errno']   = $err;
   $header['errmsg']  = $errmsg;
   $header['content'] = $content;
      curl_close($ch);

    return $header;
}
$postback = sendCurl($urlPostback, true,"");
if($postback['errno'] != 0 or $postback['http_code'] != 200) {
	echo 'Error desconocido! Intenta nuevamente<br>';
	echo $_SESSION['QUERY'];
}
else
{
$html = str_get_html($postback['content']);
foreach($html-> find('table[width="495px"]') as $s) {
	$Asistencia['Deporte'] = $html->find('#lblNombreDeporte');
	$Asistencia['HoraInicio'] = $html->find('#lblHoraInicio');
	$Asistencia['ReservaHasta'] = $html->find('#lblHoraReserva');
	$Asistencia['ReservaTermino'] = $html->find('#lblTerminoReservas');
	$Asistencia['MinutosCastigo'] = $html->find('#lblTiempoReserva');
}
if ($Asistencia['Deporte'] != null) { 
echo '                    <div data-role="collapsible" data-collapsed="false" data-theme="e">
                        <h3>
                            Reserva Actual
                        </h3>
                        <ul data-role="listview" data-divider-theme="a" data-inset="false">
                            <li data-role="list-divider" role="heading">
                                Deporte:
                            </li>
                            <li data-theme="c">
                                '.$Asistencia['Deporte'][0].'
                            </li>
                            <li data-role="list-divider" role="heading">
                                Hora Inicio:
                            </li>
                            <li data-theme="c">
                               '.$Asistencia['HoraInicio'][0].'
                            </li>
                            <li data-role="list-divider" role="heading">
                                Hora de Reserva:
                            </li>
                            <li data-theme="c">
                                '.$Asistencia['ReservaHasta'][0].'
                            </li>
						    <li data-role="list-divider" role="heading">
                                Fin de Reserva:
                            </li>
                            <li data-theme="c">
                                '.$Asistencia['ReservaTermino'][0].'
                            </li>
							 <li data-theme="c">
                                '.$Asistencia['MinutosCastigo'][0].'
                            </li>
							<li data-role="list-divider" role="heading">
                            </li>
                        </ul>
                        <ul data-role="listview" data-divider-theme="a" data-inset="false">
                            <li data-theme="e">
                                <a href="#" class="cancelar" data-transition="none">
                                    Cancelar Reserva
                                </a>
                            </li>
                        </ul>
                    </div>
                ';
}
foreach($html-> find('td[style="text-align:left;"]') as $s) {
	$norecords[]=$s->plaintext;//norecords
}
if ($norecords[0] != ""){
	echo ' <ul data-role="listview" data-divider-theme="a" data-inset="true">
                    <li data-role="list-divider" role="heading">
                    </li>
                    <li data-theme="c">
                        <a href="#" data-transition="none">
                            No hay deportes disponibles.
                            <span class="ui-li-count">
                                0
                            </span>
                        </a>
                    </li></ul>';
}
else
{
	$row=0;
	$i=0;
		foreach($html ->find('input') as $d) {
	     $input[]=$d->value;
		}
	echo '<input type="hidden" id="qw" value="'.$input[2].'">';
	echo '<input type="hidden" id="vv" value="'.$input[3].'">';
	foreach($html-> find('tr[class*=Row]') as $s) {
		foreach($s ->find('span[id$=HoraInicio1]') as $d) {
	    $HoraInicio[]=$d->plaintext;
		}
	    foreach($s ->find('span[id$=HoraTermino1]') as $d) {
	    $HoraFin[]=$d->plaintext;
		}
		$aux=0;
		$i=0;
	    foreach($s ->find('td') as $d) {
			if ($aux>2 and $aux<11){
			}
			else{
				if($i%2 == 0){
					 $Profesor[$row]=$d->plaintext.'<br>';
				}
				else {
					 $Deporte[$row]=$d->plaintext.'<br>';

				}
				$i++;
			}
	    $aux++;
		}
        foreach($s ->find('span[id*=Cupo]') as $d) {
			if ($d->plaintext == "Sin Cupo ") {
				$Cupo[]=$d->plaintext.'disponible';
			}
			else
			{
				$Cupo[]=preg_replace('/-/', 'de',$d->plaintext).' Cupos';
			}
		}
		foreach($s ->find('a') as $d) {
	    $PostBack[]=$d->href;
		}
	$row++;
}
echo ' <ul data-role="listview" data-divider-theme="a" data-inset="true">
                    <li data-role="list-divider" role="heading">
					'.$HoraInicio[0].' - '.$HoraFin[0].'
                    </li>
                    <li data-theme="c">
                        <a href="#" id="'.$PostBack[0].'" class="postback" data-transition="none">
                            <font size=3>'.$Deporte[0].'</font><br><font size=2>Prof: </font><font size=2 color="blue">'.$Profesor[0].'</font>
                            <span class="ui-li-count">
                                '.$Cupo[0].'
                            </span>
                        </a>
                    </li>';
$j=1;				
$Horanorep=array_unique($HoraInicio);
if(count($HoraInicio>1)){
		while($j<count($HoraInicio)) {
		 if ($HoraInicio[$j]!=$HoraInicio[$j-1]) {
echo ' </ul><ul data-role="listview" data-divider-theme="a" data-inset="true">
                    <li data-role="list-divider" role="heading">
					'.$HoraInicio[$j].' - '.$HoraFin[$j].'
                    </li>
                    <li data-theme="c">
                             <a href="#" id="'.$PostBack[$j].'" class="postback" data-transition="none">
                            <font size=3>'.$Deporte[$j].'</font><br><font size=2> Prof: </font><font size=2 color="blue">'.$Profesor[$j].'</font>
                            <span class="ui-li-count">
                                '.$Cupo[$j].'
                            </span>
                        </a>
                    </li>';				
		 }
		 else {    
		 			if($j+1==count($HoraInicio)){
			echo ' 
                                      <li data-theme="c">
                             <a href="#" id="'.$PostBack[$j].'" class="postback" data-transition="none">
                            <font size=3>'.$Deporte[$j].'</font><br><font size=2>Prof: </font><font size=2 color="blue">'.$Profesor[$j].'</font>
                            <span class="ui-li-count">
                                '.$Cupo[$j].'
                            </span>
                        </a>
                    </li></ul>';			}
						else { 			 				
			echo ' 
                                  <li data-theme="c">
                             <a href="#" id="'.$PostBack[$j].'" class="postback" data-transition="none">
                            <font size=3>'.$Deporte[$j].'</font><br><font size=2>Prof: </font><font size=2 color="blue">'.$Profesor[$j].'</font>
                            <span class="ui-li-count">
                                '.$Cupo[$j].'
                            </span>
                        </a>
                    </li>';	
						}
					
		 }
		 		 $j++;
		}
}	
}
}
?>
    </div>
    
        <div data-theme="a" data-role="footer" data-position="fixed">
                <div data-role="navbar" data-iconpos="top" data-id="menu">
                    <ul>
                        <li>
                            <a href="reservar.php" rel="external" data-theme="" data-icon="home" class="ui-btn-active  ui-state-persist" data-transition="none">
                                Reservar
                            </a>
                        </li>
                        <li>
                            <a href="asistencias.php"  data-theme="" data-icon="info" data-transition="none">
                                Asistencias
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    </div>
</body>
</html>