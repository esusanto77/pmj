<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here		
		$this->load->model('query');
		if(getSessionUser() < 1){
			redirect(base_url());
		}

		checkHoursVerification();
	}


	public function index()
	{

		$this->load->view('user/chat');
	}

	public function popup($id = '')
	{
		if( $id === ''){
			exit('Wrong User!');
		}

		$data['id'] = $id;
		$this->load->view('user/chat-popup', $data);
	}

	public function popup_video($id = '',$file = '')
	{
		if( $id === ''){
			exit('Wrong User!');
		}

		if( $file === ''){
			exit('Wrong File');
		}

		/*$filenameExplode = explode("/", $file);
		$resultFilenameExplode = (count($filenameExplode) - 1);*/


		$data['id'] = $id;
		$data['file'] = $file;
		$this->load->view('user/chat-video-popup', $data);
	}

	public function popup_image($id = '',$file = '')
	{
		if( $id === ''){
			exit('Wrong User!');
		}

		if( $file === ''){
			exit('Wrong File');
		}

		/*$filenameExplode = explode("/", $file);
		$resultFilenameExplode = (count($filenameExplode) - 1);*/


		$data['id'] = $id;
		$data['file'] = $file;
		$this->load->view('user/chat-image-popup', $data);
	}

	// Upload File In Azure
	public function photoChatNew(){
		header("Content-Type: application/json", true);

		if(empty($_FILES['image']['name'])){
			$json = array("info" => "false","error"=>"You did not select a file to upload.");
		}else{
			$check = validasiUploadData($_FILES['image']['type'], 'image');

		  	if(!empty($check)) {
		  		$json = array("info" => "false","error"=>$check);	  		
	        }else{
	        	$uploadData = uploadDataWithAzure($_FILES['image'],"chat", $this->config->item("chatImageAzure")."/".getSessionCodeId()); 

	        	if($uploadData==="error"){
	        		$json = array("info" => "false","error"=>"please upload again");
	        	}else{
	        		$json = array("info"=>"true","link"=>$this->config->item('azureUrl').$this->config->item("chatImageAzure")."/".getSessionCodeId()."/".$uploadData,"file_name"=>$uploadData);
	        	}
	        }	
		}

		echo json_encode($json);

		exit;
	}

	public function photoChat(){
		header("Content-Type: application/json", true);

		/* Upload Foto */
		$path = 'public/upload/chat/image/'.getSessionCodeId();
		
		if (!is_dir($path)) {
		    mkdir($path);
		    $upload_path  = $path;
		} else {
			$upload_path  = $path;
		}

		$config['upload_path']  = $upload_path ;
		$config['allowed_types']= 'jpg|jpeg|png';
		$config['file_name'] = md5(time().getSessionCodeId());

		$this->load->library('upload', $config);

		if ($this->upload->do_upload("image")) {
			$data['img']	 = $this->upload->data();
			$json = array("info"=>"true","file_name"=>$data['img']['file_name']);
		}else{
			$json = array("info" => "false","error"=>$this->upload->display_errors());
		}
		echo json_encode($json);

		exit;
		
	}

	public function postMediaChat(){
		if(getSessionUser() > 1){
			$data['media_from'] = strip_tags($this->input->post("from"));
			$data['media_to'] = strip_tags($this->input->post("to"));
			$data['media_type'] = strip_tags($this->input->post("type"));

			if ($data['media_type'] == 'video') {
				$dir = $this->config->item("chatVideoAzure");
			} elseif ($data['media_type'] == 'image') {
				$dir = $this->config->item("chatImageAzure");
			}

			$data['media_file_name'] = $this->config->item('azureUrl').$dir."/".getSessionCodeId()."/".$this->input->post("filename");
			$data['media_date'] = date("Y-m-d H:i:s");

			$this->query->insert('media',$data);

			echo 1;

		} else {

			echo 0;
			
		}
	}

	public function postMediaChatAvaliable(){
		if(getSessionUser() > 1){
			$data['media_from'] = strip_tags($this->input->post("from"));
			$data['media_to'] = strip_tags($this->input->post("to"));
			$data['media_type'] = strip_tags($this->input->post("type"));

			if ($data['media_type'] == 'video') {
				$dir = $this->config->item("chatVideoAzure");
			} elseif ($data['media_type'] == 'image') {
				$dir = $this->config->item("chatImageAzure");
			}

			$data['media_file_name'] = $this->input->post("filename");
			$data['media_date'] = date("Y-m-d H:i:s");

			$this->query->insert('media',$data);

			echo 1;

		} else {

			echo 0;
			
		}
	}

	public function getOwnImage(){
		header("Content-Type: application/json", true);

		/* Upload Foto */
		$path = 'public/upload/chat/image/'.getSessionCodeId();
		
		$files = array();

		$dir = opendir($path);
		while ($file = readdir($dir)) {
		    if ($file == '.' || $file == '..') {
		        continue;
		    }

		    $files[] = $file;
		}

		echo json_encode($files);
		
	}

	public function getMedia(){
		header("Content-Type: application/json", true);

		$files = $this->query->get("media",array("where"=>array("media_from"=>getSessionCodeId()), "group"=>'media_file_name'));

		echo json_encode($files);
		
	}



	// Upload File In Azure
	public function videoChatNew(){
		header("Content-Type: application/json", true);

		if(empty($_FILES['video']['name'])){
			$json = array("info" => "false","error"=>"You did not select a file to upload.");
		}else{
			$check = validasiUploadData($_FILES['video']['type'], 'video');

		  	if(!empty($check)) {
		  		$json = array("info" => "false","error"=>$check);	  		
	        }else{
	        	$uploadData = uploadDataWithAzure($_FILES['video'],"chat", $this->config->item("chatVideoAzure")."/".getSessionCodeId()); 

	        	if($uploadData==="error"){
	        		$json = array("info" => "false","error"=>"please upload again");
	        	}else{
	        		$json = array("info"=>"true","link"=>$this->config->item('azureUrl').$this->config->item("chatVideoAzure")."/".getSessionCodeId()."/".$uploadData,"file_name"=>$uploadData);
	        	}
	        }	
		}

		echo json_encode($json);

		exit;
	}

	public function videoChat(){
		header("Content-Type: application/json", true);

		/* Upload video */
		$path = 'public/upload/chat/video/'.getSessionCodeId();
		
		if (!is_dir($path)) {
		    mkdir($path);
		    $upload_path  = $path;
		} else {
			$upload_path  = $path;
		}

		$config['upload_path']  = $upload_path ;
		$config['allowed_types']= '*';
		$config['file_name'] = md5(time().getSessionCodeId());

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('video')) {
			$data['vid']	 = $this->upload->data();
			$json = array("info"=>"true","file_name"=>$data['vid']['file_name']);
		}else{
			$json = array("info" => "false","error"=>$this->upload->display_errors());
		}
		echo json_encode($json);

		exit;
		
	}

}

/* End of file chat.php */
/* Location: ./application/controllers/chat.php */