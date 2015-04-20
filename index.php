<?php 

$title = "MySQL - Interactive shell V2";

function welcome(){
    echo "<p class = \"lead\">Hello dear user,</p>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title;?>  </title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <br><br><br>
	
	<div class="row">
	    <div class="col-xs-8 col-md-offset-1">
			<div class="container" style = "background-color: #dedef8; box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
				<div class="row">
					<div class="col-xs-6 col-md-offset-3" >
						<div class="row">
							<div class="col-xs-9 col-md-offset-2">
					
							<?php
							echo "<h2>".$title ."<br>*********************************"."<br></h2>";
							welcome(); 
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-offset-3"> 
						<form class = "form-horizontal" action="submit_test.php" method="POST">
							<div class="form-group">
								<label class="col-sm-3 control-label">UserName : </label> 
								<div class="col-sm-9">
									<input type="text" class="form-control" name="user_name">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Password : </label> 
								<div class="col-sm-9">
									<input type="password" class="form-control" name="password">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Database Name : </label> 
								<div class="col-sm-9">
									<input type="text" class="form-control" name="db_name">
								</div>
							</div>					
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success">Connect</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div><!-- end container -->	
		</div><!-- end column -->
	</div><!-- end row -->
	<!-- footer row -->
	<div class="row">
	    <div class="col-xs-8 col-md-offset-1">
		    Copyright 2015, Licensed under MIT, M. Bassel Shmali [bass3l@live.com].
		</div>
	</div>
</body>
</html>