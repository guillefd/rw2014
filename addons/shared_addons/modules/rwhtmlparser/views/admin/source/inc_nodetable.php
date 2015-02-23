<!-- ############## -->
<!-- ### MAIN Nodes -->
<?php foreach($nodes as $node): ?>		
	<table class="createsourceform">
	
	<!-- ############# -->
	<!-- ### current Node -->
	<?php include 'inc_nodetable_node.php'; ?>
	<!-- ###### end current Node -->
	<!-- #################### -->

	<!-- ############### -->
	<!-- ### childnodes -->								
	<?php include 'inc_nodetable_childnode.php'; ?>
	<!-- ###### end childnodes -->
	<!-- ##################### -->							
	
	</table>				
<?php endforeach; ?>
<!-- ### end MAIN Nodes -->		
<!-- ################## -->	