<?php
require_once 'core/init.php';

//Connection
mysql_connect("sfsuswe.com", "s16g09", "9team2016") or die(mysql_error());
mysql_select_db("student_s16g09") or die(mysql_error());

$elements = explode('/', $_SERVER['REQUEST_URI']);
$account = $elements[1];
if (!$username)
    if (!$username = Input::get('user'))
        Redirect::to("/$account/");

$user = new User($username);
if (!$user->exists()) {
    Redirect::to(404);
} else {
    $data = $user->data();
    $user = new User();
}
?>

<!doctype html>
<head>
    <title>Imaguana | Profile</title>
    
    <?php
    $elements = explode('/', $_SERVER['REQUEST_URI']);
    $account = $elements[1];
    echo "<BASE href=\"/$account/\">";
    ?>
    
    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
    
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <div class="container" style="margin-bottom: 10px;">
        <div class="ws-works-title clearfix">
            <br>
            <div class="col-sm-12">
                <h3 style="font-size: 25px"><?php if ($data->group == 1) { ?>Artist Profile: <?php } else if($data->group == 2) { ?>
                        Customer Profile: <?php }  echo $data->username; ?></h3>
                <div class="ws-separator"></div> 
            </div>
        </div> 
        <div class="row">
            <!-- left column -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-center">
                    <img height="210" width="350"src="assets/img/profile_pictures/<?php echo ($data->profile_picture_path == "") ? 'avatar.jpg' : $data->profile_picture_path ?>" class="avatar img-circle img-thumbnail" alt="avatar"><br><br>
                </div>
                <ul style="list-style: none; ">
                    <?php if ($data->group == 1) { ?>
                        <li class="ws-shop-cart">
                            <form action="imageresults.php" method="POST">
                                <input class="btn btn-sm col-sm-12" style="margin-left: -30px; margin-bottom: 10px;" type="submit" value="BROWSE THIS ARTIST'S WORK" name="submit">
                                <input type="hidden" name="search" id="search" value="<?php echo $data->username; ?>"> </form>
                        </li>
                    <?php } else if($data->group == 3){ ?>
                        <li class="ws-shop-cart">
                            <a href="./#contact" class="btn btn-sm col-sm-12" style="margin-left: -30px; margin-bottom: 10px;">Contact / Message</a>
                        </li> 
                     <?php }
                    if ($user->isLoggedIn() && strtolower($user->data()->username) == strtolower($username) ) {
                        if ($user->data()->group == 1) {
                            ?>
                            <li class="ws-shop-cart">
                                <a href="upload.php" class="btn btn-sm col-sm-12" style="margin-left: -30px; margin-bottom: 10px;">Upload an Image</a>
                            </li>
                            <li class="ws-shop-cart">
                                <a href="videoupload.php" class="btn btn-sm col-sm-12" style="margin-left: -30px; margin-bottom: 10px;">Upload a Video</a>
                            </li>
                        <?php } if($user->data()->group != 3){ ?>
                        <li class="ws-shop-cart">
                            <a href="purchases.php" class="btn btn-sm col-sm-12" style="margin-left: -30px; margin-bottom: 10px;">View Purchases</a>
                        </li> 
                    <?php }else if($user->data()->group == 3){ ?>
                        <li class="ws-shop-cart">
                            <a href="messages.php" class="btn btn-sm col-sm-12" style="margin-left: -30px; margin-bottom: 10px;">View Messages</a>
                        </li> 
                    <?php }   }?>   
                </ul>
            </div>
            <br>
            <!-- edit form column -->
            <div style="font-size: 17px;" class="col-md-8 col-sm-6 col-xs-12 personal-info">
                <form class="form-horizontal" role="form" method="POST" action="update.php">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" style="margin-bottom: 23px; color:black;"><b>Name:</b></label>
                        <div class="col-md-8" style="padding-top: 8px; color:black; ">
                            <p1><?php echo $data->name; ?></p1>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" style="margin-bottom: 23px; color:black;"><b>Username:</b></label>
                        <div class="col-md-8" style="padding-top: 8px; color:black;">
                            <p1><?php echo $data->username; ?></p1>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" style="margin-bottom: 23px; color:black;"><b>Email:</b></label>
                        <div class="col-md-8" style="padding-top: 8px; color:black;">
                            <p1><?php echo $data->email; ?></p1>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" style="margin-bottom: 23px; color:black; "><b>Bio:</b></label>
                        <div class="col-md-8" style="padding-top: 8px; color:black;">
                            <p1><?php echo ($data->bio == "") ? 'Update your bio by clicking on the edit profile button below your profile picture' : $data->bio ?></p1>
                        </div>
                    </div><br>
                    <div class="form-group" style="margin-top: -20px;">
                        <label class="col-md-3 control-label" style="margin-bottom: 50px; color:black;"><b>Social links:</b></label>
                        <ul class="footer-social" type='none' style="padding-top: 8px;">
                            <li><a href="<?php if($data->facebook != ""){echo $data->facebook    . '" target="_blank';}else{echo "javascript:;";}  ?>"><i class="fa fa-facebook-square"></i></a></li>&nbsp;&nbsp;
                            <li><a href="<?php if($data->instagram != ""){echo $data->instagram . '" target="_blank';}else{echo "javascript:;";}  ?>"><i class="fa fa-instagram"></i></a></li>&nbsp;&nbsp;
                            <li><a href="<?php if($data->twitter != ""){echo  $data->twitter    . '" target="_blank';}else{echo "javascript:;";}   ?>"><i class="fa fa-twitter"></i></a></li>&nbsp;&nbsp;
                            <li><a href="<?php if($data->website != ""){echo $data->website . '" target="_blank';}else{echo "javascript:;";}   ?>">Website</a></li>&nbsp;&nbsp;
                        </ul>
                    </div>
                     <?php
                    if ($user->isLoggedIn() && strtolower($user->data()->username) == strtolower($username) ) { ?>
                        <ul style="margin-bottom: 25px;">  
                            <li class="ws-shop-cart" type='none'>
                                <a href="update.php" class="btn btn-sm" ">Edit Profile</a>&nbsp;&nbsp;
                                <a href="changepassword.php" class="btn btn-sm " >Change Password</a>
                            </li>
                        </ul><br>
                    <?php }
                    if($user->isLoggedIn() && $user->data()->group == 3 && $data->username != "Admin"){?>
                         <ul style="margin-bottom: 25px;">  
                            <li class="ws-shop-cart" type='none'>
                                <span style="color:black;">Admin Access: Edit this profile -></span>
                                <input class="btn btn-sm" type="submit" name='auser' value="<?php echo $data->username; ?>">&nbsp;&nbsp;                            
                            </li>
                        </ul><br>
                    <?php }  ?>
                </form>
            </div>
            <!-- end edit form column -->
        </div>
    </div>
    
    <?php if ($data->group == 1) { ?>
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3 style="text-decoration: underline; color: #D5AD92; text-align: center;"><span style="color: black;">Artists' Work Sample</span></h3>
            </div>
        </div>
    <!-- Carousel -->
    <div style="margin-top: -100px;" id="ws-items-carousel">
            <?php
            $output = "";
            $css = '<style type="text/css"> ';
            $title_query = mysql_query("SELECT * "
                    . "FROM images "
                    . "WHERE user_id = " . $data->id . " limit 8");
            while ($row = mysql_fetch_array($title_query)) {
                $css .= '
                                .multiPic' . $row['id'] . '{ 
                                    width:330px; 
                                    height:240px;  
                                    background: url(' . $row['image'] . ') no-repeat;
                                    background-size: 350px 240px;
                                } 
                                .multiPic' . $row['id'] . ' .text' . $row['id'] . '{ 
                                    width:320px; 
                                    height:80px; 
                                    background:#FFA500; background: url(assets/img/favicon.png) no-repeat; opacity:0; } 

                                .multiPic' . $row['id'] . ':hover .text' . $row['id'] . '{ 
                                    opacity:0.9; 
                                } ';
                $output .="
                    <!-- Item -->
                    <div class='ws-works-item' data-sr='wait 0s, ease-in 20px'>
                        <a href=image/show/" . $row['id'] . ">
                            <!-- Image -->
                            <figure>
                                <div class='multiPic". $row['id'] . "'> 
                                    <div class='text" . $row['id'] . "'>                     
                                    </div>
                                </div>
                            </figure>
                            <div class='ws-works-caption text-center'>
                                <!-- Item Category -->
                                <div class='ws-item-category'>" . $row['category'] . "</div>
                                <!-- Title -->
                                <h3 class='ws-item-title'>" . $row['title'] . "</h3>  <br>
                                <!-- Buttons -->
                                <a href='image/show/" . $row['id'] . "' ><span class='ws-shop-cart'><input style='margin-left: 5px; height: 41px;' type='submit' class='btn btn-lg' value='View'></span></a>
                                <div class='ws-item-separator'></div>          
                            </div>
                        </a>
                    </div>";
            }
            
            if ($output == ""){
                $output .= "<div style='margin-top: 70px;'><p style='color:black; text-align: right;'> No Artwork to Display </p></div>";
            }
            echo $output;
            $css .= '</style>';
            echo $css;
            ?>
        </div>
    <?php }?>

    <!-- Foot Bar -->
    <div style="margin-top: 100px;">
        <?php include 'view/foot-bar.php'; ?>
    </div>

    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>
    
    <!-- Social CSS -->
    <style>
        nav#footer{
            background: #222222;
            color: #ffffff;
            padding: 20px 0 15px 0;
        }
        nav#footer .fnav{ vertical-align: middle;}
        ul.footer-social li{
            display: inline-block;
            margin-right: 10px;
        }
        nav#footer p{
            font-size: 12px;
            margin-top: 10px;
        }
        #footer i.fa {
            height: 30px;
            width: 30px;
            border: 2px solid #8c8c8c;
            font-size: 20px;
            padding: 4px 5px;
            border-radius: 50%;
            color: #8c8c8c;
            transition: all 0.5s;
        }
        #footer i.fa:hover{
            background: #FCAC45;
            border-color: #FCAC45;
            color: #ffffff;
        }
    </style>
    
</body>
</html>

