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

			<?php foreach($parser->result['nodes'] as $node): ?>
				<?php $selector = $postvalues['htmlelement']; ?>			
				<table class="createsourceform">
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

					<!-- Selector -->
					<td>
						<label>Selector</label><br>
						<input type="text" name="" value="<?php echo $nodeslug['topnode']; ?>"> 
					</td>
					<!-- end selector -->

					<!-- map -->
					<td>

					</td>
					<!-- end map -->
				</tr>
				<?php foreach($node->children as $child): ?>
					<?php $nodeSub++; ?>	
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
<!-- ### Nodes SUB 1 -->
							<td>
								<?php 
									echo $child->tag;
									$nodeslug['childnode'] = $child->tag; 
								?>
								<?php foreach($child->attr as $attr=>$value): ?>	
										<p><?php echo htmlspecialchars($attr); ?><?php echo htmlspecialchars($value); ?></p>
								<?php endforeach; ?>
							</td>
							<td>
								<textarea class="input-form" name="">
									<?php echo trim($child->plaintext); ?>
								</textarea>
							</td>
							<td>
								<textarea class="input-form" name="">
									<?php echo htmlspecialchars($child->innertext); ?>
								</textarea>
							</td>
<!-- ###### end Node SUB 1 -->

							<!-- Selector -->
							<?php $selector.= ' '.$child->tag; ?>
							<td>
								<input type="checkbox" name="" value="<?php echo $nodeslug['topnode'].' '.$nodeslug['childnode']; ?>"> <?php echo $nodeslug['topnode'].' '.$nodeslug['childnode']; ?>
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

						<?php else: ?>
							<tr class="childrentitle2">
								<th colspan="3"><small>%empty children2%</small></th>
								<th colspan="2"></th>
							</tr>	
							<!-- end CHIL -->
						<?php endif; ?>
							<!-- end nodes -->			
						<tr>
							<td colspan="5"></td>
						</tr>	
				<?php endforeach; ?>					
				<!-- end NODE -->	
				</table>				
			<?php endforeach; ?>
		<?php else: ?>
			<h4><?php echo lang('rwhtmlparser:parser_result_empty'); ?></h4>
		<?php endif; ?>			
	</div>
</section>