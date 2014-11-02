<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "loc.visual.web.id" || $_SERVER['HTTP_HOST'] == "pmj.dev"){

// loc.visual.web.id
	$config['appId']   = '192700120922189';
	$config['secret']  = '33dcd97f240bdc7ffa1eb1a0fc410c39';
} elseif($_SERVER['HTTP_HOST'] == "pmjakarta.com" || $_SERVER['HTTP_HOST'] == "pmjakarta.azurewebsites.net" || $_SERVER['HTTP_HOST'] == "pmjbeta.azurewebsites.net" || $_SERVER['HTTP_HOST'] == "beta.pmjakarta.com" || $_SERVER['HTTP_HOST'] == "www.pmjakarta.com" ){
	$config['appId']   = '652312484828087';
	$config['secret']  = 'c28b7b70d79969c7adbb89e072b92bf8';
}
?>