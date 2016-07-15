<?php
require_once 'core/init.php';
$user = new User;
?>

<!doctype html>
<head>
    <title>Imaguana | Image Details</title>
    
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
                <h3 class="ws-item-title" style="color: black; font-size: 30px; text-align: center;"><?php echo $image->data()->title; ?></h3><span class="ws-separator"></span>
                <div class="item">
                    <?php $css = '
                    <style type="text/css"> 
            .multiPic{ 
                width:670px; 
                height:446px;  
                background: url(' . $image->data()->image . ') no-repeat;
                background-size: 670px 446px;
            } 
            .multiPic .text1{ 
                margin-top: 50px;
                margin-left: 50px;
                width:320px; 
                height:80px; 
                background:#FFA500; background: url(assets/img/favicon.png) no-repeat; opacity:0; } 
            
            .multiPic:hover .text1{ 
                opacity:0.9; 
            } 
        </style> '; echo $css;?>
                    <div class="multiPic" style="margin-top: -30px; margin-bottom: 17px;"> 
                        <div class="text1">                     
                        </div>
                    </div>
                    
                    <form action="preview.php" method="POST">
                    <?php $_SESSION['previewimage'] = $image->data()->image; ?>
                    <?php $_SESSION['imageid'] = $image->data()->id; ?>
                    <input style="margin-top: -10px;" class="btn ws-btn-fullwidth" type="submit" value="Preview this image with a background" name="preview" >
                    </form>
                </div>
                
            </div>

            <!-- Product Information -->
            <div class="col-sm-5">
                <div class="ws-product-content">

                    <header>
                        <div class="ws-product-details">
                            <!-- Author -->
                            <h3 style="text-decoration: underline; color: #D5AD92; margin-top: 20px; margin-bottom: 18px;"><span style="color: black;">Artist</span></h3>
                            <p style="margin-bottom: 15px;"><a style="margin-top: 4px; color: #0000EE;" href="<?php echo str_replace(' ', '', rawurldecode("user/profile/" . $image->data()->username)); ?>" ><?php echo $image->data()->username; ?></a></p>
                            <!-- Description -->
                            <h3 style="text-decoration: underline; color: #D5AD92; margin-bottom: 15px;"><span style="color: black;">Description</span></h3>
                            <p style="color: black; margin-top: 5px; margin-bottom: 15px;"><?php echo $image->data()->description; ?></p>
                            <!-- Category -->
                            <h3 style="text-decoration: underline; color: #D5AD92; margin-bottom: 15px;"><span style="color: black;">Category</span></h3>
                            <p style="margin-bottom: 15px;"><a style="margin-top: 4px; color: #0000EE;" href="imageresults.php#<?php echo strtolower($image->data()->category) ?>" ><?php echo $image->data()->category ?></a></p>
                            <!-- Tags -->
                            <h3 style="text-decoration: underline; color: #D5AD92; margin-bottom: 15px;"><span style="color: black;">Tags</span></h3>
                            <p style="color: black; margin-top: 5px; margin-bottom: 15px;">
			    <?php $tags = split('[, ]',$image->data()->tags); 
			          foreach($tags as $tag)
				  	echo '<a style="margin-top: 4px; color: #0000EE;" href=image/tag/'.$tag.' >'.$tag.'</a>  ';  ?>
                            </p>
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-4">
				    <div class="pull-left">
                                        <h3 class="pull-left" style="text-decoration: underline; color: #D5AD92;"><span style="color: black;">License</span></h3>
                                        <a class="col-sm-offset-1" data-toggle="modal" data-target="#License" >
                                            <img style='height:16px; width:16px;' alt='assets/img/help.gif' src='assets/img/help.gif' >
                                        </a>
                                    </div>
				</div>
                            </div>

                            <br>
                            <form class="ws-buy-form" action="transaction.php" method="POST">
                                <!-- Product Details -->
                                <div class="ws-product-details">
                                    <div class="row">
                                        
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <label style="color: black;" for="radio2">
                                                <input style="margin-left: -95px;"type="radio" checked="true" id ="radio2" name="license" value="web" class="radio pull-left">                                   
                                            Web License
                                            </label>
                                            <p id ="radio2" style="color: black; " class="pull-right">$<?php echo $image->data()->web; ?></p>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <label style="color: black;" for="radio1">
                                                <input style="margin-left: -93px;" value="print" type="radio" name="license" class="radio pull-left" id ="radio1">
                                            Print License
                                            </label>
                                            <p style="color: black;" class="pull-right">$<?php echo $image->data()->print; ?></p>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <label style="color: black;" for="radio3">
                                            <input style="margin-left: -75px;" value="unlimited" type="radio" name="license" class="radio pull-left" id ="radio3">
                                            Unlimited License</label>
                                            <p style="color: black;" class="pull-right">$<?php echo $image->data()->unlimited; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button -->
                                <input hidden="true" name="imageid" type="text" <?php echo 'value="' . $image->data()->id . '"' ?> >
                                <?php if ($user->isLoggedIn() && ($user->data()->id == $image->data()->user_id || $user->data()->group == 3)){ ?>
                                <a style="margin-top: -10px;" class="btn ws-btn-fullwidth" href="image/edit/<?php echo $image->data()->id; ?>">Edit Image</a>                
                                <?php }else if ($user->isLoggedIn()){?>
                                <input style="margin-top: -10px;" class="btn ws-btn-fullwidth" type="submit" value="Buy" name="submit" >
                                <?php }else if (!$user->isLoggedIn()){
                                $button = "<a href='#ws-buy-modal" . $image->data()->id . "' data-toggle='modal' ><span class='ws-shop-cart'><input style='height: 50px; font-size:15px;' type='submit' class='btn ws-btn-fullwidth' value='Buy'></span></a> ";
                                $modal = '

                    <!-- Register Buy Modal -->
                    <div class="modal fade" id="ws-buy-modal' . $image->data()->id . '" tabindex="-1">
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
                                                <h4><b>Title:</b> ' . $image->data()->title . '<h4><br>
                                                <h4 ><b>Category:</b> ' . $image->data()->category . '<h4><br>
                                                <h4 ><b>Artist:</b> ' . $image->data()->username . '<h4><br>
                                                <h4 ><b>ID:</b> ' . $image->data()->id . '<h4><br>
                                                <h4><b>Licenses:</b> &nbsp;&nbsp;Web-$' . $image->data()->web . ' &nbsp;&nbsp;Print-$' . $image->data()->print . ' &nbsp;&nbsp;Unlimited-$' . $image->data()->unlimited . '</h4>
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
            $css = '<style type="text/css"> ';
            $imagelist = new Image();
            if (!$imagelist->search("category", $image->data()->category))
                echo "<p>No related images found: " . "</p>";
            else
                foreach ($imagelist->data() as $img) {
                    $css .= '
                    .multiPic' . $img->id . '{ 
                        width:350px; 
                        height:240px;  
                        background: url(' . $img->image . ') no-repeat;
                        background-size: 350px 240px;
                    } 
                    .multiPic' . $img->id . ' .text' . $img->id . '{ 
                        width:320px; 
                        height:80px; 
                        background:#FFA500; background: url(assets/img/favicon.png) no-repeat; opacity:0; } 

                    .multiPic' . $img->id . ':hover .text' . $img->id . '{ 
                        opacity:0.9; 
                    } ';
                    if ($image->data()->id == $img->id)
                        continue;
                    $output .='
                <div class="col-sm-4">
                    <!-- Item -->
                    <div class="ws-works-item">
                        <a href=image/show/' . $img->id . '>
                            <!-- Image -->
                            <figure>
                                <div class="multiPic' . $img->id . '"> 
                                    <div class="text' . $img->id . '">                     
                                    </div>
                                </div>
                            </figure>
                            <div class="ws-works-caption text-center">
                                <!--Category -->
                                <div class="ws-item-category">' . $img->category . '</div>

                                <!-- Title -->
                                <div style = "margin-bottom: 10px;"><h3 class="ws-item-title">' . $img->title . '</h3></div>
                                    
                                <!-- Buttons -->
                                <a href="image/show/' . $img->id . '" ><span class="ws-shop-cart"><input style="margin-left: 5px; height: 41px;" type="submit" class="btn btn-lg" value="View"></span></a>

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
            $css .= '</style>';
            echo $css;
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
                    <p style="color:black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You will receive a URL that you can use on your website to display the image.</p>
                    <br>
                    <h3 style="text-align: center; color:black;" ><u>Print</u></h3>
                    <p style="color:black; text-align: center;">You will receive a downloadable file of the image.</p>
                    <br>
                    <h3 style="text-align: center; color:black;" ><u>Unlimited</u></h3>
                    <p style="color:black; text-align: center;">You will receive the URL and the downloadable file of the image.</p>
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
