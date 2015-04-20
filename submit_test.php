<?php
   /** TODO use sessions instead of text files **/
	
	require_once("FileHandler.php");
	
	$title = "MySQL - Interactive shell V2";
	$query = $_POST['query']; // the query we might have posted to this php page...
	$tables[] = NULL;         
	
	function fetch_tables($db,$db_name){
		
			$query_result = mysqli_query($db,"SHOW TABLES from ".$db_name);
						
			while ($row = $query_result->fetch_assoc()) {
						global $tables;
						$tables[] = $row['Tables_in_'.$db_name];
					    //var_dump($row);
						//print_r($row);
			}
			$query_result->close();
	}
	
	if(!$query){ // we are in a query-input request
		$fileHandler = new FileHandler();
	
		$db_user = $_POST['user_name'];
		$db_password = $_POST['password'];
		$db_name = $_POST['db_name'];
		$db = new mysqli("localhost",$db_user,$db_password,$db_name);//connecting to database
		$connect_flag = false;
		if($db->connect_errno){
			$result_str = "Failed to connect to database...<br>" . $db->connect_error;
			$connection_flag = false;
		}
		else{		//connected successfully so we store access data for later use...
			$result_str = "connected.";
			$data = $db_user . "\r\n" . $db_password . "\r\n" . $db_name ;
			$fileHandler->write2File($data);
			fetch_tables($db,$db_name);
			
						
			$db->close();
			$connection_flag = true;
		}
	}
	else{ // we are in a query-result request
	
		    $result_str = "connected.";
			$connection_flag = true; // we are sure we are connected successfully
			//getting database access : 
			$fileHandler = new FileHandler();
			$fileHandler->readFromFile();
			$db_username = $fileHandler->db_username;
			$db_password = $fileHandler->db_password;
			$db_name = $fileHandler->db_name ;
	        
		    $db = new mysqli("localhost",trim($db_username),trim($db_password),trim($db_name));//connecting to database
			//mysqli_select_db($db,$db_name) or die(mysqli_error($db));
			if($query_result = mysqli_query($db,$query) or die(mysqli_error($db))){
						//the query result was ok.
						fetch_tables($db,$db_name);//fetch tables to display them is first step
						//now let's check if it's an "insert" query and handle the result:
						if(strripos($query,"insert")!==false){
							$result_query = "<div class=\"row\"> 
							    <div class = \"col-xs-9 col-md-offset-2\">
								     <h4>" . " the new record has been added successfully." .
									 "</h4></div></div>";
						}else if (strripos($query,"delete")!==false){//or it's a delete query:
							$result_query = "<div class=\"row\"> 
							    <div class = \"col-xs-9 col-md-offset-2\">
								     <h4>" . " the specified record has been deleted successfully." .
									 "</h4></div></div>";
						}else{//or it's a show query:
							$result_query = "<div class=\"row\">
									<div class = \"col-xs-9 col-md-offset-2\">
										<table class=\"table\">    
										<thead>       
										<tr>";
							while($field_info = $query_result->fetch_field()){
								$result_query .= "<th>".$field_info->name."</th>";
							}			
						
							$result_query .= "</tr></thead><tbody><tr>";
									
	
							while($row = $query_result->fetch_assoc()){
									//$result_query = $result_query . "<tr><td>{$row['USER_ID']}</td><td>{$row['USER_FIRST_NAME']}</td><td>{$row['USER_LAST_NAME']}</td></tr>";
									$result_query .= "<tr>";
									foreach($row as $data){
										$result_query = $result_query ."<td>$data</td>"; 
									}
									$result_query .= "</tr>";
							}		

						
							$result_query = $result_query . "</tbody></table></div></div>";
							$query_result->close();
						
						}//end else	
			}//end if
			else {
						$result_query = "QUERY FAILED.";
			}
			$db->close();
	}//end-if
?>
<html>
<link rel='stylesheet' type='text/css' href='styles.css' />
<head>
    <title><?php echo $title;?>  </title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <br><br><br>
	<div class="row">
	    <div class="col-xs-8 col-md-offset-1">
			<div class="container" style = "background-color: #dedef8; box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
				<!-- title row -->
				<div class="row">
					<div class="col-xs-6 col-md-offset-3" >
						<div class="row">
							<div class="col-xs-9 col-md-offset-2">
					
							<?php
							echo "<h2>".$title ."<br>*********************************"."<br></h2>";
							echo "<p class=\"lead\">" . $result_str . "</p>";
							?>
							</div>
						</div>
					</div>
				</div>
	
				<!-- form raw -->
				<div class="row">
					<div class="col-xs-8 col-md-offset-1">
						<?php 
								if($connection_flag){//we have no connection errors
									//inner first row "tables" 
									echo " 
										<div class=\"row\">
											<div class=\"col-sx-6 col-md-offset-5\">
														<h4>The database contains the following tables:</h4>
														<ul>";
												
									//removing first element
									array_shift($tables);					
									foreach($tables as $table){
															echo "<li>".$table."</li>";
									}					
									echo "              </ul>
											</div>
										</div>";					
												
									//inner second row "query form"					
									echo					"
										<div class=\"row\">
											<div class=\"col-sx-6 col-md-offset-5\">
												<form name = \"queryForm\" action = \"submit_test.php\" onSubmit = \"return validateForm('queryForm','query')\" method = \"POST\" >
													<div class=\"form-group\">
														<label id =\"query_label\">Enter Query:</label>
														<input type = \"text\" class=\"form-control\" rows=\"3\" name=\"query\"></input>
													</div>
													<div class=\"form-group\">
														<button type=\"submit\" class=\"btn btn-success\">Send Query</button>
													</div>
												</form> 
											</div>		
										</div>
										";
							
				
								}
						?>
					</div>
				</div>
				<!-- query result table -->
				<div class="row">
					<div class="col-xs-6 col-md-offset-3">
						<?php 
							echo $result_query;
							?>
					</div>
				</div>
			</div><!-- end container -->
		</div><!-- end column -->
	</div><!-- end first row -->
	<!-- footer row -->
	<div class="row">
	    <div class="col-xs-8 col-md-offset-1">
		    Copyright 2015, Licensed under MIT, M. Bassel Shmali [bass3l@live.com].
		</div>
	</div>
	
	<script src="javascript/forms.js"></script>
</body>
</html>