<?php

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-16            Create singular class product
// Anubha Dubey(2032178)          2022-04-18            Create private members, getters and setters of customer class 
// Anubha Dubey(2032178)          2022-04-23            Add connection.php, add created and modified getter setter 

require_once('connection.php'); #connection = new PDo


class product {
    private $prod_id="";
    private $prod_code="";
    private $prod_desc="";
    private $retail_price="";
    private $cost_price="";
    private $created="";
    private $modified="";
    
    // getters
    public function getProductId() {
        return $this->prod_id;
    }
    
    public function getProductCode() {
        return $this->prod_code;
    }
    
    public function getProductDesc() {
        return $this->prod_desc;
    }
    
    public function getRetailPrice() {
        return $this->retail_price;
    }
    
    public function getCostPrice() {
        return $this->cost_price;
    }
    
    public function getCreated() {
        return $this->created;
    }
    
    public function getModified() {
        return $this->modified;
    }
    
    // setters
    
    // set prod_id
    public function setProductId($newProductId) {
        if (mb_strlen($newOrderId) == 0) {
            $errorMsgProductId="The Product Id is empty";
            return $errorMsgProductId;
        } 
        else {
            $this->odr_id = $newProductId;
            $errorMsgProductId="";
        }
        return $errorMsgProductId;
    }
    
    // set prod_code 
    public function setProdCode($newProdCode) {
        if (mb_strlen($newProdCode) == 0) {
            return "The product code is empty";
        } else {
            $this->prod_code = $newProdCode;
        }
    }
    // set prod_description
    public function setProdDesc($newProdDesc) {
        if (mb_strlen($newProdDesc) == 0) {
            return "The product description is empty";
        } else {
            $this->prod_desc = $newProdDesc;
        }
    }
    
    
    // set retail price 
    public function setRetailPrice($newRetailPrice) {
        if (mb_strlen($newRetailPrice) == 0) {
            return "The retail price is empty";
        } else {
            $this->retail_price = $newRetailPrice;
        }
    }
    
    // set cost price
    public function setCostPrice($newCostPrice) {
        if (mb_strlen($newCostPrice) == 0) {
            return "The cost price is empty";
        } else {
            $this->cost_price = $newCostPrice;
        }
    }
    
    
    // parametrized constructor of class customer 

    public function _construct($prod_id, $prod_code, $prod_desc, 
            $retail_price,$cost_price,$created, $modifieds) {
        if ($firstname!= "") {
            $this->setFirstname($prod_id);
        }
        if ($lastname!= "") {
            $this->setLastname($prod_code);
        }
        if ($address!= "") {
            $this->setAddress($prod_desc);
        }
        if ($province!= "") {
            $this->setProvince($retail_price);
        }
        if ($postalcode!= "") {
            $this->setPostalcode($cost_price);
        }
        if ($city!= "") {
            $this->setCity($created);
        }
        if ($username!= "") {
            $this->setUsername($modifieds);
        }
    }  // end of constructor
    
    
    public function loadProductDropdown(){
        try{
            $arrProdCode=[];
            $arrProdDesc=[];
            $arrProdRetailPrice=[];
            $arrFinalProductName=[];
            
            // using MySQLi Procedural technique 
            $conn = mysqli_connect('localhost', 'root', '','database_2032178');
            if(!$conn){
                echo 'Connection error : '.mysqli_connect_error();
                return false;
            }
            $sql= "SELECT * FROM products";  
            $result = mysqli_query($conn, $sql);
            $allProducts = mysqli_fetch_all($result,MYSQLI_ASSOC);
            for ($x = 0; $x < sizeof($allProducts); $x++) {
                // get all the values in product fields
                $this->prod_id=$allProducts[$x]['prod_id'];
                $this->prod_code=$allProducts[$x]['prod_code'];
                $this->prod_desc=$allProducts[$x]['prod_desc'];
                $this->retail_price=$allProducts[$x]['retail_price'];
                $this->cost_price=$allProducts[$x]['cost_price'];
                
                // load all values in Product name array 
                array_push($arrProdCode,$allProducts[$x]['prod_code']);
                array_push($arrProdDesc,$allProducts[$x]['prod_desc']);
                array_push($arrProdRetailPrice,$allProducts[$x]['retail_price']);
                array_push($arrFinalProductName,$arrProdCode[$x]." - ".$arrProdDesc[$x]." (".$arrProdRetailPrice[$x]."$)");
                //print_r($allProducts[$x]['prod_code']);
            }
//            print_r($arrFinalProductName);
            return $arrFinalProductName;
        } 
        catch (mysqli_sql_exception $ex) {
            echo $ex->getMessage();
//            return false;
        }
    } // end of load function
    
    
    
    public function loadProdDetails($prod_code){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "database_2032178";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT prod_id, prod_code,prod_desc, retail_price, cost_price FROM products WHERE prod_code='$prod_code'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1){
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $this->prod_id=$row['prod_id'];
                $this->prod_code=$row['prod_code'];
                $this->prod_desc=$row['prod_desc'];
                $this->retail_price=$row['retail_price'];
                $this->cost_price=$row['cost_price'];
//                echo $this->prod_desc;
            }
            return true;
        }
        else{
            return false;
        }
    }
    
    
    
} // end of class product


?>