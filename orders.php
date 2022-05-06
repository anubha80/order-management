<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
// checking if logged in 
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
?>


<?php

// REVISION HISTORY

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-02-26              Added php common functions, company name and description
// Anubha Dubey(2032178)          2022-02-28              Updated best seller product image to appear 100%
// Anubha Dubey(2032178)          2022-02-29              Fixed error in best seller product image, added CSS for the same 
// Anubha Dubey(2032178)          2022-02-29              Added product name for bestseller 
// Anubha Dubey(2032178)          2022-03-03              Added code to display orders in html table form
// Anubha Dubey(2032178)          2022-03-03              Fixed extra row error in table
// Anubha Dubey(2032178)          2022-03-03              Created cheat sheet button
// Anubha Dubey(2032178)          2022-03-04              Created cheat sheet download link
// Anubha Dubey(2032178)          2022-03-05              Changed column subtotal's font color based on price
// Anubha Dubey(2032178)          2022-03-06              Removed hard coded orders array length



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

// calling main html body function with page name 'Orders'
bodyHTML("Orders");

$errorMsgOrderDate="";

?>


<div class="form-container">
    <h2 class="form-heading">🍓🍇 Search Orders 🍓🍇</h2>

    <form class="myOrderform" action="" method="POST" enctype="multipart/form-data">
        <div class="field-container orders">
            <div class="form-field order">
                <label for="">Show orders made on this day or later :</label>
                <input type="text" name="order-date" class="order-date" id="" value=""  placeholder="2022 - 04 - 22">
                <span class="validationError"><?php echo $errorMsgOrderDate; ?></span>
            </div>
        </div>
        <div class="form-buttons">
                <button class="submit-btn" type="submit" name="searchbtn" value="";>Search</button>
        </div>
    </form>
</div>




<?php
//calling footer in the end
    footer();
?>
