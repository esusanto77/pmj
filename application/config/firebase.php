<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

  if($_SERVER['HTTP_HOST'] == "localhost" || 
     $_SERVER['HTTP_HOST'] == "loc.visual.web.id" || 
     $_SERVER['HTTP_HOST'] == "pmj.dev") {
  	$config['user_chat']   = 'https://pmjdev.firebaseio.com/';
    $config['notifications']   = 'https://pmjdev.firebaseio.com/';
    $config['mosaic_url'] = 'http://pmj.cloudapp.net/mosaicdev/v1/activity';
  } 
  elseif($_SERVER['HTTP_HOST'] == "pmjakarta.com" || 
         $_SERVER['HTTP_HOST'] == "pmjakarta.azurewebsites.net" || 
         $_SERVER['HTTP_HOST'] == "pmjbeta.azurewebsites.net" || 
         $_SERVER['HTTP_HOST'] == "beta.pmjakarta.com") {
  	$config['user_chat']   = 'https://pmjprod.firebaseio.com/';
    $config['notifications']   = 'https://pmjprod.firebaseio.com/';
    $config['mosaic_url'] = 'http://pmj.cloudapp.net/mosaic/v1/activity';
  }
  else {
    // default is dev
    $config['user_chat']   = 'https://pmjdev.firebaseio.com/';
    $config['notifications']   = 'https://pmjdev.firebaseio.com/';
    $config['mosaic_url'] = 'http://pmj.cloudapp.net/mosaicdev/v1/activity';
  }

?>