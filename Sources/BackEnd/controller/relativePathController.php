<?php

    //Setup Sever Root Constant
    $currentPWD = getcwd();
    $currentPWDtoRoot = substr($currentPWD, 0, strpos($currentPWD, "Sources"));
    define("ServerRoot", "$currentPWDtoRoot", true);

//    Config Controllers
    require_once ServerRoot."Sources/BackEnd/config/database.php";
    require_once ServerRoot."Sources/BackEnd/config/setup.php";
    require_once ServerRoot."Sources/BackEnd/engine/sqlRequestHandler.php";
    require_once ServerRoot."Sources/BackEnd/controller/sqlControllerInterface.php";
    require_once ServerRoot."Sources/BackEnd/controller/DBControllerclass.php";
    require_once ServerRoot."Sources/BackEnd/engine/Userclass.php";
    require_once ServerRoot."Sources/BackEnd/validationDTO.php";

    //HTML Template Controllers
    $headerTemplate = ServerRoot."Sources/FrontEnd/html/html_template/header.php";
    $footerTemplate = ServerRoot."Sources/FrontEnd/html/html_template/footer.php";
    $sectionMainTemplate = ServerRoot."Sources/FrontEnd/html/html_template/sectionMain.php";
    $sectionAsideTemplate =  ServerRoot."Sources/FrontEnd/html/html_template/sectionAside.php";
    $linkCSS = ServerRoot.'Sources/FrontEnd/css/indexLogin.css';


