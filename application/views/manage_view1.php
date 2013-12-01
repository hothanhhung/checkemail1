<script src="<?php echo base_url()?>js/jquery-2.0.3.min.js"></script>
<a href="<?php echo base_url()?>index.php/manage/checkemailrecods">check email records</a>
<br/>
<?php
	if(isset($checkemailrecods))
	{
	?>
		<table>
			<tr>
				<td>ID</td><td>From IP</td><td>User Name</td><td>Checked Email</td><td>Check Date</td><td>Status</td>
			</tr>

			<?php
			foreach ($checkemailrecods as $row)
			{
			?>
			<tr>
				<td><?php echo $row['ID']?></td><td><?php echo $row['FromIP']?></td><td><?php echo $row['UserName']?></td>
				<td><?php echo $row['CheckedEmail']?></td><td><?php echo $row['CheckDate']?></td><td><?php echo $row['Status']?></td>
			</tr>
			<?php
			}
			?>
		</table>
	<?php
	}
?>