<?php
// checking if logged in 
//session_start();
//if(!isset($_SESSION['loggedin'])){
//    //header("location:index.php");
//}
?>


<?php

// REVISION HISTORY

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-02-26            Created top page, nav menu & footer
// Anubha Dubey(2032178)          2022-02-04            Created folder for cheatSheet
// Anubha Dubey(2032178)          2022-04-20            Adding login function
// Anubha Dubey(2032178)          2022-04-20            Adding welcome function
// Anubha Dubey(2032178)          2022-04-20            Created login session 
// Anubha Dubey(2032178)          2022-04-21            Issue with login logout on page change
// Anubha Dubey(2032178)          2022-04-21            login/logout issue fixed (exception: home page)
// Anubha Dubey(2032178)          2022-04-22            fix session creation and destruction issue in previous implementation


require_once('connection.php');
include('customer.php');

// Constants 
define("FOLDER_CSS", "CSS/");
define("FOLDER_IMAGES", "Images/");
define("FILE_INDEX", "index.php");
define("FILE_BUY", "buy.php");
define("FILE_ORDERS_PHP", "orders.php");
define("FILE_ACCOUNT_PHP", "account.php");
define("FILE_STYLES", FOLDER_CSS . "styles.css");
define("LOGO", FOLDER_IMAGES . "yogo-logo.png");
define("FOLDER_ORDERS", "Orders/");
define("FILE_ORDERS_TXT", FOLDER_ORDERS."orders.txt");
define("FILE_CHEAT_SHEET", FOLDER_ORDERS."cheatSheet.txt");

// Function to prevent page caching
function noCache(){
    header('Expires: Sat, 01 Jan 1990 16:00:00 GMT');
    header('Cache-Control: no-store, no-cache'); 
    header('Pragma: no-cache'); 
    header('Content-type: text/html; charset=UTF-8');
}

// product image array
define("PRODUCT_IMAGES",  array("cherry-yogo.png", "greek-yogo.png", "orange-yogo.png", "plain-yogo.png", "strawberry-yogo.png"));

// image of the product to be displayed 2x times bigger
$bestSellerProduct="strawberry-yogo.png";

// login success bollean variable 
$loginSuccess=false;


// logout and destroy session
if (isset($_POST["logout"])) {
    $loginSuccess=false;
    session_start();
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

// validate username and password and login user
if(isset($_POST["login"])){
    include('connection.php');
    $username=$_POST["username"];
    $password=$_POST["password"];
    
    $connection = new mysqli('localhost', 'root', '', 'database_2032178');
    if ($connection->connect_error) {
        exit('Connection to mySQL failed:' . $connection->connect_error);
    }
    else{
        $sql="SELECT * from customers where username='$username'";
        $result=mysqli_query($connection, $sql);
        $num= mysqli_num_rows($result);
        if($num==1){
            while($row= mysqli_fetch_assoc($result)){
                if(password_verify($password, $row['password'])){
                    $loginSuccess=true;
                // starting session
//                session_start();
                    
                $_SESSION['loggedin']=true;
                $_SESSION['username']=$row['username'];
                $_SESSION['cus_id']=$row['cus_id'];
                }
                else{
                    echo '<p class="error">Invalid Password. Try Again!</p>';
                    $loginSuccess=false;
                }
            }  
        }
        else{
            echo '<p class="error">Invalid Username. Try Again!</p>';
            $loginSuccess=false;
        }
    }
}


// LOGIN VALIDATION END 


// function for navigation menu containing home, buy and orders page along with company's logo
function navigationMenu()
{ ?>
        <div class="container-main-nav">
            <img src="<?php echo LOGO ?>" class="logo" alt="company-logo">
            
            <div class="navigation">
                <a class="nav-menu" href="<?php echo FILE_INDEX ?>">HOME</a> 
                <a class="nav-menu" href="<?php echo FILE_BUY ?>">BUY</a>
                <a class="nav-menu" href="<?php echo FILE_ORDERS_PHP ?>">ORDERS</a>
                <a class="nav-menu" href="<?php echo FILE_ACCOUNT_PHP ?>">ACCOUNT</a>
            </div>
        </div>
    <?php
}
?>


<?php
// function for login 
function login()
{?>
    <div class="login-container">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <label for="username">Username : </label>
            <input type="text" placeholder="your username" name="username" required> <br>
            <label for="password">Password :&nbsp;</label>
            <input type="password" placeholder="your password" name="password" required><br><br>
            <input class="login-btn" type="submit" name="login" value="Login">
            <p>Need a user account ?<a href="register.php"> Register </a></p>
        </form>
        
        
    </div>
<?php
}?>


<?php
// function to welcome in case login is successful
function logout()
{
?>
        
        <form  action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <div class="login-container">
                    <p>
                     <?php 
                     $customer = new customer();
                     $customer->load($_SESSION['username']);
                     $loggedInUserFirstName=$customer->getFirstname();
                     $loggedInUserLastName=$customer->getLastname();
                     $loggedInUserPicture=$customer->getPicture();
                     if($customer->load($_SESSION['username'])){
//                            echo '<img src="data:image/gif;base64,' . $loggedInUserPicture . '" />';
//                            echo '<img src="data:image/;base64,' . $loggedInUserPicture . '">';
                         
                         
                         
                         /////
                         
                         define('DB_SERVER', 'localhost');
                            define('DB_USERNAME', 'root');
                            define('DB_PASSWORD', '');
                            define('DB_NAME', 'database_2032178');
                         $connection = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
                            // Set the PDO error mode to exception
                            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                         $sql = "SELECT * FROM customers WHERE firstname = :firstname";
                         if ($stmt = $connection->prepare($sql)) {
                            // Bind variables to the prepared statement as parameters
                            $stmt->bindParam(":firstname", $loggedInUserFirstName);

                            // Set parameters
                            // $param_id = $_SESSION["id"];

                            // Attempt to execute the prepared statement
                            if ($stmt->execute()) {
                                if ($stmt->rowCount() == 1) {
                                    /* Fetch result row as an associative array. Since the result set
                                      contains only one row, we don't need to use while loop */
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                    // Retrieve individual field value
                                    echo "<img src='data:image; base64," .
                                    base64_encode($row["picture"]) . "'>";

                                }
                                else {
                                    // URL doesn't contain valid id. Redirect to error page
                                    header("location: error.php");
                                    exit();
                                }
                            }
                        }
                         //////
                         
                         
                            echo "<p class='welcome'>WELCOME ".$loggedInUserFirstName."  ".$loggedInUserLastName."</p>";  
                     }
                     else{
                       echo "Welcome....";  
                     }
                     
                     ?>
                        
                    </p> 
                    <button class="logout-btn" type="submit" name="logout" value="";>Logout</button>
                </div>
        </form>
        
<?php
}
?>    

<?php
// Generating HTML common code
// Page Name will go as the title of the page
function checkBestSeller(){
    echo "testing...";
}
?>

<?php
function bodyHTML($pageName)
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $pageName; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo FILE_STYLES; ?>">
    </head>
    <body>
    <?php
    navigationMenu();
//    var_dump($_SESSION);
    if(!isset($_SESSION['loggedin'])){
        login();
    }
    else{
        logout();
    }
}
?>
 
   
        
        
<?php
// function for the footer showing name and copyright
function footer()
{
    ?>
        <p class="copyright">Copyright® Anubha Dubey (#2032178) <?php echo date(' Y '); ?> </p>
    <?php
}
    ?>
    </body>
    </html>
