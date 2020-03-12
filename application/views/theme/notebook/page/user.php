<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">User</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">List User</h3>
</div>
<section class="panel panel-default">
	<header class="panel-heading">
		<a href="#new-data" class="btn btn-danger" data-toggle="modal">Tambah User</a>
	</header>
	<div class="table-responsive">
		<table id="user" class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th style="width:26.67%">Display Name</th>
					<th style="width:26.67%">Username</th>
					<th style="width:26.67%">Status</th>
					<th style="width:20%"></th>
				</tr>
			</thead>
		</table>
	</div>
</section>

<?php 
global $template; 
$template->footer_add = "
<script src='".base_url("assets/notebook/")."/js/datatables/jquery.dataTables.min.js'></script>
<script>
jQuery('#user').dataTable({
	'processing': true,
	'serverSide': true,
	'ajax': '".base_url("ajax/act/user")."',
	'sDom': ".'"'."<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>".'"'.",
	'sPaginationType': 'full_numbers',
	'columnDefs': [ { targets: -1, orderable: false } ]
});

$('form').submit(function(event){
	if($(this).children().hasClass('has-error'))
		return false;
	else
		return true;
});
$( document ).ready(function() {
	$( '#edit-polda' ).change(function() {
	  var id_polda = $('option:selected', this).val();
	  onPoldaChange(id_polda);
	});
});
</script>
";
?>

<script>
var temp;
function edit(id){
	$.ajax({
		url:'<?php echo base_url("ajax/act/get_items") ?>',
		dataType: 'json',
		data:{'id':id,'table':'users'}
	}).done(function(result) {
		$("#edit_id").val(id);
		$("#edit input[name='display_name']").val(result.display_name);
		$("#edit input[name='username']").val(result.username);
		$("#edit input[name='username']").attr("onblur","check_username_not(this,"+ id +")");
		
		temp = result;
		$("#edit select[name='level'] option").each(function (){
			$(this).removeAttr("selected");
			tmp = $(this).val();
			if(tmp == result.level)
			{
				$(this).attr("selected","selected");
			}
		});
		
		$("#edit select[name='satker'] option").each(function (){
			$(this).removeAttr("selected");
			tmp = $(this).val();
			if(tmp == result.satker)
			{
				$(this).attr("selected","selected");
			}
		});
		
		$("#edit select[name='polda'] option").each(function (){
			$(this).removeAttr("selected");
			tmp = $(this).val();
			if(tmp == result.id_polda)
			{
				$(this).attr("selected","selected");
			}
		});
		
		onPoldaChange(result.id_polda);
		
	}).fail(function() { alert("Fail to get user detail") });
}

function confirm_delete(id){
	$.ajax({
		url:'<?php echo base_url("ajax/act/get_items") ?>',
		dataType: 'json',
		data:{'id':id,'table':'users'}
	}).done(function(result) {
		$("#delete_id").val(id);
		$("#message_confirm_delete").html(result.display_name);
	}).fail(function() { alert("Fail to get user detail") });
}

function check_username(obj){
	var name = $(obj).val();
	$.ajax({
		url:'<?php echo base_url("ajax/act/check_unique") ?>',
		dataType: 'json',
		data:{'value':name,"table":"users","field":"username"}
	}).done(function(result) {
		if(result == false)
		{
			$(obj).parent().attr("class","form-group");
			$("#uname-error").hide();
		}
		else
		{
			$(obj).parent().attr("class","form-group has-error");
			$("#uname-error").show();
			$("#uname-error").html("Username sudah ada");
		}
	}).fail(function() { alert("Fail to check username.") });
}

function check_username_not(obj,id){
	var name = $(obj).val();
	$.ajax({
		url:'<?php echo base_url("ajax/act/check_unique_not_id") ?>',
		dataType: 'json',
		data:{'value':name,"table":"users","field":"username","id":id}
	}).done(function(result) {
		if(result == false)
		{
			$(obj).parent().attr("class","form-group");
			$("#uname-error-edit").hide();
		}
		else
		{
			$(obj).parent().attr("class","form-group has-error");
			$("#uname-error-edit").show();
			$("#uname-error-edit").html("Username sudah ada");
		}
	}).fail(function() { alert("Fail to check username.") });
}

function isInArray(value, array) {
  return array.indexOf(value) > -1;
}

function onPoldaChange(id_polda){
	$.ajax({
		url:'<?php echo base_url("ajax/act/get_dropdown") ?>',
		dataType: 'json',
		data:{'val':id_polda,'field':'id_polda','table':'master_polres'}
	}).done(function(result) {
		var html = '';
		$.each(result, function(i, item) {
			html += '<option value="' + item.id + '">' + item.name + '</option>';
		});
		$("#edit select[name='polres']").removeAttr("disabled");
		$("#edit select[name='polres']").html(html);
	});
}
</script>

<div class="modal fade" id="new-data">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				  <div class="row">
						<div class="col-sm-12">
							<h3 class="m-t-none m-b">User Baru</h3>
							<form role="form" action="<?php echo base_url("user") ?>" method="post">
								<div class="form-group">
									<label>Display name</label>
									<input type="text" name="display_name" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Username</label>
									<input type="text" name="username" onblur="check_username(this)" class="form-control" required>
									<p id="uname-error" style="display:none;color:red"></p>
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="text" name="password" class="form-control" required>
								</div>
								<input type="hidden" name="table" value="users">
								<input type="hidden" name="act" value="tambah_data">
								<button type="submit" class="btn btn-sm btn-success pull-right text-uc m-t-n-xs"><strong>Tambahkan</strong></button>	
								<button type="button" style="margin-right:10px" onclick='$("#new-data").modal("hide");' class="btn btn-sm btn-warning pull-right text-uc m-t-n-xs"><strong>Batal</strong></button>
							</form>
						</div>
				  </div>          
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				  <div class="row">
						<div class="col-sm-12">
							<h3 class="m-t-none m-b">Edit User</h3>
							<form role="form" action="<?php echo base_url("user") ?>" method="post">
								<div class="form-group">
									<label>Display name</label>
									<input type="text" name="display_name" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Username</label>
									<input type="text" name="username" onblur="check_username_not(this)" class="form-control" required>
									<p id="uname-error-edit" style="display:none;color:red"></p>
								</div>
								<div class="form-group">
									<label>Password Baru</label>
									<input type="text" name="password" class="form-control">
								</div>
								<input type="hidden" id="edit_id" name="ID" value="users">
								<input type="hidden" name="table" value="users">
								<input type="hidden" name="act" value="edit_data">
								<button type="submit" class="btn btn-sm btn-success pull-right text-uc m-t-n-xs"><strong>Simpan</strong></button>	
								<button type="button" style="margin-right:10px" onclick='$("#edit").modal("hide");' class="btn btn-sm btn-warning pull-right text-uc m-t-n-xs"><strong>Batal</strong></button>
							</form>
						</div>
				  </div>          
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="confirm-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" method="post" action="<?php echo base_url("user") ?>" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">Hapus User</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding:10px">
						<div class="col-sm-12">
							<p>Apakah yakin ingin menghapus <b id="message_confirm_delete"></b> ?</p>
							<input type="hidden" id="delete_id" name="ID" value="users">
							<input type="hidden" name="id" value="">
							<input type="hidden" name="table" value="users">
							<input type="hidden" name="act" value="delete">
						</div>
					</div>          
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-danger pull-right text-uc m-t-n-xs"><strong>Hapus</strong></button>
					<button type="button" style="margin-right:10px" onclick='$("#confirm-delete").modal("hide");' class="btn btn-sm btn-warning pull-right text-uc m-t-n-xs"><strong>Batal</strong></button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>