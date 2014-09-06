<section class="title">
	<h4><?php echo lang('letmeknow:item_list'); ?></h4>
</section>

<section class="item">
	<?php echo form_open('admin/letmeknow/delete');?>
	
	<?php if (!empty($items)): ?>
	
		<table>
			<thead>
				<tr>
					<th><?php echo lang('letmeknow:date'); ?></th>
					<th><?php echo lang('letmeknow:email'); ?></th>                                       
					<th><?php echo lang('letmeknow:ip_address'); ?></th>  
					<th><?php echo lang('letmeknow:user_agent'); ?></th>  					                                                                             
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
					<td><?php echo $item->email; ?></td>
                    <td><?php echo $item->ip_address ?></td> 
                    <td><?php echo $item->user_agent ?></td>                                                            
					<td class="actions">
						<?php echo
						anchor('admin/letmeknow/edit/'.$item->id, lang('letmeknow:edit'), 'class="btn orange"').' '.                                                                                                         
						anchor('admin/letmeknow/delete/'.$item->id, lang('letmeknow:delete'), 'class="confirm btn red delete"'); ?>                                         
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('letmeknow:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
</section>
