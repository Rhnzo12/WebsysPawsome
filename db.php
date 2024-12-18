<?php

$db = mysqli_connect('localhost', 'root', '', 'paw_some');

if(!$db){
    die('Connection Failed' . mysqli_connect_errno());
}
?>