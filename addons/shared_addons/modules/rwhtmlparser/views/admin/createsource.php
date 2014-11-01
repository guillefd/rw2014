<section class="title">
	<h4><?php echo lang('rwhtmlparser:createsource'); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php echo form_open('admin/rwhtmlparser/create'); ?>
		<div class="form_inputs">
			<fieldset>
				<ul>
					<li>
						<label for="title"><?php echo lang('rwhtmlparser:sourcetype') ?> <span>*</span></label>
						<div class="input"><?php echo form_dropdown('sourcetype', array(''=>'') + $sourcetypes, $postvalues['sourcetype'], ''); ?></div>
					</li>
					<li>
						<label for="title"><?php echo lang('rwhtmlparser:uri') ?> <span>*</span></label>
						<div class="input"><?php echo form_input('uri', $postvalues['uri'], 'style="width:80%"') ?></div>
						<small>http://www.domain.com</small>
					</li>
					<li>
						<label for="title"><?php echo lang('rwhtmlparser:htmlelement') ?> <span></span></label>
						<div class="input"><?php echo form_input('htmlelement', $postvalues['htmlelement'], '') ?></div>
						<label for="title"><?php echo lang('rwhtmlparser:htmlelementparam') ?> <span></span></label>
						<div class="input"><?php echo form_input('htmlelementparam', $postvalues['htmlelementparam'], '') ?></div>
					</li>					
					<li>
						<div class="input"><button type="submit" class="btn blue">Run parser</button></div>
					</li>
				</ul>
			</fieldset>	
		</div>
		<?php echo form_close(); ?>
	</div>

	<div class="content">
		<?php if(isset($parser->result)): ?>	
		<h4>Nodes found for element: <b><?php echo $postvalues['htmlelement']; ?></b></h4>
		<div class="margin-bottom-10"></div>				
			<?php 
					//init
					$nodeslug['topnode'] = $postvalues['htmlelement'];
					$nodeSub = 0; 
			?>
			<?php echo form_open('admin/rwhtmlparser/createparsertemplate'); ?>			
			<?php foreach($parser->result['nodes'] as $node): ?>
				<?php $selector = $postvalues['htmlelement']; ?>			
				<table class="createsourceform">
				<tr class="nodetitle">
					<td colspan="3">---- Node ----</td>
					<td colspan="2"></td>
				</tr>
				<tr class="nodetitle">
					<th width="10%">tag</th>
					<th>plainText</th>
					<th>innerText</th>
					<th></th>
					<th></th>							
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
							<p>{ 0 attr }</p>	
						<?php endif; ?>
					</td>
					<td>
						<?php echo $node->plaintext!='' ? substring($node->plaintext, 800) : '<small>%empty plaintext%</small>'; ?>
					</td>
					<td>
						<?php echo htmlspecialchars(substring($node->innertext)); ?>
					</td>
<!-- ###### end MAIN Node -->
<!-- #################### -->
					<!-- Selector -->
					<td>
						<label>Selector</label><br>
						<?php echo $nodeslug['topnode']; ?> 
					</td>
					<!-- end selector -->

					<!-- map -->
					<td>

					</td>
					<!-- end map -->
				</tr>			
				<?php foreach($node->children as $child): ?>
					<?php $nodeSub++; ?>	
						<tr class="childrentitle2">
							<td colspan="3"> ---- Child Node [ <?php echo $child->tag; ?> ] </td>
							<td colspan="2"> </td> 
						</tr>
						<tr class="childrentitle2">
							<th width="15%">tag <em>[attribute] {value}</em></th>
							<th>plainText</th>
							<th>outertext / innertext</th>
							<th>Selector & condition</th>
							<th>Mapping</th>							
						</tr>
						<tr class="childrencontent2">
<!-- ############### -->
<!-- ### Nodes SUB 1 -->	
							<td>
								<?php 
									echo $child->tag;
									$nodeslug['childnode'] = $child->tag; 
								?>
								<?php foreach($child->attr as $attr=>$value): ?>	
										<p>[<?php echo htmlspecialchars($attr); ?>] {<?php echo htmlspecialchars($value); ?>}</p>
								<?php endforeach; ?>
							</td>
							<td>
								<textarea class="input-form" name="">
									<?php echo trim($child->plaintext); ?>
								</textarea>
							</td>
							<td>
								<textarea class="input-form" name="">
									<?php echo htmlspecialchars($child->outertext); ?>
								</textarea>
								<textarea class="input-form" name="">
									<?php echo htmlspecialchars($child->innertext); ?>
								</textarea>
							</td>
							<!-- Selector -->
							<?php $selector.= ' '.$child->tag; ?>
							<td>
								<label>Node: <?php echo $nodeslug['topnode'].' '.$nodeslug['childnode']; ?></label>
								<br>
								<input class="input-form" type="checkbox" name="childnode[]" value="<?php echo $nodeslug['childnode']; ?>"> 
									Include
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
							</td>
							<!-- end selector -->

							<!-- map -->
							<td>
								<label>Map parse to content block</label>
								<br>
								<select class="input-form" name="contentblockselector[]" style="width:200px">
									<option>Select content block</option>
									<?php foreach($content_blocks as $block_slug=>$block_name): ?>
										<option value="<?php echo $block_slug; ?>"><?php echo $block_name ?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<!-- end map -->
						</tr>
<!-- ###### end Node SUB 1 -->
<!-- ##################### -->
						<tr>
							<td colspan="5"></td>
						</tr>	
				<?php endforeach; ?>					
				<!-- end NODE -->	
				</table>				
			<?php endforeach; ?>
				<input type="submit" value="Generate template">
			<?php echo form_close(); ?>		
		<?php else: ?>
			<h4><?php echo lang('rwhtmlparser:parser_result_empty'); ?></h4>
		<?php endif; ?>			
	</div>
</section>