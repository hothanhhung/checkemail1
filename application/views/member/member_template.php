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
	<link  rel="icon" type="image/x-icon" href="<?php echo base_url()?>favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugin/multiselect/css/jquery.multiselect.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugin/multiselect/css/jquery.multiselect.filter.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugin/multiselect/assets/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugin/multiselect/assets/prettify.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugin/jqueryui/themes/ui-lightness/jquery-ui.css" />
	<link href="<?php echo base_url()?>css/tools.css" rel="Stylesheet" type="text/css" />
	
	<script src="<?php echo base_url()?>js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>plugin/jqueryui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>plugin/multiselect/js/jquery.multiselect.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>plugin/multiselect/js/jquery.multiselect.filter.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>plugin/multiselect/assets/prettify.js"></script>
	<script type="text/javascript">
		
	</script>
</head>
<body>
	<div id ="main">
		<div id="header" >
			<h1>
				<a href="<?php echo base_url()?>" style="text-decoration: none">
					<img style="margin:0 0 0 40px;" src="<?php echo base_url()?>/img/banner2.png" />
				</a>
			<a href="<?php echo base_url()?>index.php/member/index/logouttool" style="position:relative;top:-100px;left:600px; text-decoration: none"> 
				<img  width="37px" height="37px" src="<?php echo base_url()?>img/logout.png"></img>
			</a>
			
			</h1>
			
		</div>
		<div class="body">
			<div class="menu">
				<table width="100%"><tr>
				<td>
					<ul>
						<a href="<?php echo base_url()?>index.php/member/category/">
							<li <?php if(isset($index)&&$index==1) echo 'style="background: #E6E6E6;"';?> >
								Quản lý danh mục
							</li>
						</a>
						<li <?php if(isset($index)&&$index==2) echo 'style="background: #E6E6E6;"';?>>
							<a href="#"  class="dropboxli" >Quản lý liên lạc</a>
							<ul class="sub-menu">
								<a href="<?php echo base_url()?>index.php/member/contact/toindex">
									<li>
										Quản lý chung
									</li>
								</a>
								<a href="<?php echo base_url()?>index.php/member/contact/toindex1">
									<li>
										Sử dụng điều kiện lọc
									</li>
								</a>
							</ul>
						</li>
						<li <?php if(isset($index)&&$index==3) echo 'style="background: #E6E6E6;"';?>>
							<a href="#"  class="dropboxli">Quản lý các thư gửi</a>
							<ul class="sub-menu">
								<a href="<?php echo base_url()?>index.php/member/newsletter/create">
									<li>
										Tạo thư gửi
									</li>
								</a>
								<a href="<?php echo base_url()?>index.php/member/newsletter/listnewsletter">
									<li>
										Xem và cài đặt thử gửi
									</li>
								</a>
							</ul>
						</li>						
					</ul>
				</td>
				</tr></table>
			</div>
			<div id="body" style="border:1px solid;border-radius:5px;border-color:gray;background-color:#ffffff;">
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
		</div>

		<div id="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</div>
	</div>

</body>
</html>