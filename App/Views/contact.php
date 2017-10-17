<?php
$errors = [];
$success = "";
if(!empty($_POST)){
	if(!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["message"]) ){
		$name = $_POST["name"];
		$email = $_POST["email"];
		$subject = $_POST["subject"];
		$message = $_POST["message"];
		if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) $errors["email"] = "Invalid email.";
		else{
			$msg = new \App\Table\Message($name, $email, $subject, $message);
			$msg->sendMessage();
			$success = "Message sent.";
		}
	}else{
		$errors["required"] = "All information are required.";
	}
}
site_head("Contact us", array()); 
?>
<div class="right main_content" style="margin-top:90px">
	<div class="row">
		<?php if(strlen($success) > 0): ?>
			<div class="flash success" style="margin-bottom:20px"><?= $success ?></div>
		<?php endif; ?>
		<?php if(count($errors) > 0) : ?>
			<div class="flash danger" style="margin-bottom:20px">
			<ul>
				<?php foreach($errors as $k=>$v):?>
					<li><?= $k . " : " . $v ?></li>
				<?php endforeach;?>
			</ul>
			</div>
		<?php endif;?>
	</div>
	<div class="half" style="padding-right:15px;">
		<div class="row">
			<div class="title_1" style="display:inline-block">contact us</div>
		</div>
		<div class="row">
			<form action="#" method="post">
				<div class="input_2" style="margin-bottom:20px">
					<input type="text" name="name" placeholder="your name">
					<i class="icon ion-android-person"></i> 
				</div>
				<div class="input_2" style="margin-bottom:20px">
					<input type="text" name="email" placeholder="your email">
					<i class="icon ion-email"></i>
				</div>
				<div class="input_2" style="margin-bottom:20px">
					<input type="text" name="subject" placeholder="subject">
					<i class="icon ion-document-text"></i>
				</div>
				<textarea class="textarea_2" name="message" style="margin-bottom:20px" placeholder="your message..."></textarea>
				<button class="btn main_2" type="submit">
					<span><i class="icon ion-arrow-right-c"></i> send message</span>
				</button>
			</form>
		</div>
	</div>
	<div class="half" style="padding-left:15px;">
		<div class="row">
			<div class="title_1" style="display:inline-block">follow us</div>
		</div>
		<div class="row">
			<ul class="social_icons">
				<li><a href="https://www.facebook.com/streatchTv" target="_blank"><i class="icon ion-social-facebook"></i></a></li>
				<li><a href="https://twitter.com/streawin_" target="_blank"><i class="icon ion-social-twitter"></i></a></li>
				<li><a href="http://instagram.com/streawin" target="_blank"><i class="icon ion-social-instagram"></i></a></li>
			</ul>
		</div>
		<div class="row" style="margin-top:20px">
			Or send us e-mail : <a href="mailto:contact@streawin.com">contact@streawin.com</a>
		</div>
	</div>
</div>