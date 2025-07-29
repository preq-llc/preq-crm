<?php
    $conn = mysqli_connect('localhost', 'zeal', '4321', 'zealousv2');
    // $conn = mysqli_connect('localhost', 'root', '', 'zealous');

    if(!$conn)
    {
        echo 'Mysql Error :'.mysqli_connect_error();
    }
?>