<?php
require 'core/init.php';

// Create connection
$conn = new mysqli("sfsuswe.com", "s16g09", "9team2016", "student_s16g09");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('./login.php');
}

$result = $conn->query("SELECT * FROM transactions WHERE user_id = " . $user->data()->id);
?>

<!DOCTYPE html>
<head>
    <title>Imaguana | Purchases</title>

    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
    
    <!-- Copy Button Script-->
    <script src="assets/js/clipboard.min.js"></script>

</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar.php'; ?>

    <!-- Page Content -->
    <div class="container ws-page-container" style="margin-top: -70px;">
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3 style="font-size: 45px">Purchases</h3>
                <div class="ws-separator"></div>
            </div>
        </div>

        <!-- start loop here -->
        <?php
        $output = '';
        $license = '';
        $button = '';
        $modal = '';
        $image = new Image();
        $video = new Video();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row["type"] == "image"){
                    $image->find($row["image_id"]);
                    if ($row["license"] == "web") {
                        $license = 'Web: $' . $image->data()->web;
                        $button = "
                                <a href='#ws-buy-modal" . $image->data()->id . "' data-toggle='modal' ><span class='ws-shop-cart'>
                                    <input style='margin-right: 5px; height: 41px;' type='submit' class='btn btn-lg' value='Source Code'></span>
                                </a>";

                        $modal .= '  <!-- Register Buy Modal -->
        <div class="modal fade" id="ws-buy-modal' . $image->data()->id . '" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border: none;">
                        <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                    </div>
                    <div class="row" >
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="modal-body" style="text-align: center;">                                    
                                <!-- Register Form -->                                        
                                <h3 style="text-align: center; color:black;">Thank you for your purchase!</h3>
                                <div class="ws-separator"></div>
                                <h4 style="color:black; text-align: center;">Copy and Paste this source code onto your site:</h4><br>
                                <br>
                                <input id="foo' . $image->data()->id . '" style="color:black; height: 40px; width: 510px; margin-left: -20px;" type="text" value="<img src=&quot;http://sfsuswe.com/~s16g09/' . $image->data()->image . '&quot; >" readonly name="source"><br>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-8" style="margin-left: -50px">
                                            <ul style="list-style: none;">
                                                <li class="ws-shop-cart" style="display:inline;">
                                                <button class="btn btn-sm data-clipboard-action="copy" data-clipboard-target="#foo' . $image->data()->id . '">Copy</button>
                                                <li class="ws-shop-cart" style="display:inline;">
                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm">Cancel</a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                    } else if ($row["license"] == "print") {
                        $license = 'Print: $' . $image->data()->print;
                        $button = '
                                <!-- buttons -->
                                <div class="row" style="margin-top: 15px; margin-left: -50px;">
                                    <div class="col-sm-12">
                                        <form action="download.php" method="POST">
                                            <input name="image" hidden="true" value="' . $image->data()->name . '" >
                                            <span class="ws-shop-cart">
                                                <input class="btn btn-lg" type="submit" style="margin-left: 63px; height: 41px;" value="Download">
                                            </span>  
                                        </form>

                                    </div>
                                </div>';
                    } else {
                        $license = 'Unlimited: $' . $image->data()->unlimited;
                        $button = '
                                <!-- buttons -->
                                <div class="row" style="margin-top: 15px; margin-left: -50px;">
                                    <div class="col-sm-12">
                                        <form action="download.php" method="POST">
                                            <input name="image" hidden="true" value="' . $image->data()->name . '" >
                                            <span class="ws-shop-cart">
                                                <input class="btn btn-lg" type="submit" style="margin-left: 63px; height: 41px;" value="Download">
                                            </span>&nbsp; &nbsp;  
                                            <a href="#ws-buy-modal' . $image->data()->id . '" data-toggle="modal" ><span class="ws-shop-cart">
                                    <input style="margin-right: 5px; height: 41px;" type="submit" class="btn btn-lg" value="Source Code"></span>
                                </a>
                                        </form>
                                    </div>
                                </div>';

                        $modal .= '  <!-- Register Buy Modal -->
        <div class="modal fade" id="ws-buy-modal' . $image->data()->id . '" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border: none;">
                        <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                    </div>
                    <div class="row" >
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="modal-body" style="text-align: center;">                                    
                                <!-- Register Form -->                                        
                                <h3 style="text-align: center; color:black;">Thank you for your purchase!</h3>
                                <div class="ws-separator"></div>
                                <h4 style="color:black; text-align: center;">Copy and Paste this source code onto your site:</h4><br>
                                <br>
                                <input id="foo' . $image->data()->id . '" style="color:black; height: 40px; width: 510px; margin-left: -20px;" type="text" value="<img src=&quot;http://sfsuswe.com/~s16g09/' . $image->data()->image . '&quot; >" readonly name="source"><br>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-8" style="margin-left: -50px">
                                            <ul style="list-style: none;">
                                                <li class="ws-shop-cart" style="display:inline;">
                                                <button class="btn btn-sm data-clipboard-action="copy" data-clipboard-target="#foo' . $image->data()->id . '">Copy</button>
                                                <li class="ws-shop-cart" style="display:inline;">
                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm">Cancel</a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                    }
                    $output .= '
                        <!-- contents -->
                        <section id="' . $image->data()->id . '" class="ws-about-section" >
                        <div class="row">

                            <!-- left side -->
                            <div class="col-sm-4 col-sm-offset-1">
                                <!-- image -->
                                <div>
                                    <a href=image/show/' . $image->data()->id . '><img style="width: 530px;"
                                           src="' . $image->data()->image . '" ></a>
                                </div>
                            </div>

                            <!-- right side -->
                            <div class="col-sm-5 col-sm-offset-2" style="margin-top: 5px;">

                                <!-- title -->
                                <div class="row">
                                    <div class="ws-item-category" style="font-size: 25px; text-align: center;"><u>Title</u><br><span style="color: black;" >' . $image->data()->title . '</span></div>
                                </div>
                                <br>

                                <!-- category -->
                                <div class="row">
                                    <div class="ws-item-category" style="font-size: 25px; text-align: center;"><u>Category</u><br><span style="color: black;" >' . $image->data()->category . '</span></div>
                                </div>
                                <br>

                                <!-- license -->
                                <div class="row">
                                    <div class="ws-item-category" style="font-size: 25px; text-align: center;"><u>License purchased</u><br><span style="color: black;" >' . $license . '</span></div>
                                </div>
                                <br>
                                ' . $button . '
                            </div>
                        </div>
                        </section>';
                }
                else{
                    $video->find($row["video_id"]);
                    if ($row["license"] == "web") {
                        $license = 'Web: $' . $video->data()->web;
                        $button = "
                                <a href='#ws-buy-modal-video" . $video->data()->id . "' data-toggle='modal' ><span class='ws-shop-cart'>
                                    <input style='margin-right: 5px; height: 41px;' type='submit' class='btn btn-lg' value='Source Code'></span>
                                </a>";

                        $modal .= '  <!-- Register Buy Modal -->
        <div class="modal fade" id="ws-buy-modal-video' . $video->data()->id . '" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border: none;">
                        <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                    </div>
                    <div class="row" >
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="modal-body" style="text-align: center;">                                    
                                <!-- Register Form -->                                        
                                <h3 style="text-align: center; color:black;">Thank you for your purchase!</h3>
                                <div class="ws-separator"></div>
                                <h4 style="color:black; text-align: center;">Copy and Paste this source code onto your site:</h4><br>
                                <h4 style="color:black; text-align: center;">(You can use the width and height attributes to change the dimesnions of the iframe)</h4><br>
                                <br>';
                                if($video->data()->source == "youtube"){
                                                 $modal .= '<input id="foo' . $video->data()->id . '" style="color:black; height: 40px; width: 510px; margin-left: -20px;" type="text" value="<iframe width=&quot;650&quot; height=&quot;400&quot; src=&quot;https://www.youtube.com/embed/' . $video->data()->embeded . '&quot; frameborder=&quot;0&quot; allowfullscreen></iframe>" readonly name="source"><br>';
                                }
                                else{
                                    $modal .= '<input id="foo' . $video->data()->id . '" style="color:black; height: 40px; width: 510px; margin-left: -20px;" type="text" value="<iframe width=&quot;650&quot; height=&quot;400&quot; src=&quot;https://player.vimeo.com/video/' . $video->data()->embeded . '&quot; frameborder=&quot;0&quot; allowfullscreen></iframe>" readonly name="source"><br>';
                                }    
                                $modal .= '
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-8" style="margin-left: -50px">
                                            <ul style="list-style: none;">
                                                <li class="ws-shop-cart" style="display:inline;">
                                                 <button class="btn btn-sm data-clipboard-action="copy" data-clipboard-target="#foo' . $video->data()->id . '">Copy</button>
                                                <li class="ws-shop-cart" style="display:inline;">
                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm">Cancel</a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                    } 
                    $output .= '
                        <!-- contents -->
                        <section id="video_' . $video->data()->id . '" class="ws-about-section" >
                        <div class="row">

                            <!-- left side -->
                            <div class="col-sm-4 col-sm-offset-1">
                                <!-- image -->
                                <div>';
                                if($video->data()->source == "youtube"){
                                                $output .="<iframe width='550' height='350' src='https://www.youtube.com/embed/" . $video->data()->embeded . "';  ?> frameborder='0' allowfullscreen></iframe>";
                                }
                                else{
                                    $output .="<iframe src='https://player.vimeo.com/video/" . $video->data()->embeded .  "'width='550' height='350' frameborder='0' allowfullscreen></iframe>";
                                }    
                                            $output .='
                                </div>
                            </div>

                            <!-- right side -->
                            <div class="col-sm-5 col-sm-offset-2" style="margin-top: 5px;">

                                <!-- title -->
                                <div class="row">
                                    <div class="ws-item-category" style="font-size: 25px; text-align: center;"><u>Title</u><br><span style="color: black;" >' . $video->data()->title . '</span></div>
                                </div>
                                <br>

                                <!-- category -->
                                <div class="row">
                                    <div class="ws-item-category" style="font-size: 25px; text-align: center;"><u>Category</u><br><span style="color: black;" >' . $video->data()->category . '</span></div>
                                </div>
                                <br>

                                <!-- license -->
                                <div class="row">
                                    <div class="ws-item-category" style="font-size: 25px; text-align: center;"><u>License purchased</u><br><span style="color: black;" >' . $license . '</span></div>
                                </div>
                                <br>
                                ' . $button . '
                            </div>
                        </div>
                        </section>';
                }
            }
        } else {
            $output = "<p style='text-align: center'>No Purchases</p>";
        }
        echo $output;
        echo $modal;
        ?>
    </div>
    
    <!-- Copy Button Script-->
    <script>
        var clipboard = new Clipboard('.btn');

        clipboard.on('success', function(e) {
            console.log(e);
        });

        clipboard.on('error', function(e) {
            console.log(e);
        });
    </script>
    <!-- Foot Bar -->
    <div>
        <?php include 'view/foot-bar.php'; ?>
    </div>

    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>
    
</body>
</html>
