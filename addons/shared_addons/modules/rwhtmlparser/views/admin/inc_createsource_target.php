<?php echo form_open('admin/rwhtmlparser/create'); ?>
<div class="form_inputs">
	<fieldset>
		<ul>
			<li>
				<label for="title"><?php echo lang('rwhtmlparser:mapname') ?> <span></span></label>
				<div class="input"><?php echo form_input('mapname', $postvalues['mapname'], '') ?></div>
			</li>	
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