<div style="padding: 0px 10px 10px 10px">
	<p>
		<div id="title">
			<h1>Danh sách thành viên</h1>		
		</div>
		<span class="explaindetail"> Có tất cả <?php if(isset($numbermembers)) echo $numbermembers; else echo "0"?> người dùng</span>
		<br/><br/>
		<?php if(isset($listmembers)){
			if(!isset($numberperpage)) $numberperpage=5;
			if(!isset($sort_by)) $sort_by="";
			if(!isset($sort_order)) $sort_order="";
		?>
			<script type="text/javascript">				
				function setorderparameter(by)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/manager/member/setorderparameter",
						data: { sort_by: by }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
				}				
				
				function getdatatoeditcontact(emailmember)
				{
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/manager/member/getinformember",
					data: { email: emailmember },
					dataType: "json"
					})
					.done(function( msg ) {
						if(msg=="0" || msg=="1"){
							alert('Không tìm thấy liên lạc này');
						}
						else {
							editmemberwindowclick(msg.Name,msg.EmailAddress, msg.MobilePhone, msg.Manager, msg.Level, msg.Status);
						}
					}) 
					.fail(function() {
						alert('Có lỗi khi kết nối tới server');
					});
				}
				
				function editmemberwindowclick(name,email,phone,manager,level,status) 
				{
					$('#txtNameMember').val(name);
					$('#txtEmailMember').val(email);
					$('#txtPhoneMember').val(phone);
					$("select#sbLevel option")
						.each(function() { this.selected = (this.value == level); });
					$("select#sbStatus option")
						.each(function() { this.selected = (this.value == status); });
					$("select#sbManager option")
						.each(function() { this.selected = (this.value == manager); });
					// Getting the variable's value from a link 
					var editmemberbox = "#editmember-box";//$(this).attr('href');

					//Fade in the Popup and add close button
					$(editmemberbox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(editmemberbox).height() + 24) / 2; 
					var popMargLeft = ($(editmemberbox).width() + 24) / 2; 
					
					$(editmemberbox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					
					// Add the mask to body
					$('body').append('<div id="mask"></div>');
					$('#mask').fadeIn(300);
					
					$('#mask').click(function() { 
							$('#mask , .window-popup').fadeOut(300 , function() {
							$('#mask').remove();  
							}); 
							return false;
						});
					return false;
				}
				
				function aeditmembercloseclick()
				{ 
					$('#mask, .window-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						}); 
					return false;
				}
				
				function saveinformember()
				{
				
					$('#status-editmember').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/manager/member/editmember",
					data: { name: $('#txtNameMember').val(), email:$('#txtEmailMember').val(), phone:$('#txtPhoneMember').val(), manager:$('#sbManager :selected').val(), level:$('#sbLevel :selected').val(), status:$('#sbStatus :selected').val() }
					})
					.done(function( msg ) {
						if(msg=="2"){
							window.open(window.location.pathname,"_self");
						}
						else {
							$('#status-editmember').html('<b>Có lỗi khi lưu dữ liệu</b>');
						}
					}) 
					.fail(function() {
						$('#status-editmember').html('<b>Lỗi kết nối server</b>');
					});
				}
			</script>	
			<div id="editmember-box" class="window-popup" align="center">
				<a href="javascript:void(0)" class="close" onclick="return aeditmembercloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="editnote" action="#">
					<span style="color:#999; font-size:16px;"><b>Thông tin thành viên</b></span><br/>
					<span style="color:#999; font-size:11px;">Họ và tên</span><br/>
					<input id="txtNameMember" name="txtNameMember" type="text" value="" style="width:200px" /><br/>
					<span style="color:#999; font-size:11px;">Địa chỉ email</span><br/>
					<input id="txtEmailMember" name="txtEmailMember" type="text" value="" style="width:200px" readonly/><br/>
					<span style="color:#999; font-size:11px;">Số điện thoại</span><br/>
					<input id="txtPhoneMember" name="txtPhoneMember" type="text" value="" style="width:200px" /><br/>
				<?php if(isset($managerlevel) && $managerlevel==1){ ?>
					<span style="color:#999; font-size:11px;">Quản lý</span><br/>
					<select  name="sbManager" id="sbManager" style="width:200px">
						<option value="0">---Chưa được gán---</option>
						<?php if(isset($listmanagers)){
							foreach ( $listmanagers as $manager){
							?>
							<option value="<?php echo $manager["UserName"] ?>"><?php echo $manager["FullName"] ?></option>
						<?php }} ?>
					</select><br/>
				<?php } ?>	
					<span style="color:#999; font-size:11px;">Cấp bậc</span><br/>
					<select  name="sbLevel" id="sbLevel" style="width:200px">
							<option value="1">cấp 1</option>
							<option value="2">cấp 2</option>
							<option value="3">cấp 3</option>
							<option value="4">cấp 4</option>
							<option value="5">cấp 5</option>
					</select><br/>
					<span style="color:#999; font-size:11px;">Trạng thái</span><br/>
					<select  name="sbStatus" id="sbStatus" style="width:200px">
							<option value="1">Kích hoạt</option>
							<option value="2">Khóa</option>
					</select><br/>
					<div id="status-editmember" name="status-editmember" style="color:red;font-size: 0.6em;"></div>
					<button class="submit button" type="button"  onclick="saveinformember();return false;">Lưu</button>					
					
			  </form>
			</div>
			<div>
				<form method="post" action="<?php echo base_url()?>index.php/manager/member">
					<span></span>					
					&#32;&#32;&#32;&#32;&#32;&#32;&#32;&#32;Số lượng hiển thị
					<select  name="numberperpage" onchange="form.submit();">
						<option value="5" <?php if($numberperpage==5) echo "selected"?> >5</option>
						<option value="10" <?php if($numberperpage==10) echo "selected"?> >10</option>
						<option value="15" <?php if($numberperpage==15) echo "selected"?> >15</option>
						<option value="20" <?php if($numberperpage==20) echo "selected"?> >20</option>
						<option value="30" <?php if($numberperpage==30) echo "selected"?> >30</option>
						<option value="50" <?php if($numberperpage==50) echo "selected"?> >50</option>
					</select>					
				</form>
			</div>
			<font size="2">
			<table class="listview" width="100%">
			<tr>
					<th width="10px"><input type="checkbox" onchange="checkboxcontactschange(this);"/></th>
					<th width="10px">STT</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('1')">Họ tên</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('2')">Email</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('3')">Số điện thoại</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('4')">Quản lý</th>
					<th width="100px" class="sort_sign" onclick="setorderparameter('5')">Ngày đăng ký</th>					
					<th width="100px" class="sort_sign" onclick="setorderparameter('6')">Ngày cập nhật</th>					
					<th width="100px" class="sort_sign" onclick="setorderparameter('7')">Ngày đăng nhập</th>
					<th width="80px" class="sort_sign" onclick="setorderparameter('8')">Cấp bậc</th>
					<th width="80px" class="sort_sign" onclick="setorderparameter('9')">Trạng Thái</th>
					<th width="100px"></th>								
			</tr>
		<?php
			$n=0;
			if(isset($offset)&& $offset!="") $n=$offset;
			foreach($listmembers as $member){
				$n++;
			?>
				<tr>
					<td><input type="checkbox" name="storedemailcheck" value="<?php echo $member['EmailAddress'];?>" title="<?php echo $member['Name'];?>" /></td>
					<td align="right"><?php echo $n;?></div>
					<td><?php echo $member['Name'];?></td>
					<td><?php echo $member['EmailAddress'];?></td>
					<td><?php echo $member['MobilePhone'];?></td>
					<td align="center"><?php if(isset($member['ManagerFullName'])) echo $member['ManagerFullName'];?></td>
					<td align="center"><?php echo $member['DateRegistry'];?></td>
					<td align="center"><?php echo $member['UpdatedDate'];?></td>
					<td align="center"><?php echo $member['LastDateLogin'];?></td>
					<td>
						<?php echo "Cấp độ ".($member['Level']==null?"1":$member['Level']);?>
					</td>
					<td align="center" style='<?php if($member['Status']==2) echo "background-color:Red";else echo "";?>'><?php echo $member['Status']==2? "Khóa":"Kích hoạt";?></td>					
					<td align="center">
						<div>							
							<a style="text-decoration:none;" href="javascript:void(0)" onclick="getdatatoeditcontact('<?php echo $member['EmailAddress'];?>')">
								<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/edit-content.png" title="Chính sửa liên lạc này" />
							</a>
							&#32;&#32;
							<a style="text-decoration:none;" href="javascript:void(0)" >
								<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/delete.png" title="Xóa liên lạc này" />
							</a>
						</div>
					</td>
			</tr>
			<?php
			}
			echo "</table></font>";
			echo $this->pagination->create_links(); // tạo link phân trang 
		} ?>
	</p>
</div>
