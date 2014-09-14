<section class="title">
	<h4><?php echo lang('rwhtmlparser:items_list'); ?></h4>
</section>

<section class="item">
	<div class="content">
	<?php echo form_open('admin/rwhtmlparser/delete');?>
	
	<?php if(!empty($items)): ?>
	
		<table>
			<thead>
				<tr>
					<th><?php echo lang('rwhtmlparser:date'); ?></th> 					                                                                             
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $items as $item ): ?>
				<tr>
					<td><?php echo date("d-m-Y",$item->date); ?></td>                                                           
					<td class="actions">
						<?php echo
						anchor('admin/rwhtmlparser/edit/'.$item->id, lang('rwhtmlparser:edit'), 'class="btn orange"').' '.                                                                                                         
						anchor('admin/rwhtmlparser/delete/'.$item->id, lang('rwhtmlparser:delete'), 'class="confirm btn red delete"'); ?>                                         
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('rwhtmlparser:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
	</div>
</section>