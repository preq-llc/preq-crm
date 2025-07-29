<?php
    // $conn = mysqli_connect('192.168.200.82', 'zeal', '4321', 'zealous');
    $con70 = mysqli_connect('192.168.200.70', 'zeal', '4321', 'asterisk');

    if(!$con70)
    {
        echo 'Mysql Error :'.mysqli_connect_error();
    }
?>