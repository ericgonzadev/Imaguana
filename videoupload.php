<?php
require_once 'core/init.php';
$count = 0;
$validations = "";
$user = new User();
$link = $user->data()->username;
if (!$user->isLoggedIn()) {
    Redirect::to("./login.php");
}
if ($user->data()->group == 2) {
    Redirect::to('./');
}

$video = new Video();
if(isset($_POST['submit'])){
    //Connection
    mysql_connect("sfsuswe.com", "s16g09", "9team2016") or die(mysql_error());
    mysql_select_db("student_s16g09") or die(mysql_error());

    //Variables holding the image info
    $title = $_POST['title'];
    $description = $_POST['description'];
    $url = $_POST['url'];
    $web = $_POST['web'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $embeded = "";
    $source = "";

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
    
    //validate link is from youtube or vimeo
    if (strpos($url, 'youtube.com/watch?v') !== false) {
        $source = 'youtube';
        if (($pos = strpos($url, "=")) !== FALSE){
        $embeded = substr($url, $pos+1); }
    }
    else if (strpos($url, 'vimeo.com/') !== false) {
        $source =  'vimeo';
        if (($pos = strpos($url, "m/")) !== FALSE){
        $embeded = substr($url, $pos+2); }
    }
    else{
      $validations .= "- url must be from Youtube (ex: https://www.youtube.com/watch?v=hoCmY0uGneY) or Vimeo (ex: https://vimeo.com/55455061)<br>";
      $count++; 
    }
    
    //validate that the web licenses is an integer
    if(!intval($web)){
        $validations .= "- web license value must be a number<br>";
        $count++; 
    }

    if ($validation->passed() && $validations == "") {
        //Store image into datavase. If query does not execute correctly redirect to error page
        $lastid = $video->create( array(
                'id' => '', 
                'user_id' => $user_id,
                'username' => $username,
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'source' => $source,
                'web' => $web,
                'embeded' => $embeded,
                'category' => $category,
                'tags' => $tags));
        header("location:video/show/" . $lastid);
    }
    else {
        foreach ($validation->errors() as $error) {
            $count++;  
            $validations .= "- {$error} <br>";
        }
    }  
}
?>
<!doctype html>
<head>
    <title>Imaguana | Upload</title>

    <!-- CSS, Meta, Ajax, etc. -->
    <?php include 'view/head.php' ?>

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
                        <h3>Upload Video:  <?php echo $user->data()->username; ?></h3> 
                        <div class="ws-separator"></div>   
                    </div>
                    <?php   if ($count > 0){echo "<p style='text-align: center; color: red'>" . $count . " error(s)</p><p style='text-align: center; color: red'>" . $validations . "</p><br>";}?>
                </div>   
                <div class="ws-contact-page">
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal ws-contact-form">
                        <h5 style="text-align: center; color: black;">All fields marked with * are required</h5>
                            <div class="ws-contact-info">
                                <h2>Title<span>*</span></h2>
                                <textarea class="form-control" required="true" name="title" id="title" rows="1" cols="100" placeholder="Enter a title for your image" style="resize:none;"><?php echo Input::get('title'); ?></textarea><br/>  
                                <h2>Description<span>*</span></h2> 
                                <textarea  class="form-control" name="description" required="true" id="description" rows="3" cols="100" placeholder="Add some descriptive text for your image" style="resize:none;"><?php echo Input::get('description'); ?></textarea><br/>
                                <h2>URL (Youtube or Vimeo)<span>*</span></h2>
                                <textarea class="form-control" required="true" name="url" id="url" rows="1" cols="100" placeholder="ex:&nbsp; https://www.youtube.com/watch?v=KJ38jTQcO1k" style="resize:none;"><?php echo Input::get('url'); ?></textarea><br/><br/>  
                                <h2>License<span>*</span>   
                                    <a data-toggle="modal" data-target="#License" >
                                        <img style='height:16px; width:16px;' alt='assets/img/help.gif' src='assets/img/help.gif' >
                                    </a>

                                    <table style="margin-top: 10px;">
                                        <tr>
                                            <td ><label class="control-label">Web* $</label></td>
                                            <td style="padding-right: 20px"><textarea name="web" id="web" required="true" class="form-control-upload" rows="1" cols="10" placeholder="20" style="resize:none;"><?php echo Input::get('web'); ?></textarea><p class="pull-right"></p></td>
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
                                <textarea name="tags" id="tags" rows="3" cols="100" placeholder="Input keywords that will help people search for your image. &nbsp; Examples: &nbsp; Categories, &nbsp;Colors, &nbsp;Style, &nbsp;etc." style="resize:none;"><?php echo Input::get('tags'); ?></textarea>

                                <div class="col-sm-11">
                                    <!-- Button -->
                                    <input class="btn ws-btn-fullwidth" style="margin-top: 15px; width: 300px;" type="submit" value="Upload" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="user/profile/<?php echo $user->data()->username; ?>" class="btn ws-btn-black" style="color: white; margin-top: 15px; width: 250px" >Cancel</a>
                                </div>
                                <input type="hidden" name="user_id" id="user_id" value=" <?php echo $user->data()->id; ?>">
                                <input type="hidden" name="username" id="username" value=" <?php echo $user->data()->username; ?>">
                            </div>
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
