<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    redirect(base_url());
  }
}