<?php

    define("URL", "localhost");
    define("USER", "root");
    define("PW", "506greendg@");
    define("DB_NAME", "board4");

    function data(){
        return mysqli_connect(URL, USER, PW, DB_NAME);
    }


?>