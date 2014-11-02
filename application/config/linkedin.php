<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "loc.visual.web.id" || $_SERVER['HTTP_HOST'] == "pmj.dev"){
// loc.visual.web.id
	$config['ln_appId']   = '75cx880sy5gua5';
	$config['ln_secret']  = 'OCgD58RgmMoVl0gd';
} elseif($_SERVER['HTTP_HOST'] == "pmjakarta.com" || $_SERVER['HTTP_HOST'] == "pmjakarta.azurewebsites.net" || $_SERVER['HTTP_HOST'] == "pmjbeta.azurewebsites.net" || $_SERVER['HTTP_HOST'] == "beta.pmjakarta.com" || $_SERVER['HTTP_HOST'] == "www.pmjakarta.com" ){
	$config['ln_appId']   = '75bb4r5ztujq3n';
	$config['ln_secret']  = 'KtzgSnIcPu58I6x6';
}
?>