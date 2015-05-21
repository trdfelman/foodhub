<?php

require_once("../../lib/initialize.php");
if ($user->is_logged_in()) {
    echo "1";
} else {
    echo "0";
}