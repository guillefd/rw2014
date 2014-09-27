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
				<?php foreach($node->children as $child): ?>
					<?php $selector = $postvalues['htmlelement']; ?>
					<?php $nodeIndex++; ?>	
					<table>
						<tr class="modetitle">
							<td colspan="3">---- Node ----</td>
							<td colspan="2"></td>
						</tr>
						<tr class="nodetitle">
							<th width="15%">tag</th>
							<th>plaintText</th>
							<th>innertext</th>
							<th></th>
							<th></th>							
						</tr>
						<tr class="nodecontent">
							<!-- Nodes -->
							<td>
								<?php echo $child->tag; ?>
								<?php foreach($child->attr as $attr=>$value): ?>
										<p><?php echo $attr; ?>="<?php echo $value; ?>"</p>
								<?php endforeach; ?>
							</td>
							<td><?php echo $child->plaintext!='' ? $child->plaintext : '<small>%empty%</small>'; ?></td>
							<td><?php echo htmlentities(substring($child->innertext)); ?></td>
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
						<tr class="children">
							<td colspan="3">---- Children Node ----</td>
							<td colspan="2"></td>
						</tr>	
						<?php if(count($child->children)>0): ?>
						<tr class="childtitle1">
							<th>tag</th>
							<th>plaintText</th>
							<th>attr</th>
							<th></th>
							<th></th>
						</tr>	
						<!-- CHILD NODES -->
							<?php foreach($child->children as $child1): ?>
							<tr class="childcontent1">
								<td><?php echo $child1->tag; ?></td>
								<td><?php echo $child1->plaintext; ?></td>
								<td>
								<?php if(count($child1->attr)>0): ?>
									<?php foreach($child1->attr as $attr=>$value): ?>
										<p class="child2attr"><?php echo $attr; ?>="<?php echo substring($value); ?>"</p>
									<?php endforeach; ?>
								<?php endif; ?>
								<!-- end CHILD attributes -->
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
							<tr class="childtitle1">
								<th colspan="3"><small>%empty child%</small></th>
								<th colspan="2"></th>
							</tr>	
							<!-- end CHILD NODES -->
						<?php endif; ?>
							<!-- end nodes -->			
						</table>
					<div class="margin-bottom-20"></div>	
				<?php endforeach; ?>
				<?php
						// re init 
						$nodeIndex = 0;
						$childNodeIndex = 0; 
				?>						
				<!-- end NODE -->	
			<?php endforeach; ?>
		<?php else: ?>
			<h4><?php echo lang('rwhtmlparser:parser_result_empty'); ?></h4>
		<?php endif; ?>			
	</div>
</section>