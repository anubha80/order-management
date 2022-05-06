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
// Anubha Dubey(2032178)          2022-02-26            Validation of user input done
// Anubha Dubey(2032178)          2022-02-28            Fixed access error for orders.txt file
// Anubha Dubey(2032178)          2022-03-03            Fixed comment and price error
// Anubha Dubey(2032178)          2022-04-23            Add dropdown showing options from product table
// Anubha Dubey(2032178)          2022-04-23            Add constraints for quantity and comments
// Anubha Dubey(2032178)          2022-04-23            Calculate tax, total amount and taxed amount
// Anubha Dubey(2032178)          2022-04-23            Orders Save function inserting successfully into orders table
// Anubha Dubey(2032178)          2022-04-23            Redirect to orders 


// constants 
define("FOLDER_PHP_COMMON_FUNC", "PHP-CommonFunctions/");
define("FILE_PHP_COMMON", FOLDER_PHP_COMMON_FUNC . "commonFunctions.php");

define("COMMENTS_MAX_LENGTH", 200 );
define("QUANTITY_MIN", 1 );
define("QUANTITY_MAX", 99 );




// error logs
ini_set('display_errors', 1);
ini_set('log_errors',1);
ini_set('error_log',dirname(__FILE__).'/log.txt');
date_default_timezone_set('America/New_York');
$time=date('m/d/y h:iA', time());
$contents = file_get_contents('log.txt');
$contents .= "\t$time\r";
error_reporting(E_ALL);



//
require_once('product.php');
require_once('order.php');
// including common function
include_once(FILE_PHP_COMMON);


// calling noCache() to prevent page caching
noCache();

// calling main html body function with page name 'Buy'
bodyHTML("Buy");

// declaring variables for all form fields
// setting user entered values so that user entered values are not lost incase of an error  
$product = "";
$comment = "";
$quantity = "";

// declaring error message variables for all form fields 
$errorMsgProduct = "";
$errorMsgComment = "";
$errorMsgQuantity = "";
$finalMessage="";

$retail_price="";

// declaring variables for tax calulation and subtotal
// subtotal is the quanity multiplied by retail price
$subtotal = "";
$taxes_amount = "";
// total is the amount post tax addition
$total = "";
// product id
$prod_id="";
$sold_price="";

// setting false to errorOccured initially
$errorOccured = false;

// create object of product
$productObj=new product();
$odrerObj=new order();


// load all product fields and option for drop down
$arrFinalProductName=$productObj->loadProductDropdown();



// check if GET request is made 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

} // end of GET if condition




// collecting user data on submit
if (isset($_POST["submitbtn"])) {

    $prod=htmlspecialchars($_POST["product"]);
    $comment=htmlspecialchars($_POST["comment"]);
    $quantity=htmlspecialchars($_POST["quantity"]);
    

    
    if (mb_strlen($comment) > COMMENTS_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgComment = "WARNING : Comments length greater than " . COMMENTS_MAX_LENGTH;
    }
    if ($quantity == ""){
        $errorOccured = true;
        $errorMsgQuantity = "WARNING : Quantity is empty";
    }
    else {
        if (!(is_numeric($quantity))) {
            $errorOccured = true;
            $errorMsgQuantity = "WARNING : Quantity is not a numeric value";
        }
        else if (mb_strpos($quantity, ".")) {
            $errorOccured = true;
            $errorMsgQuantity = "WARNING : Quantity is a decimal value";
        }
        else if ($quantity < QUANTITY_MIN || $quantity > QUANTITY_MAX) {
            $errorOccured = true;
            $errorMsgQuantity = "WARNING : Quantity not in the range of " . QUANTITY_MIN . " - " . QUANTITY_MAX;
        }
    }
    
    // In case of no error 
    if ($errorOccured==false){
        //$productObj->load();
        
        $prod= substr($prod,0,4);
        //echo $prod;
        $prodCodeFoundSuccess=$productObj->loadProdDetails($prod);
        // getting the sold price
        $sold_price=$productObj->getRetailPrice();
        if($prodCodeFoundSuccess==true){
            $prod_id=$productObj->getProductId();
            $retail_price=$productObj->getRetailPrice();
            $subtotal= floatval($retail_price)*floatval($quantity);
            $taxes_amount= floatval($subtotal)*(13.7/100);
            $total= floatval($subtotal)+floatval($taxes_amount);

            
            $odrSaveFoundSuccess=$odrerObj->save($prod_id, $_SESSION['cus_id'], $quantity, $sold_price, $comment, $subtotal, $taxes_amount, $total);
//            var_dump($odrSaveFoundSuccess);
            
            if($odrSaveFoundSuccess==true){
                $finalMessage="Order Placed Successfully";
                // redirect to Orders page
                echo("<script>location.href = 'orders.php';</script>");
                exit;
            }
            else{
                $finalMessage="Order could not be placed";
            }
        }
        
        
        /// create order object and save product details along with order details
    }
    
} // end of post 'if' condition 

// display user a form having various fields to place an order
?>

<div class="form-container">
    <h2 class="form-heading">🍓🍇 Place YOGO Order 🍓🍇</h2>
    <div class="final-msg">
        <?php echo '<p>'.$finalMessage.'</p>'?>
    </div>   
    <form class="buy-form" action="buy.php" method="POST">
        <div class="field-container">
            <div class="form-field">
                <label for="" >Product <span class="mandatory-field">*</span> :</label>
                <select class="product-option" name="product">
                    
                        <?php
                            // populate options for dropdown menu product
                            for ($x = 0; $x < sizeof($arrFinalProductName); $x++) {
                                // show all options in product drop down
                                echo '<option class="prod-dropdown" value="'.$arrFinalProductName[$x].'">'.$arrFinalProductName[$x].'</option>';
                            } 
                        ?>
                    
                </select>
                <span class="validationError"><?php echo $errorMsgProduct; ?></span>
            </div>
            <div class="form-field">
                <label for="" >Comments :</label>
                <input type="text" name="comment" id="" value="<?php echo $comment;?>"  placeholder="Your comment...">
                <span class="validationError"><?php echo $errorMsgComment; ?></span>
            </div>
            <div class="form-field">
                <label for="" >Quantity <span class="mandatory-field">*</span> :</label>
                <input type="text" name="quantity" id="" value="<?php echo $quantity;?>"  placeholder="Quantity...">
                <span class="validationError"><?php echo $errorMsgQuantity; ?></span>
            </div>
        </div>
        <div class="form-buttons">
                <button class="submit-btn" type="submit" name="submitbtn" value="">Buy</button>
        </div>
    </form>
</div>

<?php
// calling footer function at the end of the page
footer();
?>