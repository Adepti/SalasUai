<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="http://srv6.cpanelhost.cl/~cto4361/santiago/img/apple-touch-icon-precomposed.png" rel="apple-touch-icon-precomposed" />
        <link href="img/logo.png" rel="apple-touch-icon-precomposed" />
		<link href="img/logo.png" rel="apple-touch-icon-precomposed" sizes="72x72" />
		<link href="img/logo.png" rel="apple-touch-icon-precomposed" sizes="114x114" />
		<link href="img/logo.png" rel="apple-touch-icon-precomposed" sizes="144x144" />
        <title>Salas UAI</title>
         <style type="text/css">
		 body  * {
 white-space:normal;
  }
  .text-align-center {
  			text-align: center;
		}
  .text-align-right {
  			text-align: right;
		}
		#no-results {
   			 display : none;
		}
 		</style>
        <link rel="stylesheet" href="css/jquery.mobile-1.4.0-alpha.1.min.css" />
        <link rel="stylesheet" href="css/jquery.jgrowl.css" />
        <script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/jquery.mobile-1.4.0-alpha.1.min.js"></script>
        <script src="js/jquery.mobile-1.4.0-alpha.1.theme.js"></script>
        <script src="js/jquery.jgrowl.js"></script>
        <script src="js/jquery_cookie.js"></script>
		<script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-30603139-1']);
			  _gaq.push(['_setDomainName', '<?php
echo $_SERVER['SERVER_NAME'];
?>']);
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
            <div data-role="page" id="Salas">
                <div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1&appId=481755348556778";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

            <div data-role="panel" data-position="right" data-position-fixed="true" data-display="overlay" data-theme="a" id="nav-options">
              <ul data-role="listview" data-theme="a" class="nav-search">
                    <li data-icon="delete"><a href="#" data-rel="close">Cerrar Menu</a></li>
                </ul>
                                 <form id="sede">
                    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                    <legend><br>Seleccionar Sede: </legend>
        		    <input type="radio" data-theme="c" name="radio-choice-t-6" id="radio-choice-t-6a" checked>
        			<label for="radio-choice-t-6a">Stgo</label>
                    <input type="radio" data-theme="c" name="radio-choice-t-6" id="radio-choice-t-6b" value="off">
                    <label for="radio-choice-t-6b">Viña</label>
    				</fieldset>
                    </form>
                     <form id="edificio">
                    <fieldset data-role="controlgroup" data-type="horizontal">
                        <legend><br>Seleccionar Edificio:</legend>
                        <input type="checkbox" id="pre" value="pre" checked>
                            <label for="pre">A | B</label>
                        <input type="checkbox" id="talleres" value="talleres" checked>
                            <label for="talleres">D | E</label>
                        <input type="checkbox" id="post" value="post" checked>
                            <label for="post">C</label>
                                </fieldset>
                </form>
                <br>
                              	<ul data-role="listview" data-theme="a">
                                    <li><a data-rel="dialog" href="#about" >Acerca de</a></li>
                                    </ul><br>
                                                    <div class="fb-like" data-href="http://srv6.cpanelhost.cl/~cto4361/" data-send="false" data-layout="button_count" data-width="500" data-show-faces="true" data-font="arial"></div>
                                   
                </div>
            <div data-role="panel" data-position-fixed="true" data-theme="a" id="nav-panel">
                    <ul data-role="listview" data-theme="a" class="nav-search2">
                    <li data-icon="delete"><a href="#" data-rel="close">Cerrar Menu</a></li><br>
                    <li><a rel="external" href="http://www.salasuai.com/confesiones">Confesiones UAI</a></li>
                    <li><a rel="external" href="http://webcursos.uai.cl">Webcursos 4.0</a></li>
                    <li><a rel="external" href="http://pregrado.uai.cl">Intranet</a></li>
                    <li><a rel="external" href="https://alumnos.uai.cl">Mail</a></li>
                    <li><a rel="external" href="http://agenda.uai.cl">Salas de Estudio</a></li>
                    <li><a rel="external" href="http://primo.gsl.com.mx:1701/primo_library/libweb/action/search.do?dscnt=1&fromLogin=true&dstmp=1363322648595&vid=UAI&fromLogin=true">Biblioteca</a></li>
                     <li><a rel="external" href="http://www.uai.cl">UAI</a></li>
                </ul>
            </div><!-- /panel -->
            <div data-theme="a" data-role="header" id="foot" data-position="fixed">
                <h3>
                    Salas UAI  
                </h3>
                <a href="#nav-panel" data-theme="c" data-iconpos="notext" data-icon="bars">Más</a>
                <a href="#nav-options" data-theme="c" data-iconpos="notext" data-icon="gear">Opciones</a>
            </div>
            <div data-role="content" id="horarios">
            <ul data-role="listview" id="horario" AlignParentTop = "true" data-filter-placeholder="Buscar..."data-filter="true">
            </ul>
            </div>
            <div data-theme="a" data-role="footer" data-position="fixed">
                <div data-role="navbar" data-iconpos="top" data-id="menu">
                    <ul>
                        <li>
                            <a href="index.php" rel="external" data-theme="" data-icon="home" class="ui-btn-active  ui-state-persist" data-transition="none">
                                Salas
                            </a>
                        </li>
                        <li>
                            <a id="bus" href="buses.html" rel="external" data-theme="" data-icon="info" data-transition="none">
                                Buses
                            </a>
                        </li>
                         <li>
                            <a  href="deportes.php" data-theme="" data-icon="star" data-transition="none">
                                Deportes
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
                    </div>
                     </div>
        <div data-role="dialog" id="about">
            <div data-role="header">
                <h1>Acerca De</h1>
            </div><!-- /header -->
            <div data-role="content">
                <p>Esta página web fue creada con jQuery Mobile con el fin de facilitar información a los alumnos de la UAI.</p>
                <p>Cualquier error que encuentren avisar a mi <a href="mailto:flolas@alumnos.uai.cl">mail</a>.</p>
                <p>No me responsabilizo por problemas que puedan ocasionar los posibles errores contenidos en la página.</p>
                <p><font size=1>Desarrollado por Felipe Lolas</font><br>
                <font size=1>Optimizado para iPhone</font><br>
                <font size=1>Versión 0.9.5b</font></p>
                
            </div><!-- /content -->
        </div><!-- /page -->
    </body>
</html>