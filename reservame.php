<?php
session_start();
if(!isset($_SESSION['USER']) or !isset($_SESSION['QUERY'])) {
	exit();
}
$callback=explode( "'", $_POST["poste"]);
$callback=$callback[1];
$viewstate = $_POST["viewevent"];
$eventvalidation= $_POST["eventvalidation"];
$urlPostback = 'http://deportes.uai.cl/deportes/ReservaAsistencias/ReservarClase.aspx?rut='.$_SESSION['QUERY'];

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
/************************************************
* values used throughout the script
************************************************/
// urls to call - the login page and the secured page


// the path to a file we can read/write; this will
// store cookies we need for accessing secured pages
$cookies = '\cookie.txt';

/************************************************
* initialize a curl handle; we'll use this
*   handle throughout the script
************************************************/
$ch = curl_init();
/************************************************
* now issue a second call to the Login page;
*   this time, it will be a POST; we'll send back
*   as post data the __VIEWSTATE and __EVENTVALIDATION
*   values the server previously sent us, as well as the
*   username/password.  We'll also set up a cookie
*   jar to retrieve the authentication cookie that
*   the server will generate and send us upon login.
************************************************/
curl_setopt($ch, CURLOPT_POST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
curl_setopt($ch, CURLOPT_URL, $urlPostback);   
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_exec($ch);
/************************************************
* with the authentication cookie in the jar,
* we'll now issue a GET to the secured page;
* we set curl's COOKIEFILE option to the same
* file we used for the jar before to ensure the
* authentication cookie is sent back to the
* server
************************************************/
//$postData = 'ScriptManager1=rgReservasPanel%7C'.rawurlencode($callback).'&__EVENTTARGET='.rawurlencode($callback).'&__VIEWSTATE='.rawurlencode($viewstate).'&__EVENTVALIDATION='.rawurlencode($eventvalidation);
$postData = '&__EVENTTARGET='.rawurlencode($callback).'&__EVENTARGUMENT=&__VIEWSTATE='.rawurlencode($viewstate).'&__EVENTVALIDATION='.rawurlencode($eventvalidation).'&rgReservas_ClientState=';
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_URL,$urlPostback); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);       
curl_exec($ch);
curl_close($ch);
// at this point the secured page may be parsed for
// values, or additional POSTS made to submit parameters
// and retrieve data.  For this sample, we'll just
// echo the results.
?>