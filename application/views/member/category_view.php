
<div style="padding: 0px 10px 10px 10px">
	<div id="title">
		<h1>Thêm danh mục</h1>		
	</div>
	<p>
		<div>
			Bạn có thể thêm mới danh mục để tiện quản lý các liên lạc
		</div>
		<form  action='<?php echo base_url()?>index.php/member/category/addcategory' method="post" >
			<span class="explaindetail">Để thêm liên lạc vào trong tài nguyên của bạn, hãy nhập vào form dưới đây.</span><br/>
			<label class="label_addcategory">Tên danh mục</label>
			<input id="txtCategory" name="txtCategory" type="text" value="" style="width:300px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
			<label class="label_addcategory">Ghi Chú</label>
			<input id="txtNote" name="txtNote" type="text" value="" style="width:300px"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
			<input id="btAddCategory" value="Thêm danh mục" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
			
			<div style="color:red;font-size: 14px;">
				<?php if(isset($result_addcategory))
						if($result_addcategory=="1") echo "Đã thêm mới danh mục"; 
						else if($result_addcategory=="0") echo "Thêm mới danh mục không thành công"; 
				?>
			</div>
			
		</form>
		<br/>
		
	</p>
	<div id="title">
		<h1>Danh sách các danh mục trong tài nguyên</h1>		
	</div>
	<span class="explaindetail">Có tất cả <?php if(isset($numbercategories)) echo $numbercategories; else echo "0"?> danh mục</span>
		<br/>
		<?php if(isset($listcategories)){
			if(!isset($numberperpage)) $numberperpage=5;
			if(!isset($sort_by)) $sort_by="";
			if(!isset($sort_order)) $sort_order="";
		?>
			<script type="text/javascript">
				function editcategorywindowclick(n, id) 
				{
					$('#txtNameCate').val($('#idnamecate'+n).text());
					$('#txteditnote').val($('#idnotecate'+n).text());
					$('#id-category').val(id);
					// Getting the variable's value from a link 
					var editnotebox = "#editcategory-box";//$(this).attr('href');

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
					$('body').append('<div id="mask"></div>');
					$('#mask').fadeIn(300);
					
					$('#mask').click(function() { 
							$('#mask , .editcategory-popup').fadeOut(300 , function() {
							$('#mask').remove();  
							}); 
							return false;
						});
					return false;
				}
				
			// When clicking on the button close or the mask layer the popup closed
				function aeditnotecloseclick()
				{ 
					$('#mask, .editcategory-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						}); 
					return false;
				}
				
				function savecategory()
				{
					$('#status-editcategory').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
					$.ajax({
					type: "POST",
					url: "<?php echo base_url()?>index.php/member/category/editcategory",
					data: { note: $('#txteditnote').val(), id:$('#id-category').val(), name:$('#txtNameCate').val() }
					})
					.done(function( msg ) {
						if(msg=="2"){
							window.open(window.location.pathname,"_self");
						}
						else {
							$('#status-editcategory').html('<b>Có lỗi khi lưu dữ liệu</b>');
						}
					}) 
					.fail(function() {
						$('#status-editcategory').html('<b>Lỗi kết nối server</b>');
					});
				}
				
				
				function setorderparameter(by)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/member/category/setorderparameter",
						data: { sort_by: by }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
				}
				
				function deletecategory(el,cateID,name)
				{
					if(confirm("Bạn muốn xóa danh mục:"+name))
					{
						$(el).parent().html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
						$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/member/category/deletecategory",
						data: { id: cateID }
						})
						.done(function( msg ) {
							window.open(window.location.pathname,"_self");
							
						}) 
						.fail(function() {
							alert('Lỗi kết nối server');
						});
					}
				}
				
			</script>	
			<div id="editcategory-box" class="editcategory-popup" align="center">
				<a href="javascript:void(0)" class="close" onclick="return aeditnotecloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  <form method="post" class="editnote" action="#">
					<span style="color:#999; font-size:11px;">Tên danh mục</span><br/>
					<input id="txtNameCate" name="txtNameCate" type="text" value="" style="width:200px" /><br/>
					<span style="color:#999; font-size:11px;">Ghi chú</span><br/>
					<textarea id="txteditnote" name="txteditnote" rows="4" cols="22" autocomplete="off" ></textarea>
					
					
					<input id="id-category" name="id-category" value="" type="hidden">
					
					<div id="status-editcategory" name="status-editcategory" style="color:red;font-size: 0.6em;"></div>
					<button class="submit button" type="button"  onclick="savecategory();return false;">Lưu</button>					
					
			  </form>
			</div>
			
			<div>
				<form method="post" action="<?php echo base_url()?>index.php/member/category/">
					
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
					<th width="10px"></th>
					<th width="10px">STT</th>
					<th width="150px" class="sort_sign" onclick="setorderparameter('1')">Tên danh mục</th>			
					<th width="80px" class="sort_sign" onclick="setorderparameter('5')">Số liên lạc</th>
					<th width="100px" class="sort_sign" onclick="setorderparameter('2')">Ngày tạo</th>					
					<th width="100px" class="sort_sign" onclick="setorderparameter('3')">Ngày cập nhật</th>
					<th class="sort_sign" onclick="setorderparameter('4')">Ghi chú</th>
					<th width="100px"></th>								
			</tr>
		<?php
			$n=0;
			if(isset($offset)&& $offset!="") $n=$offset;
			foreach($listcategories  as $cate){
				$n++;
			?>
				<tr>
					<td><input type="checkbox" name="storedemailcheck" value="<?php echo $cate['ID'];?>" title="<?php echo $cate['Name'];?>" /></td>
					<td align="right"><?php echo $n;?></div>
					<td><div id="idnamecate<?php echo $n;?>"><?php echo $cate['Name'];?></td>
					<td align="center"><?php echo $cate['NumContact'];?></td>
					<td align="center"><?php echo $cate['CreatedDate'];?></td>
					<td align="center"><?php echo $cate['UpdatedDate'];?></td>
					<td>
						<div id="idnotecate<?php echo $n;?>"><?php echo $cate['Note'];?></div>						
					</td>
					
					<td align="center">
						<div></div>
						<a style="text-decoration:none;" href="<?php echo base_url()?>index.php/member/contact/listincat?catid=<?php echo $cate['ID'];?>" >
							<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/view.png" title="Danh sách các liên lạc của danh mục này" />
						</a>&#32;&#32;
						<a style="text-decoration:none;" href="javascript:void(0)" onclick="return editcategorywindowclick(<?php echo $n?>, '<?php echo $cate['ID'];?>')">
							<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/edit_category.png" title="Chỉnh sửa danh mục này" />
						</a>&#32;&#32;
						<a style="text-decoration:none;" href="javascript:void(0)" onclick="deletecategory(this, '<?php echo $cate['ID'];?>', '<?php echo $cate['Name'];?>'); return false;">
							<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/delete.png" title="Xóa danh mục này" />
						</a>
					</td></td>
			</tr>
			<?php
			}
			echo "</table></font>";
			echo $this->pagination->create_links(); // tạo link phân trang 
		} ?>
	</p>
	
</div>
