<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\ListContainersOptions;
use WindowsAzure\Blob\Models\PublicAccessType;

	function uploadDataWithAzure($image,$dirContainer,$path,$crop = ""){
		require_once(APPPATH.'libraries/WindowsAzure/WindowsAzure.php');

		static $ci = null;

	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		// Create blob REST proxy.
		$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($ci->config->item('connectionStringAzure'));

		// Check from crop or not
		if(!empty($crop)){
			$blob_name =  $image['name'];
			$content = fopen($image['tmp_name'], "r");
		}else{
			$elements = explode('.', $image['name']);
			$max = count($elements) -1;
			$ext = $elements[$max];
			$blob_name =  md5(time().getSessionCodeId()).".".$ext;
			$content = fopen($image['tmp_name'], "r");
		}
		
		try {
			// Create container if not exist
			createContainerIfNotExists($blobRestProxy,$dirContainer);
			try {
				// Check blob exist or not
				$blob = $blobRestProxy->getBlob($path, $blob_name);
				return 'error';
			} catch (ServiceException $e) {
				// Upload blob if not exist
				$blobRestProxy->createBlockBlob($path, $blob_name, $content);
				return $blob_name;
			}    
		}
		catch(ServiceException $e){
		    // Handle exception based on error codes and messages.
		    // Error codes and messages are here: 
		    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
		    $code = $e->getCode();
		    $error_message = $e->getMessage();
		    return $code.": ".$error_message."<br />";
		}
	
	}

	function validasiUploadData($filetype,$allowed){
		if ($allowed == 'video') $allowed = array("video/x-flv","video/mp4","application/x-mpegURL","video/MP2T","video/3gpp",
													"video/quicktime","video/x-msvideo","video/x-ms-wmv");
		if ($allowed == 'image') $allowed = array ("image/pjpeg", "image/jpg", "image/jpeg","image/png","image/gif");
		if ($allowed == 'jpg') $allowed = array ('image/jpeg');

		if (!in_array ($filetype, $allowed)){
			return "File type $filetype are not allowed, sorry!";
		}
	}

	function createContainerIfNotExists($blobRestProxy,$dirContainer){
		$listContainersOptions = new ListContainersOptions;
	    $listContainersOptions->setPrefix($dirContainer);
	    $listContainersResult = $blobRestProxy->listContainers($listContainersOptions);
	    $containerExists = false;
	    foreach ($listContainersResult->getContainers() as $container)
	    {
	        if ($container->getName() == $dirContainer)
	        {
	            // The container exists.
	            $containerExists = true;
	            // No need to keep checking.
	            break;
	        }
	    }
	    if (!$containerExists)
	    {
	    	$createContainerOptions = new CreateContainerOptions(); 
	    	$createContainerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY);

	        $blobRestProxy->createContainer($dirContainer,$createContainerOptions);
	    }
	}

	function deleteBlobAzure($dirContainer,$path){
		static $ci = null;

	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		// Create blob REST proxy.
		$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($ci->config->item('connectionStringAzure'));

		try {
		    // Delete container.
		    $blobRestProxy->deleteBlob($dirContainer, $path);
		}
		catch(ServiceException $e){
		    // Handle exception based on error codes and messages.
		    // Error codes and messages are here: 
		    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
		    $code = $e->getCode();
		    $error_message = $e->getMessage();
		    echo $code.": ".$error_message."<br />";
		}
	}

	function uploadDataWithAzureBase($image,$dirContainer,$path,$ext){
		require_once(APPPATH.'libraries/WindowsAzure/WindowsAzure.php');

		static $ci = null;

	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		// Create blob REST proxy.
		$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($ci->config->item('connectionStringAzure'));


		$blob_name =  md5(time().getSessionCodeId())."_".$image['name'].".".$ext;
		$content = $image['tmp_name'];
		
		try {
			// Create container if not exist
			createContainerIfNotExists($blobRestProxy,$dirContainer);
			try {
				// Check blob exist or not
				$blob = $blobRestProxy->getBlob($path, $blob_name);
				return 'error';
			} catch (ServiceException $e) {
				// Upload blob if not exist
				$blobRestProxy->createBlockBlob($path, $blob_name, $content);
				return $blob_name;
			}    
		}
		catch(ServiceException $e){
		    // Handle exception based on error codes and messages.
		    // Error codes and messages are here: 
		    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
		    $code = $e->getCode();
		    $error_message = $e->getMessage();
		    return $code.": ".$error_message."<br />";
		}
	
	}
