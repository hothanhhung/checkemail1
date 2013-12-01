
<div id="box">
	<div id="title">
		<h1>Check email</h1>
		
	</div>
	<p>
		<form id="fcheckemail" action='<?php echo base_url()?>index.php/verifyemail/checkemail' method="post" >
			<span>You can verify a email address via typing email into below textbox and click Check Email button.</span><br/>
			<label>Email</label>
			<input id="txtEmail" name="txtEmail" type="text" value="" style="width:300px" />
			<input id="btCheckEmail" value="Check Email" type="submit" />
			<br/><br/>
			
			<?php
				if(isset($email)&&trim($email)!='')
				{?>
					<div style="width:100%; height:30px; margin-left:30px">
						<div  style="width:80px;float:left;">Result for </div>
						<div style="width:200px;float:left"><b><?php echo $email?></b></div>
						<div id='lblResult0' style="float:left">
							<img border="0" alt="" src='<?php echo base_url()?>/img/loading_circle.gif'></img>
						</div>
						<script>
							 $("#lblResult0").load("<?php echo base_url()?>index.php/verifyemail/ajaxcheckemail",{txtEmail:"<?php echo $email?>",ss:"<?php echo $ss;?>"})
						</script>
						
					</div>
					<div style="width:550px; margin-left:30px">
						<?php if(!isset($userlogin) || $userlogin == "") {?>
							<div>We try to find some data which can belong to this email for members. 
							If you are a member, please log in to use this function.
							</div>
						<?php }else{ ?>
						
							<div>Try to find some data which can belong to this email</div>
							
								<div id='lblMoreDetail0'>
									<img border="0" alt="" src='<?php echo base_url()?>/img/loading_circle.gif'></img>
								</div>
								<script>
									 $("#lblMoreDetail0").load('<?php echo base_url()?>index.php/verifyemail/moredetail/?email=<?php echo $email; ?>')
								</script>
						<?php } ?>
					</div>
				<?php
				}?>
		</form>
		<br/>
		<span>You can verify many email addresses through uploading a file which contains email addresses and click Check Emails button.
		Note that email addresses must be split by characters such as ; , space, tab or enter. </span><br/><br/>
		<form id="fcheckmultiemail" enctype="multipart/form-data"
			action='<?php echo base_url()?>index.php/verifyemail/checkmultiemail' method="post" >
			<input id="flEmail" name="flEmail" type="file" />
			<input id="btCheckEmail" value="Check Emails" type="submit" <?php if(!isset($userlogin) || $userlogin == "") echo 'onclick="$(\'a.login-window\').click(); return false;"' ?> />
			<br/><br/>

			<?php
				if(isset($resultCheckEmails))
				{
					?>
					<style type="text/css">
						.popup .items { display: none }

						.popup:hover > .items {
						display: block;
						font-size: 80%;
						border: gray solid thin;
						background-color: white;
						position: absolute;
						z-index: 1;
						}

						.popup .items a {
						text-decoration: none;
						color: black;
						font-weight: bold;
						}

						.popup .items a:hover { color: blue } 
					</style>

					<span class="popup" style="font-weight: bold;">
						Download Files
						<span class="items">
							<a href="<?php echo base_url()?>index.php/verifyemail/allexcelfile/?ss=<?php echo $ss ?>" target="_blank">All Emails into excel file</a><br />
							<a href="<?php echo base_url()?>index.php/verifyemail/excelfile/?ss=<?php echo $ss ?>" target="_blank">Emails is exist into excel file</a><br />
							<a href="<?php echo base_url()?>index.php/verifyemail/textfile/?ss=<?php echo $ss ?>" target="_blank">Emails is exist into text file</a>
						</span>
					</span>
					<br/>
					<br/>
					<div style="width:100%; height:30px; margin-left:30px">
						<div  style="width:70px;float:left;text-align:center;">Number</div>
											<div style="width:250px;float:left;text-align:center;">Email Address</div>
											<div id='lblResult10' style="float:left;text-align:center;">Status</div>
											
					</div>
					
					<?php
					$n=0;
					foreach ($resultCheckEmails as $email)
					{
						if(strpos($email, '@')!=false)
						{
							$n++;
							?>
								<div style="width:100%; height:30px; margin-left:30px">
									<div  style="width:70px;float:left;text-align:center;"><?php echo $n?></div>
									<div style="width:250px;float:left;"><?php echo $email?></div>
									<div id='lblResult<?php echo $n;?>' style="float:left;text-align:center;">
										<img border="0" alt="" src='<?php echo base_url()?>/img/loading_circle.gif'></img>
									</div>
									<script>
										 $("#lblResult<?php echo $n;?>").load("<?php echo base_url()?>index.php/verifyemail/ajaxcheckemail",{txtEmail:"<?php echo $email?>",ss:"<?php echo $ss;?>"})
									</script>
								</div>
							<?php
						}
					}
				}
			?>
		</form>
	</p>
	<div style="height:100px"></div>
</div>
