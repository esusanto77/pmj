<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Linkedin
{
  protected 	$ci;

	public function __construct()
	{
        $this->ci =& get_instance();  
        $this->appId = $this->ci->config->item("ln_appId");
        $this->secret = $this->ci->config->item("ln_secret");    
        $this->callback = base_url()."auth/loginWithLinkedin";
	}

	public function getAuthorizationCode()
	{
		
		 $params = array('response_type' => 'code',
	                    'client_id' => $this->appId,	
	                    'scope' => 'r_fullprofile r_emailaddress rw_nus',                    
	                    'state' => uniqid('12334', true), // unique long string
	                    'redirect_uri' => $this->callback,
	              );
	 
	    // Authentication request
	    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
	     
	    // Needed to identify request when it returns to us
	    $array = array(
	    	'state' => $params['state']
	    );
	    
	    $this->ci->session->set_userdata( $array );	    
	 
	    // Redirect user to authenticate
	    header("Location: $url");
	    exit;
	}

	public function getAccessToken()
	{
			$params = array('grant_type' => 'authorization_code',
		                    'client_id' => $this->appId,
		                    'client_secret' => $this->secret,
		                    'code' => $_GET['code'],
		                    'redirect_uri' => $this->callback,
		              );
		     
		    // Access Token request
		    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
		     
		    // Tell streams to make a POST request
		    $context = stream_context_create(
		                    array('http' => 
		                        array('method' => 'POST',
		                        )
		                    )
		                );
		 
		    // Retrieve access token information
		    $response = file_get_contents($url, false, $context);
		 
		    // Native PHP object, please
		    $token = json_decode($response);
		 
		    // Store access token and expiration time
		    $array = array(
		    	'access_token' => $token->access_token, // guard this! 
		    	'expires_in' =>  $token->expires_in, // relative time (in seconds)
		    	'expires_at' =>  time() + $this->ci->session->userdata('expires_in') // absolute time
		    );
		    
		    $this->ci->session->set_userdata( $array );
		     
		    return true;
	}

	function fetch($method, $resource, $body = '') {
	    $params = array('oauth2_access_token' => $this->ci->session->userdata('access_token'),
	                    'format' => 'json',
	              );
	     
	    // Need to use HTTPS
	    $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
	    // Tell streams to make a (GET, POST, PUT, or DELETE) request
	    $context = stream_context_create(
	                    array('http' => 
	                        array('method' => $method,
	                        )
	                    )
	                );
	 
	 
	    // Hocus Pocus
	    $response = file_get_contents($url, false, $context);
	 
	    // Native PHP object, please
	    return json_decode($response);
	}

	

}

/* End of file linkedin.php */
/* Location: ./application/libraries/linkedin.php */
