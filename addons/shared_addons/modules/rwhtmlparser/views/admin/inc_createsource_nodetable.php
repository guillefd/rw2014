	<?php foreach($nodes as $node): ?>		
	<table class="createsourceform">
		<tr class="nodetitle">
			<td colspan="2">NODE [ <?php echo $node->tag; ?> ] [ <?php echo $node->order; ?> ]</td>
		</tr>
		<tr class="nodetitle">
			<th width="10%">tag
			<th>plainText / innerText</th>					
		</tr>
		<tr class="nodecontent">
<!-- ############# -->
<!-- ### MAIN Node -->
			<td>
				<?php echo $node->tag; ?>
				<?php if(count($node->attr)>0): ?>
					<?php foreach($node->attr as $attr=>$value): ?>
						<p><?php echo '['.$attr.']'; ?> <?php echo '{'.substring($value, 20).'}'; ?></p>
					<?php endforeach; ?>
				<?php else: ?>
					<p>{ no attr }</p>	
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


<!-- ############### -->
<!-- ### Nodes SUB 1 -->								
		<?php foreach($node->childnodes as $childtag=>$childnodeArr): ?>
				<tr class="childrentitle2">
					<td colspan="2"> NODE [ <?php echo $node->tag; ?>] [ <?php echo $node->order; ?> ]
									 > Child Node [ <?php echo $childtag; ?>  (<?php echo count($childnodeArr); ?>) ]</td>
				</tr>
				<tr class="childrentitle2">
					<th width="15%">tag <em>[attribute] {value}</em> plaintext / outertext / innertext</th>
					<th>Include and Map</th>			
				</tr>
				<tr class="childrencontent2">
					<!-- childnode -->
					<td width="75%">
						<?php foreach($childnodeArr as $childnode): ?>
							<!-- tag > attr -->
							<div class="childnodetag">
								<b><?php echo $childnode->tag; ?></b>
								<?php if(count($childnode->attr)>0): ?>
									<ul>	
									<?php foreach($childnode->attr as $attr=>$value): ?>	
										<li>[<?php echo htmlspecialchars($attr); ?>]<br></<span>{<?php echo htmlspecialchars($value); ?>}</span></li>
									<?php endforeach; ?>
									</ul>
								<?php else: ?>
									<em><br>{ no attributes }</em>
								<?php endif; ?>
								<?php if(isset($childnode->child2nodes)): ?>
									<br><p><em>Childnodes</em>:<br>
									<?php foreach($tagsArr[$childnode->tag] as $targettag=>$count): ?>
										<?php if($targettag!=$childnode->tag): ?>
											<b><?php echo $targettag; ?></b><br>
										<?php endif; ?>	
									<?php endforeach; ?>
									</p>
								<?php endif; ?>
							</div>
							<div class="childnodetext">
								<!-- plaintext -->
								<div class="textarea">
									<small><em>Node property</em>: plaintext</small><br>
									<textarea class="input-form" name=""><?php echo trim($childnode->plaintext); ?></textarea>
								</div>
								<!-- outertext -->
								<div class="textarea">
									<small><em>Node property</em>: outertext</small><br>
									<textarea class="input-form" name=""><?php echo htmlspecialchars($childnode->outertext); ?></textarea>
								</div>	
								<!-- innertext -->
								<div class="textarea">
									<small><em>Node property</em>: innertext</small><br> 
									<textarea class="input-form" name=""><?php echo htmlspecialchars($childnode->innertext); ?></textarea>
								</div>
							</div>
							<br>
						<?php endforeach; ?>	
					</td>
					<!-- end childnode --> 
					<!-- Selector -->
					<td class="childnode">
						<div class="selector">
							<h3><b>Select & Map</b></h3>
							<?php foreach($tagsArr[$childnode->tag] as $targettag=>$count): ?>
								<?php $targettagfixed = str_replace(' ', '-', $targettag); ?>
									<hr>	
									<label class="checkbox-lg">
										<input class="input-form" type="checkbox" name="childnode[<?php echo $node->order; ?>][]" value="<?php echo $targettag; ?>">
										<span>Include <em><?php echo $targettag; ?> (<?php echo $count; ?>)</em></span>
									</label>
									<label class="checkbox-lg">
										<input class="input-form" type="checkbox" name="required[<?php echo $node->order; ?>][<?php echo $targettagfixed; ?>]" value="1">
										<span>Required for parsing</span>
									</label>
									<div class="input-field">
										<label class="label-select">Property</label>
										<select class="input-form" name="nodepropertyselector[<?php echo $node->order; ?>][<?php echo $targettagfixed; ?>]" style="width:150px">
											<option value="">select</option>
											<?php foreach($node_properties as $property_slug): ?>
												<option value="<?php echo $property_slug; ?>"><?php echo $property_slug ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="input-field">
										<input type="checkbox" name="condition[notempty][<?php echo $node->order; ?>][<?php echo $targettagfixed; ?>]" value="1">
										<label>ONLY if not empty</label> 
									</div>
									<div class="input-field">
										<label>keywords</label>
										<input type="text" name="condition[keywordyesvalue][<?php echo $node->order; ?>][<?php echo $targettagfixed; ?>]" value="">
									</div>
									<div class="input-field">
										<label>no keywords</label> 
										<input type="text" name="condition[keywordnovalue][<?php echo $node->order; ?>][<?php echo $targettagfixed; ?>]" value="">
									</div>
									<div class="input-field">
										<label class="label-select">Map to:</label>
										<select class="input-form" name="contentblockselector[<?php echo $node->order; ?>][<?php echo $targettagfixed; ?>]" style="width:150px">
											<option value="">Select block</option>
											<?php foreach($content_blocks as $block_slug=>$block_name): ?>
												<option value="<?php echo $block_slug; ?>"><?php echo $block_name ?></option>
											<?php endforeach; ?>
										</select>
									</div>		
							<?php endforeach; ?>
						</div>					
					</td>
					<!-- end map -->
				</tr>
<!-- ###### end Node SUB 1 -->
<!-- ##################### -->
				<tr>
					<td colspan="2"></td>
				</tr>	
		<?php endforeach; ?>					
		<!-- end NODE -->	
		</table>				
	<?php endforeach; ?>
	<input class="btn blue large" type="submit" value="Generate Parse Map template">