<?php

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-16            Create singular class customer
// Anubha Dubey(2032178)          2022-04-16            Create private members, getters and setters of customer class 
// Anubha Dubey(2032178)          2022-04-16            Update customer constructor  
// Anubha Dubey(2032178)          2022-04-20            Modify setters to perform validation
// Anubha Dubey(2032178)          2022-04-20            Add password hash function to insert hashed password in database
// Anubha Dubey(2032178)          2022-04-21            Handle duplicate username entry
// Anubha Dubey(2032178)          2022-04-23            Fix password hash function
// Anubha Dubey(2032178)          2022-04-23            Remove repetitive code for PDO connection

require_once('connection.php'); #connection = new PDo


 // constants for form fields
define("CUSTOMER_FIRSTNAME_MAX_LENGTH", 20 );
define("CUSTOMER_LASTNAME_MAX_LENGTH", 20 );
define("CUSTOMER_ADDRESS_MAX_LENGTH", 25 );
define("CUSTOMER_CITY_MAX_LENGTH", 25 );
define("CUSTOMER_PROVINCE_MAX_LENGTH", 25 );
define("CUSTOMER_POSTAL_CODE_MAX_LENGTH", 7 );
define("CUSTOMER_USERNAME_MAX_LENGTH", 15 );
define("CUSTOMER_PASSWORD_MAX_LENGTH", 255 );
define("CUSTOMER_PICTURE_MAX_SIZE", 16 );


$errorMsgFirstName = "";
$errorMsgLastName = "";
$errorMsgAddress = "";
$errorMsgCity = "";
$errorMsgPostalCode ="";
$errorMsgUsername = "";
$errorMsgPassword = "";
$errorMsgProvince = "";
$errorMsgPicture = "";

class customer {
    // private variables of table customers
    private $cus_id="";
    private $firstname="";
    private $lastname="";
    private $address="";
    private $province="";
    private $postalcode="";
    private $city="";
    private $username="";
    private $password="";
    private $picture;
    private $created="";
    private $modified="";

    
    // getters for all private members
    
    public function getCustomerId() {
        return $this->cus_id;
    }
    
    public function getFirstname() {
        return $this->firstname;
    }
    
    public function getLastname(){
        return $this->lastname;
    }
    
    public function getAddress() {
        return $this->address;
    }
    
    public function getProvince() {
        return $this->province;
    }
    
    public function getPostalcode() {
        return $this->postalcode;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getPicture() {
        return $this->picture;
    }
    
    // setters for all private fields 
     
    // set cus_id
    
    public function setCustomerId($newCustomerId) {
        if (mb_strlen($newEmployee_id) == 0) {
            return "The cus id is empty";
        } else {
            $this->cus_id = $newCustomerId;
        }
    }
    
    // set firstname
    public function setFirstname($newFirstname) {
        if (mb_strlen($newFirstname) == 0) {
            $errorOccured = true;
            $errorMsgFirstName = "WARNING : First name is empty";
        }
        else if (mb_strlen($newFirstname) > CUSTOMER_FIRSTNAME_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgFirstName = "WARNING : First name characters more than " . CUSTOMER_FIRSTNAME_MAX_LENGTH;
        }
        else {
            $this->firstname = $newFirstname;
            $errorMsgFirstName="";
        }
        return $errorMsgFirstName;
    }
    
    // set lastname
    public function setLastname($newLastname) {
        if (mb_strlen($newLastname) == 0) {
        $errorOccured = true;
        $errorMsgLastName = "WARNING : Last name is empty";
        }
        else if (mb_strlen($newLastname) > CUSTOMER_LASTNAME_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgLastName = "WARNING : Last name characters more than " . CUSTOMER_LASTNAME_MAX_LENGTH;
        } 
        else {
            $this->lastname = $newLastname;
            $errorMsgLastName="";
        }
        return $errorMsgLastName;
    }
    
    // set address
    public function setAddress($newAddress) {
        if (mb_strlen($newAddress) == 0) {
        $errorOccured = true;
        $errorMsgAddress = "WARNING : Address name is empty";
        }
        else if (mb_strlen($newAddress) > CUSTOMER_ADDRESS_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgAddress = "WARNING : Address characters more than " . CUSTOMER_ADDRESS_MAX_LENGTH;
        }
        else {
            $this->address = $newAddress;
            $errorMsgAddress="";
        }
        return $errorMsgAddress;
    }
    
    // set province
    public function setProvince($newProvince) {
        if (mb_strlen($newProvince) == 0) {
        $errorOccured = true;
        $errorMsgProvince = "WARNING : Province is empty";
        }
        else if (mb_strlen($newProvince) > CUSTOMER_PROVINCE_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgProvince = "WARNING : Province characters more than " . CUSTOMER_PROVINCE_MAX_LENGTH;
        }
        else {
            $this->province = $newProvince;
            $errorMsgProvince="";
        }
        return $errorMsgProvince;
    }
    
    // set postal code
    public function setPostalcode($newPostalcode) {
        if (mb_strlen($newPostalcode) == 0) {
        $errorOccured = true;
        $errorMsgPostalCode = "WARNING : Postal Code is empty";
        }
        else if (mb_strlen($newPostalcode) > CUSTOMER_POSTAL_CODE_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgPostalCode = "WARNING : Postal Code characters more than " . CUSTOMER_POSTAL_CODE_MAX_LENGTH;
        }
        else {
            $this->postalcode = $newPostalcode;
            $errorMsgPostalCode="";
        }
        return $errorMsgPostalCode;
    }
    
    // set city
    public function setCity($newCity) {
        if (mb_strlen($newCity) == 0) {
        $errorOccured = true;
        $errorMsgCity = "WARNING : City name is empty";
        }
        else if (mb_strlen($newCity) > CUSTOMER_CITY_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgCity = "WARNING : City name characters more than " . CUSTOMER_CITY_MAX_LENGTH;
        }
        else {
            $this->city = $newCity;
            $errorMsgCity="";
        }
        return $errorMsgCity;
    }
    
    // set username
    public function setUsername($newUsername) {
        if (mb_strlen($newUsername) == 0) {
        $errorOccured = true;
        $errorMsgUsername = "WARNING : Username is empty";
        }
        else if (mb_strlen($newUsername) > CUSTOMER_USERNAME_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgUsername = "WARNING : Username characters more than " . CUSTOMER_USERNAME_MAX_LENGTH;
        } 
        else {
            $this->username = $newUsername;
            $errorMsgUsername="";
        }
        return $errorMsgUsername;
    }
    
    // set password
    public function setPassword($newPassword) {
        if (mb_strlen($newPassword) == 0) {
        $errorOccured = true;
        $errorMsgPassword = "WARNING : Password is empty";
        }
        else if (mb_strlen($newPassword) > CUSTOMER_PASSWORD_MAX_LENGTH) {
            $errorOccured = true;
            $errorMsgPassword = "WARNING : Password characters more than " . CUSTOMER_PASSWORD_MAX_LENGTH;
        }
        else {
            //$this->password = $newPassword;
            $this->password=password_hash($newPassword, PASSWORD_DEFAULT);
            $errorMsgPassword="";
        }
        return $errorMsgPassword;
    }
    
    // set picture
    public function setPicture($newPicture) {

//        alternate 
        if (mb_strlen($newPicture) == 0) {
            $errorOccured = true;
            $errorMsgPicture = "WARNING: Picture not uploaded";
        } else {
            $picture = file_get_contents($_FILES['picture']['tmp_name']);
            $this->picture = $newPicture;
            $errorMsgPicture="";
        }
        return $errorMsgPicture;
    }
    
    // parametrized constructor of class customer 

    public function _construct($firstname, $lastname, $address, 
            $province,$postalcode,$city, $username, $password, $picture) {
        if ($firstname!= "") {
            $this->setFirstname($firstname);
        }
        if ($lastname!= "") {
            $this->setLastname($lastname);
        }
        if ($address!= "") {
            $this->setAddress($address);
        }
        if ($province!= "") {
            $this->setProvince($province);
        }
        if ($postalcode!= "") {
            $this->setPostalcode($postalcode);
        }
        if ($city!= "") {
            $this->setCity($city);
        }
        if ($username!= "") {
            $this->setUsername($username);
        }
        if ($password!= "") {
            $this->setPassword($password);
        }
        if ($picture!= "") {
            $this->setPicture($picture);
        }
    }  // end of constructor 
    
    
    
    
    // SAVE user details into database
    public function save() {

        if ($this->username != "" && $this->password != "" ) {
            try{
                // encoding to base64 before saving the image in db
                global $connection;
                $target_file = basename($this->picture);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $img= 'data:image/'.$imageFileType.';base64,'.base64_encode($this->picture);
                $sql="INSERT INTO customers (cus_id,firstname,lastname, address,province, postalcode, "
                        . "city, username,password,picture, created, modified ) "
                        . "VALUES (UUID(),'$this->firstname','$this->lastname',"
                        . "'$this->address','$this->province', '$this->postalcode','$this->city',"
                        . "'$this->username','$this->password' , '$img' , current_timestamp(), current_timestamp())";
                $connection->exec($sql);
                return true;
            } catch (PDOException $e) {
//                echo $sql . "<br>" . $e->getMessage();
                if (str_contains($e->getMessage(), 'Duplicate')) { 
                    //echo '<p class="err-duplicate-user">ERROR :The username already exists. Please choose another username</p>';
                }
                return false;
            }
        }
        else
        {
            return false;
        }
    } // end of function save    
    
    
    
    
    /// Function to LOAD data into the customer class fields
    public function load($username) {
        try{
            // using MySQLi Procedural technique 
            $conn = mysqli_connect('localhost', 'root', '','database_2032178');
            if(!$conn){
                echo 'Connection error : '.mysqli_connect_error();
                return false;
            }
            $sql= "SELECT * FROM customers";  
            $result = mysqli_query($conn, $sql);
            $usernames = mysqli_fetch_all($result,MYSQLI_ASSOC);
            for ($x = 0; $x < sizeof($usernames); $x++) {
                if($username==$usernames[$x]['username']){
                    $this->cus_id=$usernames[$x]['cus_id'];
                    $this->firstname=$usernames[$x]['firstname'];
                    $this->lastname=$usernames[$x]['lastname'];
                    $this->address=$usernames[$x]['address'];
                    $this->province=$usernames[$x]['province'];
                    $this->postalcode=$usernames[$x]['postalcode'];
                    $this->city=$usernames[$x]['city'];
                    $this->username=$usernames[$x]['username'];
                    $this->password=$usernames[$x]['password'];
                    $this->picture=$usernames[$x]['picture'];
                    $this->created=$usernames[$x]['created'];
                    $this->modified=$usernames[$x]['modified'];
                }
            }
            return true;
        } catch (mysqli_sql_exception $ex) {
            echo $ex->getMessage();
            return false;
        }   
    }
    
    /// UPDATE customer data in customers table
    public function update($username){
        try {
            global $connection;
            $sql = "UPDATE customers SET firstname='$this->firstname', lastname='$this->lastname',address='$this->address', province='$this->province', postalcode='$this->postalcode', city='$this->city', username='$this->username', password='$this->password'  WHERE username='$username'";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            return true;
        } 
        catch (Exception $e) {
            echo $sql . "<br>" . $e->getMessage();
            $connection = null;
            return false;
        }
        
    } 
   
    
}  // end of class customer 



?>