<?php
require_once("../../lib/initialize.php");

$user->user_logout($user->userid);

if (!$user->is_logged_in()) {
    redirect_to("../../");
}
?>