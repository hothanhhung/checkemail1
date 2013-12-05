
<div style="padding: 0px 10px 10px 10px">
<script src="<?php echo base_url()?>plugin/tinymce/tinymce.min.js"></script>
	<div id="title">
		<h1>Chỉnh sửa nội dung trang</h1>		
	</div>
	<p>
		<?php if(isset($pagecontent)){ ?>
			<form  method="post" >
				<div>
					<table width="100%"><tr><td valign="top" width="305px">
						<label class="">Tên trang</label>
						<br/>
						<input id="txtIDPage" name="txtIDPage" type="hidden" value='<?php echo $pagecontent["ID"];?>'/>
						<input id="txtNamePage" name="txtNamePage" style="width:300px"  value='<?php echo $pagecontent["Name"];?>' class="ui-multiselect ui-widget ui-state-default ui-corner-all" readonly/>
						<br/>
						<label class="">Tiêu đề trang</label><br/>
						<input id="txtTitlePage" name="txtTitlePage" type="text" value="<?php echo $pagecontent["Title"];?>" style="width:300px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
						<br/><br/>
						<input id="btNext" value="Lưu nội dung" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
						<a href='<?php echo base_url()?>index.php/manager/general/'>Về lại danh sách</a>
						<div id='statusedit'><?php if(isset($statusedit)) echo $statusedit; ?></div>
					</td>
					<td style='padding-left:20px'>
						<label class="">Nội dung trang</label><br/>
						<textarea id="txtContentPage" name="txtContentPage"><?php echo $pagecontent["Content"]; ?></textarea>
					</td></tr></table>
					<script type="text/javascript">
						tinymce.init({
							selector: "textarea#txtContentPage",
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
							height:500
						 });
					</script>
				</div>
				
				 
			</form>
		<?php }else{ ?>
				Không tồn tại trang này.
				<a href='<?php echo base_url()?>index.php/manager/general/'>Về lại danh sách</a>
		<?php } ?>
		
		<br/>
		
	</p>	
</div>
