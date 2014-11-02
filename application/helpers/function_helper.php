<?php 

	/**
	 * curl post function
	 *
	 * @return void
	 * @author 
	 **/
	function curl_post($params)
	{
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $params["url"]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params["data"]); //"var1=value1&var2=value2&var_n=value_n"
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Accept: application/json',
		    'Content-Length: ' . strlen($params["data"]))
		);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		// return result
		return $result;
	}


	function curl_get($params)
	{
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $params["url"]);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		// return result
		return $result;
	}

	function curl_best_match($id){
		static $ci = null;

	    if(is_null($ci)) {
	        $ci =& get_instance();
	    }

		$curlBestMatch['url'] = $ci->config->item('apiBestMatchNode').$id;

		curl_get($curlBestMatch);
	}

	function reverse_birthday( $years ){
		return date('Y-m-d', strtotime($years . ' years ago'));
	}
	
	function get_age($birth_date){
		if($birth_date == "0000-00-00"){
			return "-";
		} else {
			return floor((time() - strtotime($birth_date))/31556926);
		}	 
	}	

	function timeago($datetime, $full = false) {
		 $now = new DateTime;
		   $ago = new DateTime($datetime);
		   $diff = $now->diff($ago);

		   if (isset($diff)) {
		        $string = array(
		        'y' => 'year',
		        'm' => 'month',
		        'd' => 'day',
		        'h' => 'hour',
		        'i' => 'minute'
		    );

		    foreach ($string as $k => &$v) {
		        if ($diff->$k) {
		            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		        } else {
		            unset($string[$k]);
		        }
		    }

		    if (!$full)
		        $string = array_slice($string, 0, 1);
		    return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
		   else {
		          return 0;
		        }
	}


	function getActivityLabel($label){
		$label =  str_replace("_", " ", $label);
		switch ($label) {
			case 'favorite':
				return "Favorited";
				break;
			case ' favorite':
				return "Favorited";
				break;	

			case 'unfavorite':
				return "Unfavorited";
				break;		

			case 'viewed':
				return "Viewed";
				break;				
			default:
				return $label;
				break;
		}
	}