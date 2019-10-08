<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller  {

    public function __construct($config = 'rest')
    {
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
        
        $this->load->library('encryption');
        $this->load->model('api/user','auth');
      

    }


    ################### Login Function Starts #########################
    public function login_post()
    {
         $postdata = file_get_contents("php://input");
         $Post = json_decode($postdata);

        $users = $this->auth->getusers();
        $email = trim($Post->email);
        $password = md5($Post->password);

        //Check email and password NULL
        if ($email == NULL || $password == NULL)
        {
            $this->response([ 'status' => FALSE,
                             'message' => 'Please fill all details',
                            ], REST_Controller::HTTP_OK); 
        }

        //Check username exists in database or not
        $emailcheck = $this->auth->check_email($email);
        if(!$emailcheck)
        {
            // Invalid token, set the response and exit.
            $this->response([
                    'status' => FALSE,
                    'message' => 'You are not authorize person'
                ], REST_Controller::HTTP_OK); 
        }

        //Check email password Start
        $loginuser = $this->auth->user_login($email,$password);
        if(! $loginuser)
        {
            // Invalid token, set the response and exit.
            $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid Login Details'
                ], REST_Controller::HTTP_OK);
        }
        else
        {
            unset($loginuser[0]->password);
            $updatekey = array(
                'user_id'   => $loginuser[0]->id,
                'status'    => 'active'
                );
            //$this->auth->update_loginkey($token,$updatekey);
            $this->set_response([
                    'status'    => TRUE,
                    'message'   => 'Login Successfull',
                    'data'      => $loginuser['0'],
                    'image_url' => base_url().'dist/img/userimage/',
                ], REST_Controller::HTTP_OK); 
            
        }


    }

    ################### Register Post Method Function Starts #########################
    public function signup_post()
    {
        $postdata = file_get_contents("php://input");
        $Post = json_decode($postdata);

		if($Post->email!='' && $Post->password!='' && $Post->full_name!='' && $Post->phone!='')
		{
			$CheckMail = $this->auth->check_email($Post->email);
            
			if($CheckMail==0)
			{
                $CheckPhone = $this->auth->check_phone($Post->phone);
                if($CheckPhone==0)
                {
                    $adduser = [
                        'full_name' => $Post->full_name,
                        'email' => $Post->email,
                        'phone' => $Post->phone,
                        'password' => md5($Post->password),
                        'status' => 'active',
                        'created_on' => date('Y-m-d H:i:s')
                    ];
                    $createuser = $this->auth->create_user($adduser);
                    if($createuser)
                    {
                        $this->set_response([
                                'status'    => TRUE,
                                'message'   => 'User Created Successfull',
                            ], REST_Controller::HTTP_OK); 
                    }
                    else
                    {
                        $this->response([
                                'status' => FALSE,
                                'message' => 'User Not Created'
                            ], REST_Controller::HTTP_OK); 
                    }
                } else {

                    $this->response([
                            'status' => FALSE,
                            'message' => 'This Phone No. has already Exists'
                        ], REST_Controller::HTTP_OK); 

                }
		      } else {
		
        				$this->response([
                            'status' => FALSE,
                            'message' => 'This Email has already Exists'
                        ], REST_Controller::HTTP_OK); 

		      } } else {
									$this->response([
                                        'status' => FALSE,
                                        'message' => 'Please Fill all fields'
                                    ], REST_Controller::HTTP_OK); 
			
		      }

       }


      ################### Contact Us Function Starts #########################
    public function contact_post()
    {
         $postdata = file_get_contents("php://input");
         $Post = json_decode($postdata);

         if($Post->name && $Post->email && $Post->subject && $Post->message)
         {

            $Details = [
                'name' => $Post->name,
                'email' => $Post->email,
                'subject' => $Post->subject,
                'message' => $Post->message,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $ContactDataInsert = $this->auth->InsertContactData($Details);
                    if($ContactDataInsert)
                    {
                        $this->set_response([
                                'status'    => TRUE,
                                'message'   => 'Your message has been sent Successfully.',
                            ], REST_Controller::HTTP_OK); 
                    }
                    else
                    {
                        $this->response([
                                'status' => FALSE,
                                'message' => 'Sorry! Your message has not been sent.'
                            ], REST_Controller::HTTP_OK); 
                    }
        } else {


            $this->response([
                    'status' => FALSE,
                    'message' => 'Please Fill all details'
                ], REST_Controller::HTTP_OK); 

        }
			
    }


   
    ################### Logout Function Starts ###########################
    public function logout_post()
    {
        $userid = $this->post('userid');
        $token = trim($this->post('token'));
        if(($userid) && ($token))
        {
             $this->set_response(['status' => true,
                                     'message' => 'Logout Successfully'
                                     ], REST_Controller::HTTP_OK);
                                     
           $logout = $this->auth->deleteusertoken($userid,$token); 
            if($logout>0)
            {
                 $this->set_response(['status' => true,
                                     'message' => 'Logout Successfully'
                                     ], REST_Controller::HTTP_OK);
            } else {
                
                $this->set_response(['status' => false,
                                     'message' => 'You are not authorized'
                                     ], REST_Controller::HTTP_OK);
            }
        } else {
                $this->response([
                        'status' => FALSE,
                        'message' => 'User Id or Token not Found'
                    ], REST_Controller::HTTP_OK);
            
        }
        
    }

   
    
    
    
    ################### Genarate the Token Starts #########################
    public function generatekey_post()
    {
        
        // Get a hex-encoded representation of the key:
        $key = bin2hex($this->encryption->create_key(16));
        $keya = array(
            'key'           => $key,
            'created_on'    => date('Y-m-d H:i:s')
            );
        $keyadd = $this->auth->addkey($keya);
        if($keyadd)
        {
                $this->set_response([
                'token' => $key
            ], REST_Controller::HTTP_OK);
        }
        else
        {
                $this->response([
                'status' => FALSE,
                'message' => 'Token not generated'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    
    ########## Generate Key After Registration ################
    public function generateloginkey()
    {
        
        // Get a hex-encoded representation of the key:
        $key = bin2hex($this->encryption->create_key(16));
        $keya = array(
            'key'           => $key,
            'created_on'    => date('Y-m-d H:i:s')
            );
        $keyadd = $this->auth->addkey($keya);
        if($keyadd)
        {
            return $key;
        }
        else
        {
            return false;
        }
    }
    
    

}

?>
