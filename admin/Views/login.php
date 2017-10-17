<?php
if($_SESSION["auth"] != null && $_SESSION["auth"]->level == "admin"){
	header("Location: " . getLink("home",[],true));
}
if(isset($_POST) && isset($_POST["username"]) && isset($_POST["password"])){
	$req = App\App::getDB()->query("SELECT * FROM users WHERE username = ? and password = ?",
		[$_POST["username"], sha1($_POST["password"])]);
	$data = $req->fetch();
	if($data){
		$_SESSION["auth"] = $data;
		header("Location: " . getLink("home",[],true));
	}else{
		echo '<div class="alert alert-danger">Login failed. Please try again.</div>';
	}
}
?>
<div class="col-md-offset-4 col-md-4">
	<div class="form-group">
		<h3><span class="label label-default">Login to administration</span></h3>
	</div>
	<form method="post" action="">
		<div class="form-group">
			<label>Username</label>
		  	<input type="text" class="form-control" placeholder="Username" name="username">
		</div>
		<div class="form-group">
			<label>Password</label>
		  	<input type="password" class="form-control" placeholder="**********" name="password">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Login</button>
		</div>
	</form>
</div>