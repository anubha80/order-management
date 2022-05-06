
<?php


/// NOTE : Tried displaying the image on a seperate page and it works, whereas it does not work in the nav bar the welcome User_FirstName

//// REVISION HISTORY

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-22              Test image showing on website

//constants
define("FOLDER_PHP_COMMON_FUNC", "PHP-CommonFunctions/");
define("FILE_PHP_COMMON_FUNC", FOLDER_PHP_COMMON_FUNC . "commonFunctions.php");

// Including commonFunctions.php file
include_once(FILE_PHP_COMMON_FUNC);

noCache();

// calling main html body function with page name 'Register'
bodyHTML("Register");

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "database_2032178"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}


 $sql = "select picture from customers limit 2";
 $result = mysqli_query($con,$sql);
 $row = mysqli_fetch_array($result);

 $image_src = $row['picture'];
 
?>
<img class="welcome-image" src='<?php echo $image_src; ?>' >
