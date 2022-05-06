<?php

require_once("collection.php");
require_once("customer.php");

class customers extends collection 
{
    function __contruct()
    {
        global $connection;
        
        $sql = "SELECT * FROOM customers ORDER BY firstname";
        
        $PDOobject = $connection->prepare($sql);
        $PDOobject->execute();
        while($row = $PDOobject->fetch(PDO::FETCH_ASSOC))
        {
            $customer = new customer($row["cus_id"], $row["firstname"], $row["lastname"], $row["address"], $row["province"], $row["postalcode"], $row["city"], $row["username"], $row["password"], $row["picture"], $row["created"], $row["modified"]);
            $this->add($row["cus_id"], $customer);            
                    
        }
    }
    
    function search($cus_id){
        global $connection;
        
        $sql="SELECT * FROM customers WHERE cus_id =?";
        $PDOobject = $connection->prepare($sql);
        $PDOobject->execute();
        
        $this->items=array();
        
        while($row=$PDOobject->fetch(PDO::FETCH_ASSOC)){
            $customers=new $customer($row["cus_id"], $row["firstname"], $row["lastname"], $row["address"], $row["province"], $row["postalcode"], $row["city"], $row["username"], $row["password"], $row["picture"], $row["created"], $row["modified"]);
            $this->add($row["cus_id"], $customer); 
        }
        
    }
}
