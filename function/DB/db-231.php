<?php
    // $conn = mysqli_connect('192.168.200.82', 'zeal', '4321', 'zealous');
    $conn = mysqli_connect('localhost', 'root', '', 'zealous');

    if(!$conn)
    {
        echo 'Mysql Error :'.mysqli_connect_error();
    }
?>