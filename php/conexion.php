<?php
$link = mysqli_connect("sql301.byethost7.com","b7_27915800","891n6jvh","b7_27915800_laboratorio");
if(mysqli_connect_error()){
    die('ERROR: Unable to connect:' . mysqli_connect_error());
    echo "<script>window.alert('Hi!')</script>";
}
?>