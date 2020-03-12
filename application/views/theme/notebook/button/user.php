<div class="m-b-sm">
	<div class="btn-group btn-group-justified">
		<?php if($active == '0' && $confirm == '1'): ?>
		<a href="<?php echo base_url("user/activate/?id=$id") ?>" class="btn btn-primary btn-sm">Activate</a>
		<?php endif; ?>
		<a href="#edit" class="btn btn-warning btn-sm" data-toggle="modal" onclick="edit(<?php echo $id; ?>)">Edit</a>
		<a href="#confirm-delete" class="btn btn-danger btn-sm" data-toggle="modal" onclick="confirm_delete(<?php echo $id; ?>)">Delete</a>
	</div>
</div>