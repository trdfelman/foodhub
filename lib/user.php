<?php
require_once("initialize.php");
class User {

    public $usertbl ="user_info";
    public $userid='';
    public $user_email='';
    public $user_password='';
    public  $user_fullname='';

    private $logged_in = false;

    function __construct(){
        session_start();
        $this->check_login();
    }

    public function check_login(){

        if(isset($_SESSION['userid'])){
            $this->userid = $_SESSION['userid'];
            $this->logged_in = true;
            $this->get_userInformation($_SESSION['userid']);
        }else {
            unset($this->userid);
            $this->logged_in=false;
        }
    }

    public  function  is_logged_in(){
        return $this->logged_in;
    }

    public  function user_login($email, $password){
        global $dbcore;
        $where =" user_email='".$dbcore->escape_value(trim($email))."' AND user_password='".$dbcore->escape_value(trim($password))."'  ";

        $query = $dbcore->select($this->usertbl,'*',null,$where);

        if($dbcore->num_of_rows == 1){

            //get all the information about the email and password.
            $found_user = $dbcore->fetch_array($query);
            $this->logged_in = true;
            $_SESSION['userid'] =$found_user['id'];
            $this->userid = $found_user['id'];
            $this->get_userInformation($found_user["id"]);
            return true;
        }else{
            return false;
        }

    }


    public function  user_logout($userid){
        unset($_SESSION['userid']);
        unset($this->userid);
        $this->logged_in=false;
    }

    public  function  get_userInformation($id){
        global $dbcore;
        $userdata = $dbcore->select($this->usertbl,"*",null," id = {$id}");
        $userdata = $dbcore->fetch_array($userdata);

        if($dbcore->num_of_rows == 1){
            $this->userid           = $userdata['id'];
            $this->user_email       = $userdata['user_email'];
            $this->user_password    = $userdata['user_password'];
            $this->user_fullname    = $userdata['full_name'];
        }else{
            return false;
        }

    }

    public  function create_user($name,$email,$password){
        global $dbcore;
        $name  = $dbcore->escape_value($name);
        $email = $dbcore->escape_value($email);
        $password = $dbcore->escape_value($password);

        $insert_user =  $dbcore->insert($this->usertbl,array('full_name'=>$name,'user_email'=>$email,'user_password'=>$password));

        if($insert_user){
            $this->user_login($email,$password);
            return true;
        }

    }



}

$user = new User();


