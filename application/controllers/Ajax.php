<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function act($work = '')
	{
		$filename = ucfirst($work);
		if(file_exists(APPPATH."models/ajax/$filename.php"))
		{
			$this->load->model("ajax/$work","x");
			$response = $this->x->exec();
		}
		else
			$response = '';
		echo json_encode($response);
	}
}
