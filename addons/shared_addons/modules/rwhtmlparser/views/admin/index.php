<section class="title">
	<h4><?php echo lang('rwhtmlparser:items_list'); ?></h4>
</section>

<section class="item">
	<div class="content">
	<?php echo form_open('admin/rwhtmlparser/delete');?>
	
	<?php if(!empty($items)): ?>
	
		<table class="indexitems">
			<thead>
				<tr>
					<th>Name</th> 					                                                                             
					<th>Source type</th>
					<th>Domain</th>
					<th>Feeds</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $items as $item ): ?>
				<tr>
					<td><a href="<?php echo base_url().'admin/rwhtmlparser/viewtemplate/'.$item->id; ?>"><?php echo $item->name; ?></a></td>
					<td><?php echo $item->type; ?></td>
					<td><?php echo $item->domain; ?></td>
					<td></td>                                                           
					<td class="actions">
						<?php echo anchor('admin/rwhtmlparser/delete/'.$item->id, 'delete', 'class="confirm btn red delete"'); ?>                                         
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>			
		</table>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('rwhtmlparser:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
	</div>
</section>