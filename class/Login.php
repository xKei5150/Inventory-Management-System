<?php 
require_once('../database/Database.php');
require_once('../interface/iLogin.php');

class Login extends Database implements iLogin {
	
	private $username;
	private $password;

	public function __construct()
	{
		parent:: __construct();
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
	}

	public function set_un_pwd($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}	
	
	public function check_user()
	{
		$at_deped = 1;
		$sql = "SELECT *
				FROM tbl_employee
				WHERE emp_un = ?
				AND emp_pass = ?
				AND emp_at_deped = ?
		";
		$result = $this->getRow($sql, [$this->username, $this->password, $at_deped]);
		return $result;

	}

	public function get_user_id()
	{
		$type = 1;
		$at_deped = 1;
		$sql = "SELECT emp_id
				FROM tbl_employee
				WHERE emp_un = ?
				AND emp_pass = ?
				AND type_id = ?
				AND emp_at_deped = ?
		";
		$result = $this->getRow($sql, [$this->username, $this->password, $type, $at_deped]);
		return $result;
	}

	public function user_session()
	{
		if(!isset($_SESSION['user_logged_in'])){
			header('location: ../index.php');
		}
	}

	public function user_logout()
	{
		unset($_SESSION['user_logged_in']);
		header('location: ../index.php');
	}



	public function admin_session()
	{
		if(!isset($_SESSION['admin_logged_in'])){
			header('location: ../index.php');
		}
	}

	public function admin_logout()
	{
		unset($_SESSION['admin_logged_in']);
		header('location: ../index.php');
	}


	public function admin_data()
	{
		$at_deped = 1;
		$id = $_SESSION['admin_logged_in'];
		$sql = "SELECT *
				FROM tbl_employee 
				WHERE emp_id = ?
				AND emp_at_deped = ?
		";
		return $this->getRow($sql, [$id, $at_deped]);

	}



}

$login = new Login();
