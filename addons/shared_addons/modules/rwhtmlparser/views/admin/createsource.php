<section class="title">
	<h4><?php echo lang('rwhtmlparser:createsource'); ?></h4>
</section>

<section class="item">
	<div class="content">
		<?php echo $this->load->view('admin/inc_createsource_target.php'); ?>
	</div>
	<div class="content">
		<?php if(isset($nodes)): ?>		
		<h2>Parse result for element: <b><?php echo $postvalues['htmlelement']; ?></b>
			<small>
				<br>Source type: <b><?php echo $postvalues['sourcetype']; ?></b>
				<br>URL: <b><?php echo $postvalues['uri']; ?></b>
				<br>Total <em><?php echo $postvalues['htmlelement']; ?></em> nodes: <b><?php echo count($nodes); ?></b>
				<br>Total <em><?php echo $postvalues['htmlelement']; ?></em> children nodes: <b><?php echo $count; ?></b>
			</small>
		</h2>		
		<hr>
		<div class="margin-bottom-10"></div>		
			<?php echo $this->load->view('admin/inc_createsource_nodetable'); ?>
		<?php else: ?>
			<h4><?php echo lang('rwhtmlparser:parser_result_empty'); ?></h4>
		<?php endif; ?>			
	</div>
</section>