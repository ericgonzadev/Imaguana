<?php
require_once 'core/init.php';
$count = 0;
$validations = "";
$user = new User();
$link = $user->data()->username;
if (!$user->isLoggedIn()) {
    Redirect::to("./login.php");
}
if ($user->data()->group != 1) {
    Redirect::to('./');
}

    $image = new Image();
    if (Input::exist()){
        //Connection
        mysql_connect("sfsuswe.com", "s16g09", "9team2016") or die(mysql_error());
        mysql_select_db("student_s16g09") or die(mysql_error());
        
        //Variables holding the image info
        $filetmpname = $_FILES["image"]["tmp_name"];
        $filename = str_replace(" ", "_", $_FILES["image"]["name"]);
        $title = $_POST['title'];
        $description = $_POST['description'];
        $web = $_POST['web'];
        $print = $_POST['print'];
        $unlimited = $_POST['unlimited'];
        $category = $_POST['category'];
        $tags = $_POST['tags'];
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'title' => array(
                'min' => 3,
                'max' => 30
            ),
            'description' => array(
                'min' => 5,
                'max' => 100,
            )
        ));
        //Check file extension type error
        if($ext != "png" && $ext != "jpg" && $ext != "jpeg" && $ext != "gif" ){
           $validations .= "- You either didn't upload a file or you uploaded a wrong filetype (Must be .png | .jpg | .jpeg | .gif ) <br>";
           $count++; 
        }
       
        if($_FILES["image"]["size"] > 2000000 || $_FILES["image"]["size"] <= 0){
            $validations .= "- The image file is too large. Must be less than 2mb <br>";
           $count++;
        }
        //check that the licenses are integers
        if(!intval($web)){
            $validations .= "- web license value must be a number<br>";
            $count++; 
        }
        if(!intval($print)){
            $validations .= "- print license value must be a number<br>";
            $count++; 
        }
        if(!intval($unlimited)){
            $validations .= "- unlimited license value must be a number<br>";
            $count++; 
        }
        if ($validation->passed() && $validations == "") {
            //Get image contents, name, and size
            $image_name = addslashes($filename);
            list($width, $height) = getimagesize($filetmpname);
            
            //Store original image locally
            $image_path = "uploads/" . $filename;
            move_uploaded_file($filetmpname, $image_path);
            if($width < 900){
            }
            else if($width > 900 && $width < 1275 ){
                $image_path = resize($ext, $width, $height,  $image_path, $filename, "1.5");
            }
            else if($width > 1275 && $width < 1700){
                $image_path = resize($ext, $width, $height,  $image_path, $filename, "2");
            }
            else if($width > 1700 && $width < 2100){
                $image_path = resize($ext, $width, $height,  $image_path, $filename, "2.5");
            }
            else if($width > 2100 && $width < 2500){
                $image_path = resize($ext, $width, $height,  $image_path, $filename, "3");
            }
            else if($width > 2500 && $width < 3000){
                $image_path = resize($ext, $width, $height,  $image_path, $filename, "3.5");
            }
            else if($width > 3000 && $width < 3500){
                $image_path = resize($ext, $width, $height,  $image_path, $filename, "4");
            }
            else if($width > 3500 && $width < 4000){
                $image_path = resize($ext, $width, $height,  $image_path, $filename, "4.5");
            }
            
            //Store image into database.
            $lastid = $image->create( array(
                    'id' => '', 
                    'user_id' => $user_id,
                    'username' => $username,
                    'name' => $image_name,
                    'title' => $title,
                    'description' => $description,
                    'web' => $web,
                    'print' => $print,
                    'unlimited' => $unlimited,
                    'image' => $image_path,
		    'category' => $category,
                    'tags' => $tags ));
            header("location:image/show/". $lastid);
        } 
        else {
            foreach ($validation->errors() as $error) {
                $count++;  
                $validations .= "- {$error} <br>";
            }
        }
    }
    
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
        if ($size == "1.5"){
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
        else if ($size == "3.5"){
            $newWidth = $width/3.5;
            $newHeight = $height/3.5;
        }
        else if ($size == "4"){
            $newWidth = $width/4;
            $newHeight = $height/4;
        }
        else if ($size == "4.5"){
            $newWidth = $width/4.5;
            $newHeight = $height/4.5;
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
<!doctype html>
<head>
    <title>Imaguana | Upload</title>

    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>

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

    <!-- Page Content Section -->
    <div style="margin-top: -50px;"class="container ws-page-container">
        <div class="row">
            <div class="row">
                <div class="ws-works-title clearfix">
                    <div class="col-sm-12">
                        <h3>Upload Image:  <?php echo $user->data()->username; ?></h3> 
                        <div class="ws-separator"></div>   
                    </div>
                    <?php   if ($count > 0){echo "<p style='text-align: center; color: red'>" . $count . " error(s)</p><p style='text-align: center; color: red'>" . $validations . "</p><br>";}?>
                </div>   
                <div class="ws-contact-page">
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal ws-contact-form">
                        <!-- Left Pane -->
                        <div class="col-sm-5">
                            <div class="item">
                                <div id="dropzone" class="dropzone">
                                    <input name="image" type="file" id="idupload" onchange="imagepreview(this);" class="text-center center-block well well-sm" />
                                    <img class="text-center center-block well well-sm" id="imgpreview" alt="Image Preview" width="450"/>
                                </div>
                            </div>
                        </div>
                        <!-- End Left Pane -->

                        <!-- Right Pane -->
                        <div class="col-sm-7">
                            <h5 style="text-align: center; color: black;">All fields marked with * are required</h5>
                            <div class="ws-contact-info">
                                <h2>Title<span>*</span></h2>
                                <textarea class="form-control" required="true" name="title" id="title" rows="1" cols="100"  placeholder="Enter a title for your image" style="resize:none;"><?php echo Input::get('title'); ?></textarea> <br>
                                <h2>Description<span>*</span></h2>
                                <textarea class="form-control" name="description" required="true" id="description" rows="3" cols="100" placeholder="Add some descriptive text for your image" style="resize:none;"><?php echo Input::get('description'); ?></textarea><br/><br/>
                                <h2>License<span>*</span>   
                                    <a data-toggle="modal" data-target="#License" >
                                        <img style='height:16px; width:16px;' alt='assets/img/help.gif' src='assets/img/help.gif' >
                                    </a>

                                    <table style="margin-top: 10px;">
                                        <tr>
                                            <td ><label class="control-label" style="color: black;">Web* $</label></td>
                                            <td style="padding-right: 20px"><textarea name="web" id="web" required="true" class="form-control-upload" rows="1" cols="10" style="resize:none; color:black;" ><?php echo Input::get('web'); ?></textarea><p class="pull-right"></p></td>

                                            <td ><label class="control-label" style="color: black;">Print* $</label> </td>
                                            <td style="padding-right: 20px"><textarea name="print" required="true" id="print" class="form-control-upload" rows="1" cols="10" style="resize:none; color:black;"><?php echo Input::get('print'); ?></textarea> <p class="pull-right"></p></td>

                                            <td ><label class="control-label" style="color: black;">Unlimited* $</label> </td>
                                            <td style="padding-right: 20px"><textarea name="unlimited" required="true" id="unlimited" class="form-control-upload" rows="1" cols="10"style="resize:none; color:black;"><?php echo Input::get('unlimited'); ?></textarea><p class="pull-right"></p></td> 
                                        </tr>
                                    </table>

                                </h2><br>
                                <h2>Category*
                                    <select for="category" name="category" id="category" >
                                        <option value="Animal" <?php if(Input::get('category') == "Animal"){echo "selected";}?>>Animal</option>
                                        <option value="Beauty" <?php if(Input::get('category') == "Beauty"){echo "selected";}?>>Beauty</option>
                                        <option value="City" <?php if(Input::get('category') == "City"){echo "selected";}?>>City</option>
                                        <option value="Education"<?php if(Input::get('category') == "Education"){echo "selected";}?>>Education</option>
                                        <option value="Fashion" <?php if(Input::get('category') == "Fashion"){echo "selected";}?>>Fashion</option>
                                        <option value="Food" <?php if(Input::get('category') == "Food"){echo "selected";}?>>Food</option>
                                        <option value="Landmark" <?php if(Input::get('category') == "Landmark"){echo "selected";}?>>Landmark</option>
                                        <option value="Nature" <?php if(Input::get('category') == "Nature"){echo "selected";}?>>Nature</option>
                                        <option value="Science" <?php if(Input::get('category') == "Science"){echo "selected";}?>>Science</option>
                                        <option value="Space" <?php if(Input::get('category') == "Space"){echo "selected";}?>>Space</option>
                                        <option value="Sport" <?php if(Input::get('category') == "Sport"){echo "selected";}?>>Sport</option>
                                        <option value="Vintage" <?php if(Input::get('category') == "Vintage"){echo "selected";}?>>Vintage</option>
                                    </select>
                                </h2><br/>
                                <h2>Search Keywords (Tags)</h2>
                                <textarea class="form-control" name="tags" id="tags" rows="3" cols="100" placeholder="Input keywords that will help people search for your image. &nbsp; Examples: &nbsp; Categories, &nbsp;Colors, &nbsp;Style, &nbsp;etc." style="resize:none;" ><?php echo Input::get('tags'); ?></textarea>

                                <div class="col-sm-11">
                                    <!-- Button -->
                                    <input class="btn ws-btn-fullwidth" style="margin-top: 15px; width: 300px;" type="submit" value="Upload" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="user/profile/<?php echo $user->data()->username; ?>" class="btn ws-btn-black" style="color: white; margin-top: 15px; width: 250px" >Cancel</a>
                                </div>
                                <input type="hidden" name="user_id" id="user_id" value=" <?php echo $user->data()->id; ?>">
                                <input type="hidden" name="username" id="username" value=" <?php echo $user->data()->username; ?>">
                            </div>

                        </div>
                        <!-- End Right Pane -->
                    </form>

                </div>
            </div>

        </div>
    </div>
    <!-- End Page Content Section -->


    <!-- DEFINING WEB, Print, and Unlimited License -->
    <div id="License" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">Types of Licenses</h3>
                </div>
                <div class="modal-body">

                    <h3>Web</h3>
                    <p>You will receive a URL that you can use on your website to display the image.</p>

                    <h3>Print</h3>
                    <p>You will receive a downloadable file of the image.</p>

                    <h3>Unlimited</h3>
                    <p>You will receive the URL and the downloadable file of the image.</p>

                </div>
                <div class="modal-footer">
                    <a class="btn ws-btn-fullwidth" style="color: white; margin-top: 15px; width: 250px" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Foot Bar -->
    <?php include 'view/foot-bar.php'; ?>

    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>

</body>
</html>
