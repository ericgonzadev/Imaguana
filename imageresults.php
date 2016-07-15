<?php
require_once 'core/init.php';

//Connection
mysql_connect("sfsuswe.com", "s16g09", "9team2016") or die(mysql_error());
mysql_select_db("student_s16g09") or die(mysql_error());

$user = new User();
$imagelist = new Image();
$modal = "";

?>

<!doctype html>
<head>
    <title>Imaguana | Browse</title>
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
    <?php include 'view/nav-bar-alt.php'; ?>

    <!-- Page Content -->
    <div class="container ws-page-container" style="margin-top: -70px">
        <div class="ws-works-title clearfix">
            <div class="col-sm-12">
                <h3 style="font-size: 35px">Image Results</h3> 
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
                             <option value="2" style="color:black;">Videos</option>
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
                    $imagelist->search("title", $searchq);
                    $title_results = $imagelist->data();
                    $results = array_merge($results, $title_results);

                    //description search
                    $imagelist->search("description", $searchq);
                    $description_results = $imagelist->data();
                    $results = array_merge($results, $description_results);

                    //category search
                    $imagelist->search("category", $searchq);
                    $category_results = $imagelist->data();
                    $results = array_merge($results, $category_results);

                    //tags search
                    $imagelist->search("tags", $searchq);
                    $tags_results = $imagelist->data();
                    $results = array_merge($results, $tags_results);

                    //username search
                    $imagelist->search("username", $searchq);
                    $username_results = $imagelist->data();
                    $results = array_merge($results, $username_results);

                    // remove duplicated image result
                    $results = array_map("unserialize", array_unique(array_map("serialize", $results)));

                    //get results count
                    $total_count = count($results);

                    $total_count == 0 ? $count = "<p style='color: black; text-align: center'>No Results for '<b>" . $searchq . "</b>'</p>" : $count = "<p style='color: black; text-align: center'>(" . $total_count . " image results for '<b>" . $searchq . "</b>')</p>";
                    echo $count;
                }
                if(isset($searchtag)){
                    $searched = 1;
                    //tags search
                    $imagelist->search("tags", $searchtag);
                    $tags_results = $imagelist->data();
                    $results = array_merge($results, $tags_results);
                    
	            //get results count
                    $total_count = count($results);

                    $total_count == 0 ? $count = "<p style='color: black; text-align: center'>No Results for Tag '<b>" . $searchtag . "</b>'</p>" : $count = "<p style='color: black; text-align: center'>(" . $total_count . " image results for Tag '<b>" . $searchtag . "</b>')</p>";
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
                        $css = '<style type="text/css"> ';
                        $imagelist->listAll();
                        if (!$searched) {
                            $category_results = $imagelist->data();
                        } else {
                            // intersect keyword search result and category result
                            $category_results = array_map("unserialize", array_intersect(array_map("serialize", $results), array_map("serialize", $imagelist->data())));
                        }
                        $count = 0;
                        foreach ($category_results as $image) {
                            $css .= '
                                .multiPic' . $image->id . '{ 
                                    width:350px; 
                                    height:240px;  
                                    background: url(' . $image->image . ') no-repeat;
                                    background-size: 350px 240px;
                                } 
                                .multiPic' . $image->id . ' .text' . $image->id . '{ 
                                    width:320px; 
                                    height:80px; 
                                    background:#FFA500; background: url(assets/img/favicon.png) no-repeat; opacity:0; } 

                                .multiPic' . $image->id . ':hover .text' . $image->id . '{ 
                                    opacity:0.9; 
                                } ';
                            $button = "<a href='#ws-buy-modal" . $image->id . "' data-toggle='modal' ><span class='ws-shop-cart'><input style='margin-right: 5px; height: 41px;' type='submit' class='btn btn-lg' value='Buy'></span></a> ";
                            if ($user->isLoggedIn() && ($user->data()->id == $image->user_id || $user->data()->group == 3)) {
                                $button = "<a href='image/edit/" . $image->id . "'>
                                <span class='ws-shop-cart' >
                                    <input class='btn btn-lg' type='submit' style='margin-right: 5px; height: 41px;' value='Edit'>
                                </span>
                                </a>";
                            }
                            $output .="
                             <!-- Item -->
                             <div class='col-sm-6 col-md-4 ws-works-item'>
                                 <a href='image/show/" . $image->id . "'>                           
                                     <div class='ws-item-offer'>
                                         <!-- Image -->                        
                                         <figure>                            
                                            <div class='multiPic". $image->id . "'> 
                                                <div class='text" . $image->id . "'>                     
                                                </div>
                                            </div>
                                         </figure>                    
                                     </div>
                                     <div class='ws-works-caption text-center'>
                                         <!-- Item Category -->
                                         <div class='ws-item-category'>" . $image->category . "</div>

                                         <!-- Title -->
                                         <h3 class='ws-item-title'>" . $image->title . "</h3>  <br>
                                        <!-- Buttons -->"
                                    . $button . "
                                        <a href='image/show/" . $image->id . "' ><span class='ws-shop-cart'><input style='margin-left: 5px; height: 41px;' type='submit' class='btn btn-lg' value='View'></span></a>
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
                    <div class="modal fade" id="ws-buy-modal' . $image->id . '" tabindex="-1">
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
                                                <h4 style="color:black;"><b>Title:</b> ' . $image->title . '<h4><br>
                                                <h4 style="color:black;"><b>Category:</b> ' . $image->category . '<h4><br>
                                                <h4 style="color:black;"><b>Artist:</b> ' . $image->username . '<h4><br>
                                                <h4 style="color:black;"><b>ID:</b> ' . $image->id . '<h4><br>
                                                <h4 style="color:black;">Choose the license you would like to purchase: </h4>
                                                <div class="ws-separator"></div>   
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" style="color: black;">
                                                        Licenses:  <a data-toggle="modal" data-target="#License" >
                                        <img style="height:16px; width:16px;" alt="assets/img/help.gif" src="assets/img/help.gif" >
                                    </a>
                                                    </label>
                                                    <label class="radio-inline"><input type="radio" checked="true" name="license" value="web">Web-$' . $image->web . '</label>
                                                    <label class="radio-inline"><input value="print" type="radio" name="license">Print-$' . $image->print . '</label>
                                                    <label class="radio-inline"><input value="unlimited" type="radio" name="license">Unlimited-$' . $image->unlimited . '</label>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"></label>
                                                        <div class="col-md-8" style="margin-left: -50px">
                                                            <ul style="list-style: none;">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <input class="btn btn-sm" type="submit" value="Buy" name="submit" >
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Cancel</a><input hidden="true" name="imageid" type="text" value="' . $image->id . '" >
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
                    <div class="modal fade" id="ws-buy-modal' . $image->id . '" tabindex="-1">
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
                                                <h4><b>Title:</b> ' . $image->title . '<h4><br>
                                                <h4 ><b>Category:</b> ' . $image->category . '<h4><br>
                                                <h4 ><b>Artist:</b> ' . $image->username . '<h4><br>
                                                <h4 ><b>ID:</b> ' . $image->id . '<h4><br>
                                                <h4><b>Licenses:</b> &nbsp;&nbsp;Web-$' . $image->web . ' &nbsp;&nbsp;Print-$' . $image->print . ' &nbsp;&nbsp;Unlimited-$' . $image->unlimited . '</h4>
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
                        $css .= '</style>';
                        echo $css;
                        ?>
                    </div>
                    <?php echo $modal ?>
                    <!-- Animal Prints -->
                    <?php list($output, $modal, $css) = getCategory($user, $imagelist, $results, $searched, "animal");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Beauty Prints -->
                    <?php list($output, $modal, $css) = getCategory($user, $imagelist, $results, $searched, "beauty");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- City Prints -->
                    <?php list($output, $modal, $css) = getCategory($user, $imagelist, $results, $searched, "city");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Education Prints -->
                    <?php list($output, $modal , $css) = getCategory($user, $imagelist, $results, $searched, "education");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Fashion Prints -->
                    <?php list($output, $modal , $css) = getCategory($user, $imagelist, $results, $searched, "fashion");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Food Prints -->
                    <?php list($output, $modal , $css) = getCategory($user, $imagelist, $results, $searched, "food");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Landmark Prints -->
                    <?php list($output, $modal, $css) = getCategory($user, $imagelist, $results, $searched, "landmark");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Nature Prints -->
                    <?php list($output, $modal, $css) = getCategory($user, $imagelist, $results, $searched, "nature");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Science Prints -->
                    <?php list($output, $modal , $css) = getCategory($user, $imagelist, $results, $searched, "science");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Space Prints -->
                    <?php list($output, $modal , $css) = getCategory($user, $imagelist, $results, $searched, "space");
                    echo $output;
                    echo $modal
                    ?>

                    <!-- Sport Prints -->
                    <?php list($output, $modal , $css) = getCategory($user, $imagelist, $results, $searched, "sport");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                    <!-- Vintage Prints -->
                    <?php list($output, $modal , $css) = getCategory($user, $imagelist, $results, $searched, "vintage");
                    echo $output;
                    echo $css;
                    echo $modal
                    ?>

                </div>  
                <!-- End Categories Content -->   
            </div>
        </div>
    </div>
    <!-- End Page Content -->

    <?php

    function getCategory($user, $imagelist, $results, $searched, $category) {
        $modal = "";
        $css = '<style type="text/css"> ';
        $categories = array("all" => "all", "animal" => "animal", "beauty" => "beauty",
            "city" => "city", "education" => "education", "fashion" => "fashion",
            "food" => "food", "landmark" => "landmark", "nature" => "nature",
            "science" => "science", "space" => "space", "sport" => "sport", "vintage" => "vintage");
        $output = '<div role="tabpanel" class="tab-pane fade" id="' . $categories[$category] . '">';
        $category == "all" ? $imagelist->listAll() : $imagelist->search("category", $categories[$category]);
        $category_results = $imagelist->data();
        if ($searched) {
            $category_results = array_map("unserialize", array_intersect(array_map("serialize", $results), array_map("serialize", $imagelist->data())));
        }
        $count = 0;
        foreach ($category_results as $image) {
            $css .= '
                .multiPic' . $image->id . '{ 
                    width:350px; 
                    height:240px;  
                    background: url(' . $image->image . ') no-repeat;
                    background-size: 350px 240px;
                } 
                .multiPic' . $image->id . ' .text' . $image->id . '{ 
                    width:320px; 
                    height:80px; 
                    background:#FFA500; background: url(assets/img/favicon.png) no-repeat; opacity:0; } 

                .multiPic' . $image->id . ':hover .text' . $image->id . '{ 
                    opacity:0.9; 
                } ';
            $button = "<a href='#ws-buy-modal" . $image->id . "' data-toggle='modal' ><span class='ws-shop-cart'><input style='margin-right: 5px; height: 41px;' type='submit' class='btn btn-lg' value='Buy'></span></a> ";
            if ($user->isLoggedIn() && $user->data()->id == $image->user_id) {
                $button = "<a href='image/edit/" . $image->id . "'>
                    <span class='ws-shop-cart'>
                        <input class='btn btn-lg' type='submit' style='margin-right: 5px;  height: 41px;' value='Edit'>
                    </span>
                    </a>";
            }
            $output .="
                 <!-- Item -->
                 <div class='col-sm-6 col-md-4 ws-works-item'>
                     <a href='image/show/" . $image->id . "'>                           
                         <div class='ws-item-offer'>
                             <!-- Image -->                        
                             <figure>                            
                                <div class='multiPic". $image->id . "'> 
                                    <div class='text" . $image->id . "'>                     
                                    </div>
                                </div>
                             </figure>                    
                         </div>
                         <div class='ws-works-caption text-center'>
                             <!-- Item Category -->
                             <div class='ws-item-category'>" . $image->category . "</div>

                             <!-- Title -->
                             <h3 class='ws-item-title'>" . $image->title . "</h3>  <br>
                            <!-- Buttons -->"
                    . $button . "
                            <a href='image/show/" . $image->id . "' ><span class='ws-shop-cart'><input style='margin-left: 5px; height: 41px;' type='submit' class='btn btn-lg' value='View'></span></a>
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
                    <div class="modal fade" id="ws-buy-modal' . $image->id . '" tabindex="-1">
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
                                                <h4 style="color:black;"><b>Title:</b> ' . $image->title . '<h4><br>
                                                <h4 style="color:black;"><b>Category:</b> ' . $image->category . '<h4><br>
                                                <h4 style="color:black;"><b>Artist:</b> ' . $image->username . '<h4><br>
                                                <h4 style="color:black;"><b>ID:</b> ' . $image->id . '<h4><br>
                                                <h4 style="color:black;">Choose the license you would like to purchase: </h4>
                                                <div class="ws-separator"></div>   
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" style="color: black;">
                                                        Licenses:  <a data-toggle="modal" data-target="#License" >
                                        <img style="height:16px; width:16px;" alt="assets/img/help.gif" src="assets/img/help.gif" >
                                    </a>
                                                    </label>
                                                    <label class="radio-inline"><input type="radio" checked="true" name="license" value="web">Web-$' . $image->web . '</label>
                                                    <label class="radio-inline"><input value="print" type="radio" name="license">Print-$' . $image->print . '</label>
                                                    <label class="radio-inline"><input value="unlimited" type="radio" name="license">Unlimited-$' . $image->unlimited . '</label>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"></label>
                                                        <div class="col-md-8" style="margin-left: -50px">
                                                            <ul style="list-style: none;">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <input class="btn btn-sm" type="submit" value="Buy" name="submit" value="Save Changes">
                                                                <li class="ws-shop-cart" style="display:inline;">
                                                                <a data-dismiss="modal" aria-label="Close" class="btn btn-sm" style="margin-left: 25px;">Cancel</a>
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
                    <div class="modal fade" id="ws-buy-modal' . $image->id . '" tabindex="-1">
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
                                                <h4><b>Title:</b> ' . $image->title . '<h4><br>
                                                <h4 ><b>Category:</b> ' . $image->category . '<h4><br>
                                                <h4 ><b>Artist:</b> ' . $image->username . '<h4><br>
                                                <h4 ><b>ID:</b> ' . $image->id . '<h4><br>
                                                <h4><b>Licenses:</b> &nbsp;&nbsp;Web - $' . $image->web . ' &nbsp;&nbsp;Print - $' . $image->print . ' &nbsp;&nbsp;Unlimited - $' . $image->unlimited . '</h4>
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
        $css .= '</style>';
        return array($output, $modal,$css);
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
