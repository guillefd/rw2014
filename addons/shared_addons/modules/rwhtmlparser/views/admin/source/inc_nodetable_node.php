<!-- ############# -->
<!-- ### MAIN Node -->
		<tr class="nodetitle">
			<td colspan="2"><?php echo $node->tagstring; ?></td>
		</tr>
		<tr class="nodetitle">
			<th width="10%">tag
			<th>plainText / innerText</th>					
		</tr>
		<tr class="nodecontent">
			<td>
				<?php echo $node->tag; ?>
				<?php if(count($node->attr)>0): ?>
					<?php foreach($node->attr as $attr=>$value): ?>
						<p><?php echo '['.$attr.']'; ?> <?php echo '{'.substring($value, 20).'}'; ?></p>
					<?php endforeach; ?>
				<?php else: ?>
					<p><?php echo STR_NOATTR; ?></p>	
				<?php endif; ?>
			</td>
			<td>
				<?php echo wordwrap(htmlspecialchars(substring($node->outertext)), 50, '<br>', true); ?>
			</td>
		</tr>	
		<tr>
			<td colspan="2"></td>
		</tr>	
<!-- ###### end MAIN Node -->
<!-- #################### -->
