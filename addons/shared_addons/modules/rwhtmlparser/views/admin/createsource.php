<section class="title">
	<h4><?php echo lang('rwhtmlparser:createsource'); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php echo $this->load->view('admin/inc_createsource_target.php'); ?>
	</div>
	<div class="content">
		<?php if(isset($nodes)): ?>
			<?php echo form_open('admin/rwhtmlparser/createparsertemplate'); ?>		
			<h2>Parse result for element: <b><?php echo $postvalues['htmlelement']; ?></b></h2>
			<div class="input-field">
				<label>Source type</label>
				<input name="sourcetype" type="text" value="<?php echo $postvalues['sourcetype']; ?>" readonly="readonly">
			</div>
			<div class="input-field">
				<label>URL</label>
				<input name="uri" type="text" value="<?php echo $postvalues['uri']; ?>" readonly="readonly" style="width:75%">
			</div>
			<div class="input-field">
				<label>Node</label>
				<input name="node" type="text" value="<?php echo $postvalues['htmlelement']; ?>" readonly="readonly">
			</div>
			<br>Total <em><?php echo $postvalues['htmlelement']; ?></em> nodes: <b><?php echo count($nodes); ?></b>
			<br>Total <em><?php echo $postvalues['htmlelement']; ?></em> children nodes: <b><?php echo $count; ?></b>		
			<hr>
			<div class="margin-bottom-10"></div>			
			<?php echo $this->load->view('admin/inc_createsource_nodetable'); ?>
			<?php echo form_close(); ?>	
		<?php else: ?>
			<h4><?php echo lang('rwhtmlparser:parser_result_empty'); ?></h4>
		<?php endif; ?>			
	</div>
</section>