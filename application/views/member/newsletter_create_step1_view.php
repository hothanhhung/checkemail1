
<div style="padding: 0px 10px 10px 10px">
	<div id="title">
		<h1>Tạo định dạng thư gửi</h1>		
	</div>
	<p>
		<div>
			Chi tiết định dạng thư gửi
		</div>
		<form  action='<?php echo base_url()?>index.php/member/newsletter/createstep2' method="post" >
			<input id="btNext" value="Tiếp tục" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
			<div style="padding-left:100px;">
				<div>
					<label class="">Tên thư gửi</label><br/>
					<input id="txtNameNewsletter" name="txtNameNewsletter" type="text" value="" style="width:400px"   class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
				</div>
				<table><tr>
				<td>	
					<label class="">Chọn mẫu thư gửi</label><br/>
					<select name="slTemplate" id="slTemplate"  onchange="$('#imgPreview').attr('src', this.value=='notemplate'? '<?php echo base_url()?>img/nopreview.gif' : '<?php echo base_url()?>newsletters/'+this.value+'/jpeg/newsletter.jpg')" size="11"   class="ui-multiselect ui-widget ui-state-default ui-corner-all">
						<option value="notemplate" >Không dùng mẫu thư</option>
						<?php 
							if(isset($listTemplate))
							{
								foreach($listTemplate as $template)
								{?>
								<option value='<?php echo $template["name"]?>'><?php echo $template["name"]?></option>
						<?php	}
							} ?>
						
					 </select>
				 </td>
				 <td style="padding-left:20px;">
					<label class=""></label><br/>
					 <div width="247" height="200" align="center" style="display:block; border: 1px solid black;" >
						<img height="200" onerror="this.src=<?php echo base_url()?>img/nopreview.gif" 
						style="border: 1px solid black;"  scale="noscale" src="<?php echo base_url()?>img/nopreview.gif"  id="imgPreview" />
					</div>
					<a onclick="javascript: ShowPreview(); return false;" href="#"><img border="0" style="padding-right:5px" src="<?php echo base_url()?>img/magnify.gif">Xem lớn hơn</a>
				</td>
				</tr></table>
			</div>
			<script type="text/javascript">
				$('#imgPreview').attr('src', $('#slTemplate').val()=='notemplate'? '<?php echo base_url()?>img/nopreview.gif' : '<?php echo base_url()?>newsletters/'+$('#slTemplate').val()+'/jpeg/newsletter.jpg')
				
				function ShowPreview()
				{
					$('#imgZomPreview').attr('src', $('#slTemplate').val()=='notemplate'? '<?php echo base_url()?>img/nopreview.gif' : '<?php echo base_url()?>newsletters/'+$('#slTemplate').val()+'/jpeg/newsletter.jpg')
				
					/************************/
					var previewbox = "#preview-box";

					//Fade in the Popup and add close button
					$(previewbox).fadeIn(300);
					
					//Set the center alignment padding + border
					var popMargTop = ($(previewbox).height() + 24) / 2; 
					var popMargLeft = ($(previewbox).width() + 24) / 2; 
					
					$(previewbox).css({ 
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					
					// Add the mask to body
					$('body').append('<div id="mask"></div>');
					$('#mask').fadeIn(300);
					
					$('#mask').click(function() { 
							$('#mask , .preview-popup').fadeOut(300 , function() {
							$('#mask').remove();  
							}); 
							return false;
						});
						
				}
				
				function btpreviewboxcloseclick()
				{ 
					$('#mask, .preview-popup').fadeOut(300 , function() {
						$('#mask').remove();  
						});
				}
			</script>
		</form>
		<div id="preview-box" class="preview-popup" align="center">
			
			<div> 
				<a href="javascript:void(0)" onclick="return btpreviewboxcloseclick();" ><img src="<?php echo base_url()?>img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			  
				<img height="600px"  onerror="this.src=<?php echo base_url()?>img/nopreview.gif" 
				style="border: 1px solid black;"  scale="noscale" src="<?php echo base_url()?>img/nopreview.gif"  id="imgZomPreview" />
			</div>
				
		</div>
		
		<br/>
		
	</p>	
</div>
