<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$config['connectionStringAzure'] = "DefaultEndpointsProtocol=https;AccountName=pmjstorage;AccountKey=qGWMlSphird2zSlZ4HLiQNXn7pWmweASe8p0yYZVOpWzA9k7Fvq9Erd/1WSkz7vH0CWbnUO0GS2DZ2us53jX1w==";
	$config['azureUrl']   = 'https://pmjstorage.blob.core.windows.net/';

	/* Upload Photo */
	$config['photoRealAzure']   = 'photo/real';
	$config['photoTempAzure']   = 'photo/temp';
	$config['photoThumbAzure']   = 'photo/thumb';
	$config['dirPhotoRealAzure']   = $config['azureUrl'].'photo/real/';
	$config['dirPhotoThumbAzure']   = $config['azureUrl'].'photo/thumb/';

	/* Verification */
	$config['verificationRealAzure']   = 'verification/real';
	$config['dirVerificationRealAzure']   = $config['azureUrl'].'verification/real/';

	/* Chat */
	$config['chatImageAzure']   = 'chat/image';
	$config['chatVideoAzure']   = 'chat/video';
?>