<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Model {


	//Get all the users
	public function getusers()
	{

	    $this->db->select('*');
        $this->db->from('auth_users');
        // $this->db->order_by('id','DESC');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
        return $query->result();
        } else {
        return false;
        }
	}

	//Add key to Database
	public function addkey($keya)
	{
		$this->db->insert('auth_tokens', $keya);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
           return true;
        }
        else
        {
            return false;
        }
	}

	//Check token in database
	public function check_token($token)
	{
        $this->db->where('key', $token);
        $this->db->from('auth_tokens'); 
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
        return $query->result();
        } else {
        return false;
        }
	}

	//Check email exists in database
	public function check_email($email)
	{
        $this->db->where('email', $email);
        $this->db->from('auth_users'); 
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
        return $query->num_rows();
        } else {
        return $query->num_rows();
        }
	}

    //Check phone exists in database
    public function check_phone($phone)
    {
        $this->db->where('phone', $phone);
        $this->db->from('auth_users'); 
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
        return $query->num_rows();
        } else {
        return $query->num_rows();
        }
    }

	//User login function
	public function user_login($email,$password)
	{
		$this->db->where('email', $email);
		$this->db->where('password', $password);
        $this->db->from('auth_users'); 
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
        return $query->result();
        } else {
        return false;
        }
	}

    //Sign in after registration
    public function user_login_aftersignup($createuser)
    {
        $this->db->where('id', $createuser);
        $this->db->from('auth_users'); 
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
        return $query->result();
        } else {
        return false;
        }
    }

	//Update Token Status after Success Login
	public function update_loginkey($token,$updatekey)
	{
		$this->db->where('key', $token);
        $this->db->update('auth_tokens', $updatekey);
        if ( $this->db->affected_rows() == '1' ) {return true;}
        else {return false;}
	}


	//Create New user
	public function create_user($adduser)
	{
		$this->db->insert('auth_users', $adduser);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
           return $insert_id;
        }
        else
        {
            return false;
        }

	}

	
	//Update the Forgot Password
	public function update_pass($newpass,$email)
	{
		$this->db->where('email', $email);
        $this->db->update('auth_users', $newpass);
        if ( $this->db->affected_rows() == '1' ) {return true;}
        else {return false;}
	}


	//Verify Token for login user
	public function verify_token($token,$userid)
	{
		$this->db->select('*');
        $this->db->from('auth_tokens');
        $this->db->where('key', $token);
        $this->db->where('user_id', $userid);
        $this->db->where('status', 'active');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
        return true;
        } else {
        return false;
        }
	}



    //Insert Contact Details
    public function InsertContactData($details)
    {
        $this->db->insert('auth_contact', $details);
        $insert_id = $this->db->insert_id();
        if ($insert_id) 
        {
           return $insert_id;
        }
        else
        {
            return false;
        }

    }



}

?>