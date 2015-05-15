<?php
require_once("../../lib/initialize.php");

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["id"])) {

    $dbcore->select('user_info', "*", null, "  id='" . $_POST["id"] . "' ");
    if ($dbcore->num_of_rows == 1) {
        if (empty($_POST["name"]) && empty($_POST["email"]) && empty($_POST["id"])) {
            echo "0";
        } else {
            $name = $dbcore->escape_value($_POST["name"]);
            $email = $dbcore->escape_value($_POST["email"]);
            $id = $dbcore->escape_value($_POST["id"]);
            if ($dbcore->update('user_info', array("full_name" => $name, "user_email" => $email), " id='" . $_POST["id"] . "' ")) {
                $_SESSION['userid'] = $id;
                echo "1";
            } else {
                echo "Unknown server error";
            }
        }
    } else if ($dbcore->num_of_rows < 1) {
        if (empty($_POST["name"]) && empty($_POST["email"]) && empty($_POST["id"])) {
            echo "0";
        } else {
            $name = $dbcore->escape_value($_POST["name"]);
            $email = $dbcore->escape_value($_POST["email"]);
            $id = $dbcore->escape_value($_POST["id"]);

            if ($dbcore->insert('user_info', array("id" => $id, "full_name" => $name, "user_email" => $email, "user_password" => ''))) {
                $_SESSION['userid'] = $id;
                echo "1";
            } else {
                echo "Unknown server error";
            }
        }
    }

}
