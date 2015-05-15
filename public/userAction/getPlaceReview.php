<?php
require_once("../../lib/initialize.php");

if(isset($_POST['placeid']) && !empty($_POST['placeid'])){

        $user_review = $dbcore->select('user_review',"user_review.*,user_info.full_name,user_info.user_email"," user_info ON user_info.id=user_review.user_info_id "," user_review.placeid= '".$_POST['placeid']."' ");
        $json_response = array();
        if($dbcore->num_of_rows >=1){
            while($row = $dbcore->fetch_assoc($user_review)){
                array_push($json_response,$row);
            }

            echo json_encode($json_response);
        }
}