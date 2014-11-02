<?php echo form_open('admin/rwhtmlparser/createparsertemplate'); ?>			
	<?php foreach($nodes as $node): ?>
	<?php $selector = $node->tag; ?>			
	<table class="createsourceform">
		<tr class="nodetitle">
			<td colspan="3">NODE [ <?php echo $node->tag; ?> ] [ <?php echo $node->order; ?> ]</td>
			<td colspan="1"></td>
		</tr>
		<tr class="nodetitle">
			<th width="10%">tag</th>
			<th>plainText</th>
			<th>innerText</th>
			<th>Include & Map</th>					
		</tr>
		<tr class="nodecontent">
<!-- ############# -->
<!-- ### MAIN Node -->
			<td>
				<?php echo $node->tag; ?>
				<?php if(count($node->attr)>0): ?>
					<?php foreach($node->attr as $attr=>$value): ?>
						<p><?php echo '['.$attr.']'; ?> <?php echo '{'.$value.'}'; ?></p>
					<?php endforeach; ?>
				<?php else: ?>
					<p>{ no attr }</p>	
				<?php endif; ?>
			</td>
			<td>
				<?php echo $node->plaintext!='' ? substring($node->plaintext, 800) : '<small>%empty plaintext%</small>'; ?>
			</td>
			<td>
				<?php echo htmlspecialchars(substring($node->innertext)); ?>
			</td>
			<!-- Include and select -->
			<td>
				<label>Selector</label><br>
				<?php echo $node->tag; ?> 
			</td>
			<!-- end include and select -->
		</tr>	
				<tr>
					<td colspan="4"></td>
				</tr>	
<!-- ###### end MAIN Node -->
<!-- #################### -->


<!-- ############### -->
<!-- ### Nodes SUB 1 -->								
		<?php foreach($node->childnodes as $childtag=>$childnodeArr): ?>
				<tr class="childrentitle2">
					<td colspan="4"> NODE [ <?php echo $node->tag; ?> ] [ <?php echo $node->order; ?> ]
									 > Child Node [ <?php echo $childtag; ?> ] [ <?php echo count($childnodeArr); ?> ]</td>
				</tr>
				<tr class="childrentitle2">
					<th width="15%">tag <em>[attribute] {value}</em></th>
					<th colspan="2">plaintext / outertext / innertext</th>
					<th>Include and Map</th>			
				</tr>
				<tr class="childrencontent2">
					<!-- childnode -->
					<td colspan="3">
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
					<?php $selector.= ' '.$childtag; ?>
					<td class="childnode">
						<div class="selector">
							<h3><b>Select & Map</b>
							</h3>
							<label class="checkbox-lg">
								<input class="input-form" type="checkbox" name="childnode[]" value="<?php echo $childnode->tag; ?>">
								<span>Include <em><?php echo $childtag; ?></em></span>
							</label>
							<label class="checkbox-lg">
								<input class="input-form" type="checkbox" name="childnode[]" value="<?php echo $childnode->tag; ?>">
								<span>Required for parsing</span>
							</label>
							<hr>
							<h4>Copy property:</h4>
							<select class="input-form" name="nodepropertyselector[]" style="width:150px">
								<option value="">Select property</option>
								<?php foreach($node_properties as $property_slug): ?>
									<option value="<?php echo $property_slug; ?>"><?php echo $property_slug ?></option>
								<?php endforeach; ?>
							</select>
							<div class="margin-bottom-10"></div>
							<h4>If property is:</h4>
							<input type="checkbox" name="condition[notempty][]" value="1" checked="checked"> not empty 
							<br>
							<div class="margin-bottom-10"></div>
							<label>has this keyword</label> 
							<input type="text" name="condition[keywordyesvalue][]" value="">
							<br>
							<div class="margin-bottom-10"></div>
							<label>Does not have this keywords</label> 
							<input type="text" name="condition[keywordnovalue][]" value="">
							<div class="margin-bottom-10"></div>
							<hr>
							<h4>Map property to:</h4>
							<select class="input-form" name="contentblockselector[]" style="width:200px">
								<option>Select content block</option>
								<?php foreach($content_blocks as $block_slug=>$block_name): ?>
									<option value="<?php echo $block_slug; ?>"><?php echo $block_name ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</td>
					<!-- end map -->
				</tr>
<!-- ###### end Node SUB 1 -->
<!-- ##################### -->
				<tr>
					<td colspan="4"></td>
				</tr>	
		<?php endforeach; ?>					
		<!-- end NODE -->	
		</table>				
	<?php endforeach; ?>
	<input type="submit" value="Generate template">
<?php echo form_close(); ?>	