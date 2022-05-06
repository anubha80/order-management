<?php
 
// REVISION HISTORY

// DEVELOPER                      DATE                        COMMENTS
// Anubha Dubey(2032178)          2022-04-20                Create collection.php
// Anubha Dubey(2032178)          2022-04-20                Add remove,add, get and count functions

//



class collection
{
    public $items = array();
    
    public function add($primary_key, $item)
    {
        $this->items[$primary_key] = $item;
    }
    
    public function remove($primary_key)
    {
        if(isset($this->items[$primary_key]))
        {
            unset($this->items[$primary_key]);
        }
  
    }
    
    
    public function get($primary_key)
    {
        if(isset($this->items[$primary_key]))
        {
            return($this->items[$primary_key]);
        }
  
    }
    
        
    public function count()
    {
        return count($this->items);
    }
}
