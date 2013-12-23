<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confesiones UAI</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
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
<head>
<body>
<div data-role="page" id="confesiones">
<div data-role="header" data-position="fixed">
	<h1>Confesiones UAI</h1>
</div>
    <div data-role="content">
        <ul data-role="listview" data-divider-theme="b" data-inset="true">
<?php
function fetchUrl($url){

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_TIMEOUT, 20);
 // You may need to add the line below
 // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

 $feedData = curl_exec($ch);
 curl_close($ch); 

 return $feedData;

}

$profile_id = "261714223969633";

//App Info, needed for Auth
$app_id = "481755348556778";
$app_secret = "10cf7c4070fa6e0fffaece8c69e66aec";

//Retrieve auth token
$authToken = fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");
$limit=40;
$json_object = fetchUrl("https://graph.facebook.com/{$profile_id}/feed?fields=message&limit={$limit}&{$authToken}");
$feedarray = json_decode($json_object);
foreach ( $feedarray->data as $feed_data )
{
	if (strpos($feed_data->message,'#') ) {
    echo "<li data-theme='c'>{$feed_data->message}</li>";
	}
}
?>
        </ul>
    </div>
    <div data-role="navbar" data-position="fixed">
    <ul>
        <li><a href="#confesiones" class="ui-btn-active ui-state-persist">Confesiones</a></li>
        <li><a href="https://docs.google.com/forms/d/1Iyjhss0ec1wQryIEyLdvXe54bQAwkByrEAAt2cTyvkM/viewform" data-ajax=false>Envíar Confesión</a></li>
    </ul>
</div><!-- /navbar -->
</div>
</body>
</html>