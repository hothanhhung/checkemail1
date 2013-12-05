<div style="padding: 0px 10px 10px 10px">
	<p>
		<div id="title">
			<h1>Danh sách các trang tĩnh</h1>		
		</div>
		
			<font size="2">
			<table class="listview" width="100%">
			<tr>
					<th width="10px"><input type="checkbox" onchange="checkboxcontactschange(this);"/></th>
					<th width="10px">STT</th>
					<th width="200px">Tên</th>
					<th>Tiêu đề</th>
					<th width="100px">Ngày Tạo</th>					
					<th width="100px">Ngày cập nhật</th>	
					<th width="100px"></th>								
			</tr>
		<?php
			$n=0;
			foreach($generallist as $element){
				$n++;
			?>
				<tr>
					<td><input type="checkbox" name="storedemailcheck" value="<?php echo $element['ID'];?>" title="<?php echo $element['Name'];?>" /></td>
					<td align="right"><?php echo $n;?></div>
					<td><?php echo $element['Name'];?></td>
					<td><?php echo $element['Title'];?></td>
					<td align="center"><?php echo $element['CreatedDate'];?></td>
					<td align="center"><?php echo $element['UpdatedDate'];?></td>
					
					<td align="center">
						<div>							
							<a style="text-decoration:none;" href="<?php echo base_url()?>index.php/manager/general/edit/?ID=<?php echo $element['ID']; ?>">
								<img width="24px" height="24px" src="<?php echo base_url()?>img/actions/edit-content.png" title="Chính sửa liên lạc này" />
							</a>
						</div>
					</td>
			</tr>
			<?php
			} ?>
			</table></font>
	</p>
</div>
