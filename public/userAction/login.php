<?php
require_once("../../lib/initialize.php");

if(isset($_POST['email']) && isset($_POST['password'])){

    if(empty($_POST['email']) || empty($_POST['password']) ){

        echo json_encode(array("res" =>0));

    }else{
        $user_email = $dbcore->escape_value($_POST['email']);
        $user_pword = $dbcore->escape_value($_POST['password']);
        if($user->user_login($user_email,$user_pword)){

            $response = array("res" =>1,
                "username"=>$user->user_fullname
            );

            echo json_encode($response);
        }else{
            echo json_encode(array("res" =>"Incorrect username or password"));
        }

    }
}