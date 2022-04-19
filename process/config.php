<?php
class Config{
	public function __construct(){

	}
	function getConnection(){
       return new mysqli("localhost", "root", "", "evoting");
    }
}
?>