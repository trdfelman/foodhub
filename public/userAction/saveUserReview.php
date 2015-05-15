<?php
require_once("../../lib/initialize.php");

if ($user->is_logged_in()) {
    if (isset($_POST['rating']) && isset($_POST['placeid']) && isset($_POST['reviewtext'])) {
        $rating = $dbcore->escape_value($_POST['rating']);
        $placeid = $dbcore->escape_value($_POST['placeid']);
        $reviewtext = $dbcore->escape_value($_POST['reviewtext']);
        echo $placeid;
        $review = array(
            "placeid" => $placeid,
            "user_info_id" => $user->userid,
            "rating" => $rating,
            "reviewtext" => $reviewtext
        );
        $data = $dbcore->insert('user_review', $review);
        if ($data) {
            echo "saved";
        }
    }

} else {
    echo "not-loggedin";
}
