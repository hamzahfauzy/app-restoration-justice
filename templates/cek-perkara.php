<?php 
if(isset($_GET['logout']))
{
    unset($_SESSION['cek_perkara']);
}

$auth = $_SESSION['cek_perkara']??false;
if($auth)
    require 'cek-perkara/index.php';
else
    require 'cek-perkara/login.php';