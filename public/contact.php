<?php
require_once 'securimage/securimage.php';
?>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/webfonts/font.css">
<link rel="stylesheet" href="css/style1.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/fontello.css" />
<script src="js/modernizr.custom.js"></script>
</head>
<body class="contact">
	<header class="clearfix">
		<a href="index.html" class="logo">Hans Dairy</a> <a href="#" id="menu"
			class="menu">Menu</a>
	</header>
	<div class="wrapper">
		<div class="content">
			<h1>Contact</h1>
			<p class="wcont">We would love to hear from you. Please call or email
				us with your questions, comments, or suggestions. We want to hear
				what you have to say.</p>
			<div class="contact-form">
				<form id="contact-form" action="send_contact.php" method="post"
					class="clearfix">
					<div class="left">
						<input type="text" id="name" name="name" placeholder="Name" /> <input
							type="email" id="email" name="email" placeholder="Email" />
					</div>
					<div class="contactMessage">
						<textarea class="textarea" id="message" name="message"
							placeholder="Message"></textarea>
					</div>
					<div class="left">
           <?php echo Securimage::getCaptchaHtml()?>
           </div>
					<div class="contactSubmit">
						<input type="button" onclick="sendContacts();" name="submit"
							class="submit" value="SEND">
					</div>
				</form>
			</div>
			<ul class="contact-info">
				<li class="loc">3400 American Drive<br />Mississauga, ON<br />L4V
					1C1
				</li>
				<li class="tel">Office: (905) 671-3200<br />Fax: (905) 671-3205
				</li>
				<li class="mail"><a href="mailto:info@hansdairy.com">info@hansdairy.com</a><br />
				<a href="mailto:sales@hansdairy.com">sales@hansdairy.com</a></li>
			</ul>
			<a class="c-facebook"
				href="https://www.facebook.com/pages/Hans-Dairy/278246853601?sk=timeline">Connect
				with Us On: <i class="icon-facebook" style="color: #d5363b;"></i>
		
		</div>
		<div class="overlay overlay-hugeinc">
			<a href="index.html" class="logo-w"><img src="img/logo-w.png"
				alt="Hans Dairy" /></a>
			<button type="button" class="overlay-close">Close</button>
			<nav>
				<ul class="nav">
					<li><strong>MENU</strong></li>
					<li><a href="index.html">Home</a></li>
					<li><a href="index.html#slide4">Products</a></li>
					<li><a href="about.html#think">Think</a></li>
					<li><a href="about.html">About</a></li>
					<li><a href="contact.php">Contact</a></li>
				</ul>
				<ul class="social-media">
					<li class="facebook"><a
						href="https://www.facebook.com/pages/Hans-Dairy/278246853601?sk=timeline">Connect
							with Us On: <span>Facebook</span>
					</a> </a></li>
				</ul>
			</nav>
			<!--  <ul class="social-media">
          <li class="facebook"><a href="https://www.facebook.com/pages/Hans-Dairy/278246853601?sk=timeline">Facebook</a></li>
        </ul> -->
		</div>
	</div>
	<div class="contactus_image"></div>
	<footer class="bottom">
		Copyright ©
		<script language="JavaScript" type="text/javascript">document.write((new Date()).getFullYear());</script>
		Hans Dairy. All rights reserved.<br> Designed &amp; Developed by <a
			href="http://www.ankitdesigns.com">Ankit Designs</a>.
	</footer>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/classie.js"></script>
	<script src="js/menu.js"></script>
	<script src="js/main.js"></script>
	<script src="js/contact.js"></script>

</body>
</html>
