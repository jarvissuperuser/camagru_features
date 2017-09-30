<?php

    session_start();

    //Global Variables
    $dbUsername = $_SESSION['dbUsername'];
    $pageTypeCheck = $_SESSION['pageTypeCheck'];

//    echo '<header class="headerClass">Header</header>';
?>
<header class="headerClass">

    <h1>
        <?php

            if ($pageTypeCheck == 'mainPage') {

                echo "Welcome to Camagru: ";
                echo ucfirst($dbUsername);
            } elseif ($pageTypeCheck == 'indexPage') {

                echo "Welcome to Camagru";
								
								
            }
        ?>
    </h1>
    <?php

        if ($pageTypeCheck == 'mainPage') {

            echo "<a href='../../../BackEnd/controller/logoutController.php' class='logoutButtonClass'>Logout</a>";
						echo '<a href="ShowCase.php" class="logoutButtonClass" >Show Case</a>';
        }
    ?>
	
	
</header>
