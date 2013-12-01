	<script type="text/javascript">
		$(function(){
		
			$("#sbCateID").multiselect(
				{
					multiple: false,
					selectedList: 1,
				}
			).multiselectfilter();
			
			$("#sbCateID-mt").multiselect(
				{
					multiple: false,
					selectedList: 1,
				}
			).multiselectfilter();
		});
	</script>
	
<div style="padding: 0px 10px 10px 10px">
	<div id="title">
		<h1>Thêm mới liên lạc vào tài nguyên</h1>		
	</div>
	<p>
		<div>
			Bạn có thể thêm mới địa chỉ email bằng cách sử dụng form bên dưới hoặc upload file chưa danh sách email. 
			Chú ý rằng, nếu địa chỉ bạn thêm vào đã thật sự tồn tại trong tài nguyên của bạn, nó sẽ được cập nhật lại thông tin.
		</div>
		<table><tr>
			<td width="50%">
				<span><strong>Thêm mới một liên lạc</strong></span>
				<form id="faddContact" action='<?php echo base_url()?>index.php/member/contact/addcontact' method="post" >
					<span class="explaindetail">Để thêm địa chỉ email vào trong tài nguyên của bạn, hãy nhập vào form dưới đây.</span><br/>
					<label class="label_addcontact">Họ tên</label>
					<input id="txtFullName" name="txtFullName" type="text" value="" style="width:300px" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					<br/>
					<label class="label_addcontact">Email</label>
					<input id="txtEmailAdd" name="txtEmailAdd" type="text" value="" style="width:300px" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					<br/>
					<label class="label_addcontact">Ghi Chú</label>
					<input id="txtEmailNote" name="txtEmailNote" type="text" value="" style="width:300px" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					<br/>
					<label class="label_addcontact">Danh mục</label>
					<select  name="sbCateID"  id="sbCateID"  style="width:305px">
						<option value="-1" selected >---Không vào danh mục nào---</option>
						<?php
							if(isset($listcategories))
							{ 
								foreach($listcategories as $cat)
								{
							?>
							<option value="<?php echo $cat['ID']; ?>" ><?php echo $cat['Name']; ?></option>
						<?php 
								}
							} 
						?>

					</select>
					<br/>
					<div style="color:red;font-size: 14px;">
						<?php if(isset($result_addcontact))
								if($result_addcontact=="2") echo "Đã thêm mới liên lạc"; 
								else if($result_addcontact=="1") echo "Email là không hợp lệ"; 
						?>
					</div>
					<input id="btAddContact" value="Thêm liên lạc" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					<br/>
					
				</form>
			</td>	
			<td width="50%" valign="top">
				<span><strong>Thêm mới nhiều liên lạc</strong></span>
				<div class="explaindetail">
				Để thêm mới các địa chỉ liên lạc, bạn có thể upload file chưa danh sách email thông qua form bên dưới.
				Chú ý rắng, các địa chỉ email này phải được cách nhau bới: dâu chấm phẩy, ký tự trắng hoặc xuống dòng. </div>
				<form id="fcheckmultiemail" enctype="multipart/form-data"
					action='<?php echo base_url()?>index.php/member/contact/addcontacts' method="post" >
					<label class="label_addcontact">Chọn file</label>
					<input id="flEmail" name="flEmail" type="file" style="width:300px" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					<br/>
					<label class="label_addcontact">Danh mục</label>
					<select  name="sbCateID"  id="sbCateID-mt" style="width:305px">
						<option value="-1" >---Không vào danh mục nào---</option>
						<?php
							if(isset($listcategories))
							{ 
								foreach($listcategories as $cat)
								{
							?>
							<option value="<?php echo $cat['ID']; ?>" ><?php echo $cat['Name']; ?></option>
						<?php 
								}
							} 
						?>

					</select>
					<div style="color:red;font-size: 14px;">
						<?php if(isset($result_addcontacts))
								if($result_addcontacts=="2") echo "Đã thêm mới các liên lạc"; 
								else if($result_addcontacts=="1") echo "File là không hợp lệ"; 
						?>
					</div>
					<input id="btAddContacts" value="Thêm các liên lạc" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					<br/>
				</form>		
			</td>
		</tr></table>
	</p>
	<p>
		<div id="title">
			<h1>Danh sách liên lạc trong tài nguyên</h1>		
		</div>
		<span class="explaindetail"> Có tất cả <?php if(isset($numbercontacts)) echo $numbercontacts; else echo "0"?> liên lạc</span>
		<br/><br/>
		<?php if(isset($listemails)){
			if(!isset($numberperpage)) $numberperpage=5;
			if(!isset($sort_by)) $sort_by="";
			if(!isset($sort_order)) $sort_order="";
		?>
			<script type="text/javascript">
				
				function checkemail(el,email)
				{
					$(el).parent().html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/verifyemail/ajaxcheckemail",
					data: { txtEmail: email, ss:'0' }
					})
					.done(function( msg ) {
						window.open(window.location.pathname,"_self");
						
					}) 
					.fail(function() {
						alert('<b>Lỗi kết nối server</b>');
					});
				}
				
				function deletestoredemail(el,idemail,email)
				{
					if(confirm("Bạn muốn xóa email:"+email))
					{
						$(el).parent().html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
						$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/member/contact/deletestoredemail",
						data: { id: idemail }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
					}
				}
				
				function deleteallemails(el)
				{
				
					$(el).parent().children('span').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					 if(confirm("Bạn muốn xóa tất cả những email được chọn"))
					 {
						elements = jQuery('[name="storedemailcheck"]');
						var idlist = "";
						for(var i=0; i<elements.length;i++)
						{
							if(elements[i].checked) idlist = idlist + "ID=" + elements[i].value + " OR ";
						}
						idlist = idlist + "False";
						
						$.ajax({
							type: "POST",
							url: "<?php echo base_url()?>index.php/member/contact/deletemultistoredemail",
							data: { ids: idlist}
						 })
						.done(function( msg ) {
							 window.open('<?php echo base_url()?>index.php/member/contact/',"_self");
							
						 }) 
						 .fail(function() {
							$(el).parent().children('span').html('');
							alert('Lỗi kết nối server');
						 });
					 }
				}
				
				function checkallemails(el)
				{
				
					//$(el).parent().children('span').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					elements = jQuery('input[name="storedemailcheck"]:checked');
					var listemails = "";
					var sum=elements.length;
					if(sum<1) 
					{
						alert("Chưa có email được chọn");
						return;
					}
					 if(confirm("Bạn muốn kiểm tra tất cả những email được chọn"))
					 {
						/************************/
						var loadingbox = "#loading-box";

						//Fade in the Popup and add close button
						$(loadingbox).fadeIn(300);
						
						//Set the center alignment padding + border
						var popMargTop = ($(loadingbox).height() + 24) / 2; 
						var popMargLeft = ($(loadingbox).width() + 24) / 2; 
						
						$(loadingbox).css({ 
							'margin-top' : -popMargTop,
							'margin-left' : -popMargLeft
						});
						
						// Add the mask to body
						$('body').append('<div id="mask"></div>');
						$('#mask').fadeIn(300);
						/************************/
						
						
						var success=0;
						var fail=0;
						$('#status-loading-sum').html('Có '+sum+' emails đang được kiểm tra');
						for(var i=0; i<sum;i++)
						{
							if(elements[i].checked) 
							{
								$.ajax({
									type: "POST",
									url: "<?php echo base_url()?>index.php/verifyemail/ajaxcheckemail",
									data: { txtEmail: elements[i].title, ss:"0"}
								 })
								.done(function( msg ) {
									success++;
									$('#status-loading-suc').html('Có '+success+' emails đã được kiểm tra');
									var percent=parseInt((success + fail)*100/sum);
									$('#loading-process').html('' + percent + '%');
									$('#loading-process').width('' + percent + '%');
									if((success + fail) == sum) $('#bt-loading-close').css('display','block');
								 }) 
								.fail(function() {
									fail++;
									$('#status-loading-fai').html('Có '+fail+' emails không thể kiểm tra');
									var percent=parseInt((success + fail)*100/sum);
									$('#loading-process').html('' + percent + '%');
									$('#loading-process').width('' + percent + '%');
									if(success + fail == sum) $('#bt-loading-close').css('display','block');
								 });
							}
						}
					 }
				}
				
				function btloadingcloseclick()
				{ 
					$('#mask, .loading-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						});
					window.open(window.location.pathname,"_self");
				}
				
				function setorderparameter(by)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/member/contact/setorderparameter",
						data: { sort_by: by }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
				}
				
				function getdatatoeditcontact(idCate)
				{
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/contact/getcontact",
					data: { id: idCate },
					dataType: "json"
					})
					.done(function( msg ) {
						if(msg=="0" || msg=="1"){
							alert('Không tìm thấy liên lạc này');
						}
						else {
							showeditcontact(msg.IDContact,msg.FullName, msg.StoredEmail, msg.CategoryID, msg.Note, msg.Disconected, msg.Status );
						}
					}) 
					.fail(function() {
						alert('Có lỗi khi kết nối tới server');
					});
				}
				
				function showeditcontact(IDContact,username, StoredEmail, CategoryID, Note, Disconected, Status )
				{
					$('#id-contact').val(IDContact);
					$('#username-contact').val(username);
					$('#email-contact').val(StoredEmail);
					$('#txteditnote').val(Note);
					$('#status-contact').html(name);
					$("select#sbCateID-editContact option")
						.each(function() { this.selected = (this.value == CategoryID); });
						
					var contactBox = "#contact-box";//$(this).attr('href');

					//Fade in the Popup and add close button
					$(contactBox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(contactBox).height() + 24) / 2; 
					var popMargLeft = ($(contactBox).width() + 24) / 2; 
					
					$(contactBox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					
					// Add the mask to body
					$('body').append('<div id="mask"></div>');
					$('#mask').fadeIn(300);
					
					$('#mask').click(function() { 
							$('#mask , .contact-popup').fadeOut(300 , function() {
							$('#mask').remove();  
							}); 
							return false;
						});
					return false;
				}
				function acontactcloseclick()
				{ 
					$('#mask , .contact-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						}); 
					return false;
				}
				
				function savecontact()
				{
				
					$('#status-editcontact').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/contact/editcontact",
					data: { note: $('#txteditnote').val(), id:$('#id-contact').val(), fullname:$('#username-contact').val(), catID:$('#sbCateID-editContact :selected').val() }
					})
					.done(function( msg ) {
						if(msg=="2"){
							window.open(window.location.pathname,"_self");
						}
						else {
							$('#status-editcontact').html('<b>Có lỗi khi lưu dữ liệu</b>');
						}
					}) 
					.fail(function() {
						$('#status-editcontact').html('<b>Lỗi kết nối server</b>');
					});
				}
				
				function checkboxcontactschange(el)
				{
					if(el.checked)
					{
						jQuery('input[name="storedemailcheck"]').each(function() { $(this).prop("checked", true);});
					}
					else 
						jQuery('input[name="storedemailcheck"]').each(function() { $(this).prop('checked', false);});
				}	
			</script>	
			<div id="contact-box" class="contact-popup">
				<a href="javascript:void(0)" class="profile-close" onclick="return acontactcloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="editnote" action="#">
					<fieldset class="textbox">
					<label class="username">
						<span>Họ và tên</span>
						<input id="username-contact" name="username-contact" value="" type="text">
					</label> 
					<label class="username">
						<span>Email</span>
						<input id="email-contact" name="email-contact" value="" type="text" readonly>
					</label>
					<label class="username">
						<span>Danh mục</span>						
						<select  name="sbCateID-editContact" id="sbCateID-editContact">
							<option value="-1" selected >---Không vào danh mục nào---</option>
							<?php
								if(isset($listcategories))
								{ 
									foreach($listcategories as $cat)
									{
								?>
								<option value="<?php echo $cat['ID']; ?>" ><?php echo $cat['Name']; ?></option>
							<?php 
									}
								} 
							?>

						</select>
					</label>
					<label class="username">
						<span style="color:#999; font-size:11px;">Ghi chú</span>
						<textarea id="txteditnote" name="txteditnote" rows="4" cols="22" autocomplete="off" ></textarea>
					</label>
					<div id="status-contact" name="status-contact"> </div>
					<div id="status-editcontact" name="status-editcontact"  style="color:red;font-size: 0.6em;"></div>
					<input id="id-contact" name="id-contact" value="" type="hidden">
					<button class="submit button" type="button" onclick="savecontact(); return false;">lưu</button>
					
					
					</fieldset>
			  </form>
			</div>
			
			
			<div id="loading-box" class="loading-popup" align="center">
				<span style="color:#999; font-size:14px;">Kiểm tra sự tồn tại các email</span><br/>
				<div  style="width:214px;height:30px;border:2px solid;border-radius:5px;border-color:#ff9900;background-color:#e0fe0f;"> 
					<div id="loading-process" name="loading-process" style="height:22px;font-size:13px;padding-top:8px;background-color:#ffffff; width:0%">
					</div>
				</div>
				<div id="status-loading-sum" name="status-loading-sum" style="color:white;font-size: 0.6em;"></div>
				<div id="status-loading-suc" name="status-loading-suc" style="color:white;font-size: 0.6em;"></div>
				<div id="status-loading-fai" name="status-loading-fai" style="color:white;font-size: 0.6em;"></div>
				
				<button class="submit button" type="button" id="bt-loading-close" name="bt-loading-close" onclick="btloadingcloseclick(); return false;" style="display:none">Ok</button>					
					
			</div>
			<div>
				<form method="post" action="<?php echo base_url()?>index.php/member/contact">
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
					&#32;&#32;&lsaquo;<a href="javascript:void(0)" style="font-size:13px" onclick="deleteallemails(this); return false;" >Xóa những email được chọn</a>&rsaquo;
					&#32;&#32;
					&lsaquo;<a href="javascript:void(0)" style="font-size:13px" onclick="checkallemails(this); return false;">Kiểm tra những email được chọn</a>&rsaquo;
				 
				</form>
			</div>
			<font size="2">
			<table class="listview" width="100%">
			<tr>
					<th width="10px"><input type="checkbox" onchange="checkboxcontactschange(this);"/></th>
					<th width="10px">STT</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('1')">Họ tên</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('2')">Email</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('3')">Danh mục</th>
					<th width="100px" class="sort_sign" onclick="setorderparameter('4')">Tên miền</th>					
					<th width="100px" class="sort_sign" onclick="setorderparameter('6')">Ngày cập nhật</th>
					<th class="sort_sign" onclick="setorderparameter('7')">Ghi chú</th>
					<th width="60px" class="sort_sign" onclick="setorderparameter('8')">Kết nối</th>	
					<th width="90px" class="sort_sign" onclick="setorderparameter('9')">Trạng Thái</th>	
					<th width="90px"></th>								
			</tr>
		<?php
			$n=0;
			if(isset($offset)&& $offset!="") $n=$offset;
			foreach($listemails as $email){
				$n++;
			?>
				<tr>
					<td><input type="checkbox" name="storedemailcheck" value="<?php echo $email['ID'];?>" title="<?php echo $email['StoredEmail'];?>" /></td>
					<td align="right"><?php echo $n;?></div>
					<td><?php echo $email['FullName'];?></td>
					<td><?php echo $email['StoredEmail'];?></td>
					<td><?php if($email['NameCategory']==null) echo "#"; else echo $email['NameCategory'];?></td>
					<td><?php echo $email['Domain'];?></td>
					<td align="center"><?php echo $email['UpdatedDate'];?></td>
					<td>
						<div><?php echo $email['Note'];?></div>
					</td>
					<td align="center" style='<?php if($email['Disconnected']==null) echo "";else echo "background-color:Red";?>'>
						<div>
							<?php if($email['Disconnected']==null) echo "Có";else echo "Không";?>	
						<div>
					</td>
					<td style='background-color:<?php if($email['Status']==0) echo "Red";else if($email['Status']==1) echo "#42F5AE";else echo "Gray";?>'>
						<div>
							<?php if($email['Status']==0) echo "Không tồn tại";else if($email['Status']==1) echo "Tồn tại";else echo "Chưa kiểm tra";?>	
							
						<div>
					</td>
					<td align="center">
						<div>
							<a style="text-decoration:none;" href="javascript:void(0)" onclick="return checkemail(this, '<?php echo $email['StoredEmail'];?>'); return false;">
								<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/email-find.png" title="Kiểm tra sự tồn tại của liên lạc này" />
							</a>&#32;&#32;
							<a style="text-decoration:none;" href="javascript:void(0)" onclick="return getdatatoeditcontact('<?php echo $email['ID'];?>')">
								<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/edit-content.png" title="Chính sửa liên lạc này" />
							</a>
							&#32;&#32;
							<a style="text-decoration:none;" href="javascript:void(0)" onclick="return deletestoredemail(this, '<?php echo $email['ID'];?>', '<?php echo $email['StoredEmail'];?>')">
								<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/delete.png" title="Xóa liên lạc này" />
							</a>
						</div>
					</td></td>
			</tr>
			<?php
			}
			echo "</table></font>";
			echo $this->pagination->create_links(); // tạo link phân trang 
		} ?>
	</p>
</div>
