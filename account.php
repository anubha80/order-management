<? php 

// REVISION HISTORY

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-10                Create account.php file, add header and footer
// Anubha Dubey(2032178)          2022-04-16                Fix Register and Logout Button style
// Anubha Dubey(2032178)          2022-04-20                Add account form fields
// Anubha Dubey(2032178)          2022-04-23                Account Update performing correctly 
//

?>


<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
//// checking if logged in 
// Do Not Remove
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: index.php");
    exit;
}
?>




<?php




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

// calling main html body function with page name 'Account'
bodyHTML("Account");

// declare variables for user registration
$firstName = "";
$lastName = "";
$address = "";
$city = "";
$postalCode = "";
$username = "";
$password = "";
$province = "";

// declare variables to store error message if any
$errorMsgFirstName = "";
$errorMsgLastName = "";
$errorMsgAddress = "";
$errorMsgCity = "";
$errorMsgPostalCode ="";
$errorMsgUsername = "";
$errorMsgPassword = "";
$errorMsgProvince = "";
$errorMsgPicture = null;

// setting the initial value to false
$errorOccured = false;
// FInal message display to user weather login successful or failed
$finalMessage ="";




// check if GET request is made 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $cusObj = new customer();
    $cusObj->load($_SESSION['username']);
    $firstName=$cusObj->getFirstname();
    $lastName=$cusObj->getLastname();
    $address=$cusObj->getAddress();
    $city=$cusObj->getCity();
    $province=$cusObj->getProvince();
    $postalCode=$cusObj->getPostalcode();
    $username=$cusObj->getUsername();
    $picture=$cusObj->getPicture();
    $finalMessage ="Account Details of ".$firstName." ".$lastName;
}




// read fields and put value in case of POST request
if (isset($_POST["updatebtn"])) {
    
    
    // creating new customer class
    $cusObj = new customer();
    
    $firstName = htmlspecialchars($_POST["firstName"]);
    $lastName = htmlspecialchars($_POST["lastName"]);
    $address = htmlspecialchars($_POST["address"]);
    $province = htmlspecialchars($_POST["province"]);
    $city = htmlspecialchars($_POST["city"]);
    $postalCode = htmlspecialchars($_POST["postalCode"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $picture=null;
    
    
    $errorMsgFirstName= $cusObj->setFirstname($firstName);
    $errorMsgLastName= $cusObj->setLastname($lastName);
    $errorMsgAddress= $cusObj->setAddress($address);
    $errorMsgCity= $cusObj->setCity($city);
    $errorMsgPostalCode= $cusObj->setPostalcode($postalCode);
    $errorMsgProvince= $cusObj->setProvince($province);
    $errorMsgUsername= $cusObj->setUsername($username);
    $errorMsgPassword= $cusObj->setPassword($password );
    $errorMsgPicture= $cusObj->setPicture($picture);
    
    // check if picture is uploaded
    if ($_FILES['picture']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['picture']['tmp_name'])) {
        $picture = file_get_contents($_FILES['picture']['tmp_name']);
    } else {
        $errorMsgPicture = "WARNING: Picture not uploaded";  
        //echo $errorMsgPicture;
    }
   
   
    if ($firstName !="" && $picture!="" && $lastName!="" && $address!="" && $city!="" && $postalCode!="" && $username!="" && $password!="") {
        $finalMessage="SUCCESS";
    } // end of 'if' condition of errorOccured
    
    

    
    // check if all fields are valid
    if ($finalMessage=="SUCCESS"){
        // calling update function
//        $updateSuccess=$cusObj->update($firstName, $lastName, $address, $city, $province, $postalCode, $picture, $_SESSION['username'], $password);
        $updateSuccess=$cusObj->update($_SESSION['username']);
//        var_dump($updateSuccess);
        if($updateSuccess==true){
            $finalMessage="Record updated successfully";
        }
        else{
            $finalMessage="Error occurred";
        }
    }
    else{
            $finalMessage="OOPS... Fields with * are mandatory";
    }    
}

?>


<div class="form-container">
    <h2 class="form-heading">🍓🍇 Account Setting 🍓🍇</h2>
    <div class="final-msg">
        <?php echo '<p>'.$finalMessage.'</p>'?>
    </div>
    <form class="myform" action="" method="POST" enctype="multipart/form-data">
        <div class="field-container account">
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
                <label for="">Upload Picture <span class="mandatory-field">*</span>: </label>
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
                <button class="submit-btn" type="submit" name="updatebtn" value="";>Update Info</button>
        </div>
    </form>
    
</div>



<?php
//calling footer in the end
    footer();
?>

