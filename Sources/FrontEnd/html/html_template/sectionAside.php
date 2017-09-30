<?php

    $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
    require $projectRoot."Sources/BackEnd/controller/relativePathController.php";

    //Session Creation
    session_start();

    //Global Variables
    $divOneLikes = 0;
    $divOneDislikes = 0;
    $divTwoLikes = 0;
    $divTwoDislikes = 0;
    $divThreeLikes = 0;
    $divThreeDislikes = 0;
    $divFourLikes = 0;
    $divFourDislikes = 0;
    $divFiveLikes = 0;
    $divFiveDislikes = 0;
?>

<script>

//    function ft_galleryLikeCountOne() {
//
//        var divOneLikeClickObj = {
//
//            "divOneLikeClick":1
//        };
//        location.replace('?params='+encodeURIComponent(JSON.stringify(divOneLikeClickObj)));
//    }
</script>

<aside class="sectionAsideClass">

    <div class="headerDivsSectionAside">
        <h2>Camagru Gallery</h2>
    </div>
    <div class="fiveDivContainer">

        <?php

            function json_decode_nice($json, $assoc = TRUE){
                $json = str_replace(array("\n","\r"),"\\n",$json);
                $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
                $json = preg_replace('/(,)\s*}$/','}',$json);
                return json_decode($json,$assoc);
            }

            if (isset($_GET['params']) && $params=json_decode($_GET['params'])) {

                $divOneLikesJSON = json_decode_nice(json_encode($params), true)['divOneLikeClick'];
                $divOneLikesJSON = (int)$divOneLikesJSON;

                if ($divOneLikesJSON == 1) {

                    $_SESSION['divOneLikes'] += 1;
                }
                $divOneLikes = $_SESSION['divOneLikes'];
            }
        ?>

        <div class="divOne">

            <img src="../../../../Resources/donate-button.gif" class="thumbNails">

            <div class="like">Likes: <?php echo $divOneLikes;?></div>

            <button class="upvoteButton" onclick="ft_like(event)">

                <img src="../../../../Resources/smilys.png">
            </button>

            <button class="downvoteButton" onclick="ft_like(event)">

                <img src="../../../../Resources/smilys.png">
            </button>
        </div>

        <div class="divTwo">

            <img src="../../../../Resources/image-1.jpg" class="thumbNails">
            <div class="like">Likes: <?php echo $divTwoLikes;?></div>
            <button class="upvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
            <button class="downvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
        </div>

        <div class="divThree">

            <img src="../../../../Resources/thumb-1.jpg" class="thumbNails">
            <div class="like">Likes: <?php echo $divThreeLikes;?></div>
            <button class="upvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
            <button class="downvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
        </div>

        <div class="divFour">

            <img src="../../../../Resources/lv.jpg" class="thumbNails">
            <div class="like">Likes: <?php echo $divFourLikes;?></div>
            <button class="upvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
            <button class="downvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
        </div>

        <div class="divFive">

            <img src="../../../../Resources/bullet.gif" class="thumbNails">
            <div class="like">Likes: <?php echo $divFiveLikes;?></div>
            <button class="upvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
            <button class="downvoteButton" onclick="ft_like(event)">
                <img src="../../../../Resources/smilys.png">
            </button>
        </div>

    <div class="paginationclass">

			<a class="prev" href="#" onclick="ft_prev()">

                Prev
        </a>
			<a class="next" href="#" onclick="ft_next()">

                Next
        </a>
    </div>
</aside>
