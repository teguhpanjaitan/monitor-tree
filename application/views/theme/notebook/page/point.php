<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Pohon</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">Pohon</h3>
</div>
<section class="panel panel-default">
	<header class="panel-heading">
		<a href="#new-data" class="btn btn-success" data-toggle="modal">Tambah Data</a>
	</header>
	<div class="table-responsive">
		<table id="satker" class="table table-striped b-t b-light" data-ride="datatables">
			<thead>
				<tr>
					<th width="7%">No</th>
					<th width="20%">Jenis Pohon</th>
					<th width="20%">Segmen</th>
					<th width="20%">Prediksi Tinggi (m)</th>
					<th width="15%">Limit Tinggi (m)</th>
					<th width="20%">Posisi</th>
					<th width="18%"></th>
				</tr>
			</thead>
		</table>
	</div>
</section>

<div class="modal fade" id="new-data">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="m-t-none m-b">Data Point Baru</h3>
						<form role="form" action="<?php echo base_url("point") ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>Nama Jenis Pohon</label>
								<select name="id_jenis_pohon" class="form-control" required>
									<option value="">Pilih Jenis Pohon</option>
									<?php foreach ($jenis_pohon as $jenis) : ?>
										<option value="<?= $jenis->id ?>"><?= $jenis->name ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label>Segmen</label>
								<input type="text" name="segmen" value="" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Tanggal Pengukuran</label>
								<input type="date" name="tanggal" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Tinggi Pengukuran (Saat Ini) dalam Meter</label>
								<input type="number" name="tinggi" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Limit Tinggi dalam Meter</label>
								<input type="number" name="limit_tinggi" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Latitude</label>
								<input type="number" name="latitude" class="form-control" step=".000000001" required>
							</div>
							<div class="form-group">
								<label>Longitude</label>
								<input type="number" name="longitude" class="form-control" step=".000000001" required>
							</div>
							<input type="hidden" name="table" value="point">
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
						<h3 class="m-t-none m-b">Edit Point</h3>
						<form role="form" action="<?php echo base_url("point") ?>" method="post" enctype="multipart/form-data">
							<select name="id_jenis_pohon" class="form-control" required>
								<option value="">Pilih Jenis Pohon</option>
								<?php foreach ($jenis_pohon as $jenis) : ?>
									<option value="<?= $jenis->id ?>"><?= $jenis->name ?></option>
								<?php endforeach ?>
							</select>
							<div class="form-group">
								<label>Segmen</label>
								<input type="text" name="segmen" value="" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Tanggal Pengukuran</label>
								<input type="date" name="tanggal" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Tinggi Pengukuran (Saat Ini) dalam Meter</label>
								<input type="number" name="tinggi" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Limit Tinggi dalam Meter</label>
								<input type="number" name="limit_tinggi" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Latitude</label>
								<input type="number" name="latitude" class="form-control" step=".000000001" required>
							</div>
							<div class="form-group">
								<label>Longitude</label>
								<input type="number" name="longitude" class="form-control" step=".000000001" required>
							</div>
							<input type="hidden" id="edit_id" name="ID">
							<input type="hidden" name="table" value="point">
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
			<form role="form" method="post" action="<?php echo base_url("point") ?>" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Hapus Point</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding:10px">
						<div class="col-sm-12">
							<p>Apakah yakin ingin menghapus <b id="message_confirm_delete"></b> ?</p>

							<input type="hidden" id="delete_id" name="id" value="">
							<input type="hidden" name="table" value="point">
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

<?php
global $template;
$template->footer_add = "
<script src='" . base_url("assets/notebook/") . "/js/datatables/jquery.dataTables.min.js'></script>

<script>
jQuery('#satker').dataTable({
	'processing': true,
	'serverSide': true,
	'ajax': '" . base_url("ajax/act/point") . "',
	'sDom': " . '"' . "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>" . '"' . ",
	'sPaginationType': 'full_numbers',
	'columnDefs': [ { targets: -1, orderable: false } ]
});
</script>
";
?>

<script>
	var temp;

	function edit(id) {
		$.ajax({
			url: '<?php echo base_url("ajax/act/get_items") ?>',
			dataType: 'json',
			data: {
				'id': id,
				'table': 'point'
			}
		}).done(function(result) {
			$("#edit_id").val(id);
			$("#edit input[name='segmen']").val(result.segmen);
			$("#edit input[name='tanggal']").val(result.tanggal);
			$("#edit input[name='tinggi']").val(result.tinggi);
			$("#edit input[name='limit_tinggi']").val(result.limit_tinggi);
			$("#edit input[name='latitude']").val(result.latitude);
			$("#edit input[name='longitude']").val(result.longitude);

			$("#edit select[name='id_jenis_pohon'] option").each(function() {
				$(this).removeAttr("selected");
				tmp = $(this).val();
				if (tmp == result.id_jenis_pohon) {
					$(this).attr("selected", "selected");
				}
			});
		}).fail(function() {
			alert("Gagal mengambil detail data satuan kerja")
		});
	}

	function confirm_delete(id) {
		$.ajax({
			url: '<?php echo base_url("ajax/act/get_items") ?>',
			dataType: 'json',
			data: {
				'id': id,
				'table': 'point'
			}
		}).done(function(result) {
			$("#delete_id").val(id);
			$("#message_confirm_delete").html(result.name);
		}).fail(function() {
			alert("fail")
		});
	}
</script>