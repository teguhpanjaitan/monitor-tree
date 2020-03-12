<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Pohon</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">Bulk Import</h3>
</div>
<section class="panel panel-default">
	<header class="panel-heading">
		Pilih file :
		<input type="file" name="file" required/>
	</header>
</section>

<?php 
global $template; 
$template->footer_add = "
<script src='".base_url("assets/notebook/")."/js/datatables/jquery.dataTables.min.js'></script>

<script>
</script>
";