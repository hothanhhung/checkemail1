
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
	
	function gettemplatefromfile()
	{
		a = document.getElementById("flAddContent");
		$('#statusaddcontent').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
		$.get($('input[type=file]').val(), function(data) {
			tinyMCE.get('txtContentNewsletter').setContent(data);
			$('#statusaddcontent').html('');
		}, 'text');
	}
	
	function checkRadioAdd()
	{
		if($('input[name=rdAddContent]:checked').val()=='web')
		{
			$('#areaFromWebsite').css('display','block');  
			$('#areaFromFile').css('display','none');  
		}
		else if($('input[name=rdAddContent]:checked').val()=='file'){
			$('#areaFromFile').css('display','block');
			$('#areaFromWebsite').css('display','none');
		}
		else {
			$('#areaFromFile').css('display','none');
			$('#areaFromWebsite').css('display','none');
		}
	}
</script>
	<div id="title">
		<h1>Tạo định dạng thư gửi</h1>		
	</div>
	<p>
		<div>
			Chi tiết định dạng thư gửi
		</div>
		<form  action='<?php echo base_url()?>index.php/member/newsletter/createstep3' method="post" >
			<input id="btNext" value="Lưu và Tiếp tục" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
			<div>
				<table width="100%"><tr><td valign="top" width="305px">
					<label class="">Tên thư gửi:</label><b>
					<label class="" id="lblNameNewsletter" name="lblNameNewsletter">
						<?php if(isset($namenewsletter)) echo $namenewsletter;?>
					</label></b>
					<input id="txtNameNewsletter" name="txtNameNewsletter" type="hidden" value='<?php if(isset($namenewsletter)) echo $namenewsletter;?>'/>
					<br/>
					<label class="">Tiêu đề thư gửi</label><br/>
					<input id="txtSubjectNewsletter" name="txtSubjectNewsletter" type="text" value="" style="width:300px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
					<br/>
					<label class="">Lời chào trong thử gửi</label><br/>
					<textarea style="width: 300px;resize:vertical" id="txtGreetNewsletter" name="txtGreetNewsletter"></textarea><br/>
					<label class="">Ghi chú cho thư gửi</label><br/>
					<textarea style="width: 300px;resize:vertical;"  id="txtNoteNewsletter" name="txtNoteNewsletter"></textarea>
					<br/>
					<input type="radio" name="rdAddContent" onclick="checkRadioAdd(); " value='web'>Thêm nội dung thư từ trang web<br>
					<div style="display:none" id="areaFromWebsite">
						<input id="txtAddFromWebsite" name="txtAddFromWebsite" type="text" value="" style="width:300px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
						<a class="ui-multiselect ui-widget ui-state-default ui-corner-all" href="javascript:void(0)" onclick="gettemplatefromws();">Thêm</a>
					</div>
					<!--
					<input type="radio" name="rdAddContent" onclick="checkRadioAdd(); "  value='file'>Thêm nội dung thư từ file <br/>
					<div style="display:none" id="areaFromFile">
						<input id="flAddContent" name="flAddContent" type="File" value="" style="width:300px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
						<a class="ui-multiselect ui-widget ui-state-default ui-corner-all" href="javascript:void(0)" onclick="gettemplatefromfile();">Thêm</a>
					</div> -->
					<div id='statusaddcontent'></div>
				</td>
				<td align="center">
					<label class="">Nội dung thư gửi</label><br/>
					<textarea id="txtContentNewsletter" name="txtContentNewsletter">
						<?php if(isset($templatenewsletter)) echo $templatenewsletter; ?>
					</textarea>
				</td></tr></table>
				<script type="text/javascript">
					checkRadioAdd();
					tinymce.init({
						selector: "textarea#txtContentNewsletter",
						toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
						height:500
					 });
				</script>
			</div>
			
			 
		</form>
		
		
		<br/>
		
	</p>	
</div>
