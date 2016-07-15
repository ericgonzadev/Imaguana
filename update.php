<?php
require_once 'core/init.php';
$validations = "";
$count = 0;
$user = new User();
$link = $user->data()->username;
if (!$user->isLoggedIn()) {
    Redirect::to("./login.php");
}

if($user->data()->group == 3){
    $u = new User();
    $u->find($_POST['auser']);
    $link = $u->data()->username;
    if (Input::exist()) {
        if (Token::check(Input::get('token'))) {
            if (Input::get('email') == $u->data()->email) {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'min' => 2,
                        'max' => 20
                    ),
                    'email' => array(
                    ),
                    'bio' => array(
                    ),
                    'facebook' => array(
                    ),
                    'instagram' => array(
                    ),
                    'twitter' => array(
                    ),
                    'website' => array(
                    )

                ));
            } else {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'min' => 2,
                        'max' => 20
                    ),
                    'email' => array(
                        'unique' => 'users'
                    ),
                    'bio' => array(
                    ),
                    'facebook' => array(
                    ),
                    'instagram' => array(
                    ),
                    'twitter' => array(
                    ),
                    'website' => array(
                    )
                ));
            }
            if ($validation->passed()) {
                try {
                    $u->update(array(
                        'name' => Input::get('name'),
                        'email' => Input::get('email'),
                        'bio' => Input::get('bio'),
                        'facebook' => Input::get('facebook'),
                        'instagram' => Input::get('instagram'),
                        'twitter' => Input::get('twitter'),
                        'website' => Input::get('website')

                    ));
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                $filename = str_replace(" ", "_", $_FILES["image"]["name"]);
                if ($filename != "") {
                    try {
                        $u->update(array(
                            'profile_picture_path' => $filename
                        ));

                        $filetmpname = $_FILES["image"]["tmp_name"];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);

                        //Get image contents, name, and size
                        $image_name = addslashes($filename);
                        list($width, $height) = getimagesize($filetmpname);

                        //Store original image locally
                        $image_path = "assets/img/profile_pictures/" . $filename;
                        move_uploaded_file($filetmpname, $image_path);
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
                Redirect::to("user/profile/$link");
            } else {
                foreach ($validation->errors() as $error) {
                    $count++;
                }
                foreach ($validation->errors() as $error) {
                    $validations .= "- {$error} <br>";
                }
            }
        }
    }
}
else{
    if (Input::exist()) {
        if (Token::check(Input::get('token'))) {
            if (Input::get('email') == $user->data()->email) {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'min' => 2,
                        'max' => 20
                    ),
                    'email' => array(
                    ),
                    'bio' => array(
                    ),
                    'facebook' => array(
                    ),
                    'instagram' => array(
                    ),
                    'twitter' => array(
                    ),
                    'website' => array(
                    )

                ));
            } else {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'min' => 2,
                        'max' => 20
                    ),
                    'email' => array(
                        'unique' => 'users'
                    ),
                    'bio' => array(
                    ),
                    'facebook' => array(
                    ),
                    'instagram' => array(
                    ),
                    'twitter' => array(
                    ),
                    'website' => array(
                    )
                ));
            }
            if ($validation->passed()) {
                try {
                    $user->update(array(
                        'name' => Input::get('name'),
                        'email' => Input::get('email'),
                        'bio' => Input::get('bio'),
                        'facebook' => Input::get('facebook'),
                        'instagram' => Input::get('instagram'),
                        'twitter' => Input::get('twitter'),
                        'website' => Input::get('website')

                    ));
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                $filename = str_replace(" ", "_", $_FILES["image"]["name"]);
                if ($filename != "") {
                    try {
                        $user->update(array(
                            'profile_picture_path' => $filename
                        ));

                        $filetmpname = $_FILES["image"]["tmp_name"];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);

                        //Get image contents, name, and size
                        $image_name = addslashes($filename);
                        list($width, $height) = getimagesize($filetmpname);

                        //Store original image locally
                        $image_path = "assets/img/profile_pictures/" . $filename;
                        move_uploaded_file($filetmpname, $image_path);
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
                Redirect::to("user/profile/$link");
            } else {
                foreach ($validation->errors() as $error) {
                    $count++;
                }
                foreach ($validation->errors() as $error) {
                    $validations .= "- {$error} <br>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<head>
    <title>Imaguana | Edit Profile</title>

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

</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>
            
    <?php if($user->data()->group == 3){ ?>
    <div class="container" style="margin-bottom: 10px;">
        <div class="ws-works-title clearfix">
            <br>
            <div class="col-sm-12">
                <h3 style="font-size: 25px">Edit Profile: <?php echo $u->data()->username; ?></h3>
                <div class="ws-separator"></div> 
            </div>
        </div> 
        <div class="row">
            <?php
            if ($count != 0) {
                echo "<p style='text-align: center; color: red;'>{$count} error(s) </p>";
                echo "<p style='text-align: center; color: red;'>{$validations} </p>";
            }
            ?>
            <!-- left column -->
            <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="text-center">
                        <?php echo "assets/img/profile_pictures/" . $u->data()->profile_picture_path ?>
                        <img height="210" width="510"src="assets/img/profile_pictures/<?php echo $u->data()->profile_picture_path ?>" class="avatar img-circle img-thumbnail" alt="avatar"><br><br>
                        <h3 style="color: black;">Change your profile picture</h3><br>  
                        <input name="image" type="file" id="fileToUpload" onchange="imagepreview(this);" class="text-center center-block well well-sm" /><br>
                        <p style="color:black;" >New Profile Picture Preview:</p>
                        <img id="imgpreview" alt="Preview will be displayed here" width="450" class="avatar img-circle img-thumbnail"/>
                    </div>
                </div>
                <!-- edit form column -->
                <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                    <h3 style="align-content: center; margin-left: 330px; color: black;"><u>Personal Info</u></h3><br>
                    <div  class="form-group">
                        <label class="col-lg-3 control-label" for="name">Name: </label><div class="col-lg-8">
                            <input required="true" class="form-control" type="text" name="name" id="name" value="<?php echo $u->data()->name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="email">Email</label>
                        <div class="col-lg-8">
                            <input required="true" class="form-control" type="email" name="email" id="email" value="<?php echo $u->data()->email; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bio:</label>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="4" style="resize: none;" name="bio" id="bio" ><?php echo $u->data()->bio; ?></textarea>
                        </div>
                    </div>
                     <div  class="form-group">
                        <label class="col-lg-3 control-label" for="facebook">Facebook: </label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="facebook" id="facebook" placeholder="ex: https://www.facebook.com/Imaguana" accept="" value="<?php echo $u->data()->facebook; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instagram">Instagram: </label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="instagram" id="instagram" placeholder="ex: https://www.instagram.com/imaguana" value="<?php echo $u->data()->instagram; ?>">
                        </div>
                    </div>
                    <div  class="form-group">
                        <label class="col-lg-3 control-label" for="twitter">Twitter: </label><div class="col-lg-8">
                            <input class="form-control" type="text" name="twitter" id="twitter" placeholder="ex: https://twitter.com/imaguana648" value="<?php echo $u->data()->twitter; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="website">Website: </label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="website" id="website" placeholder="ex: http://www.yourwebsite.com/" value="<?php echo $u->data()->website; ?>">
                        </div>
                    </div>
                    <div class="form-group" style="margin-left: 100px;">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-10 col-md-offset-2">
                            <div class="col-sm-11">
                                <!-- Button -->
                                <input class="btn ws-btn-fullwidth" style=" width: 200px;" type="submit" value="Update Profile" name="submit">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="user/profile/<?php echo $u->data()->username; ?>" class="btn ws-btn-black" style="color: white; width: 150px" >Cancel</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="auser" value="<?php echo $_POST['auser']; ?>"> 
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"> 
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?> 
    <div class="container" style="margin-bottom: 10px;">
        <div class="ws-works-title clearfix">
            <br>
            <div class="col-sm-12">
                <h3 style="font-size: 25px">Edit Profile: <?php echo $user->data()->username; ?></h3>
                <div class="ws-separator"></div> 
            </div>
        </div> 
        <div class="row">
            <?php
            if ($count != 0) {
                echo "<p style='text-align: center; color: red;'>{$count} error(s) </p>";
                echo "<p style='text-align: center; color: red;'>{$validations} </p>";
            }
            ?>
            <!-- left column -->
            <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="text-center">
                        <img height="210" width="510"src="assets/img/profile_pictures/<?php echo ($user->data()->profile_picture_path == "") ? 'avatar.jpg' : $user->data()->profile_picture_path ?>" class="avatar img-circle img-thumbnail" alt="avatar"><br><br>
                        <h3 style="color: black;">Change your profile picture</h3><br>  
                        <input name="image" type="file" id="fileToUpload" onchange="imagepreview(this);" class="text-center center-block well well-sm" /><br>
                        <p style="color:black;" >New Profile Picture Preview:</p>
                        <img id="imgpreview" alt="Preview will be displayed here" width="450" class="avatar img-circle img-thumbnail"/>
                    </div>
                </div>
                <!-- edit form column -->
                <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                    <h3 style="align-content: center; margin-left: 330px; color: black;"><u>Personal Info</u></h3><br>
                    <div  class="form-group">
                        <label class="col-lg-3 control-label" for="name">Name: </label><div class="col-lg-8">
                            <input required="true" class="form-control" type="text" name="name" id="name" value="<?php echo $user->data()->name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="email">Email</label>
                        <div class="col-lg-8">
                            <input required="true" class="form-control" type="email" name="email" id="email" value="<?php echo $user->data()->email; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bio:</label>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="4" style="resize: none;" name="bio" id="bio" ><?php echo $user->data()->bio; ?></textarea>
                        </div>
                    </div>
                     <div  class="form-group">
                        <label class="col-lg-3 control-label" for="facebook">Facebook: </label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="facebook" id="facebook" placeholder="ex: https://www.facebook.com/Imaguana" accept="" value="<?php echo $user->data()->facebook; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instagram">Instagram: </label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="instagram" id="instagram" placeholder="ex: https://www.instagram.com/imaguana" value="<?php echo $user->data()->instagram; ?>">
                        </div>
                    </div>
                    <div  class="form-group">
                        <label class="col-lg-3 control-label" for="twitter">Twitter: </label><div class="col-lg-8">
                            <input class="form-control" type="text" name="twitter" id="twitter" placeholder="ex: https://twitter.com/imaguana648" value="<?php echo $user->data()->twitter; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="website">Website: </label>
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="website" id="website" placeholder="ex: http://www.yourwebsite.com/" value="<?php echo $user->data()->website; ?>">
                        </div>
                    </div>
                    <div class="form-group" style="margin-left: 100px;">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-10 col-md-offset-2">
                            <div class="col-sm-11">
                                <!-- Button -->
                                <input class="btn ws-btn-fullwidth" style=" width: 200px;" type="submit" value="Update Profile" name="submit">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="user/profile/<?php echo $user->data()->username; ?>" class="btn ws-btn-black" style="color: white; width: 150px" >Cancel</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"> 
                </div>
            </form>
        </div>
    </div>
     <?php } ?>

    <!-- Foot Bar -->
    <div style="margin-top: 100px;">
        <?php include 'view/foot-bar.php'; ?>
    </div>
    
    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>

</body>
</html>
