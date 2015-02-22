<?php
	define('STR_NOATTR','(--no attr--)');

?>
	<?php foreach($nodes as $node): ?>		
	<table class="createsourceform">
		<tr class="nodetitle">
			<td colspan="2"><?php echo $node->tagstring; ?></td>
		</tr>
		<tr class="nodetitle">
			<th width="10%">tag
			<th>plainText / innerText</th>					
		</tr>
<!-- ############# -->
<!-- ### MAIN Node -->
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


<!-- ############### -->
<!-- ### Nodes SUB 1 -->								
		<?php foreach($node->childnodes as $childtag=>$childnodeArr): ?>
				<?php
					# PRINT VALUES
					$node_tag_string = $node->tagstring.' > Child Node [ '.$childtag.' ( '.count($childnodeArr).' ) ]';			
				?>
				<tr class="childrentitle2">
					<td colspan="2"><?php echo $node_tag_string; ?></td>
				</tr>
				<tr class="childrentitle2">
					<th width="15%">tag <em>[attribute] {value}</em> plaintext / outertext / innertext</th>
					<th>Include and Map</th>			
				</tr>
				<tr class="childrencontent2">
					<td width="75%">
						<!-- childnode -->
						<?php foreach($childnodeArr as $childnode): ?>
							<!-- TAG -->
							<div class="childnodetag">
								<b>Childnode: </b><?php echo $node->tag; ?> <?php echo $childnode->tag; ?>
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
							<!-- attribute -->
							<?php if(count($childnode->attr)>0): ?>
								<div class="childnodetag">
									<b>Attributes for:</b> <?php echo $node->tag; ?> <?php echo $childnode->tag; ?>
								</div>
								<div class="childnodetext">
									<?php foreach($childnode->attr as $attr=>$value): ?>
									<div class="input">
										<label><?php echo $attr; ?></label>
										<input type="text" class="input-form" name="" value="<?php echo htmlspecialchars($value); ?>">	
										<input type="checkbox" name="" value="1">							
									</div>	
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<!-- end attribute -->
						<!-- end childnode -->	
						<!-- child2node -->
							<?php if(isset($childnode->child2nodes)): ?>						
								<?php foreach($childnode->child2nodes as $child2tag=>$child2nodesArr): ?>
									<?php foreach($child2nodesArr as $child2node): ?>
										<!-- TAG -->
										<div class="child2nodetag">
											<b>Child2node: </b><?php echo $node->tag; ?> <?php echo $child2node->tag; ?>
										</div>							
										<div class="child2nodetext">
											<!-- plaintext -->
											<div class="textarea">
												<small><em>Node property</em>: plaintext</small><br>
												<textarea class="input-form" name=""><?php echo trim($child2node->plaintext); ?></textarea>								
											</div>
											<!-- outertext -->
											<div class="textarea">
												<small><em>Node property</em>: outertext</small><br>
												<textarea class="input-form" name=""><?php echo htmlspecialchars($child2node->outertext); ?></textarea>
											</div>	
											<!-- innertext -->
											<div class="textarea">
												<small><em>Node property</em>: innertext</small><br> 
												<textarea class="input-form" name=""><?php echo htmlspecialchars($child2node->innertext); ?></textarea>
											</div>
										</div>
										<!-- attribute -->
										<?php if(count($child2node->attr)>0): ?>
											<div class="childnodetag">
												<b>Attributes for:</b> <?php echo $node->tag; ?> <?php echo $child2node->tag; ?>
											</div>
											<div class="childnodetext">
												<?php foreach($child2node->attr as $attr=>$value): ?>
												<div class="input">
													<label><?php echo $attr; ?></label>
													<input type="text" class="input-form" name="" value="<?php echo htmlspecialchars($value); ?>">	
													<input type="checkbox" name="" value="1">							
												</div>	
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
										<!-- end attribute -->										
									<?php endforeach; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						<!-- end child2node -->													
						<?php endforeach; ?>	
					</td>
					<!-- end childnode --> 

					<!-- ### SELECTOR ### -->
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