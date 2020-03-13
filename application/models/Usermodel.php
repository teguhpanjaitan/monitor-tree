<?php

class UserModel extends CI_Model {

	public function get_current_uid()
	{
		$credential = $this->session->userdata('credential');
		$tmp = json_decode($credential);
		return $tmp->ID;
	}
	
	public function change() {
		$post = $this->input->post();
		$id = $this->get_ID();

		if(!empty($post['new_password']))
		{
			$data = array("password" => password_hash($post['new_password'], PASSWORD_DEFAULT));
		
			$this->db->where("ID = '$id'");
			$this->db->update('user',$data);
		}
		if(!empty($post['new_username']))
		{
			$data = array("username" => $post['new_username']);
		
			$this->db->where("ID = '$id'");
			$this->db->update('user',$data);
		}
		
	}
	
	private function get_ID()
	{
		$credential = $this->session->userdata('credential');
		$tmp = json_decode($credential);
		$username = $tmp->username;
		$pass = $tmp->password;
		
		$this->db->select("ID")
				->from('users')
				->where("username",$username)
				->where("password",$pass);
		$res = $this->db->get()->result_array();

		return $res[0]['ID'];
	}
	
}
