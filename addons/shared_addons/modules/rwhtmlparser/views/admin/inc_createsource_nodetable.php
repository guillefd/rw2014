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
					<th>plainText</th>
					<th>outertext / innertext</th>
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
							<!-- plaintext -->
							<textarea class="input-form" name=""><?php echo trim($childnode->plaintext); ?></textarea>
							<!-- outertext -->
							<textarea class="input-form" name=""><?php echo htmlspecialchars($childnode->outertext); ?></textarea>
							<!-- innertext --> 
							<textarea class="input-form" name=""><?php echo htmlspecialchars($childnode->innertext); ?></textarea>
							<br>
						<?php endforeach; ?>	
					</td>
					<!-- end childnode -->
					<!-- Selector -->
					<?php $selector.= ' '.$childtag; ?>
					<td class="childnode">
						<div class="selector">
							<h5><b>Include, filter and map</b>
								<br>Node: <?php echo $node->tag.' '.$childtag; ?>
							</h5>
							<br>
							<label class="checkbox-lg">
								<input class="input-form" type="checkbox" name="childnode[]" value="<?php echo $childnode->tag; ?>">
								<span>Include <em><?php echo $childtag; ?></em></span>
							</label>
							<br>
							<label>Node property to parse</label>
							<br>
							<select class="input-form" name="nodepropertyselector[]" style="width:150px">
								<option value="">Select property</option>
								<?php foreach($node_properties as $property_slug): ?>
									<option value="<?php echo $property_slug; ?>"><?php echo $property_slug ?></option>
								<?php endforeach; ?>
							</select>
							<div class="margin-bottom-10"></div>
							<label class="label">Conditions</label>
							<br>
							<input type="checkbox" name="condition[notempty][]" value="1" checked="checked"> Not empty 
							<br>
							<input type="checkbox" name="condition[keywordyes][]" value="1"> Required keyword 
							<input type="text" name="condition[keywordyesvalue][]" value="">
							<br>
							<input type="checkbox" name="condition[keywordno][]" value="1"> Keyword not present 
							<input type="text" name="condition[keywordnovalue][]" value="">
							<br>
							<div class="margin-bottom-10"></div>
							<hr>
							<label>Map parse to content block</label>
							<br>
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