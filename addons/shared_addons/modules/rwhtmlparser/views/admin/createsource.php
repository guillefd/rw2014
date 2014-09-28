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
					$nodeIndex = 0;
					$childNodeIndex = 0; 
			?>

			<?php foreach($parser->result['nodes'] as $node): ?>
				<?php $selector = $postvalues['htmlelement']; ?>			
				<table>
				<tr class="nodetitle">
					<td colspan="3">---- Node ----</td>
					<td colspan="2"></td>
				</tr>
				<tr class="nodetitle">
					<th width="15%">tag</th>
					<th>plainText</th>
					<th>innerText</th>
					<th></th>
					<th></th>							
				</tr>
				<tr class="nodecontent">
					<!-- Nodes -->
					<td>
						<?php echo $node->tag; ?>
						<?php foreach($node->attr as $attr=>$value): ?>
								<p><?php echo $attr; ?>="<?php echo $value; ?>"</p>
						<?php endforeach; ?>
					</td>
					<td><?php echo $node->plaintext!='' ? substring($node->plaintext, 800) : '<small>%empty plaintext%</small>'; ?></td>
					<td><?php echo htmlspecialchars(substring($node->innertext)); ?></td>
					<!-- end Nodes -->

					<!-- Selector -->
					<td>
						<label>Selector</label><br>
						<input type="text" name="" value="<?php echo $selector; ?>"> 
					</td>
					<!-- end selector -->

					<!-- map -->
					<td>

					</td>
					<!-- end map -->
				</tr>
				<?php foreach($node->children as $child): ?>
					<?php $nodeIndex++; ?>	
						<tr class="childrentitle1">
							<td colspan="3"> ---- Child1 Node ---- </td>
							<td colspan="2"> </td> 
						</tr>
						<tr class="childrentitle1">
							<th width="15%">tag</th>
							<th>plainText</th>
							<th>innerText</th>
							<th></th>
							<th></th>							
						</tr>
						<tr class="childrencontent1">
							<!-- Nodes -->
							<td>
								<?php echo $child->tag; ?>
								<?php foreach($child->attr as $attr=>$value): ?>
										<p><?php echo htmlspecialchars($attr); ?><?php echo htmlspecialchars($value); ?></p>
								<?php endforeach; ?>
							</td>
							<td><?php echo $child->plaintext!='' ? $child->plaintext : '<small>%empty children1%</small>'; ?></td>
							<td><?php echo htmlspecialchars(substring($child->innertext)); ?></td>
							<!-- end Nodes -->

							<!-- Selector -->
							<?php $selector.= ' '.$child->tag; ?>
							<td>
								<label>Selector</label><br>
								<input type="text" name="" value="<?php echo $selector; ?>"> 
							</td>
							<!-- end selector -->

							<!-- map -->
							<td>

							</td>
							<!-- end map -->
						</tr>
						<tr class="childrentitle2">
							<td colspan="3">---- Child2 Node ----</td>
							<td colspan="2"></td>
						</tr>	
						<?php if(count($child->children)>0): ?>
						<tr class="childrentitle2">
							<th>tag</th>
							<th>plaintText</th>
							<th>attr</th>
							<th></th>
							<th></th>
						</tr>	
						<!-- CHILD NODES -->
							<?php foreach($child->children as $child1): ?>
							<tr class="childrencontent2">
								<td><?php echo $child1->tag; ?></td>
								<td><?php echo $child1->plaintext; ?></td>
								<td>
								<!-- attributes -->
								<?php if(count($child1->attr)>0): ?>
									<?php foreach($child1->attr as $attr=>$value): ?>
										<p class="childrenattr"><?php echo $attr; ?>="<?php echo htmlentities(substring($value)); ?>"</p>
									<?php endforeach; ?>
								<?php endif; ?>
								<!-- end attributes -->
								</td>
								<!-- Selector -->
								<td>
									<label>Selector</label><br>
									<input type="text" name="" value="<?php echo $selector.' '.$child1->tag; ?>"> 
								</td>
								<!-- end selector -->

								<!-- map -->
								<td>

								</td>
								<!-- end map -->
							</tr>		 
							<?php endforeach; ?>
						<?php else: ?>
							<tr class="childrentitle2">
								<th colspan="3"><small>%empty children2%</small></th>
								<th colspan="2"></th>
							</tr>	
							<!-- end CHILD NODES -->
						<?php endif; ?>
							<!-- end nodes -->			
						<tr>
							<td colspan="5"></td>
						</tr>	
				<?php endforeach; ?>
				<?php
						// re init 
						$nodeIndex = 0;
						$childNodeIndex = 0; 
				?>						
				<!-- end NODE -->	
				</table>				
			<?php endforeach; ?>
		<?php else: ?>
			<h4><?php echo lang('rwhtmlparser:parser_result_empty'); ?></h4>
		<?php endif; ?>			
	</div>
</section>