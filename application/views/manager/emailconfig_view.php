<div style="padding: 0px 10px 10px 10px">
	<p>
		<div id="title">
			<h1>Thêm email để gửi thư</h1>		
		</div>
		<div style="padding:5px 5px 5px 5px; border:1px solid;border-radius:5px;border-color:gray;background-color:#ffsfef; " align="center">
			<form id="faddEmailConfig" action='<?php echo base_url()?>index.php/manager/emailconfig/add' method="post" >
				<b>
				<table style="border-spacing: 15px 0;"><tr>
					<td>
						<span>Địa chỉ email</span><br/>
						<input id="txtAddressEmailConfigAdd" name="txtAddressEmailConfigAdd" type="text" value="" style="width:200px"/>
					</td>
					<td>
						<span>Protocol</span><br/>
						<input id="txtProtocolEmailConfigAdd" name="txtProtocolEmailConfigAdd" type="text" value="smtp" style="width:200px"/>
					</td>
					<td>
						<span>SMTP Host</span><br/>
						<input id="txtSMTPHostEmailConfigAdd" name="txtSMTPHostEmailConfigAdd" type="text" value="" style="width:200px" />
					</td>
					<td>
						<span>SMTP Port</span><br/>
						<input id="txtSMTPPortEmailConfigAdd" name="txtSMTPPortEmailConfigAdd" type="text" value="" style="width:200px" />
					</td>
					<td>
						<span>Số email gửi trong ngày</span><br/>
						<input id="txtNumberSendPerDateEmailConfigAdd" name="txtNumberSendPerDateEmailConfigAdd" type="text" value="500" style="width:200px"/>
					</td>
				</tr>
				<tr>
					<td>
						<span>Mật khẩu</span><br/>
						<input id="txtPasswordEmailConfigAdd" name="txtPasswordEmailConfigAdd" type="password" value="" style="width:200px"/>
					</td>
					<td>
						<span>Xác nhận mật khẩu</span><br/>
						<input id="txtPasswordAgainEmailConfigAdd" name="txtPasswordAgainEmailConfigAdd" type="password" value="" style="width:200px"/>
					</td>
					<td>
						<span>Ghi chú</span><br/>
						<input id="txtNoteEmailConfigAdd" name="txtNoteEmailConfigAdd" type="text" value="" style="width:200px" />
					</td>
					<td>
						<span>Trạng thái</span><br/>
						<select  name="sbStatusEmailConfigAdd" id="sbStatusEmailConfigAdd" style="width:200px">
								<option value="1">Kích hoạt</option>
								<option value="2">Khóa</option>
						</select>					
					</td>
					<td>								
						<input id="btemailconfigAdd" value="Thêm email gửi thư" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					</td>
				</tr></table>		
				</b>
				<div id="status-emailconfigAdd" name="status-emailconfigAdd" style="color:red;font-size: 0.9em;">
							<?php if(isset($result_addemailconfig))
								 echo $result_addemailconfig; 
							?>
						</div>	
				<br/>
				
			</form>
		</div>
		<br/>
		
		<div id="title">
			<h1>Danh sách email dùng để gửi</h1>		
		</div>
		<span class="explaindetail"> Có tất cả <?php if(isset($numberemailconfig)) echo $numberemailconfig; else echo "0"?> email được dùng để gửi thư</span>
		<br/><br/>
		<?php if(isset($emailconfiglist)){
			if(!isset($numberperpage)) $numberperpage=5;
			if(!isset($sort_by)) $sort_by="";
			if(!isset($sort_order)) $sort_order="";
		?>
			<script type="text/javascript">				
				function setorderparameter(by)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/manager/emailconfig/setorderparameter",
						data: { sort_by: by }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
				}				
				
				function getdatatoedit(idemailconfig)
				{
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/manager/employee/getinforemailconfig",
					data: { ID: idemailconfig },
					dataType: "json"
					})
					.done(function( msg ) {
						if(msg=="0" || msg=="1"){
							alert('Không tìm thấy liên lạc này');
						}
						else {
							editemailconfigwindowclick(msg.FullName,msg.UserName, msg.MobilePhone, msg.Level, msg.Status, msg.Note);
						}
					}) 
					.fail(function() {
						alert('Có lỗi khi kết nối tới server');
					});
				}
				
				function editemailconfigwindowclick(name,username,phone,level,status,note) 
				{
					$('#txtFullNameemailconfig').val(name);
					$('#txtUserNameemailconfig').val(username);
					$('#txtPhoneemailconfig').val(phone);
					$('#txteditnote').val(note);
					$("select#sbLevel option")
						.each(function() { this.selected = (this.value == level); });
					$("select#sbStatus option")
						.each(function() { this.selected = (this.value == status); });
						
					// Getting the variable's value from a link 
					var editemailconfigbox = "#editemailconfig-box";//$(this).attr('href');

					//Fade in the Popup and add close button
					$(editemailconfigbox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(editemailconfigbox).height() + 24) / 2; 
					var popMargLeft = ($(editemailconfigbox).width() + 24) / 2; 
					
					$(editemailconfigbox).css({ 
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
				
				function aeditemailconfigcloseclick()
				{ 
					$('#mask, .window-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						}); 
					return false;
				}
				
				function saveinforemployee()
				{
				
					$('#status-editemailconfig').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/manager/employee/editemployee",
					data: { name: $('#txtFullNameemailconfig').val(), username:$('#txtUserNameemailconfig').val(), phone:$('#txtPhoneemailconfig').val(), note:$('#txteditnote').val(), level:$('#sbLevel :selected').val(), status:$('#sbStatus :selected').val() }
					})
					.done(function( msg ) {
						if(msg=="2"){
							window.open(window.location.pathname,"_self");
						}
						else {
							$('#status-editemailconfig').html('<b>Có lỗi khi lưu dữ liệu</b>');
						}
					}) 
					.fail(function() {
						$('#status-editemailconfig').html('<b>Lỗi kết nối server</b>');
					});
				}
			</script>	
			<div id="editemailconfig-box" class="window-popup" align="center">
				<a href="javascript:void(0)" class="close" onclick="return aeditemailconfigcloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="editnote" action="#">
					<span style="color:#999; font-size:16px;"><b>Thông tin nhân viên viên</b></span><br/>
					<span style="color:#999; font-size:11px;">Tên tài khoản</span><br/>
					<input id="txtUserNameemailconfig" name="txtEmailemailconfig" type="text" value="" style="width:200px" readonly/><br/>
					<span style="color:#999; font-size:11px;">Họ và tên</span><br/>
					<input id="txtFullNameemailconfig" name="txtNameemailconfig" type="text" value="" style="width:200px" /><br/>
					<span style="color:#999; font-size:11px;">Số điện thoại</span><br/>
					<input id="txtPhoneemailconfig" name="txtPhoneemailconfig" type="text" value="" style="width:200px" /><br/>				
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
					<span style="color:#999; font-size:11px;">Ghi chú</span><br/>
					<textarea id="txteditnote" name="txteditnote" rows="4" cols="22" autocomplete="off" ></textarea>
					<div id="status-editemailconfig" name="status-editemailconfig" style="color:red;font-size: 0.6em;"></div>
					<button class="submit button" type="button"  onclick="saveinforemployee();return false;">Lưu</button>					
					
			  </form>
			</div>
			
			<div>
				<form method="post" action="<?php echo base_url()?>index.php/manager/employee">
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
					<th width="10px" onclick="setorderparameter('0')">STT</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('1')">Email</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('2')">Protocol</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('3')">smtp_host</th>
					<th width="100px" class="sort_sign" onclick="setorderparameter('4')">smtp_port</th>					
					<th width="100px" class="sort_sign" onclick="setorderparameter('5')">Ngày thêm</th>					
					<th width="100px" class="sort_sign" onclick="setorderparameter('6')">Ngày vừa sử dụng</th>
					<th width="80px" class="sort_sign" onclick="setorderparameter('7')">Số lượng gửi</th>
					<th width="80px" class="sort_sign" onclick="setorderparameter('8')">Số lượng gửi một ngày</th>
					<th width="80px" class="sort_sign" onclick="setorderparameter('9')">Số lượng gửi hôm nay</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('10')">Ghi chú</th>
					<th width="80px" class="sort_sign" onclick="setorderparameter('11')">Trạng thái</th>
					<th width="100px"></th>								
			</tr>
		<?php
			$n=0;
			if(isset($offset)&& $offset!="") $n=$offset;
			foreach($emailconfiglist as $emailconfig){
				$n++;
			?>
				<tr>
					<td><input type="checkbox" name="storedemailcheck" value="<?php echo $emailconfig['ID'];?>" title="<?php echo $emailconfig['Email'];?>" /></td>
					<td align="right"><?php echo $n;?></div>
					<td><?php echo $emailconfig['Email'];?></td>
					<td><?php echo $emailconfig['Protocol'];?></td>
					<td><?php echo $emailconfig['smtp_host'];?></td>
					<td align="center"><?php echo $emailconfig['smtp_port'];?></td>
					<td align="center"><?php echo $emailconfig['CreatedDate'];?></td>
					<td align="center"><?php echo $emailconfig['LastUsedDate'];?></td>
					<td><?php echo $emailconfig['NumberSentEmail'];?></td>
					<td><?php echo $emailconfig['NumberSendPerDate'];?></td>
					<td><?php echo $emailconfig['NumberSentEmailToday'];?></td>
					<td align="center"><?php if(isset($emailconfig['Note'])) echo $emailconfig['Note'];?></td>
					<td align="center" style='<?php if($emailconfig['Status']==2) echo "background-color:Red";else echo "";?>'><?php echo $emailconfig['Status']==2? "Khóa":"Kích hoạt";?></td>					
					
					<td align="center">
						<div>							
							<a style="text-decoration:none;" href="javascript:void(0)" onclick="getdatatoedit('<?php echo $emailconfig['ID'];?>')">
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
