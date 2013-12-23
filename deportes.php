<?php
session_start();
$_SESSION=array();
session_unset();
session_destroy();
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
   <script>
        function onSuccess(data, status)
        {
            $("#page").append(data).page();
			
        }
  
        function onError(data, status)
        {
            
        }        
  
        $(document).ready(function() {
            $("#submit").click(function(){
  
                var formData = $("#LoginForm").serialize();
  
                $.ajax({
                    type: "POST",
                    url: "auth.php",
                    cache: false,
                    data: formData,
                    success: onSuccess,
                    error: onError
                });
  
                return false;
            });
        });
    </script>
<body>  
    <div data-role="page" id="first">
        <div data-role="header">
            <h1>Deportes UAI</h1>
        </div>
  
        <div data-role="content" id="page">
            <form id="LoginForm" action="auth.php" method="post" data-ajax="false">
                <div data-role="fieldcontain">
                    <label for="user">Usuario:</label>
                    <input type="text" name="name" id="name" value=""/><br>
                    <label for="password">Clave:</label>
                    <input type="password" name="password" id="password" value=""  />
<input type="submit" value="Entrar" data-theme="a">      </form>
                                    </div>
                    <p style="font-weight: bold;" >Al apretar el botón 'Entrar' aceptas que cualquier problema generado por el uso de la página web es de tú responsabilidad.</font></p>
                    <p>Tus datos en ningún caso son guardados en el servidor, solo se ocupan para que reserves y veas tus asistencias.</p><p><font color="red" size=2>Probado solo para santiago<br>Marcha blanca</font></p>
        </div>
          <div data-theme="a" data-role="footer" data-position="fixed">
                <div data-role="navbar" data-iconpos="top" data-id="menu">
                    <ul>
                        <li>
                            <a href="index.php" rel="external" data-theme="" data-icon="home" 
                         data-transition="none">
                                Salas
                            </a>
                        </li>
                        <li>
                            <a id="bus" href="buses.html" rel="external" data-theme="" data-icon="info" data-transition="none">
                                Buses
                            </a>
                        </li>
                         <li>
                            <a  href="deportes.php" data-theme="" rel"external" class="ui-btn-active  ui-state-persist" data-icon="star" data-transition="none">
                                Deportes (beta)
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
    </div>
    
</body>
</html>