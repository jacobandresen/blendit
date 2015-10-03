<?php

$navn=$_REQUEST['navn'];
$historie=$_REQUEST['historie'];

$navn = filter_var($navn, FILTER_SANITIZE_STRING);
$historie = filter_var($historie, FILTER_SANITIZE_STRING);

file_put_contents("historier.txt","<b>". $navn ."</b><br>\r\n", FILE_APPEND);
file_put_contents("historier.txt", $historie, FILE_APPEND);
file_put_contents("historier.txt", "<hr/>", FILE_APPEND);
