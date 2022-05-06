<?php

if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

 // checking if logged in 
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
//    header("location: index.php");
}
?>


<?php

// REVISION HISTORY

// DEVELOPER                      DATE                                      COMMENTS
// Anubha Dubey(2032178)          2022-02-26                Added php common functions, company name and description
// Anubha Dubey(2032178)          2022-02-28                Updated best seller product image to appear 100%
// Anubha Dubey(2032178)          2022-02-29                Fixed error in best seller product image, added CSS for the same 
// Anubha Dubey(2032178)          2022-02-29                Added product name for bestseller 
// Anubha Dubey(2032178)          2022-03-05                Added gogle link to each product image
// Anubha Dubey(2032178)          2022-04-16                Move cheat sheet from orders to page






// error logs
ini_set('display_errors', 1);
ini_set('log_errors',1);
ini_set('error_log',dirname(__FILE__).'/log.txt');
date_default_timezone_set('America/New_York');
$time=date('m/d/y h:iA', time());
$contents = file_get_contents('log.txt');
$contents .= "\t$time\r";
error_reporting(E_ALL);


//constants 
define("FOLDER_PHP_COMMON_FUNC", "PHP-CommonFunctions/");
define("FILE_PHP_COMMON_FUNC", FOLDER_PHP_COMMON_FUNC . "commonFunctions.php");


// Including commonFunctions.php file
include_once(FILE_PHP_COMMON_FUNC);

// calling noCache() to prevent page caching 
noCache();

// calling main html body function with page name 'Home'
bodyHTML("Home");


// get page title

//echo '<script>alert(document.title);</script>';



// Shuffle Product Images
$product_images  = PRODUCT_IMAGES;
shuffle($product_images);
//print_r($product_images);
?> <!-- php tag ends here -->

<div class="company-container">
    <?php 
    echo "<div class='download-btn'><a class='cheat-sheet-link' href=".FILE_CHEAT_SHEET." download='CheatSheet_Anubha'>Cheat Sheet</a></div>";
    ?>
    <h1 class="company-name">🍒🍓 YOGO Yogurt 🍒🍓</h1>
    
    <h3 class="company-slogan">The yogurt for your gut... 🍒</h3>
    <p class="company-detail">Yogurt is a dairy product made by fermenting milk with a yogurt culture. 
        <br> It provides protein and calcium, and it may enhance healthy gut bacteria.
        <br>Health benefits range from protecting against osteoporosis to relieving irritable bowel 
        <br>disease and aiding digestion, but these depend on the type of yogurt consumed.</p>
</div>



<?php
// checking for the best seller image to display 2x times
if($product_images[0]=="strawberry-yogo.png"){
    echo '<h3 class="bestselling-heading">🥇⭐️🏆 BESTSELLER 🏆⭐️🥇</h3>';
    echo '<a href="https://www.google.ca/" target="_blank"><img alt="yogurt-img" class="bestseller-img" src="Images/'.$product_images[0].'"/></a>';
    echo '<p class="bestselling-prod-name">🍓 Strawberry Yogurt 🍓</p>';
}
else{
    echo '<a href="https://www.google.ca/" target="_blank"><img alt="yogurt-img" class="product-img" src="Images/'.$product_images[0].'"/></a>';
}    
?>

<?php
//calling footer function
footer();
?>

