
<div id="box">
	<div id="title">
		<h1>Quản lý tài nguyên</h1>		
	</div>
	<p>
		<div>
			Bạn có thể thêm mới địa chỉ email bằng cách sử dụng form bên dưới hoặc upload file chưa danh sách email. 
			Chú ý rằng, nếu địa chỉ bạn thêm vào đã thật sự tồn tại trong tài nguyên của bạn, nó sẽ được cập nhật lại ngày cập nhật.
		</div>
		<form id="fcheckemail" action='<?php echo base_url()?>index.php/member/addemail' method="post" >
			<span>Để thêm địa chỉ email vào trong tài nguyên của bạn, hãy nhập vào form dưới đây.</span><br/>
			<label>Email</label>
			<input id="txtEmailAdd" name="txtEmailAdd" type="text" value="" style="width:300px" />
			<br/>
			<label>Ghi Chú</label>
			<input id="txtEmailNote" name="txtEmailNote" type="text" value="" style="width:300px" />
			<input id="btAddEmail" value="Thêm Email" type="submit" />
			<br/><br/>
			
		</form>
		<br/>
		<span>Để thêm mới các địa chỉ email, bạn có thể upload file chưa danh sách email thông qua form bên dưới.
		Chú ý rắng, các địa chỉ email này phải được cách nhau bới: dâu chấm phẩy, ký tự trắng hoặc xuống dòng. </span><br/><br/>
		<form id="fcheckmultiemail" enctype="multipart/form-data"
			action='<?php echo base_url()?>index.php/member/addemails' method="post" >
			<input id="flEmail" name="flEmail" type="file" />
			<input id="btCheckEmail" value="Thêm Emails" type="submit" />
			<br/><br/>

		</form>		
	</p>
	<p>
		<div>Danh sách email trong tài nguyên</div>
		<?php if(isset($listemails)){
			if(!isset($numberperpage)) $numberperpage=5;
			if(!isset($sort_by)) $sort_by="";
			if(!isset($sort_order)) $sort_order="";
		?>
			<script type="text/javascript">
				function editnotewindowclick(el, id) 
				{
					$('#txteditnote').val($(el).parent().children('div').text());
					$('#id-editnote').val(id);
					// Getting the variable's value from a link 
					var editnotebox = "#editnote-box";//$(this).attr('href');

					//Fade in the Popup and add close button
					$(editnotebox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(editnotebox).height() + 24) / 2; 
					var popMargLeft = ($(editnotebox).width() + 24) / 2; 
					
					$(editnotebox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					
					// Add the mask to body
					$('body').append('<div id="mask-editnote"></div>');
					$('#mask-editnote').fadeIn(300);
					
					$('#mask-editnote').click(function() { 
							$('#mask-editnote , .editnote-popup').fadeOut(300 , function() {
							$('#mask-editnote').remove();  
							}); 
							return false;
						});
					return false;
				}
				
			// When clicking on the button close or the mask layer the popup closed
				function aeditnotecloseclick()
				{ 
					$('#mask-editnote , .editnote-popup').fadeOut(300 , function() {
						$('#mask-editnote').remove();  
						}); 
					return false;
				}
				
				function savenote()
				{
					$('#status-editnote').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/editnote",
					data: { note: $('#txteditnote').val(), id:$('#id-editnote').val() }
					})
					.done(function( msg ) {
						if(msg=="2"){
							window.open(window.location.pathname,"_self");
						}
						else {
							$('#status-editnote').html('<b>Có lỗi khi lưu dữ liệu</b>');
						}
					}) 
					.fail(function() {
						$('#status-editnote').html('<b>Lỗi kết nối server</b>');
					});
				}
				
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
						url: "<?php echo base_url()?>index.php/member/deletestoredemail",
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
							url: "<?php echo base_url()?>index.php/member/deletemultistoredemail",
							data: { ids: idlist}
						 })
						.done(function( msg ) {
							 window.open('<?php echo base_url()?>index.php/member',"_self");
							
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
						$('body').append('<div id="mask-loading"></div>');
						$('#mask-loading').fadeIn(300);
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
					$('#mask-loading , .loading-popup').fadeOut(300 , function() {
						$('#mask-loading').remove();  
						});
					window.open(window.location.pathname,"_self");
				}
				
				function setorderparameter(by)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/member/setorderparameter",
						data: { sort_by: by }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
				}
			</script>	
			<div id="editnote-box" class="editnote-popup" align="center">
				<a href="#" class="close" onclick="return aeditnotecloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="editnote" action="#">
					
						<span style="color:#999; font-size:11px;">Ghi chú</span><br/>
						<textarea id="txteditnote" name="txteditnote" rows="4" cols="22" autocomplete="off" ></textarea>
					
					
					<input id="id-editnote" name="id-editnote" value="" type="hidden">
					
					<div id="status-editnote" name="status-editnote" style="color:red;font-size: 0.6em;"></div>
					<button class="submit button" type="button"  onclick="savenote();return false;">Lưu</button>					
					
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
				<form method="post" action="<?php echo base_url()?>index.php/member/">
					<span></span>
					&lsaquo;<a href="#" style="font-size:13px" onclick="deleteallemails(this); return false;" >Xóa những email được chọn</a>&rsaquo;
					&#32;&#32;
					&lsaquo;<a href="#" style="font-size:13px" onclick="checkallemails(this); return false;">Kiểm tra những email được chọn</a>&rsaquo;
				 
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
			<table class="listemails" width="97%">
			<tr>
					<th width="10px"></th>
					<th width="10px">STT</th>
					<th width="150px" <?php if($sort_by=="StoredEmail") echo 'class="sort_'.$sort_order.'"';?> onclick="setorderparameter('1')">Email</th>
					<th width="100px" <?php if($sort_by=="Domain") echo 'class="sort_'.$sort_order.'"';?> onclick="setorderparameter('5')">Tên miền</th>					
					<th width="80px" <?php if($sort_by=="UpdatedDate") echo 'class="sort_'.$sort_order.'"';?> onclick="setorderparameter('3')">Ngày cập nhật</th>
					<th <?php if($sort_by=="Note") echo 'class="sort_'.$sort_order.'"';?> onclick="setorderparameter('6')">Ghi chú</th>
					<th width="80px" <?php if($sort_by=="Status") echo 'class="sort_'.$sort_order.'"';?> onclick="setorderparameter('4')">Trạng Thái</th>	
					<th width="30px"></th>								
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
					<td><?php echo $email['StoredEmail'];?></td>
					<td><?php echo $email['Domain'];?></td>
					<td align="center"><?php echo $email['UpdatedDate'];?></td>
					<td><div><?php echo $email['Note'];?></div>
						<a href="#" onclick="return editnotewindowclick(this, '<?php echo $email['ID'];?>')"> &lsaquo;Sửa&rsaquo; </a> 
					</td>
					<td>
						<div>
							<?php if($email['Status']==0) echo "Không tồn tại";else if($email['Status']==1) echo "Tồn tại";else echo "Chưa kiểm tra";?>	
							<br/><a href="#" onclick="return checkemail(this, '<?php echo $email['StoredEmail'];?>')"> &lsaquo;Kiểm tra&rsaquo; </a>
						<div>
					</td>
					<td>
						<div></div>
						<a href="#" onclick="return deletestoredemail(this, '<?php echo $email['ID'];?>', '<?php echo $email['StoredEmail'];?>')"> &lsaquo;Xóa&rsaquo; </a> 
					</td></td>
			</tr>
			<?php
			}
			echo "</table></font>";
			echo $this->pagination->create_links(); // tạo link phân trang 
		} ?>
	</p>
</div>
