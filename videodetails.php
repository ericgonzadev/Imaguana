<?php
require_once 'core/init.php';
$user = new User();
?>

<!doctype html>
<head>
    <title>Imaguana | Video Details</title>
    
    <?php
    $elements = explode('/', $_SERVER['REQUEST_URI']);
    $user = $elements[1];
    echo "<BASE href=\"/$user/\">";
    ?>
    
    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
    
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <!-- Product Content -->
    <div class="container ws-page-container" style="margin-top: -40px;">
        <div class="row">

            <!-- Product Image Carousel -->
            <div class="col-sm-7">
                <h3 class="ws-item-title" style="color: black; margin-bottom: 10px; text-align: center; font-size: 30px;"><?php echo $video->data()->title; ?></h3><span class="ws-separator"></span>
                <?php if($video->data()->source == "youtube"){ ?>
                    <iframe width="650" height="435" <?php echo 'src="https://www.youtube.com/embed/' . $video->data()->embeded . '"';  ?> frameborder='0' allowfullscreen></iframe>
                <?php   } else{ ?>
                    <iframe width="650" height="435" <?php echo 'src="https://player.vimeo.com/video/' . $video->data()->embeded . '"';  ?> frameborder='0' allowfullscreen></iframe>
                <?php } ?> 
            </div>

            <!-- Product Information -->
            <div class="col-sm-5">
                <div class="ws-product-content">

                    <header>
                        <div class="ws-product-details">
                            <!-- Author -->
                            <h3 style="text-decoration: underline; color: #D5AD92;"><span style="color: black;">Artist</span></h3><br>
                            <a href="<?php echo str_replace(' ', '', rawurldecode("user/profile/" . $video->data()->username)); ?>" <p style="margin-top: 4px;"><?php echo $video->data()->username; ?></p></a><br>
                            <h3 style="text-decoration: underline; color: #D5AD92;"><span style="color: black;">Description</span></h3><br>
                            <p style="margin-top: 5px;"><?php echo $video->data()->description; ?></p><br>
                            <h3 style="text-decoration: underline; color: #D5AD92;"><span style="color: black;">Category</span></h3><br>
                            <form action="videoresults.php" method="POST">
                                <input hidden="true" name="search" type="text" value=<?php echo $video->data()->category ?> >
                                <input style="background-color: white; border-width: 0px; color: #0000EE;" type="submit" value=<?php echo $video->data()->category ?> >
                            </form><br>
                            <h3 style="text-decoration: underline; color: #D5AD92;"><span style="color: black;">Tags</span></h3><br>
                            <p style="margin-top: 5px;"><?php echo $video->data()->tags; ?></p><br>
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-4">
                                    <h3 class="pull-left" style="text-decoration: underline; color: #D5AD92;"><span style="color: black;">License</span></h3>
                                    <a data-toggle="modal" data-target="#License" >
                                        <img style='height:16px; width:16px;' alt='assets/img/help.gif' src='assets/img/help.gif' >
                                    </a>
                                </div>
                            </div>

                            <br>
                            <form class="ws-buy-form" action="transaction.php" method="POST">
                                <!-- Product Details -->
                                <div class="ws-product-details">
                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <input type="radio" checked="true" name="license" value="web" class="radio pull-left">                                   
                                            <label for="radio2">Web License</label>
                                            <p class="pull-right">$<?php echo $video->data()->web; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button -->
                                <input hidden="true" name="videoid" type="text" <?php echo 'value="' . $video->data()->id . '"' ?> >
                                <?php if ($user->isLoggedIn() && ($user->data()->id == $video->data()->user_id || $user->data()->group == 3)){ ?>
                                <a style="margin-top: -10px;" class="btn ws-btn-fullwidth" href="video/edit/<?php echo $video->data()->id; ?>">Edit Video Information</a>                
                                <?php }else if ($user->isLoggedIn()){?>
                                <input style="margin-top: -10px;" class="btn ws-btn-fullwidth" type="submit" value="Buy License" name="submit" >
                                <input hidden="true" name="videoid" type="text" value="<?php echo $video->data()->id ?>" >
                                <input hidden="true" name="type" type="text" value="video" >
                                <?php }else if (!$user->isLoggedIn()){ $button = "<a href='#ws-buy-modal" . $video->data()->id . "' data-toggle='modal' ><span class='ws-shop-cart'><input style=' height: 50px; font-size:15px;' type='submit' class='btn ws-btn-fullwidth' value='Buy'></span></a> ";
                                $modal = '

                    <!-- Register Buy Modal -->
                    <div class="modal fade" id="ws-buy-modal' . $video->data()->id . '" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="border: none;">
                                    <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                                </div>
                                <div class="row" >
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="modal-body" style="color: black;>                                    
                                            <!-- Register Form -->                                        
                                            <form class="ws-buy-form" style="color: black;">
                                                <h3 style="text-align: center;">Thank you for your interest!</h3>
                                                <div class="ws-separator"></div>   
                                                <div class="form-group">
                                                    <h4>to complete your purchase, please contact CII at <b>(415)855-8555</b>. Image info is listed below: </h4><br>
                                                <h4><b>Title:</b> ' . $video->data()->title . '<h4><br>
                                                <h4 ><b>Category:</b> ' . $video->data()->category . '<h4><br>
                                                <h4 ><b>Artist:</b> ' . $video->data()->username . '<h4><br>
                                                <h4 ><b>ID:</b> ' . $video->data()->id . '<h4><br>
                                                <h4><b>Licenses:</b> &nbsp;&nbsp;Web-$' . $video->data()->web . '</h4>
                                                <br>
                                                <h4>or you can <a href="login.php"><span>Login</span></a> to your account to save the transaction!</h4>
                                                <br>
                                                <h4>Dont have an account? <a href="register.php"><span>Sign Up</span></a> today!</h4><br>
                                                <div class="form-group">
                                                        <label class="col-md-3 control-label"></label>
                                                        <div class="col-md-8" style="margin-left: 300px">
                                                            <ul style="list-style: none;">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-right: 10px;">Close</a>
                                                            </ul>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';    
                                echo $button;
                                echo $modal;
                                
                                } ?>
                            </form>   
                        </div>
                    </header>

                </div>
            </div>
        </div>
    </div>
    <!-- Product Content -->

    <!-- Related Post -->
    <div class="ws-related-section" style="margin-top: -100px">
        <div class="container">

            <!-- Title -->
            <div class="ws-related-title">
                <h3>Related Products</h3>
            </div>

            <?php
            $count = 0;
            $output = "";
            $videolist = new Video();
            if (!$videolist->search("category", $video->data()->category))
                echo "<p>No related videos found: " . "</p>";
            else
                foreach ($videolist->data() as $img) {
                    if ($video->data()->id == $img->id)
                        continue;
                    $output .='
                <div class="col-sm-4">
                    <!-- Item -->
                    <div class="ws-works-item">
                        <a href=video/show/' . $img->id . '>
                            <!-- Image -->
                            <figure>
                                <iframe width="350" height="200" src="https://www.youtube.com/embed/' . $img->embeded . '" frameborder="1" allowfullscreen></iframe>
                            </figure>
                            <div class="ws-works-caption text-center">
                                <!--Category -->
                                <div class="ws-item-category">' . $img->category . '</div>
                                    
                                <!-- Title -->
                                <div style = "margin-bottom: 10px;"><h3 class="ws-item-title">' . $img->title . '</h3></div>
                                    
                                <!-- Buttons -->
                                <a href="video/show/' . $img->id . '" ><span class="ws-shop-cart"><input style="margin-left: 5px; height: 41px;" type="submit" class="btn btn-lg" value="View"></span></a>

                                <div class="ws-item-separator"></div>
                            </div>
                        </a>
                    </div>
                </div>';
                    $count += 1;
                    if ($count >= 3)
                        break;
                }
            echo $output;
            ?>
        </div>
    </div>
    <!-- End Related Post -->
    
    <!-- DEFINING WEB, Print, and Unlimited License -->
    <div id="License" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <h3 style="text-align: center; color:black;">License Descriptions:</h3>
                    <div class="ws-separator"></div> 

                    <h3 style="text-align: center; color:black;" ><u>Web</u></h3>
                    <p style="color:black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You will receive a URL that you can use on your website to display the video.</p>
                    <br>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8" style="margin-left: 300px">
                            <ul style="list-style: none;">
                                <li class="ws-shop-cart" style="display:inline;">
                                    <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Close</a>
                            </ul>
                        </div>
                    </div>
                    <br>
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
