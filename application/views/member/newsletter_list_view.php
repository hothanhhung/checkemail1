<div style="padding: 0px 10px 10px 10px">
	<p>
		<div id="title">
			<h1>Danh sách các thử gửi trong tài nguyên được hiển thị theo điều kiện lọc</h1>		
		</div>
		<?php if(isset($listnewsletters)){
			if(!isset($numberperpage)) $numberperpage=5;
			if(!isset($sort_by)) $sort_by="";
			if(!isset($sort_order)) $sort_order="";
		?>
			<script type="text/javascript">
				
				function setorderparameter(by)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/member/newsletter/setorderparameter",
						data: { sort_by: by }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
				}
				
				function deletenewsletter(el,idnewsletter,name)
				{
					if(confirm("Bạn muốn xóa thử gửi:"+name))
					{
						$(el).parent().html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
						$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/member/newsletter/deletenewsletter",
						data: { id: idnewsletter }
						})
						.done(function( msg ) {
							if(msg=="2"){
								alert('Đã xóa thành công');
								window.open(window.location.pathname,"_self");
							}
							else {
								alert('Gặp lỗi khi xóa');
								$(el).parent().html('');
							}
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
					}
				}
				
				function deleteallnewsletter(el)
				{
				
					$(el).parent().children('span').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					 if(confirm("Bạn muốn xóa tất cả những thư được chọn"))
					 {
						elements = jQuery('[name="newslettercheck"]');
						var idlist = "";
						for(var i=0; i<elements.length;i++)
						{
							if(elements[i].checked) idlist = idlist + "ID=" + elements[i].value + " OR ";
						}
						idlist = idlist + "False";
						
						$.ajax({
							type: "POST",
							url: "<?php echo base_url()?>index.php/member/newsletter/deletemultinewsletter",
							data: { ids: idlist}
						 })
						.done(function( msg ) {
							if(msg=="2"){
								alert('Đã xóa thành công');
								window.open(window.location.pathname,"_self");
							}
							else {
								alert('Gặp lỗi khi xóa');
								$(el).parent().html('');
							}
						 }) 
						 .fail(function() {
							$(el).parent().children('span').html('');
							alert('Lỗi kết nối server');
						 });
					 }
				}
				
				function checkboxnewsletterschange(el)
				{
					if(el.checked)
					{
						jQuery('input[name="newslettercheck"]').each(function() { $(this).prop("checked", true);});
					}
					else 
						jQuery('input[name="newslettercheck"]').each(function() { $(this).prop('checked', false);});
				}	
			</script>	
			
			
			<br/>
			<div>
				<form method="post" action="<?php echo base_url()?>index.php/member/newsletter/listnewsletter">
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
					&#32;&#32;&lsaquo;<a href="javascript:void(0)" style="font-size:13px" onclick="deleteallnewsletter(this); return false;" >Xóa những thư được chọn</a>&rsaquo;
					&#32;&#32;
					
				</form>
			</div>
			<font size="2">
			<table class="listview" width="100%">
			<tr>
					<th width="10px"><input type="checkbox" onchange="checkboxnewsletterschange(this);"/></th>
					<th width="10px">STT</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('1')">Tên thư gửi</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('2')">Tiêu đề</th>
					<th width="100px" class="sort_sign" onclick="setorderparameter('3')">Ngày tạo</th>				
					<th width="100px" class="sort_sign" onclick="setorderparameter('4')">Ngày cập nhật</th>
					<th width="100px" class="sort_sign" onclick="setorderparameter('5')">Đã chạy lúc</th>				
					<th width="100px" class="sort_sign" onclick="setorderparameter('6')">Lần chạy tiếp</th>
					<th  class="sort_sign" onclick="setorderparameter('7')">Ghi chú</th>
					<th width="90px" class="sort_sign" onclick="setorderparameter('8')">Trạng Thái</th>	
					<th width="90px"></th>								
			</tr>
		<?php
			$n=0;
			if(isset($offset)&& $offset!="") $n=$offset;
			foreach($listnewsletters as $newsletter){
				$n++;
			?>
				<tr>
					<td><input type="checkbox" name="newslettercheck" id="newslettercheck" value="<?php echo $newsletter['ID'];?>" title="<?php echo $newsletter['Name'];?>" /></td>
					<td align="right"><?php echo $n;?></div>
					<td><?php echo $newsletter['Name'];?></td>
					<td><?php echo $newsletter['Subject'];?></td>
					<td align="center"><?php echo $newsletter['CreatedDate'];?></td>
					<td align="center"><?php echo $newsletter['UpdatedDate'];?></td>
					<td align="center"><?php echo $newsletter['LastRun']==null?"#":$newsletter['LastRun'];?></td>
					<td align="center"><?php echo $newsletter['NextRun']==null?"#":$newsletter['NextRun'];?></td>
					<td>
						<div><?php echo $newsletter['Note'];?></div>
					</td>
					
					<td style='background-color:<?php if($newsletter['Status']==0) echo "Red";else if($newsletter['Status']==1) echo "#42F5AE";else echo "Gray";?>'>
						<div>
							<?php echo $newsletter['Status']; ?>
						<div>
					</td>
					<td align="center">
						<div></div>
						<a style="text-decoration:none;" href="<?php echo base_url().'index.php/member/newsletter/resetupnewsletter/?ID='.$newsletter['ID'].'' ?>">
							<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/setting.png" title="Cài đặt lại thử gửi này" />
						</a>&#32;&#32;
						<a style="text-decoration:none;" href="<?php echo base_url().'index.php/member/newsletter/editnewsletter/?ID='.$newsletter['ID'].'' ?>">
							<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/email-edit.png" title="Thay đổi nội dung thử gửi này" />
						</a>
						&#32;&#32;
						<a style="text-decoration:none;" href="javascript:void(0)" onclick="deletenewsletter(this,<?php echo $newsletter['ID'].",'".$newsletter['Name']."')"?>">
							<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/delete.png" title="Xóa thư gửi này" />
						</a>
					</td>
			</tr>
			<?php
			}
			echo "</table></font>";
			echo $this->pagination->create_links(); // tạo link phân trang 
		} ?>
	</p>
</div>
