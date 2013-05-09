<?php if ($tracking): ?>
	<table class="default">
		<thead>
			<tr>
				<th width="120">Date</th>
				<th>Name</th>
				<th>Referer</th>
				<th>Last Page</th>
				<th>Hits</th>			
			</tr>
		</thead>
		<?php
			$i=0;
			foreach($tracking as $visit):
			$style = '';
			$class = ($i % 2) ? 'alt' : ''; $i++;			
			if (strtotime($visit['date']) >= strtotime('-2 minutes')) $style = 'background: #FFFCDF;';
		?>
		<?php
			// get userdata
			$userdata = @unserialize($visit['userdata']);
		?>
		<tbody>
			<tr class="<?php echo $class; ?>" style="<?php echo $style; ?>">
				<td><?php echo dateFmt($visit['date'], '', '', TRUE); ?></td>
				<td>
					<?php if ($visit['userdata']): ?>
						<?php echo anchor('/admin/users/edit/'.$userdata['userID'], $userdata['firstName'].' '.$userdata['lastName']); ?>
					<?php else: ?>
						Guest
					<?php endif; ?>
				</td>
				<td><?php echo ($visit['referer']) ? anchor($visit['referer'], htmlentities($visit['referer'])) : 'Direct (no referrer)'; ?></td>
				<td><?php echo $visit['lastPage']; ?></td>
				<td><?php echo $visit['views']+1; ?></td>
			</tr>
		</tbody>
		<?php endforeach; ?>
	</table>
<?php else: ?>

	<p>Nothing has happened yet!</p>
	
<?php endif; ?>
