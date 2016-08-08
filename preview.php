<?php
require_once 'core/init.php';
$user = new User();
$validations = "";
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <title>Imaguana | Preview</title>

        <!-- CSS, Meta, Ajax, etc. -->
        <?php include 'view/head.php' ?>
        <link rel="stylesheet" type="text/css" href="assets/css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/preview.css" />

        <!--Image preview -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script type="text/javascript">
            function imagepreview(input) {
                if (input.files && input.files[0]) {
                    var filerd = new FileReader();
                    filerd.onload = function (e) {
                        $('#imgpreview').attr('src', e.target.result);
                    };
                    filerd.readAsDataURL(input.files[0]);
                }
            }
        </script>        
    </head>
    <body>

        <!-- Navigation Bar -->
        <?php include 'view/nav-bar.php'; ?>
        
        <!-- Page Content -->
        <div class="container ws-page-container">
            <div class="ws-works-title clearfix">
                <div class="col-sm-12">
                    <h3 style="font-size: 25px; margin-top: -75px;">Image Preview</h3>
                    <div class="ws-separator"></div>
                </div>
            </div> 
       
        <?php if(!isset($_POST['submit'])){ ?>
         <div>
            <br><p style="color:black; font-size: 20px; text-align: center; margin-top: -28px; margin-bottom: 20px;">Upload a Background Picture to Preview the Image</p>
            <form method="POST" enctype="multipart/form-data" >  
                <input style="color:black; font-size: 18px;"name="image" type="file" id="idupload" onchange="imagepreview(this);" class="text-center center-block well well-sm" />
                <img style="color:black; font-size: 12px;" class="text-center center-block well well-sm" id="imgpreview" alt="Image Preview" width="450"/>
                <input style="margin-left: 42%; color: white; font-size: 18px; height: 50px; width: 200px;" class="btn ws-btn-fullwidth" type="submit" value="Upload" name="submit">
            </form>
         </div>
        <?php }
        else{ 
            //Variables holding the image info
            $filetmpname = $_FILES["image"]["tmp_name"];
            $filename = str_replace(" ", "_", $_FILES["image"]["name"]);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            
            if(empty($filename)){
               $validations = 'Error: No background image was selected. Please try another image.';
            }
            // Check for file size erro
            else if ($_FILES["image"]["size"] > 2000000 || $_FILES["image"]["size"] <= 0){
                 $validations = 'Error: File size must be less than 2mb. Please try another image.';
            }
            //Check file extension type error
            else if($ext != "png" && $ext != "jpg" && $ext != "jpeg" && $ext != "gif" ){
                $validations = 'Error: File type must be .png | .jpg | .jpeg | .gif. Please try another image';
            }
            if ($validations == ""){
                //Get image contents, name and size
                $image = addslashes(file_get_contents($filetmpname));
                $image_name = addslashes($filename);
                list($width, $height) = getimagesize($filetmpname);

                $image_path = getenv('OPENSHIFT_DATA_DIR') . "/preview/" . $filename;
                move_uploaded_file($filetmpname, $image_path);
                if($width < 1200){
                }
                else if($width > 1200 && $width <= 1500 ){
                    $image_path = resize($ext, $width, $height,  $image_path, $filename, "1.25");
                }
                else if($width > 1500 && $width <= 1800){
                    $image_path = resize($ext, $width, $height,  $image_path, $filename, "1.5");
                }
                else if($width > 1800 && $width <= 2200){
                    $image_path = resize($ext, $width, $height,  $image_path, $filename, "2");
                } 
                else if($width > 2200 && $width <= 2600){
                    $image_path = resize($ext, $width, $height,  $image_path, $filename, "2.5");
                }  
                else if($width > 2600){
                    $image_path = resize($ext, $width, $height,  $image_path, $filename, "3");
                }
            }
            list($width, $height) = getimagesize($image_path);
        ?>
            
            <div class="col-sm-11" style="text-align: center; margin-top: -20px; margin-left: 24px;" >
                <ul style="margin-bottom: 30px;">  
                    <li class="ws-shop-cart" type='none'>
                        <a href="/image/preview/<?php echo $image->data()->id; ?>" class="btn btn-sm">Upload another Background image</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="image/show/<?php echo $image->data()->id; ?>" class="btn btn-sm " style="width: 340px;">Go back to the image details</a>
                    </li>
                </ul>
            </div><br><br>
            <div class="container">
                <!-- Top Navigation -->
                <div class="codrops-top clearfix">
                </div>
                <div class="content">
                    <?php if ($validations != "") { ?>                    
                    <header class="codrops-header">  
                    <div class="a-tip">
                        <br><br>
                        <p style="color: red; font-size: 20px; margin-top: -20px; margin-bottom: 10px;"><?php echo $validations ?></p>
                    </div>
                    </header>                   
                    <?php }else{ ?>
                     <header class="codrops-header">  
                    <div class="a-tip">
                        <p style="color: black; font-size: 20px; margin-top: -20px; margin-bottom: 10px;"><strong>Tip: </strong> Hold <span>SHIFT</span> while resizing to keep the original aspect ratio.</p>
                    </div>
                    </header>  
                    <div class="component" style="height: <?php echo $height ?>px; width: <?php echo $width ?>px; background: url(<?php echo 'preview/preview/' . $filename ?>) no-repeat;">
                        <img class="resize-image" src="<?php echo $image->data()->image; ?>" alt="image for resizing">
                    </div>
                    <?php } ?>
                </div><!-- /content -->
            </div> <!-- /container -->
        <?php } 

            function resize($ext, $width, $height, $image_path, $filename, $size){
                //Create medium size picture
                switch ($ext){
                    case "png":
                        $src= imagecreatefrompng($image_path);
                        break;
                    case "gif":
                        $src= imagecreatefromgif($image_path);
                        break;
                    default:
                        $src= imagecreatefromjpeg($image_path);
                }
                if ($size == "1.25"){
                    $newWidth = $width/1.25;
                    $newHeight = $height/1.25;
                }
                else if ($size == "1.5"){
                    $newWidth = $width/1.5;
                    $newHeight = $height/1.5;
                }
                else if ($size == "2"){
                    $newWidth = $width/2;
                    $newHeight = $height/2;
                }
                else if ($size == "2.5"){
                    $newWidth = $width/2.5;
                    $newHeight = $height/2.5;
                }
                else if ($size == "3"){
                    $newWidth = $width/3;
                    $newHeight = $height/3;
                }
                $tmp = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($tmp, $src, 0,0,0,0, $newWidth, $newHeight, $width, $height);
                switch ($ext){
                    case "png":
                        imagepng($tmp, $image_path , 9);
                        break;
                    case "gif":
                        imagegif($tmp, $image_path , 100);
                        break;
                    default:
                        imagejpeg($tmp, $image_path , 100);
                }
                imagedestroy($src);
                imagedestroy($tmp);
                return $image_path;
            }
        ?>          
        </div>
        
        <script src="assets/js/jquery-2.1.1.min.js"></script>
        <script src="assets/js/component.js"></script>
        
        <!-- Foot Bar -->
        <?php include 'view/foot-bar.php'; ?>

        <!-- Scripts -->
        <?php include 'view/scripts.php' ?>
    </body>
</html>