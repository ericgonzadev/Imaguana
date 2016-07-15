<?php echo '
    <!-- Top Bar Start -->
    <div class="ws-topbar" id="home">
        <div class="pull-left">
            <div class="ws-topbar-message hidden-xs">
                <a href="index.php">Find your perfect image!</a> 
            </div>
        </div>

       <div class="ws-center">
          <!-- Search Bar -->
          <ul class="ws-shop-menu">
             <li>
                <form class="ws-shop-cart">
                    <input  style="color: black; height:36px; width: 300px; font-size:20px;" type="text" placeholder="Search here..." required>
                </form>
             </li>
             <!-- Search -->
             <li class="ws-shop-cart">
                <a href="#x" class="btn btn-sm">Submit</a>
             </li>
          </ul>
       </div>

        <div class="pull-right">
            <!-- Shop Menu -->
            <ul class="ws-shop-menu">
                <!-- Account -->
                <li class="ws-shop-account">
                    <a href="index.php" class="btn btn-sm">Log out</a>
                </li>
            </ul>
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
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Logo -->
                <div class="ws-logo ws-center">
                    <a href="index.php">
                        <img src="assets/img/iguana_ed.gif" alt="Alternative Text" class="img-responsive">
                    </a>
                </div>
               <!-- Links -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="./">Home</a></li>
                        <li><a href="./#about">About US</a></li>
                        <li><a href="imageresults.php">Browse All</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li><a href="profile.php" class="btn btn-sm">My Account</a></li>

                        <li><a href="./#contactA">Contact</a></li>
                        <li><a href="faq.php">F.A.Q.</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->';
?>
