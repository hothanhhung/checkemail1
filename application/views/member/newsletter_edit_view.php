
<div style="padding: 0px 10px 10px 10px">
<script src="<?php echo base_url()?>plugin/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	function gettemplatefromws()
	{
		$('#statusaddcontent').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
		$.ajax({
		type: "POST",
		url: "<?php echo base_url()?>index.php/member/newsletter/readfromws",
		data: { url: $('#txtAddFromWebsite').val() }
		})
		.done(function( msg ) {
			if(msg=="0" || msg=="0"){
				alert('Lỗi khi đọc trang web');
				$('#statusaddcontent').html('');
			}
			else {
				tinyMCE.get('txtContentNewsletter').setContent(msg);
				$('#statusaddcontent').html('');
			}
		}) 
		.fail(function() {
			alert('Có lỗi khi kết nối tới server');
		});
	}
	
</script>
	<div id="title">
		<h1>Chỉnh sửa thư gửi</h1>		
	</div>
	<p>
		<div>
			Chi tiết định dạng thư gửi
		</div>
		<?php if(isset($newsletter)){ ?>
			<form  method="post" >
				<div>
					<table width="100%"><tr><td valign="top" width="305px">
						<label class="">Tên thư gửi:</label>
						<br/>
						<input id="txtIDNewsletter" name="txtIDNewsletter" type="hidden" value='<?php echo $newsletter["ID"];?>'/>
						<input id="txtNameNewsletter" name="txtNameNewsletter" style="width:300px"  value='<?php echo $newsletter["Name"];?>' class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
						<br/>
						<label class="">Tiêu đề thư gửi</label><br/>
						<input id="txtSubjectNewsletter" name="txtSubjectNewsletter" type="text" value="<?php echo $newsletter["Subject"];?>" style="width:300px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
						<br/>
						<label class="">Lời chào trong thử gửi</label><br/>
						<textarea style="width: 300px;resize:vertical" id="txtGreetNewsletter" name="txtGreetNewsletter"><?php echo $newsletter["Greet"];?></textarea><br/>
						<label class="">Ghi chú cho thư gửi</label><br/>
						<textarea style="width: 300px;resize:vertical;"  id="txtNoteNewsletter" name="txtNoteNewsletter"><?php echo $newsletter["Note"];?></textarea>
						<br/>
						Thêm nội dung thư từ trang web 
						<br>
						<div style="padding:5px 5px 5px 5px; border:1px solid;border-radius:5px;border-color:gray;background-color:#ffsfef;" id="areaFromWebsite">
							<input id="txtAddFromWebsite" name="txtAddFromWebsite" type="text" value="" style="width:300px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
							<a class="ui-multiselect ui-widget ui-state-default ui-corner-all" href="javascript:void(0)" onclick="gettemplatefromws();">Thêm</a>
						</div>
						<br/>
						<input id="btNext" value="Lưu Thư gửi" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
						<a href='<?php echo base_url()?>index.php/member/newsletter/listnewsletter'>Về lại danh sách</a>
						<div id='statusedit'></div>
					</td>
					<td style='padding-left:20px'>
						<label class="">Nội dung thư gửi</label><br/>
						<textarea id="txtContentNewsletter" name="txtContentNewsletter"><?php echo $newsletter["Content"]; ?></textarea>
					</td></tr></table>
					<script type="text/javascript">
						tinymce.init({
							selector: "textarea#txtContentNewsletter",
							toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
							height:500
						 });
					</script>
				</div>
				
				 
			</form>
		<?php } ?>
		
		<br/>
		
	</p>	
</div>
