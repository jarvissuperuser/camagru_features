<?php
 $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
 require $projectRoot."Sources/BackEnd/controller/relativePathController.php";
/* 
 * rels
 */
if (strlen(filter_input(INPUT_POST, "meta"))>0){ 
  
  $target_dir = ServerRoot."/Resources";
  $uploadOk = 1;
  if(strlen(filter_input(INPUT_POST, "meta"))>0) {
    $type = filter_input(INPUT_POST, "meta");
    
    $date = time();
    $data = hash('sha256', $date);
		echo $data.'.'.$type .":" .file_put_contents("$projectRoot/Resources/$data".'.'.$type, base64_decode(filter_input(INPUT_POST,'filedata'))) ;
  }
}
else if (isset ($_FILES['mov']['error'])){
  echo "error";
}
?>

