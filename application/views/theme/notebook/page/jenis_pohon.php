<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Jenis Pohon</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">Jenis Pohon</h3>
</div>
<section class="panel panel-default">
	<header class="panel-heading">
		<a href="#new-data" class="btn btn-success" data-toggle="modal">Tambah Data</a>
	</header>
	<div class="table-responsive">
		<table id="satker" class="table table-striped b-t b-light" data-ride="datatables">
			<thead>
				<tr>
					<th width="10%">ID</th>
					<th width="20%">Nama</th>
					<th width="20%">Meter / Month</th>
					<th width="10%"></th>
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
jQuery('#satker').dataTable({
	'processing': true,
	'serverSide': true,
	'ajax': '".base_url("ajax/act/jenis_pohon")."',
	'sDom': ".'"'."<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>".'"'.",
	'sPaginationType': 'full_numbers',
	'columnDefs': [ { targets: -1, orderable: false } ]
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
		data:{'id':id,'table':'jenis_pohon'}
	}).done(function(result) {
		$("#edit_id").val(id);
		$("#edit input[name='name']").val(result.name);
		$("#edit input[name='meter_per_month']").val(result.meter_per_month);
	}).fail(function() { alert("Gagal mengambil detail data satuan kerja") });
}

function confirm_delete(id){
	$.ajax({
		url:'<?php echo base_url("ajax/act/get_items") ?>',
		dataType: 'json',
		data:{'id':id,'table':'jenis_pohon'}
	}).done(function(result) {
		$("#delete_id").val(id);
		$("#message_confirm_delete").html(result.name);
	}).fail(function() { alert("fail") });
}

</script>

<div class="modal fade" id="new-data">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				  <div class="row">
						<div class="col-sm-12">
							<h3 class="m-t-none m-b">Data Jenis Pohon Baru</h3>
							<form role="form" action="<?php echo base_url("jenis_pohon") ?>" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label>Nama</label>
									<input type="text" name="name" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Meter / Month</label>
									<input type="number" name="meter_per_month" class="form-control" step=".01" required>
								</div>
								<input type="hidden" name="table" value="jenis_pohon">
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
							<h3 class="m-t-none m-b">Edit Jenis Pohon</h3>
							<form role="form" action="<?php echo base_url("jenis_pohon") ?>" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label>Nama</label>
									<input type="text" name="name" class="form-control" required>
								</div>
								<div class="form-group">
									<label>Meter / Month</label>
									<input type="number" name="meter_per_month" class="form-control" step=".01" required>
								</div>
								<input type="hidden" id="edit_id" name="ID">
								<input type="hidden" name="table" value="jenis_pohon">
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
			<form role="form" method="post" action="<?php echo base_url("jenis_pohon") ?>" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title">Hapus Jenis Pohon</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding:10px">
						<div class="col-sm-12">
							<p>Apakah yakin ingin menghapus <b id="message_confirm_delete"></b> ?</p>
						
							<input type="hidden" id="delete_id" name="id" value="">
							<input type="hidden" name="table" value="jenis_pohon">
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