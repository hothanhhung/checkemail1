<div style="padding: 0px 10px 10px 10px">
	<p>
		<div id="title">
			<h1>Cấu hình service gửi thư</h1>		
		</div>
		
		<script type="text/javascript">	
			function btRunServiceChange_Click()
			{
				$('#status-editemailconfig').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
				xhr = $.ajax({
				type: "POST",
				url: "<?php echo base_url()?>index.php/manager/servicesendemail/run"
				});
				// .done(function( msg ) {
					// if(msg.ErrorCode=="0"){
						
						// alert(msg.Infor);
						// window.open(window.location.pathname,"_self");
					// }
					// else {
						// $('#status-editemailconfig').html('<b>'+msg.Infor+'</b>');
					// }
				// }) 
				// .fail(function(mgs) {
					// $('#status-editemailconfig').html('<b>Lỗi kết nối server</b>'+mgs);
				// });
				setTimeout(function() {
					// if(xhr && xhr.readyState != 4){
						// xhr.abort();
					// }
					window.open(window.location.pathname,"_self");
					}, 3000);
			}
			
			function btResetServiceChange_Click()
			{
				$('#status-editemailconfig').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
				$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>index.php/manager/servicesendemail/reset",
				dataType: "json"
				})
				.done(function( msg ) {
					if(msg.ErrorCode=="0"){
						alert(msg.Infor);
						window.open(window.location.pathname,"_self");
					}else{
						$('#status-editemailconfig').html('<b>'+msg.Infor+'</b>');
					}
				})
				.fail(function() {
					$('#status-editemailconfig').html('<b>Lỗi kết nối server</b>');
				});
			}
			
			function btStopServiceChange_Click()
			{
				$('#status-editemailconfig').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
				$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>index.php/manager/servicesendemail/stop",
				dataType: "json"
				})
				.done(function() {
					window.open(window.location.pathname,"_self");
				})
				.fail(function() {
					$('#status-editemailconfig').html('<b>Lỗi kết nối server</b>');
				});
			}
			
			function btCycleEmailConfigEdit_Click()
			{
				$('#status-editemailconfig').html('<img border="0" alt="" src="<?php echo base_url()?>/img/loading_circle.gif"></img>');
				$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>index.php/manager/servicesendemail/settimesleep",
				data: { second: $('#txtCycleEmailConfig').val()},
				dataType: "json"
				})
				.done(function( msg ) {
					if(msg.ErrorCode=="0"){
						//
						alert(msg.Infor);
						<?php if(isset ($IsRunning) && $IsRunning==true) { ?>
						alert("Hãy chạy service khác để chạy cấu hình mới.\nService cũ đang bị dừng");
						<?php } ?>
						window.open(window.location.pathname,"_self");
					}
					else {
						$('#status-editemailconfig').html('<b>'+msg.Infor+'</b>');
					}
				}) 
				.fail(function() {
					$('#status-editemailconfig').html('<b>Lỗi kết nối server</b>');
				});
			}
		</script>	
		
		<div style="padding:5px 5px 5px 5px; border:1px solid;border-radius:5px;border-color:gray;background-color:#ffsfef; " align="center">
			Thời gian thay đổi cuối cùng <b><?php echo $LastConfig ?></b>. Chu kỳ chạy <b><?php echo $TimeSleep ?></b> giây.<br/>
			Hiện tại <b><?php if(isset ($IsRunning) && $IsRunning==true) echo "đang hoạt động"; else echo "không hoạt động"?></b><br/>
			<input id="txtCycleEmailConfig" name="txtCycleEmailConfig" type="text" value="<?php echo $TimeSleep ?>" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
			<input id="btCycleEmailConfigEdit" value="Thay đổi chu kỳ" type="button" onclick="btCycleEmailConfigEdit_Click(); return false;" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/><br/>
			<input id="btStopServiceChange" name="btStopServiceChange" value="Dừng service" style="display:<?php if(isset ($IsRunning) && $IsRunning==true) echo "inline"; else echo "none"?>" type="button" onclick="btStopServiceChange_Click(); return false;" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
			<input id="btRunServiceChange" name="btRunServiceChange" value="Chạy service" style="display:<?php if(isset ($IsRunning) && $IsRunning==true) echo "none"; else echo "inline"?>" type="button" onclick="btRunServiceChange_Click(); return false;" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
			<input id="btRunServiceNow"  name="btRunServiceNow" value="Chạy service khác" style="display:<?php if(isset ($IsRunning) && $IsRunning==true) echo "inline"; else echo "none"?>"  type="button" onclick="btRunServiceChange_Click(); return false;" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
			<input id="btResetServiceNow"  name="btResetServiceNow" value="reset service" type="button" onclick="btResetServiceChange_Click(); return false;" class="ui-multiselect ui-widget ui-state-default ui-corner-all"/>
			<div name="status-editemailconfig" id="status-editemailconfig" style="color:red;font-size: 0.9em;">
			</div>
		</div>
	</p>
	<p>
		<div id="title">
			<h1>Lịch sử các hoạt động của services</h1>		
		</div>
		<div>
			<font size="2">
				<table class="listview" width="100%">
					<tr>
							<th width="10px">STT</th>
							<th width="150px">ID</th>
							<th width="150px">Chạy lúc</th>
							<th width="150px">Chu kỳ (giây)</th>
							<th width="100px">Trạng Thái</th>					
							<th width="100px">Trạng Thái cập nhật</th>							
					</tr>
				<?php
					$n=0;
					if(isset($listServices))
						for($i=count($listServices); $i>0; $i--){
							$ser = $listServices[$i - 1];
							$n++;
						?>
							<tr>
								<td align="right"><?php echo $n;?></div>
								<td><?php echo $ser['ID'];?></td>
								<td align="center"><?php echo $ser['RunAt'];?></td>
								<td align="right"><?php echo $ser['Cycle'];?></td>
								<td align="center" style='<?php if($ser['Status']=="Started") echo "background-color:Green";else echo "";?>'><b><?php echo $ser['Status'];?></b></td>
								<td align="center"><?php echo $ser['StatusChangeAt'];?></td>
						</tr>
						<?php
						} 
						?>
				</table>
			</font>
		</div>
	</p>
</div>
