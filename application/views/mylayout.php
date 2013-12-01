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
	<link href="<?php echo base_url()?>css/main.css" rel="Stylesheet" type="text/css" />
	<script src="<?php echo base_url()?>js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript">
		
	</script>
</head>
<body>

<div id="main">
	<div id="header">
		<h1>
			<a href="">
				<img style="position:relative;top:-20px;left:20px" src="<?php echo base_url()?>/img/banner1.png" />
			</a>
		</h1>
		
		<div id="login">
			<?php 
			if(isset($userlogin) && $userlogin != ""){ ?>
				<a href="#" onclick="signout();" style="color:white;">
					Sign out
				</a> / 
				<a href="#" onclick="getdatatoshowprofile();" style="color:white;">
					Profile
				</a>
			<?php } else { ?>
				<a href="#"  class="login-window" style="color:white;" onclick="return aloginwindowclick();">
					Sign in
				</a> / 
				<a href="#"  class="signup-window" style="color:white;" onclick="return asignupwindowclick();">
					Sign up
				</a>
			<?php } ?>
		</div>
	</div>
	<?php
		if(isset($userlogin) && $userlogin != ""){ ?>
			<script type="text/javascript">
				function signout()
				{
					$.ajax({
					url: "<?php echo base_url()?>index.php/member/index/logout",
					})
					.done(function( msg ) {
						if(msg=="1"){
							window.open(window.location.pathname,"_self");
						}
						else {
							alert('A problem from server.<br/>Please try again');
						}
					}) 
					.fail(function() {
						alert('The internet had a problem');
					});
				}
				
				function getdatatoshowprofile()
				{
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/index/getprofile",
					data: { email: '<?php echo $userlogin; ?>' },
					dataType: "json"
					})
					.done(function( msg ) {
						if(msg=="0" || msg=="1"){
							alert('Lỗi khi lấy thông tin người dùng');
						}
						else {
							showprofile(msg.email, msg.mobilephone, msg.name );
						}
					}) 
					.fail(function() {
						alert('The internet had a problem');
					});
				}
				
				function showprofile(email, mobilephone, name)
				{
					$('#email-profile').val(email);
					$('#mobilephone-profile').val(mobilephone);
					$('#username-profile').val(name);
					var profileBox = "#profile-box";//$(this).attr('href');

					//Fade in the Popup and add close button
					$(profileBox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(profileBox).height() + 24) / 2; 
					var popMargLeft = ($(profileBox).width() + 24) / 2; 
					
					$(profileBox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					
					// Add the mask to body
					$('body').append('<div id="mask"></div>');
					$('#mask').fadeIn(300);
					
					$('#mask').click(function() { 
							$('#mask , .profile-popup').fadeOut(300 , function() {
							$('#mask').remove();  
							}); 
							return false;
						});
					return false;
				}
				
				function aprofilecloseclick()
				{ 
					$('#mask , .profile-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						}); 
					return false;
				}
				
				function checkChangePass(el)
				{
					if(el.checked) $("#changepassarea-profile").css("display", "block");
					else  $("#changepassarea-profile").css("display", "none");
					
					var profileBox = "#profile-box";
					var popMargTop = ($(profileBox).height() + 24) / 2; 
					var popMargLeft = ($(profileBox).width() + 24) / 2; 
					
					$(profileBox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
				}
				
				function saveProfile()
				{
					isChangePass=$('#ischangepass-profile').is(':checked');
					username=$('#username-profile').val();
					mobile=$("#mobilephone-profile").val();
					oldpass=$("#password-profile").val();
					newpass=$("#newpassword-profile").val();
					cfpass=$("#newpassword-again-profile").val();
					
					 alert(''+username+''+mobile+''+oldpass+''+newpass+''+cfpass+''+isChangePass);
					if(username=="")
					{
						$('#status-profile').html('<b>Tên không hợp lệ</b>');
						return;
					}
					
					if(isChangePass==true)
					{
						if(newpass=="")
						{
							$('#status-profile').html('<b>Mật khẩu không hợp lệ</b>');
							return;
						}
						if(newpass!=cfpass)
						{
							$('#status-profile').html('<b>Mật khẩu xác nhận không đúng</b>');
							return;
						}
					}
					$('#status-profile').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/index/saveprofile",
					data: { fullname: username,  mobilephone:mobile, pass:oldpass, newpass:newpass, changepass:isChangePass }
					})
					.done(function( msg ) {
						if(msg=="1"){
							$('#status-profile').html('<b>Mật khẩu không đúng</b>');
						}
						else if(msg=="2"){
							$('#status-profile').html('<b>Lưu dữ liệu thành công</b>');
						}
						else {
							$('#status-profile').html('<b>Không thể cập nhật</b>'+msg);
						}
					}) 
					.fail(function() {
						$('#status-profile').html('<b>Không thể kết nối tới server</b>');
					});
				}
				
			</script>
			<div id="profile-box" class="profile-popup">
				<a href="#" class="profile-close" onclick="return aprofilecloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="signup" action="#">
					<fieldset class="textbox">
						<label>
							<span>Họ và tên</span>
							<input id="username-profile" name="username-profile" value="" type="text">
						</label>
						<label>
							<span>Email</span>
							<input id="email-profile" name="email-profile" value="" type="text" readonly>
						</label>
						<label>
							<span>Số điện thoại</span>
							<input id="mobilephone-profile" name="mobilephone-profile" value="" type="text">
						</label>
						<label>
							<span>
								Đổi mật khẩu
							<input style="width:10px" type="checkbox"  name="ischangepass-profile" autocomplete="off" id="ischangepass-profile" onchange="checkChangePass(this);"/>
							</span>
						</label>
						<div id="changepassarea-profile" style="display:none">
							<label>
								<span>Mật khẩu cũ</span>
								<input id="password-profile" name="password-profile" value="" type="password" placeholder="Password">
							</label>
							<label>
								<span>Mật khẩu mới</span>
								<input id="newpassword-profile" name="password-profile" value="" type="password" placeholder="Password">
							</label>
							<label>
								<span>Xác nhận mật khẩu mới</span>
								<input id="newpassword-again-profile" name="password-again-profile" value="" type="password" placeholder="Password">
							</label>
						</div>
						<div id="status-profile" name="status-profile"  style="color:red;font-size: 0.6em;"></div>
						<button class="submit button" type="button" onclick="saveProfile(); return false;">lưu</button>
					
					
					</fieldset>
			  </form>
			</div>
	<?php } else { ?>
			<script type="text/javascript">
				function aloginwindowclick() 
				{
					// Getting the variable's value from a link 
					var loginBox = "#login-box";//$(this).attr('href');

					//Fade in the Popup and add close button
					$(loginBox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(loginBox).height() + 24) / 2; 
					var popMargLeft = ($(loginBox).width() + 24) / 2; 
					
					$(loginBox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					
					// Add the mask to body
					$('body').append('<div id="mask"></div>');
					$('#mask').fadeIn(300);
					
					$('#mask').click(function() { 
							$('#mask , .login-popup').fadeOut(300 , function() {
							$('#mask').remove();  
							}); 
							return false;
						});
					return false;
				}
				
			// When clicking on the button close or the mask layer the popup closed
				function alogincloseclick()
				{ 
					$('#mask , .login-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						}); 
					return false;
				}
				
				function asignupwindowclick() 
				{
					
					// Getting the variable's value from a link 
					var loginBox = "#signup-box";//$(this).attr('href');

					//Fade in the Popup and add close button
					$(loginBox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(loginBox).height() + 24) / 2; 
					var popMargLeft = ($(loginBox).width() + 24) / 2; 
					
					$(loginBox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					
					// Add the mask to body
					$('body').append('<div id="mask-signup"></div>');
					$('#mask-signup').fadeIn(300);
					
					$('#mask-signup').click(function() { 
							$('#mask-signup , .signup-popup').fadeOut(300 , function() {
							$('#mask-signup').remove();  
							}); 
							return false;
						});
					return false;
				}
					
				function asignupcloseclick() 
				{ 
					$('#mask-signup , .signup-popup').fadeOut(300 , function() {
						$('#mask-signup').remove();  
						}); 
					return false;
				}
				
				function signin()
				{
					$('#status-signin').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/index/signinajax",
					data: { email: $('#email-signin').val(), pass:$('#password-signin').val() }
					})
					.done(function( msg ) {
						if(msg=="2"){
							window.open(window.location.pathname,"_self");
						}
						else {
							$('#status-signin').html('<b>Email or password is not correct</b>');
						}
					}) 
					.fail(function() {
						$('#status-signin').html('<b>The internet had a problem</b>');
					});
				}
				function isEmail(em)
				{
					var x=em;
					var atpos=x.indexOf("@");
					var dotpos=x.lastIndexOf(".");
					if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
					{
					  return false;
					}
					return true;
				}
				
				function signup()
				{
					if($('#username-signup').val()=="")
					{
						$('#status-signup').html('<b>Full name is empty</b>');
						return;
					}
					if(!isEmail($('#email-signup').val()))
					{
						
						$('#status-signup').html('<b>Not a valid e-mail address</b>');
						return;
					}
					if($('#password-signup').val()=="")
					{
						$('#status-signup').html('<b>Password is not correct</b>');
						return;
					}
					if($('#password-signup').val()!=$('#password-again-signup').val())
					{
						$('#status-signup').html('<b>Confirm password is not correct</b>');
						return;
					}
					$('#status-signup').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/index/signup",
					data: { fullname: $('#username-signup').val(), email: $('#email-signup').val(), pass:$('#password-signup').val(), mobilephone:$('#mobilephone-signup').val() }
					})
					.done(function( msg ) {
						if(msg=="1"){
							$('#status-signup').html('<b>This email was used</b>');
						}else if(msg=="2"){
							alert("Registry successfully!");
							window.open(window.location.pathname,"_self");
						}
						else {
							$('#status-signup').html('<b>A problem from server.<br/>Please try again</b>');
						}
					}) 
					.fail(function() {
						$('#status-signup').html('<b>The internet had a problem</b>');
					});
				}
			</script>
			
			 <div id="login-box" class="login-popup">
				<a href="#" class="close" onclick="return alogincloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="signin" action="#">
					<fieldset class="textbox">
					<label class="username">
					<span>Email</span>
					<input id="email-signin" name="email-signin" value="" type="text" autocomplete="on" placeholder="Email Address">
					</label>
					
					<label class="password">
					<span>Password</span>
					<input id="password-signin" name="password-signin" value="" type="password" placeholder="Password" onkeydown="if (event.keyCode == 13) signin();">
					</label>
					<div id="status-signin" name="status-signin" style="color:red;font-size: 0.6em;"></div>
					<button class="submit button" type="button"  onclick="signin();return false;">Sign in</button>
					
					<p style="width:100%">
					<a class="forgot" href="#" style="color:#00c6ff">Forgot your password?</a>
					<a href="#" onclick="$('a.close').click();$('a.signup-window').click();" style="color:#00c6ff; margin-left:35px">Sign up</a>
					</p>
					
					</fieldset>
			  </form>
			</div>
			
			<div id="signup-box" class="signup-popup">
				<a href="#" class="signup-close" onclick="return asignupcloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="signup" action="#">
					<fieldset class="textbox">
					<label class="username">
					<span>Full Name</span>
					<input id="username-signup" name="username-signup" value="" type="text" autocomplete="on" placeholder="Full Name">
					</label>
					<label class="username">
					<span>Email</span>
					<input id="email-signup" name="email-signup" value="" type="text" autocomplete="on" placeholder="Email Address">
					</label>
					<label class="username">
					<span>Mobile Phone</span>
					<input id="mobilephone-signup" name="mobilephone-signup" value="" type="text" autocomplete="on" placeholder="Mobile Phone">
					</label>
					
					<label class="password-signup">
					<span>Password</span>
					<input id="password-signup" name="password-signup" value="" type="password" placeholder="Password">
					</label>
					<label class="password-signup">
					<span>Confirm Password</span>
					<input id="password-again-signup" name="password-again-signup" value="" type="password" placeholder="Password">
					</label>
					<div id="status-signup" name="status-signup"  style="color:red;font-size: 0.6em;"></div>
					<button class="submit button" type="button" onclick="signup();return false;">Sign up</button>
					
					
					</fieldset>
			  </form>
			</div>
			
	<?php } ?>
	
	
	<div id="body">
		<div id="left_body">
			<ul class="navigation">
				<li id="first">
					<?php if(!isset($index) || $index==1) echo '<strong>' ?> 
					<a href="<?php echo base_url()?>" id="home">Trang chủ</a>
					<?php if(!isset($index) || $index==1) echo '</strong>' ?> 
				</li>
				<li><?php if(isset($index) && $index==2) echo '<strong>' ?>
					<a href="<?php echo base_url()?>index.php/verifyemail" id="ip-address">Kiểm tra Email</a>
					<?php if(isset($index) && $index==2) echo '</strong>' ?>
				</li>
				<li>
					<?php if(isset($index) && $index==3) echo '<strong>' ?>
					<a href="<?php echo base_url()?>index.php/member/index/" id="owndata" target="_blank">Email marketing</a>
					<?php if(isset($index) && $index==3) echo '</strong>' ?>
				</li>
				<li>
					<?php if(isset($index) && $index==4) echo '<strong>' ?>
					<a href="" id="domain-name-system">DNS Query</a>
					<?php if(isset($index) && $index==4) echo '</strong>' ?>
				</li>
				<li>				
					<?php if(isset($index) && $index==5) echo '<strong>' ?>
					<a href="<?php echo base_url()?>index.php/general/faq" id="portscan">Câu hỏi thường gặp</a>
					<?php if(isset($index) && $index==5) echo '</strong>' ?>
				</li>
				<li id="last">
					<?php if(isset($index) && $index==6) echo '<strong>' ?>
					<a href="<?php echo base_url()?>index.php/general/policy" id="dropped-domains">Điều khoản sử dụng</a>
					<?php if(isset($index) && $index==6) echo '</strong>' ?>
				</li>
			</ul>
		</div>

		<div id="content_body">
			<?php 
				if(isset($template))  
				{
					if(isset($data)) $this->load->view($template,$data);
					else $this->load->view($template);
				}
				else
				{?>			
					<div id="box">
						<div id="title">
							<h1>Check emails </h1>
						</div>
						<p>chao moi nguoi</p>
						<div style="height:100px">more</div>
					</div>
			<?php } ?>
		</div>
		<div id="right_body">right</div>

	</div>

	<div id="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</div>
</div>

</body>
</html>