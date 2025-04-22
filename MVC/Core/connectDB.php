<?php
class connectDB {
    public $con;
    
    
    function __construct() 
    {
       $this->con=mysqli_connect('localhost','root','1234','qlhssv') ;
       mysqli_query($this->con,"SET NAMES 'utf8'");
    }
}
?>
