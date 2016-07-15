<?php
require_once 'core/init.php';
$user = new User();
if ($user->isLoggedIn()){
    $name = $user->data()->name;
    $link = $user->data()->username; 
}
$navbar = '
    <!-- Top Bar Start -->
    <div class="ws-topbar" id="home">
        <div class="pull-left">
            <div class="ws-topbar-message hidden-xs">
                <a href="./"><p>Find your <span>perfect</span> image!</p></a> 
            </div>
        </div>

        <div class="pull-right">
            <!-- Shop Menu -->
            <ul class="ws-shop-menu">
                <!-- Account --> ' ?>
                <?php if (!$user->isLoggedIn()){
                    $navbar .= '<!-- Account -->
                    <li class="ws-shop-account">
                        <a href="login.php" class="btn btn-sm">Login</a>
                    </li>
                     <li class="ws-shop-account">
                        <a href="register.php" class="btn btn-sm">Sign Up</a>
                    </li>';
                }
                else{
                    $navbar .= "<!-- Account -->
                    <li class='ws-shop-account'>
                        <a href='user/profile/$link' class='btn btn-sm'>Hello, {$name}</a>
                    </li>
                    <li class='ws-shop-account'>
                        <a href='logout.php' class='btn btn-sm'>Logout</a>
                    </li>";
                }
             $navbar .= '</ul>
        </div>
    </div>
    <!-- Top Bar End -->

    <!-- Header Start -->
    <header class="ws-header ws-header-static">

        <!-- Navbar -->
        <nav class="navbar ws-navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Logo -->
                <div class="ws-logo ws-center">
                    <a href="./">
                        <img src="assets/img/iguana_ed.gif" alt="Alternative Text" class="img-responsive">
                    </a>
                </div>
                <!-- Links -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="./">Home</a></li>
                        <li><a href="./#about">About US</a></li>
                        <li class="dropdown">
                            <a href="imageresults.php" class="dropdown-toggle" data-hover="dropdown" data-animations="fadeIn">Browse<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="imageresults.php">Browse Images</a></li>
                                <li><a href="videoresults.php">Browse Videos</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right"> ' ?>
                    <?php if (!$user->isLoggedIn()){
                        $navbar .= '<li><a href="login.php" class="btn btn-sm">My Account</a></li>';
                    }
                    else{
                        $navbar .= '<li class="dropdown">
                            <a href="user/profile/' . $user->data()->username .'" class="dropdown-toggle" data-hover="dropdown" data-animations="fadeIn">My Account<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="upload.php">Upload an image</a></li>
                                <li><a href="videoupload.php">Upload a video</a></li>
                                <li><a href="purchases.php">View purchases</a></li>
                            </ul>
                        </li>';
                    }   

                    $navbar .=    '<li><a href="./#contactA">Contact</a></li>
                        
                            <li><a href="faq.php">F.A.Q.</a></li>
                            
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->';
    echo  $navbar;
?>
