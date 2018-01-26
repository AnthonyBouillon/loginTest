<?php

session_start();
session_destroy();
echo 'DECO';
header('refresh:2,url=connexion.php');
