
<?php

// REVISION HISTORY

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-11              Create registration form
// Anubha Dubey(2032178)          2022-04-12              Add form field validation
// Anubha Dubey(2032178)          2022-04-20              Test regustartion initial stage 
// Anubha Dubey(2032178)          2022-04-20              Create object of customer and set fields
// Anubha Dubey(2032178)          2022-04-20              Fix logical error for showing error messages
// Anubha Dubey(2032178)          2022-04-22              Add picture uploading feature

if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}



// error logs
ini_set('display_errors', 1);
ini_set('log_errors',1);
ini_set('error_log',dirname(__FILE__).'/log.txt');
date_default_timezone_set('America/New_York');
$time=date('m/d/y h:iA', time());
$contents = file_get_contents('log.txt');
$contents .= "\t$time\r";
error_reporting(E_ALL);


//include_once('customer.php');
require_once('connection.php');



//constants
define("FOLDER_PHP_COMMON_FUNC", "PHP-CommonFunctions/");
define("FILE_PHP_COMMON_FUNC", FOLDER_PHP_COMMON_FUNC . "commonFunctions.php");

// Including commonFunctions.php file
include_once(FILE_PHP_COMMON_FUNC);

// calling noCache() to prevent page caching 
noCache();

// calling main html body function with page name 'Register'
bodyHTML("Register");
?>



<?php
// checking if logged in 
//session_start();
//if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
//    header("location:register.php");
//    exit;
//}
?>




<?php

// declare variables for user registration
$firstName = "";
$lastName = "";
$address = "";
$city = "";
$postalCode = "";
$username = "";
$password = "";
$province = "";
$picture = NULL;

// declare variables to store error message if any
$errorMsgFirstName = "";
$errorMsgLastName = "";
$errorMsgAddress = "";
$errorMsgCity = "";
$errorMsgPostalCode ="";
$errorMsgUsername = "";
$errorMsgPassword = "";
$errorMsgProvince = "";
$errorMsgPicture = "";

// setting the initial value to false
$errorOccured = false;
// FInal message display to user weather login successful or failed
$finalMessage ="";

if (isset($_POST["submitbtn"])) {
    $firstName = htmlspecialchars($_POST["firstName"]);
    $lastName = htmlspecialchars($_POST["lastName"]);
    $address = htmlspecialchars($_POST["address"]);
    $province = htmlspecialchars($_POST["province"]);
    $city = htmlspecialchars($_POST["city"]);
    $postalCode = htmlspecialchars($_POST["postalCode"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    
    // check if picture is uploaded
    if ($_FILES['picture']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['picture']['tmp_name'])) {
        $picture = file_get_contents($_FILES['picture']['tmp_name']);
    } else {
        $errorMsgPicture = "WARNING: Picture not uploaded";  
        //echo $errorMsgPicture;
    }
   
   
    if ($firstName !="" && $picture!="" && $lastName!="" && $address!="" && $city!="" && $province!="" && $username!="" && $password!="") {
        $finalMessage="SUCCESS";
    } // end of 'if' condition of errorOccured
    
    // creating new customer class
    $cusObj = new customer();
    // setting all the fields for customer 
    $errorMsgFirstName= $cusObj->setFirstname($firstName);
    $errorMsgLastName= $cusObj->setLastname($lastName);
    $errorMsgAddress= $cusObj->setAddress($address);
    $errorMsgCity= $cusObj->setCity($city);
    $errorMsgPostalCode= $cusObj->setPostalcode($postalCode);
    $errorMsgProvince= $cusObj->setProvince($province);
    $errorMsgUsername= $cusObj->setUsername($username);
    $errorMsgPassword= $cusObj->setPassword($password );
    $errorMsgPicture= $cusObj->setPicture($picture);
    
    // check if all fields are valid
    if ($finalMessage=="SUCCESS"){
        if($errorMsgFirstName=="" && $errorMsgPicture=="" && $errorMsgLastName=="" && $errorMsgAddress=="" && $errorMsgCity=="" && $errorMsgPostalCode=="" && $errorMsgProvince=="" && $errorMsgUsername=="" && $errorMsgPassword==""){

            $saveSuccess = $cusObj->save();
            var_dump($saveSuccess);
//            echo $saveSuccess;
            if($saveSuccess==true){
                $finalMessage="User Registration Successful";
            }
            else{
                $finalMessage="OOPS! User Registration Failed.";
            }
        }
    }
    else{
            $finalMessage="Hmmm... Something is missing";
    }
    
} 

?>

<div class="form-container">
    <h2 class="form-heading">🍓🍇 Register Yourself 🍓🍇</h2>
    <div class="final-msg">
        <?php echo '<p>'.$finalMessage.'</p>'?>
    </div>
    <form class="myform" action="register.php" method="POST" enctype="multipart/form-data">
        <div class="field-container">
            <div class="form-field">
                <label for="">First Name  <span class="mandatory-field">*</span> :</label>
                <input type="text" name="firstName" id="firstname" value="<?php echo $firstName;?>"  placeholder="Your first name...">
                <span class="validationError"><?php echo $errorMsgFirstName; ?></span>
            </div>
            <div class="form-field">
                <label for="">Last Name  <span class="mandatory-field">*</span> :</label>
                <input type="text" name="lastName" id="lastname" value="<?php echo $lastName;?>"  placeholder="Your last name...">
                <span class="validationError"><?php echo $errorMsgLastName; ?></span>
            </div>
            <div class="form-field">
                <label for="">Address  <span class="mandatory-field">*</span> :</label>
                <input type="text" name="address" id="" value="<?php echo $address;?>"  placeholder="Your last name...">
                <span class="validationError"><?php echo $errorMsgAddress; ?></span>
            </div>
            <div class="form-field">
                <label for="">City  <span class="mandatory-field">*</span> :</label>
                <input type="text" name="city" id="" value="<?php echo $city;?>"  placeholder="Your city...">
                <span class="validationError"><?php echo $errorMsgCity; ?></span>
            </div>
            <div class="form-field">
                <label for="">Province :</label>
                <input type="text" name="province" id="" value="<?php echo $province;?>"  placeholder="Your province...">
                <span class="validationError"><?php echo $errorMsgProvince; ?></span>
            </div>
            <div class="form-field">
                <label for="">Postal Code <span class="mandatory-field">*</span> : </label>
                <input type="text" name="postalCode" id="" value="<?php echo $postalCode;?>"  placeholder="Postal Code  ...">
                <span class="validationError"><?php echo $errorMsgPostalCode; ?></span>
            </div>
            <div class="form-field">
                <label for="">Upload Picture : </label>
                <input type="file" id="myFile" name="picture">
                <span class="validationError"><?php echo $errorMsgPicture; ?></span>
            </div>
            <div class="form-field">
                <label for="">Username  <span class="mandatory-field">*</span> :</label>
                <input type="text" name="username" id="" value="<?php echo $username;?>"  placeholder="Username...">
                <span class="validationError"><?php echo $errorMsgUsername; ?></span>
            </div>
            <div class="form-field">
                <label for="">Password  <span class="mandatory-field">*</span> :</label>
                <input type="password" name="password" id="" value="<?php echo $password;?>"  placeholder="Password...">
                <span class="validationError"><?php echo $errorMsgPassword; ?></span>
            </div>
        </div>
        <div class="form-buttons">
                <button class="submit-btn" type="submit" name="submitbtn" value="";>Register</button>
                <button class="reset-btn" type="reset" value=""; >Reset</button>
        </div>
    </form>
    
</div>



<?php
// calling footer function at the end of the page
footer();
?>