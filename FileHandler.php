<?php
   /* FileHandler is used to handle the database config file 
    * which will be a shared preferences.
	*/
   class FileHandler {
	   public $file_name;
	   public $db_username;
	   public $db_password;
	   public $db_name;
	   
	   function __construct(){
		   $this->file_name = "configs.txt";
		   if(!file_exists($this->file_name))
			   echo "FILE NOT FOUND".$this->file_name;
	   }
	   
	   function write2File($text){
		   $file = fopen($this->file_name,'w') or die("FAILED TO CREATE FILE");
		   fwrite($file,$text) or die("FAILED TO WRITE TO FILE");
		   fclose($file);
	   }
	   
	   function readFromFile(){
		   $file = fopen($this->file_name,'r') or die("FAILED TO OPEN FILE FOR READ");
		   $this->db_username = fgets($file);
		   $this->db_password = fgets($file);
		   $this->db_name = fgets($file);
		   fclose($file);
	   }
	   
   }



?>