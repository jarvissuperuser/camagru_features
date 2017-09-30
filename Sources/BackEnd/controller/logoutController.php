<?php
session_start();
    //Kill Sessions
session_destroy();

    //Redirect To Index
    header('Location: ../../../index.php');