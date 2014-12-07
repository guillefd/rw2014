<section class="title">
	<h4>Template Map</h4>
</section>

<section class="item">
	<div class="content">
		<h2><?php echo $map->name; ?></h2>
		<p>Source type: <?php echo $map->type; ?></p>
		<p>Domain: <?php echo $map->domain; ?></p>
		<p>Node: <?php echo $map->node; ?></p>
		<p>Created: <?php echo mdate('%d-%m-%Y', $map->created_on); ?></p>
		<h4><b>Rules</b></h4>
		<table class="indexitems">
			<tr>
				<th>childnode</th>
				<th>required</th>
				<th>property</th>
				<th>only not empty</th>
				<th>keyword filter</th>
				<th>negative keyword</th>
				<th>map to content</th>
			</tr>
			<?php foreach($rules as $rule): ?>
			<tr>
				<td><?php echo $rule->childnode; ?></td>
				<td><?php echo $rule->required; ?></td>
				<td><?php echo $rule->nodepropertyselector; ?></td>
				<td><?php echo $rule->condition_notempty; ?></td>
				<td><?php echo $rule->condition_keywordyesvalue; ?></td>
				<td><?php echo $rule->condition_keywordnovalue; ?></td>
				<td><?php echo $rule->contentblockselector; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>	
	</div>
</section>