<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php 
		if(isset($title))
		{?>
			<title><?php echo $title; ?></title>
		<?php }else { ?>
			<title>Internet Marketing Tools</title>
		<?php } ?>
	<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" />
	
	<style type="text/css">
		.login-class{
			background: #333;
			padding: 10px; 	
			border: 2px solid #ddd;
			float: left;
			font-size: 1.2em;
			position: fixed;
			top: 20%; left: 40%;
			z-index: 99999;
			box-shadow: 0px 0px 20px #999;
			-moz-box-shadow: 0px 0px 20px #999; /* Firefox */
			-webkit-box-shadow: 0px 0px 20px #999; /* Safari, Chrome */
			border-radius:3px 3px 3px 3px;
			-moz-border-radius: 3px; /* Firefox */
			-webkit-border-radius: 3px; /* Safari, Chrome */
		}


		fieldset { 
			border:none; 
		}

		form.signin .textbox label { 
			display:block; 
			padding-bottom:7px; 
		}

		form.signin .textbox span{ 
			display:block;
		}

		form.signin p, form.signin span{ 
			color:#999; 
			font-size:15px; 
			width:200px;
			line-height:18px;
		} 

		form.signin .textbox input{ 
			background:#666666; 
			border-bottom:1px solid #333;
			border-left:1px solid #000;
			border-right:1px solid #333;
			border-top:1px solid #000;
			color:#fff; 
			border-radius: 3px 3px 3px 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			font:13px Arial, Helvetica, sans-serif;
			padding:6px 6px 4px;
			width:200px;
		}

		form.signin input:-moz-placeholder { color:#bbb; text-shadow:0 0 2px #000; }
		form.signin input::-webkit-input-placeholder { color:#bbb; text-shadow:0 0 2px #000;  }

		.button { 
			background: -moz-linear-gradient(center top, #f3f3f3, #dddddd);
			background: -webkit-gradient(linear, left top, left bottom, from(#f3f3f3), to(#dddddd));
			background:  -o-linear-gradient(top, #f3f3f3, #dddddd);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f3f3f3', EndColorStr='#dddddd');
			border-color:#000; 
			border-width:1px;
			border-radius:4px 4px 4px 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			color:#333;
			cursor:pointer;
			display:inline-block;
			padding:6px 6px 4px;
			margin-top:10px;
			font:12px; 
			width:214px;
		}
	</style>
</head>
<body style="background-color:gray;">
<div class="login-class">
	 <form method="post" class="signin" action="<?php echo base_url()?>index.php/manager/index/login">
		<fieldset class="textbox">
			<label style="padding:0px 0px 15px 0px;">
				<span>Tên đăng nhập</span>
				<input id="email-signin" name="email-signin" value="" type="text" autocomplete="on" placeholder="Tên đăng nhập">
			</label>
			<label style="padding:0px 0px 15px 0px;">
				<span>Mật khẩu</span>
				<input id="password-signin" name="password-signin" value="" type="password" placeholder="Mật khẩu" onkeydown="if (event.keyCode == 13) form.submit();">
			</label>
			<div style="color:red;font-size: 14px;">
				<?php if(isset($errorlogin)) echo $errorlogin; ?>
			</div>
			<button class="button" type="button"  onclick="form.submit();">Đăng nhập</button>		
			<span style="padding-top:12px;">
				<a href="#" style="color:#00c6ff">Quên mật khẩu?</a>
			</span>		
		</fieldset>
  </form>
</div>
</body>
</html>