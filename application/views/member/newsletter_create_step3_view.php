
<div style="padding: 0px 10px 10px 10px">
	<script type="text/javascript">
		function checkbeforesend()
		{
			if(confirm("Bạn muốn gửi thư ngay bây giờ?"))
			{
				var src1 = document.getElementById('rightSelect');
				
				if(src1.length > 0)
				{
					for(var ii in src1.options)
					{
						src1.options[ii].selected = true;
						
					}	
					$("#issendnow").val("1");
					return true;
						
					
				}else{
					alert("Bạn phải chọn địa chỉ thử gửi đến");
					return false;
				}
			}
			else return false;
		}
		
		function checkbeforesubmit()
		{
			var src2 = document.getElementById('rightSelect');
			if(src2.length > 0) 
			{
				for(var ij in src2.options)
				{
					src2.options[ij].selected = true;
					
				}
				return true;
			}
		}
		function move(direction)
		{
			var src = document.getElementById('leftSelect');
			var trg = document.getElementById('rightSelect');	
			var tem;
		 
			if(direction)
			{
				tem = src;
				src = trg;
				trg = tem;
			}
		 
			var selected = [];
		 
			for(var i in src.options)
			{
				if(src.options[i].selected)
				{
					trg.options.add(new Option(src.options[i].text, src.options[i].value));
					selected.unshift(i);
				}
			}
		 
			for(i in selected)
				src.options.remove(selected[i]);
		}
	<?php if(isset($sendemailnow) && $sendemailnow==1 && isset($idnewsletter)) {?>	
		$( document ).ready(function() {
			$.ajax({
						type: "POST",
						url: "<?php echo base_url()?>index.php/manager/sendemail/runnewsletter/",
						data: { ID: <?php echo $idnewsletter; ?> }
						});/*
						.done(function( msg ) {
							
								//alert('Đã gửi');
							
						}) 
						.fail(function() {
							alert('Có lỗi khi kết nối tới server');
						});*/
			alert('Thư đã được lưu và gửi.\nCác liên lạc sẽ sớm nhận được thư này');
		});
	<?php } ?>
	</script>
	<div id="title">
		<h1>Cài đặt thư gửi</h1>		
	</div>
	<p>
		<div>
		<form action="">
			
			<input type="hidden" value="<?php if(isset($IDNewsletter)) echo $IDNewsletter; ?>" />
			<table><tr>
			<td valign='top'>
				<label style="display: inline-block; width:100px; padding:5px 2px 6px 2px;">Kích hoạt ngay</label>
				<input type="checkbox" id="cbActive"  name="cbActive" value="Yes" class="ui-multiselect ui-widget ui-state-default ui-corner-all">
				<br>
				<label style="display: inline-block; width:100px; padding:5px 2px 6px 2px;">Ngày gửi</label>
				<input type="Text" id="txtSentDate" name="txtSentDate" style="width:200px" class="ui-multiselect ui-widget ui-state-default ui-corner-all"> <br/>
				<label style="display: inline-block; width:100px; padding:5px 2px 6px 2px;">Định kỳ gửi</label>
				<select id="slperiod" name="slperiod" style="width:200px" class="ui-multiselect ui-widget ui-state-default ui-corner-all">
					<option value="0">Chỉ gửi 1 lần</option>
					<option value="1">Hàng ngày</option>
					<option value="2">Hàng tuần</option>
					<option value="3">Hàng tháng</option>
					<option value="4">Hàng năm</option>
				</select>
				<br/> <br/>
					<input id="issendnow" name="issendnow" type="hidden" value="0" />
				<input id="btsave" onclick="return checkbeforesubmit();" style="width:100px;align:center" value="Lưu Cài đặt" type="submit"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
					<input id="btsend" onclick="if(checkbeforesend()) form.submit();" style="width:100px;align:center" value="Gửi thư ngay" type="button"  class="ui-multiselect ui-widget ui-state-default ui-corner-all" />
				<a href='<?php echo base_url()?>index.php/member/newsletter/listnewsletter'>Về lại danh sách</a>
					<div style="forecolor:red">
						<?php if(isset($statussetup) && $statussetup!="") echo $statussetup; ?>
					</div>
			</td>
			<td valign='top' style='padding-left:20px'>
				<label style="padding:5px 2px 6px 2px;">Gửi thư đến danh mục</label><br/>
				 
				<table><tr><td>
						<select class='sel' id='rightSelect' name='slcatergories[]' multiple style='line-height:27px; height:200px; width:200px;'>
					</select>
				</td><td style="padding-left:20px;padding-right:20px">
					<input type='button' value='<< Thêm' onclick='move(0)' style="width:80px" class="ui-multiselect ui-widget ui-state-default ui-corner-all">
					<br/><br/>
					<input type='button' value='Bớt >>' onclick='move(1)' style="width:80px" class="ui-multiselect ui-widget ui-state-default ui-corner-all">
				</td>
				<td>
						<select class='sel' id='leftSelect' name='slcater'  multiple style='line-height:27px; height:200px; width:200px;'>
						<option value="-1" selected >---Không thuộc danh mục nào---</option>
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
				</td></tr></table>
			</td></tr></table>
		</form>
			Đã hoàn thành việc tạo thư gửi. Bấm <a href='<?php echo base_url()?>index.php/member/newsletter/listnewsletter'>vào đây</a> để xem danh sách thử gửi của bạn 
		</div>
		
	</p>	
</div>
