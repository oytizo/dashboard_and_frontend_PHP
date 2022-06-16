<?php
session_start();
$con=mysqli_connect("localhost","root","","ecom");

define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/University_Final_Project/'); //declare for image upload path ---[DOCUMENT_ROOT]=D:/xampserver/htdocs
define('SITE_PATH','http://localhost/University_Final_Project/'); //declare  image server path  for showing image

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/product/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/');

?>