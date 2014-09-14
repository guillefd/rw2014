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
		<table>			
		<?php if(isset($parser->result)): ?>	
			<tr>
				<td colspan="2"><h4>Nodes found for element: <b><?php echo $postvalues['htmlelement']; ?></b></h4></td>
				<td colspan="2"><h4>Map capture</h4></td>
			</tr>			
			<?php foreach($parser->result['nodes'] as $node): ?>
				<!-- NODE -->
				<?php foreach($node->children as $child): ?>	
					<tr>
						<td width="35%">
							<table>
								<tr>
									<th><small>tag</small></th>
									<th><?php echo $child->tag; ?></th>
								</tr>
								<tr>
									<td><small>plaintext</small></td>
									<td>	
										<?php echo $child->plaintext!='' ? $child->plaintext : '<small>%empty%</small>'; ?>
									</td>
								</tr>
								<tr>
									<td><small>innertext</small></td>
									<td>
										<?php echo htmlentities(substring($child->innertext)); ?>
									</td>
								</tr>
								<tr>
									<td><small>children</small></td>
									<td>		
										<table>
											<?php if(count($child->children)>0): ?>
												<!-- CHILD NODES -->
												<?php foreach($child->children as $child1): ?>
											<tr>
												<td><small>tag</small></td>
												<td><?php echo $child1->tag; ?></td>
											</tr>
											<tr>	
												<td><small>plaintext</small></td>
												<td><?php echo $child1->plaintext; ?></td>
											</tr>
											<tr>
												<td><small>attr</small></td>
												<td>
													<table>
													<!-- CHILD attributes -->
													<?php if(count($child1->attr)>0): ?>
														<?php foreach($child1->attr as $attr=>$value): ?>
														<tr>
															<td><small><?php echo $attr; ?></small></td>
															<td><?php echo substring($value); ?></td>
														</tr>
														<?php endforeach; ?>
													<?php endif; ?>
													<!-- end CHILD attributes -->
													</table>
												</td>
											</tr>		 
												<?php endforeach; ?>
											<?php else: ?>
												<tr><td><small>%empty child%</small></td></tr>	
												<!-- CHILD NODES -->
											<?php endif; ?>
										</table>
									</td>		
								</tr>
							</table>
						</td>
						<td widht="10%"></td>
						<td></td>
					</tr>
				<?php endforeach; ?>
				<!-- end NODE -->	
			<?php endforeach; ?>
		<?php else: ?>
			<tr><td><?php echo lang('rwhtmlparser:parser_result_empty'); ?></td></tr>
		<?php endif; ?>			
		</table>
	</div>
</section>