<?php

function redirect_to($location)
{
    if ($location != NULL && !empty($location)) {
        header("Location: {$location}");
        exit;
    }
}