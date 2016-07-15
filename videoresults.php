<?php
require 'core/init.php';

//Connection
mysql_connect("sfsuswe.com", "s16g09", "9team2016") or die(mysql_error());
mysql_select_db("student_s16g09") or die(mysql_error());

$user = new User();
$videolist = new Video();
$modal = "";
?>

<!doctype html>
<head>
    <title>Imaguana | Browse</title
    
    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'view/nav-bar-alt.php'; ?>

    <!-- Page Content -->
    <div class="container ws-page-container" style="margin-top: -70px">
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3 style="font-size: 35px">Video Results</h3> 
                <div class="ws-separator"></div>   
            </div>
        </div> 
        <div class="row">            
            <div class="ws-shop-page">                
                <!-- Categories Nav -->  
                <p style=" text-align: center; color: black;"><u>Filter by category</u></p>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
                    <li role="presentation"><a href="#animal" aria-controls="animal" role="tab" data-toggle="tab">Animals</a></li>
                    <li role="presentation"><a href="#beauty" aria-controls="beauty" role="tab" data-toggle="tab">Beauty</a></li>
                    <li role="presentation"><a href="#city" aria-controls="city" role="tab" data-toggle="tab">City</a></li>
                    <li role="presentation"><a href="#education" aria-controls="education" role="tab" data-toggle="tab">Education</a></li>
                    <li role="presentation"><a href="#fashion" aria-controls="fashion" role="tab" data-toggle="tab">Fashion</a></li>
                    <li role="presentation"><a href="#food" aria-controls="food" role="tab" data-toggle="tab">Food</a></li>
                    <li role="presentation"><a href="#landmark" aria-controls="landmark" role="tab" data-toggle="tab">Landmarks</a></li>
                    <li role="presentation"><a href="#nature" aria-controls="nature" role="tab" data-toggle="tab">Nature</a></li>
                    <li role="presentation"><a href="#science" aria-controls="science" role="tab" data-toggle="tab">Science</a></li>
                    <li role="presentation"><a href="#space" aria-controls="space" role="tab" data-toggle="tab">Space</a></li>
                    <li role="presentation"><a href="#sport" aria-controls="sport" role="tab" data-toggle="tab">Sports</a></li>
                    <li role="presentation"><a href="#vintage" aria-controls="vintage" role="tab" data-toggle="tab">Vintage</a></li>                  
                </ul>

                <!-- Search Bar -->
                <form class="col-sm-offset-3" style="width: 610px;" method="POST" name="myform" onsubmit="return OnSubmitForm();">
                    <input class="pull-left" style="color: black; height:41px; width: 350px; font-size:20px;" name="search" type="text" <?php if (isset($_POST['search'])) {echo "value=\"" . $_POST['search'] . "\"";} ?> placeholder="Begin your search here..." required>
                        <div id="mainselection" style="float: left;">
                            <select for="filter" name="filter" id="filter">
                                <option value="1" style="color:black;">Images</option>
                                <option selected value="2" style="color:black;">Videos</option>
                            </select>
                        </div>
                    <span class="ws-shop-cart"><input style="margin-bottom: 9px; height: 41px;" type="submit" class="btn btn-lg" value="Search"></span>
                </form>

                <?php
                $output = '';
                $searched = 0;
                $total_count = 0;
                $results = array();
                if (isset($_POST['search'])) {
                    $searched = 1;
                    $searchq = $_POST['search'];
                    $searchq = preg_replace("#[^0-9a-z]#i", " ", $searchq);
                    //title search
                    $videolist->search("title", $searchq);
                    $title_results = $videolist->data();
                    $results = array_merge($results, $title_results);

                    //description search
                    $videolist->search("description", $searchq);
                    $description_results = $videolist->data();
                    $results = array_merge($results, $description_results);

                    //category search
                    $videolist->search("category", $searchq);
                    $category_results = $videolist->data();
                    $results = array_merge($results, $category_results);

                    //tags search
                    $videolist->search("tags", $searchq);
                    $tags_results = $videolist->data();
                    $results = array_merge($results, $tags_results);

                    //username search
                    $videolist->search("username", $searchq);
                    $username_results = $videolist->data();
                    $results = array_merge($results, $username_results);

                    // remove duplicated video result
                    $results = array_map("unserialize", array_unique(array_map("serialize", $results)));

                    //get results count
                    $total_count = count($results);

                    $total_count == 0 ? $count = "<p style='color: black; text-align: center'>No Results for '<b>" . $searchq . "</b>'</p>" : $count = "<p style='color: black; text-align: center'>(" . $total_count . " video results for '<b>" . $searchq . "</b>')</p>";
                    echo $count;
                }
                ?>    
                <!-- Categories Content -->           
                <div class="tab-content">

                    <!-- All -->
                    <div role="tabpanel" class="tab-pane fade in active" id="all">   
                        <?php
                        $output = "";
                        $modal = "";
                        $videolist->listAll();
                        if (!$searched) {
                            $category_results = $videolist->data();
                        } else {
                            // intersect keyword search result and category result
                            $category_results = array_map("unserialize", array_intersect(array_map("serialize", $results), array_map("serialize", $videolist->data())));
                        }
                        $count = 0;
                        foreach ($category_results as $video) {
                            $button = "<a href='#ws-buy-modal" . $video->id . "' data-toggle='modal' ><span class='ws-shop-cart'><input style='margin-right: 5px; height: 41px;' type='submit' class='btn btn-lg' value='Buy'></span></a> ";
                            if ($user->isLoggedIn() && ($user->data()->id == $video->user_id || $user->data()->group == 3)) {
                                $button = "<a href='video/edit/" . $video->id . "'>
                                <span class='ws-shop-cart' >
                                    <input class='btn btn-lg' type='submit' style='margin-right: 5px; height: 41px;' value='Edit'>
                                </span>
                                </a>";
                            }
                            $output .="
                             <!-- Item -->
                             <div class='col-sm-6 col-md-4 ws-works-item'>
                                 <a href='video/show/" . $video->id . "'>                           
                                     <div class='ws-item-offer'>
                                         <!-- Image -->                        
                                         <figure>   ";
                            if($video->source == "youtube"){
                                            $output .="<iframe width='370' height='230' src='https://www.youtube.com/embed/" . $video->embeded . "';  ?> frameborder='0' ></iframe>";
                            }
                            else{
                                $output .="<iframe src='https://player.vimeo.com/video/" . $video->embeded .  "'width='370' height='230' frameborder='0'></iframe>";
                            }    
                                        $output .="</figure>                    
                                     </div>
                                     <div class='ws-works-caption text-center'>
                                         <!-- Item Category -->
                                         <div class='ws-item-category'>" . $video->category . "</div>

                                         <!-- Title -->
                                         <h3 class='ws-item-title'>" . $video->title . "</h3>  <br>
                                        <!-- Buttons -->"
                                    . $button . "
                                        <a href='video/show/" . $video->id . "' ><span class='ws-shop-cart'><input style='margin-left: 5px; height: 41px;' type='submit' class='btn btn-lg' value='View'></span></a>
                                         <div class='ws-item-separator'></div>          
                                     </div>
                                  </a>
                            </div>";
                            if ($count % 3 == 2) {
                                $output .= '<div class="clearfix visible-md"></div>';
                                $output .= '<div class="clearfix visible-lg"></div>';
                            }
                            $count += 1;
                            if ($user->isLoggedIn()) {
                                $modal .= '

                    <!-- Register Buy Modal -->
                    <div class="modal fade" id="ws-buy-modal' . $video->id . '" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="border: none;">
                                    <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                                </div>
                                <div class="row" >
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="modal-body">                                    
                                            <!-- Register Form -->                                        
                                            <form class="ws-buy-form" action="transaction.php" method="POST">
                                                <h3 style="text-align: center; color:black;">Thank you for your interest!</h3>
                                                <div class="ws-separator"></div> 
                                                <h4 style="color:black;"><b>Title:</b> ' . $video->title . '<h4><br>
                                                <h4 style="color:black;"><b>Category:</b> ' . $video->category . '<h4><br>
                                                <h4 style="color:black;"><b>Artist:</b> ' . $video->username . '<h4><br>
                                                <h4 style="color:black;"><b>ID:</b> ' . $video->id . '<h4><br>
                                                <h4 style="color:black;">Choose the license you would like to purchase: </h4>
                                                <div class="ws-separator"></div>   
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" style="color: black;">
                                                        Licenses:  <a data-toggle="modal" data-target="#License" >
                                        <img style="height:16px; width:16px;" alt="assets/img/help.gif" src="assets/img/help.gif" >
                                    </a>
                                                    </label>
                                                    <label class="radio-inline"><input type="radio" checked="true" name="license" value="web">Web-$' . $video->web . '</label>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"></label>
                                                        <div class="col-md-8" style="margin-left: -50px">
                                                            <ul style="list-style: none;">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <input class="btn btn-sm" type="submit" value="Buy" name="submit" >
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Cancel</a><input hidden="true" name="videoid" type="text" value="' . $video->id . '" ><input hidden="true" name="type" type="text" value="video" >
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
                            } else {
                                $modal .= '

                    <!-- Register Buy Modal -->
                    <div class="modal fade" id="ws-buy-modal' . $video->id . '" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="border: none;">
                                    <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                                </div>
                                <div class="row" >
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="modal-body">                                    
                                            <!-- Register Form -->                                        
                                            <form class="ws-buy-form" style="color: black;">
                                                <h3 style="text-align: center;">Thank you for your interest!</h3>
                                                <div class="ws-separator"></div>   
                                                <div class="form-group">
                                                    <h4>to complete your purchase, please contact CII at <b>(415)855-8555</b>. Image info is listed below: </h4><br>
                                                <h4><b>Title:</b> ' . $video->title . '<h4><br>
                                                <h4 ><b>Category:</b> ' . $video->category . '<h4><br>
                                                <h4 ><b>Artist:</b> ' . $video->username . '<h4><br>
                                                <h4 ><b>ID:</b> ' . $video->id . '<h4><br>
                                                <h4><b>Licenses:</b> &nbsp;&nbsp;Web-$' . $video->web . '</h4>
                                                <br>
                                                <h4>or you can <a href="login.php"><span>Login</span></a> to your account to save the transaction!</h4>
                                                <br>
                                                <h4>Dont have an account? <a href="register.php"><span>Sign Up</span></a> today!</h4><br>
                                                <div class="form-group">
                                                        <label class="col-md-3 control-label"></label>
                                                        <div class="col-md-8" style="margin-left: 300px">
                                                            <ul style="list-style: none;">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Close</a>
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
                            }
                        }
                        echo $output;
                        ?>
                    </div>
                    <?php echo $modal ?>
                    <!-- Animal Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "animal");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Beauty Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "beauty");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- City Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "city");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Education Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "education");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Fashion Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "fashion");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Food Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "food");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Landmark Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "landmark");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Nature Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "nature");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Science Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "science");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Space Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "space");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Sport Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "sport");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Vintage Prints -->
                    <?php list($output, $modal) = getCategory($user, $videolist, $results, $searched, "vintage");
                    echo $output;
                    echo $modal
                    ?>

                </div>  
                <!-- End Categories Content -->   
            </div>
        </div>
    </div>
    <!-- End Page Content -->

    <?php

    function getCategory($user, $videolist, $results, $searched, $category) {
        $modal = "";
        $categories = array("all" => "all", "animal" => "animal", "beauty" => "beauty",
            "city" => "city", "education" => "education", "fashion" => "fashion",
            "food" => "food", "landmark" => "landmark", "nature" => "nature",
            "science" => "science", "space" => "space", "sport" => "sport", "vintage" => "vintage");
        $output = '<div role="tabpanel" class="tab-pane fade" id="' . $categories[$category] . '">';
        $category == "all" ? $videolist->listAll() : $videolist->search("category", $categories[$category]);
        $category_results = $videolist->data();
        if ($searched) {
            $category_results = array_map("unserialize", array_intersect(array_map("serialize", $results), array_map("serialize", $videolist->data())));
        }
        $count = 0;
        foreach ($category_results as $video) {
            $button = "<a href='#ws-buy-modal" . $video->id . "' data-toggle='modal' ><span class='ws-shop-cart'><input style='margin-right: 5px; height: 41px;' type='submit' class='btn btn-lg' value='Buy'></span></a> ";
            if ($user->isLoggedIn() && ($user->data()->id == $video->user_id || $user->data()->group == 3)) {
                $button = "<a href='video/edit/" . $video->id . "'>
                    <span class='ws-shop-cart'>
                        <input class='btn btn-lg' type='submit' style='margin-right: 5px; height: 41px;' value='Edit'>
                    </span>
                    </a>";
            }
            $output .="
                 <!-- Item -->
                 <div class='col-sm-6 col-md-4 ws-works-item'>
                     <a href='video/show/" . $video->id . "'>                           
                         <div class='ws-item-offer'>
                             <!-- Image -->                        
                             <figure>   ";
                            if($video->source == "youtube"){
                                            $output .="<iframe width='370' height='230' src='https://www.youtube.com/embed/" . $video->embeded . "';  ?> frameborder='0' ></iframe>";
                            }
                            else{
                                $output .="<iframe src='https://player.vimeo.com/video/" . $video->embeded .  "'width='370' height='230' frameborder='0'></iframe>";
                            }    
                                        $output .="</figure>                   
                         </div>
                         <div class='ws-works-caption text-center'>
                             <!-- Item Category -->
                             <div class='ws-item-category'>" . $video->category . "</div>

                             <!-- Title -->
                             <h3 class='ws-item-title'>" . $video->title . "</h3>  <br>
                            <!-- Buttons -->"
                    . $button . "
                            <a href='video/show/" . $video->id . "' ><span class='ws-shop-cart'><input style='margin-left: 5px; height: 41px;' type='submit' class='btn btn-lg' value='View'></span></a>
                             <div class='ws-item-separator'></div>          
                         </div>
                      </a>
                </div>";
            if ($count % 3 == 2) {
                $output .= '<div class="clearfix visible-md"></div>';
                $output .= '<div class="clearfix visible-lg"></div>';
            }
            $count ++;
            if ($user->isLoggedIn()) {
                $modal .= '

                    <!-- Register Buy Modal -->
                    <div class="modal fade" id="ws-buy-modal' . $video->id . '" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="border: none;">
                                    <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                                </div>
                                <div class="row" >
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="modal-body">                                    
                                            <!-- Register Form -->                                        
                                            <form class="ws-buy-form" action=transaction.php>
                                                <h3 style="text-align: center; color:black;">Thank you for your interest!</h3>
                                                <div class="ws-separator"></div> 
                                                <h4 style="color:black;"><b>Title:</b> ' . $video->title . '<h4><br>
                                                <h4 style="color:black;"><b>Category:</b> ' . $video->category . '<h4><br>
                                                <h4 style="color:black;"><b>Artist:</b> ' . $video->username . '<h4><br>
                                                <h4 style="color:black;"><b>ID:</b> ' . $video->id . '<h4><br>
                                                <h4 style="color:black;">Choose the license you would like to purchase: </h4>
                                                <div class="ws-separator"></div>   
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" style="color: black;">
                                                        Licenses:  <a data-toggle="modal" data-target="#License" >
                                        <img style="height:16px; width:16px;" alt="assets/img/help.gif" src="assets/img/help.gif" >
                                    </a>
                                                    </label>
                                                    <label class="radio-inline"><input type="radio" checked="true" name="license" value="web">Web-$' . $video->web . '</label>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"></label>
                                                        <div class="col-md-8" style="margin-left: -50px">
                                                            <ul style="list-style: none;">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <input class="btn btn-sm" type="submit" value="Buy" name="submit" value="Save Changes">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Cancel</a><input hidden="true" name="videoid" type="text" value="' . $video->id . '" ><input hidden="true" name="type" type="text" value="video" >
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
            } else {
                $modal .= '

                    <!-- Register Buy Modal -->
                    <div class="modal fade" id="ws-buy-modal' . $video->id . '" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="border: none;">
                                    <a class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                                </div>
                                <div class="row" >
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="modal-body">                                    
                                            <!-- Register Form -->                                        
                                            <form class="ws-buy-form" style="color: black;">
                                                <h3 style="text-align: center;">Thank you for your interest!</h3>
                                                <div class="ws-separator"></div>   
                                                <div class="form-group">
                                                    <h4>to complete your purchase, please contact CII at <b>(415)855-8555</b>. Image info is listed below: </h4><br>
                                                <h4><b>Title:</b> ' . $video->title . '<h4><br>
                                                <h4 ><b>Category:</b> ' . $video->category . '<h4><br>
                                                <h4 ><b>Artist:</b> ' . $video->username . '<h4><br>
                                                <h4 ><b>ID:</b> ' . $video->id . '<h4><br>
                                                <h4><b>Licenses:</b> &nbsp;&nbsp;Web - $' . $video->web . '</h4>
                                                <br>
                                                <h4>or you can <a href="login.php"><span>Login</span></a> to your account to save the transaction!</h4>
                                                <br>
                                                <h4>Dont have an account? <a href="register.php"><span>Sign Up</span></a> today!</h4><br>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"></label>
                                                        <div class="col-md-8" style="margin-left: 300px">
                                                            <ul style="list-style: none;">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Close</a>
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
            }
        }
        $output .="</div>";
        return array($output, $modal);
    }
    ?>

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
                    <h3 style="text-align: center; color:black;" ><u>Print</u></h3>
                    <p style="color:black; text-align: center;">You will receive a downloadable file of the video.</p>
                    <br>
                    <h3 style="text-align: center; color:black;" ><u>Unlimited</u></h3>
                    <p style="color:black; text-align: center;">You will receive the URL and the downloadable file of the video.</p>
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
    
    <script type="text/javascript">
        function OnSubmitForm(){
            if(document.myform.filter[0].selected == true){
              document.myform.action ="imageresults.php";
            }
            else if(document.myform.filter[1].selected == true){
              document.myform.action ="videoresults.php";
            }
            return true;
        }
    </script>
    
    <!-- Foot Bar -->
    <?php include 'view/foot-bar.php' ?>

    <!-- Scripts -->
    <?php include 'view/scripts.php' ?>
    
</body>
</html>
