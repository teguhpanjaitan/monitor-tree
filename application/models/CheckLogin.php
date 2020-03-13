<?php

class CheckLogin extends CI_Model
{

	public function check_credentials()
	{
		$username = $this->input->post("username");
		$username = $this->db->escape_str($username);
		$password = $this->input->post("password");
		$password = $this->db->escape_str($password);

		$this->db->select('*')->from("`users` as a")
			->where("a.`username` = '$username'")
			->where("a.`active`", '1')
			->where("a.`level`", '1');	//only admin level available currently
		$users = $this->db->get()->result_array();

		if (!empty($users)) {
			foreach ($users as $user) {
				if (password_verify($password, $user['password'])) {
					$temp = array("ID" => $user['ID'], "display_name" => $user['display_name'], "username" => $user['username'], "password" => $user['password'], "level" => $user['level']);
					$temp = json_encode($temp);
					$temp = array("credential" => $temp);
					$this->session->set_userdata($temp);
					return array("status" => true, "data" => $user);
				}
			}
		}

		$this->db->select('*')->from("`users` as a")
			->where("a.`username` = '$username'")
			->where("a.`active` = '1'");
		$res = $this->db->get()->result_array();
		if (!empty($res)) return array("status" => false, "message" => "Password salah");
		else {
			$this->db->select('*')->from("`users` as a")
				->where("a.`password` = '$password'")
				->where("a.`active` = '1'");
			$res = $this->db->get()->result_array();
			if (!empty($res)) return array("status" => false, "message" => "Username salah");
			else
				return array("status" => false, "message" => "Username dan password salah atau Anda telah dinonaktifkan");
		}
	}

	public function autorize()
	{
		$credential = $this->session->userdata('credential');

		if (empty($credential)) redirect(get_href("login"));

		$tmp = json_decode($credential);
		$username = $tmp->username;
		$pass = $tmp->password;

		$this->db->select("*")
			->from('users')
			->where("username", $username)
			->where("password", $pass);
		$res = $this->db->get()->result_array();

		if (count($res) == 0) redirect(get_href("login"));
		return $res;
	}

	public function logout()
	{
		$this->session->unset_userdata('credential');
		redirect(get_href("login"));
	}
}
