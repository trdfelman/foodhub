<?php
require_once("../../lib/initialize.php");

if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])){

        if(empty($_POST["name"]) && empty($_POST["email"]) && empty($_POST["password"]) ){
            echo "0";
        }else{
            $name = $dbcore->escape_value($_POST["name"]);
            $email = $dbcore->escape_value($_POST["email"]);
            $password = $dbcore->escape_value($_POST["password"]);

            if($user->create_user($name,$email,$password)){
                echo "1";
            }else{
                echo "Unknown server error";
            }
        }
}