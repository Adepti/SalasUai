<?php
if (isset($_SESSION)){
session_unset();
session_destroy();
}
else {
session_start();
/************************************************
* ASP.NET web site scraping script;
* Developed by MishaInTheCloud.com
* Copyright 2009 MishaInTheCloud.com. All rights reserved.
* The use of this script is governed by the CodeProject Open License
* See the following link for full details on use and restrictions.
*   http://www.codeproject.com/info/cpol10.aspx
*
* The above copyright notice must be included in any reproductions of this script.
************************************************/
include('simple_html_dom.php');
$usr = $_POST["name"];
$pwd = $_POST["password"];
/************************************************
* values used throughout the script
************************************************/
// urls to call - the login page and the secured page
$urlLogin = "http://pregrado.uai.cl";
$urlSecuredPage = "http://pregrado.uai.cl/WebPages/Deporte/AsistenciaDeporte.aspx";
// POST names and values to support login
$nameUsername='wucLogin1$Login1$UserName';       // the name of the username textbox on the login form
$namePassword='wucLogin1$Login1$Password';       // the name of the password textbox on the login form
$nameLoginBtn='wucLogin1$Login1$LoginButton';          // the name of the login button (submit) on the login form
$valUsername = $usr  ;      // the value to submit for the username
$valPassword = $pwd ;        // the value to submit for the password
$valLoginBtn ='Log In';             // the text value of the login button itself

// the path to a file we can read/write; this will
// store cookies we need for accessing secured pages
$cookies = '\cookie.txt';

// regular expressions to parse out the special ASP.NET
// values for __VIEWSTATE and __EVENTVALIDATION
$regexViewstate = '/__VIEWSTATE\" value=\"(.*)\"/i';
$regexEventVal  = '/__EVENTVALIDATION\" value=\"(.*)\"/i';


/************************************************
* utility function: regexExtract
*    use the given regular expression to extract
*    a value from the given text;  $regs will
*    be set to an array of all group values
*    (assuming a match) and the nthValue item
*    from the array is returned as a string
************************************************/
function regexExtract($text, $regex, $regs, $nthValue)
{
if (preg_match($regex, $text, $regs)) {
 $result = $regs[$nthValue];
}
else {
 $result = "";
}
return $result;
}



/************************************************
* initialize a curl handle; we'll use this
*   handle throughout the script
************************************************/
$ch = curl_init();


/************************************************
* first, issue a GET call to the ASP.NET login
*   page.  This is necessary to retrieve the
*   __VIEWSTATE and __EVENTVALIDATION values
*   that the server issues
************************************************/
curl_setopt($ch, CURLOPT_URL, $urlLogin);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$data=curl_exec($ch);

// from the returned html, parse out the __VIEWSTATE and
// __EVENTVALIDATION values
$viewstate = regexExtract($data,$regexViewstate,$regs,1);
$eventval = regexExtract($data, $regexEventVal,$regs,1);


/************************************************
* now issue a second call to the Login page;
*   this time, it will be a POST; we'll send back
*   as post data the __VIEWSTATE and __EVENTVALIDATION
*   values the server previously sent us, as well as the
*   username/password.  We'll also set up a cookie
*   jar to retrieve the authentication cookie that
*   the server will generate and send us upon login.
************************************************/
$postData = '__VIEWSTATE='.rawurlencode($viewstate)
          .'&__EVENTVALIDATION='.rawurlencode($eventval)
          .'&'.$nameUsername.'='.$valUsername
          .'&'.$namePassword.'='.$valPassword
          .'&'.$nameLoginBtn.'='.$valLoginBtn
          ;

curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_URL, $urlLogin);   
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
$data = curl_exec($ch);
/************************************************
* with the authentication cookie in the jar,
* we'll now issue a GET to the secured page;
* we set curl's COOKIEFILE option to the same
* file we used for the jar before to ensure the
* authentication cookie is sent back to the
* server
************************************************/
curl_setopt($ch, CURLOPT_POST, FALSE);
curl_setopt($ch, CURLOPT_URL, $urlSecuredPage);   
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);     
$data = curl_exec($ch);
$postData = '__EVENTTARGET=rgReservas%24ctl00%24ctl50%24lnkReservar&__EVENTARGUMENT=&__VIEWSTATE='.rawurlencode($viewstate).'&__EVENTVALIDATION='.rawurlencode($eventval).'&rgReservas_ClientState=';
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_URL,"http://deportes.uai.cl/deportes/ReservaAsistencias/ReservarClase.aspx?rut=MTgwMjU3NTd8MzAtMDgtMjAxMyAxMTozMzoyMg%3d%3d&"); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);       
curl_exec($ch);
curl_close($ch);
echo $postData;
// at this point the secured page may be parsed for
// values, or additional POSTS made to submit parameters
// and retrieve data.  For this sample, we'll just
// echo the results.
/************************************************
* that's it! Close the curl handle
************************************************/
// Create DOM from URL or file
$html = str_get_html($data);
foreach($html-> find('iframe') as $a) {
	$link= $a->src;
}
if ($link == NULL) {
	echo '<script type="text/javascript">
	 alert("Clave/Usuario erronea, ingresa solo tu nombre de usuario sin @alumnos.uai.cl");
				window.location = "deportes.php"
</script>';
}
else {
	$user = $html->find('#ctl00_txtUserLog') ;
	$link=parse_url($link);
	$_SESSION['USER']=$user[0]->innertext;
	$_SESSION['QUERY']=$link['query'];
	//echo '<script type="text/javascript">
//<!--
//window.location = "reservar.php"
//-->
//</script>';
	
}
}
?>