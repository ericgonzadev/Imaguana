<?php
require_once 'core/init.php';
$user = new User();

$preview = $_SESSION['previewimage'];
$image_id = $_SESSION['imageid'];
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
        <link rel="stylesheet" type="text/css" href="assets/css/component.css" />  

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
               $validations = 'Error: No background image was selected';
            }
            // Check for file size erro
            else if ($_FILES["image"]["size"] > 2000000 || $_FILES["image"]["size"] <= 0){
                 $validations = 'Error: File size must be less than 2mb';
            }
            //Check file extension type error
            else if($ext != "png" && $ext != "jpg" && $ext != "jpeg" && $ext != "gif" ){
                $validations = 'Error: File type must be .png | .jpg | .jpeg | .gif';
            }
            if ($validations == ""){
            //Get image contents, name and size
            $image = addslashes(file_get_contents($filetmpname));
            $image_name = addslashes($filename);
            list($width, $height) = getimagesize($filetmpname);

            //Store original image locally to resize it to small and medium
            move_uploaded_file($filetmpname, "assets/img/backgrounds/" . $filename);
            $image_path = "assets/img/backgrounds/" . $filename;
            }
        ?>
            
            <div class="col-sm-11" style="text-align: center; margin-top: -20px; margin-left: 24px;" >
                <ul style="margin-bottom: 30px;">  
                            <li class="ws-shop-cart" type='none'>
                                <a href="preview.php" class="btn btn-sm">Upload another Background picture</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="image/show/<?php echo $image_id ?>" class="btn btn-sm " style="width: 340px;">Go back to the image details</a>
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
                    <div class="component" style="height: <?php echo $height ?>px; width: <?php echo $width ?>px; background: url(<?php echo $image_path ?>) no-repeat;">
                        <img class="resize-image" src="<?php echo $preview ?>" alt="image for resizing">
                    </div>
                    <?php } ?>
                </div><!-- /content -->
            </div> <!-- /container -->
        <?php } ?>          
        </div>
        
        <script src="assets/js/jquery-2.1.1.min.js"></script>
        <script src="assets/js/component.js"></script>
        
        <!-- Foot Bar -->
        <?php include 'view/foot-bar.php'; ?>

        <!-- Scripts -->
        <?php include 'view/scripts.php' ?>
    </body>
</html>