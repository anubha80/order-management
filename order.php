<?php

//// REVISION HISTORY

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-23              Create order class
// Anubha Dubey(2032178)          2022-04-23              Create order getter setter and constructor


class order{
    // declare private attributes for class order
    private $odr_id="";
    private $prod_id="";
    private $cus_id="";
    private $qty_sold="";
    private $sold_price="";
    private $comments="";
    private $created="";
    private $modified="";
    private $subtotal="";
    private $taxes_amount="";
    private $total="";
    
    
    // getter methods for all private fields
    
    public function getOrderId() {
        return $this->odr_id;
    }
    
    public function getproductId() {
        return $this->prod_id;
    }
    
    public function getCustomerId() {
        return $this->cus_id;
    }
    
    public function getQuantitySold() {
        return $this->qty_sold;
    }
    
    public function getSoldPrice() {
        return $this->sold_price;
    }
    
    public function getComments() {
        return $this->comments;
    }
    
    public function getCreated() {
        return $this->created;
    }
    
    public function getModified() {
        return $this->modified;
    }
    
    public function getSubtotal() {
        return $this->subtotal;
    }
    
    public function getTaxAmount() {
        return $this->taxes_amount;
    }
    
    public function getTotal() {
        return $this->total;
    }
    
    /// setters for all private fields
    
    
    
    public function setOrderId($newOdrId) {
        $this->odr_id = $newOdrId;
    }
    
    
    public function setProductId($newProductId) {
        if (mb_strlen($newProductId) == 0) {
            return "The is empty";
        } else {
            $this->prod_id = $newProductId;
        }
    }
    
    
    public function setCustomerId($newCustomerId) {
        if (mb_strlen($newEmployee_id) == 0) {
            return "The is empty";
        } else {
            $this->cus_id = $newCustomerId;
        }
    }
    
    
    public function setQuantitySold($newQuantitySold) {
        if (mb_strlen($newQuantitySold) == 0) {
            return "The is empty";
        } else {
            $this->qty_sold = $newQuantitySold;
        }
    }
    
    
    public function setSoldPrice($newSoldPrice) {
        if (mb_strlen($newSoldPrice) == 0) {
            return "The cus id is empty";
        } else {
            $this->sold_price = $newSoldPrice;
        }
    }
    
    
    public function setComments($newComments) {
        if (mb_strlen($newComments) == 0) {
            return "The cus id is empty";
        } else {
            $this->comments = $newComments;
        }
    }
    
    
    public function setSubTotal($newSubTotal) {
        if (mb_strlen($newSubTotal) == 0) {
            return "The cus id is empty";
        } else {
            $this->subtotal = $newSubTotal;
        }
    }
    
    
    public function setTaxesAmount($newTaxesAmount) {
        if (mb_strlen($newTaxesAmount) == 0) {
            return "The cus id is empty";
        } else {
            $this->taxes_amount = $newTaxesAmount;
        }
    }
    
    
    public function setTotal($newTotal) {
        if (mb_strlen($newTotal) == 0) {
            return "The cus id is empty";
        } else {
            $this->total = $newTotal;
        }
    }
   
    
    /// Constructor for Order CLass
    public function _construct($odr_id, $prod_id, $cus_id, $qty_sold, $sold_price, $coments, $subtotal, $taxes_amount, $total){
        if($odr_id!=0){
            $this->odr_id;
        }
        if($prod_id!=0){
            $this->prod_id;
        }
        if($cus_id!=0){
            $this->cus_id;
        }
        if($qty_sold!=0){
            $this->qty_sold;
        }
        if($sold_price!=0){
            $this->sold_price;
        }
        if($comments!=0){
            $this->comments;
        }
        if($subtotal!=0){
            $this->subtotal;
        }
        if($taxes_amount!=0){
            $this->taxes_amount;
        }
        if($total!=0){
            $this->total;
        }
    }
    
    
    // Save function to save row into the orders table
    
    public function save($prod_id, $cus_id, $qty_sold, $sold_price, $comments,$subtotal , $taxes_amount, $total){
        try{
                global $connection;
                $sql="INSERT INTO orders (odr_id, prod_id, cus_id, qty_sold, sold_price, comments, "
                        . "created, modified,subtotal,taxes_amount, total)"
                        . "VALUES (UUID(),'$prod_id','$cus_id',"
                        . "'$qty_sold','$sold_price', '$comments',current_timestamp(),"
                        . "current_timestamp(),'$subtotal' , '$taxes_amount','$total')";
                $connection->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
//                if (str_contains($e->getMessage(), 'Duplicate')) { 
//                    //echo '<p class="err-duplicate-user">ERROR :The username already exists. Please choose another username</p>';
//                }
                return false;
            }
    } // end of save function 
    
    public function load(){
        
    }
    
}

?>
