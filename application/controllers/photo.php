<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(getSessionUser() < 1){
			redirect(base_url());
		}
		//Do your magic here		
		$this->load->model('query');
	}

	public function index(){

	}

	public function uploadPhoto(){
		header("Content-Type: application/json", true);

		if(empty($_FILES['image']['name'])){
			$json = array("info" => "false","error"=>"You did not select a file to upload.");
		}else{
			// Check Validasi
			$check = validasiUploadData($_FILES['image']['type'], 'jpg');

		  	if(!empty($check)) {
		  		$json = array("info" => "false","error"=>$check);	  		
	        }else{
	        	$uploadData = uploadDataWithAzure($_FILES['image'],"photo", $this->config->item("photoTempAzure")); 

	        	if($uploadData==="error"){
	        		$json = array("info" => "false","error"=>"please upload again");
	        	}else{
	        		$json = array("info"=>"true",
	        				  "image" =>   "<img src=\"".$this->config->item('azureUrl').$this->config->item("photoTempAzure")."/".$uploadData."\"  id=\"thumbnail\" style=\"opacity:0;\"/>",
							  "file_name"=>$uploadData,
							  "filename_ori"=>$_FILES['image']['name'],
							  "filename"=>$uploadData);
	        	}
	        	
	        }
		}

		echo json_encode($json);

		exit;
	}

	public function uploadPhotoThumbnail(){
		$file_name  = $this->input->post('file_name') ;

		$source_image = $this->config->item('azureUrl').$this->config->item("photoTempAzure")."/".$file_name;

		$x = $this->input->post('x');
		$y = $this->input->post('y');
		$w = $this->input->post('w');
		$h = $this->input->post('h'); 

		$targ_w = $targ_h = 180;
		$jpeg_quality = 80;

		$src = $this->config->item('azureUrl').$this->config->item("photoTempAzure")."/".$file_name;
		$src_thumb = 'public/upload/img/thumb/'.$file_name;
		list($width, $height, $type, $attr) = getimagesize($src);

		$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor($targ_w, $targ_h);

		imagecopyresampled($dst_r,$img_r,0,0,$x,$y,
		$targ_w,$targ_h,$w,$h);

		// Save the image
		imagejpeg($dst_r,$src_thumb,$jpeg_quality);

		$image = array ("name"=>$file_name,"tmp_name"=>$src_thumb);
		$imageTemp = array ("name"=>$file_name,"tmp_name"=>$source_image);

		uploadDataWithAzure($image,"photo",$this->config->item("photoThumbAzure"),"true"); 
		uploadDataWithAzure($imageTemp,"photo",$this->config->item("photoRealAzure"),"true"); 

		deleteBlobAzure("photo","temp/$file_name");

		$fileTemp = "public/upload/img/temp/".$file_name;
		$fileReal = "public/upload/img/real/".$file_name;

		// Hapus data di folder temp 
		unlink($src_thumb);

		/* Update table member photo */
		 $this->query->update("pmj_member_photo",array("type"=>"other"),array("registration_id"=>getSessionUser()));

		/* Masukkan data ke table member photo */
		$this->query->save("pmj_member_photo",array("registration_id"=>getSessionUser(),"filename_ori"=>$this->input->post('filename_ori'),"filename"=> $this->config->item('dirPhotoRealAzure').$file_name,"filename_thumb"=>$this->config->item('dirPhotoThumbAzure').$file_name,"type"=>"main","avatar"=>"0","submit_date"=> date("Y-m-d H:i:s"),"status"=>"online"));


		if($this->input->post('uri')=="viewAllPhoto")
			redirect(base_url()."photo/viewAllPhoto");
		elseif($this->input->post('uri')=="edit")
			redirect(base_url()."profile/edit");
		else
			redirect(base_url()."profile");

	}

	public function availablePhoto(){
		/* Masukkan data ke table member photo */
		$this->query->save("pmj_member_photo",array("registration_id"=>getSessionUser(),"filename_ori"=>$this->input->post('radio-avatar'),"filename"=>$this->input->post('radio-avatar'),"filename_thumb"=>$this->input->post('radio-avatar'),"type"=>"main","avatar"=>"1","submit_date"=> date("Y-m-d H:i:s"),"status"=>"online"));
		
		redirect(base_url()."profile");
	}

	public function getPhoto(){
		$loadImage = $this->query->get("member_photo",array('where'=>array("registration_id"=>$this->uri->segment(3),"filename_thumb !="=>""),'order'=>"id desc",'limit'=>"6"));
		
		$i = 0;
		foreach ($loadImage as $v) {
			if($this->uri->segment(3)==getSessionUser()){
				$gear = '<a class="dropdown-toggle gear-list-photo" data-toggle="dropdown" href="#">  <i class="fa fa-gear fa-gear-white"></i>
						</a>
						<ul class="dropdown-menu arrow-photo-edit dropdown-menu-size" role="menu">
						<li><a href="'.base_url("photo").'/delPhoto/'.$v->id.'">Delete Photo</a></li>
						<li><a href="'.base_url("photo").'/changeAvatar/'.$v->id.'">Make Profile</a></li>
						</ul>
						';
			}else{
				$gear="";
			}

			if($v->avatar=="1"){
				echo  '<li class="col-md-2 col-sm-3 col-xs-6 list-photo">
				<a class="fancybox" rel="ligthbox" href="'.$v->filename.'" title="'.$v->filename_ori.'">
				<img alt  onerror="this.src=\'http://placehold.it/241x241&text=no+image\';"  class="img-thumbnail avatar img-thumbnail-custom" alt=""  src="'.$v->filename_thumb.'" />
				'.$gear.'</a>
				</li>';	
			}else{
				echo  '<li class="col-md-2 col-sm-3 col-xs-6 list-photo">
				<a class="fancybox" rel="ligthbox" href="'.$v->filename.'" title="'.$v->filename_ori.'">
				<img alt onerror="this.src=\'http://placehold.it/241x241&text=no+image\';" class="img-thumbnail avatar img-thumbnail-custom"  src="'.$v->filename_thumb.'"/>
				'.$gear.'</a>
				</li>';		
			}

			$i++;
		}

		if($i < 6 and $this->uri->segment(3)==getSessionUser()){
				echo  '<li class="col-md-2 col-sm-3 col-xs-6 list-photo">
				<a href="javascript:void(0);">
				<img class="img-thumbnail avatar img-thumbnail-custom add-photo" alt=""  src="'.base_url().'public/assets/img/image_add.png" />
				</a>
				</li>';		
		}
	}

	public function delPhoto(){
		if($this->uri->segment(3)!=""){
			$cekPhoto = $this->query->get('pmj_member_photo',array("where"=>array("id"=>$this->uri->segment(3))));

			if($cekPhoto[0]->registration_id == getSessionUser()){

				if($cekPhoto[0]->avatar!="1"){
					$filenameExplode = explode("/", $cekPhoto[0]->filename);
					$resultFilenameExplode = (count($filenameExplode) - 1);
					deleteBlobAzure("photo","real/".$filenameExplode[$resultFilenameExplode]);

					$filenameThumbExplode = explode("/", $cekPhoto[0]->filename_thumb);
					$resultFilenameThumbExplode = (count($filenameThumbExplode) - 1);

					deleteBlobAzure("photo","thumb/".$filenameThumbExplode[$resultFilenameThumbExplode]);
				}

				$this->query->delete('pmj_member_photo',array("id"=>$this->uri->segment(3)));
				if($this->uri->segment(4)!=""){
					redirect(base_url("photo")."/viewAllPhoto");
				}
			}
		}
		redirect(base_url("profile"));
	}

	public function changeAvatar(){
		if($this->uri->segment(3)!=""){
			$cekPhoto = $this->query->get('pmj_member_photo',array("where"=>array("id"=>$this->uri->segment(3))));

			if($cekPhoto[0]->registration_id == getSessionUser()){
				/* Update table member photo */
				$this->query->update("pmj_member_photo",array("type"=>"other"),array("registration_id"=>getSessionUser()));
				$this->query->update("pmj_member_photo",array("type"=>"main"),array("registration_id"=>getSessionUser(),"id"=>$cekPhoto[0]->id));

				if($this->uri->segment(4)!=""){
					redirect(base_url("photo")."/viewAllPhoto");
				}
			}
		}
		
		redirect(base_url("profile"));
	}

	public function viewAllPhoto(){
		if($this->uri->segment(3)){
			$array['code_id'] = $this->uri->segment(3);
		}else{
			$array['code_id'] = getSessionCodeId();
		}

		$user = $this->query->get("member",array("where"=>$array));

		$config['base_url'] = "?";
		$total = $this->query->get("member_photo",array("count"=>1,'where'=>array("registration_id"=>$user[0]->id,"filename_thumb !="=>""),'order'=>"id desc"));
		$config['total_rows'] =  $total[0]->total;				
        $config['per_page'] = 12;
		$config['num_links'] = 3;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$offset = $this->input->get("page");

		if(empty($offset) || $offset == 0){
			$offset = 0;
		} 

		$data['user'] = $user[0];
		$data['matches'] = $this->query->get("member_photo",array("limit"=>$config['per_page'],"offset"=>$offset,'where'=>array("registration_id"=>$user[0]->id,"filename_thumb !="=>""),'order'=>"id desc"));
		$data['bodyClass'] = 'list-photo';
		$data['pageTitle'] = "List Photo";
		$data['class'] = 'list-photo-wrapper';
		$this->load->view('user/viewAllPhoto',$data);
	}

	public function photoVerification(){
		if( $this->input->post('photo1')!="" &&   $this->input->post('photo2')!=""){
			$base64img = str_replace('data:image/jpeg;base64,', '', $this->input->post('photo1'));
			$data = base64_decode($base64img);

			$image = array ("name"=>"photo1","tmp_name"=>$data);

			$photo1 = uploadDataWithAzureBase($image,"verification",$this->config->item("verificationRealAzure"),"jpeg"); 

			$base64img2 = str_replace('data:image/jpeg;base64,', '', $this->input->post('photo2'));
			$data2 = base64_decode($base64img2);

			$image2 = array ("name"=>"photo2","tmp_name"=>$data2);

			$photo2 = uploadDataWithAzureBase($image2,"verification",$this->config->item("verificationRealAzure"),"jpeg"); 

			if($photo1!=="error" && $photo2!=="error"){
				$dataVerification['id_member'] = getSessionUser();
				$dataVerification['photo_1'] = $this->config->item('dirVerificationRealAzure').$photo1;
				$dataVerification['photo_2'] = $this->config->item('dirVerificationRealAzure').$photo2;
				$dataVerification['created_date'] = date("Y-m-d h:i:s");

				$this->query->save("pmj_verification",$dataVerification);

				$dataEmail =array('code_id' => getSessionCodeId(),'id'=>getSessionUser());

				/* Send Email */
				sendEmail("verification",$dataEmail);

				echo "true";
			}else{
				echo "false";
			}
			
		}else{
			echo "false";	
		}
	
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
			$data['media_file_name'] = strip_tags($this->input->post("filename"));

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

}

/* End of file photo.php */
/* Location: ./application/controllers/photo.php */