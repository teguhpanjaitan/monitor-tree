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
					<th style="min-width:60px">No</th>
					<th style="min-width:120px">Jenis Pohon</th>
					<th style="min-width:120px">Segmen</th>
					<th style="min-width:85px">Tinggi</th>
					<th style="min-width:120px">Posisi</th>
					<th style="min-width:110px">Bentangan</th>
					<th style="min-width:120px">Penanganan</th>
					<th style="min-width:110px">Ket.</th>
					<th style="min-width:100px">Gambar</th>
					<th style="min-width:50px"></th>
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
								<label>Tanggal Pengukuran</label>
								<input type="date" name="tanggal" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Tinggi Pengukuran Saat Ini (M)</label>
								<input type="number" name="tinggi" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Tiang 1</label>
								<!-- <input type="number" name="latitude" class="form-control" step=".000000001" required> -->
								<select id="new-tiang1" name="tiang1" style="width:100%" required>
									<option value="">Input Tiang 1</option>
								</select>
							</div>
							<div class="form-group">
								<label>Tiang 2</label>
								<!-- <input type="number" name="longitude" class="form-control" step=".000000001" required> -->
								<select id="new-tiang2" name="tiang2" style="width:100%" required>
									<option value="">Input Tiang 2</option>
								</select>
							</div>
							<div class="form-group">
								<label>Bentangan Pohon (M)</label>
								<input type="number" class="form-control" name="bentangan" step="0.01" required/>
							</div>
							<div class="form-group">
								<label>Penanganan Pohon</label>
								<select name="penanganan" class="form-control" required>
									<option value="">Pilih Penanganan</option>
									<option value="Tebang kandas">Tebang kandas</option>
									<option value="Rabas-rabas">Rabas-rabas</option>
									<option value="Diracun">Diracun</option>
								</select>
							</div>
							<div class="form-group">
								<label>Keterangan Tambahan</label>
								<textarea class="form-control" name="keterangan"></textarea>
							</div>
							<div class="form-group">
								<label>Foto</label>
								<input type="file" name="image" class="form-control">
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
								<label>Tanggal Pengukuran</label>
								<input type="date" name="tanggal" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Tinggi Pengukuran Saat Ini (M)</label>
								<input type="number" name="tinggi" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Tiang 1</label>
								<!-- <input type="number" name="latitude" class="form-control" step=".000000001" required> -->
								<select id="edit-tiang1" name="tiang1" style="width:100%" required>
									<option value="">Input Tiang 1</option>
								</select>
							</div>
							<div class="form-group">
								<label>Tiang 2</label>
								<!-- <input type="number" name="longitude" class="form-control" step=".000000001" required> -->
								<select id="edit-tiang2" name="tiang2" style="width:100%" required>
									<option value="">Input Tiang 2</option>
								</select>
							</div>
							<div class="form-group">
								<label>Bentangan Pohon (M)</label>
								<input type="number" class="form-control" name="bentangan" step="0.01" required/>
							</div>
							<div class="form-group">
								<label>Penanganan Pohon</label>
								<select name="penanganan" class="form-control" required>
									<option value="">Pilih Penanganan</option>
									<option value="Tebang kandas">Tebang kandas</option>
									<option value="Rabas-rabas">Rabas-rabas</option>
									<option value="Diracun">Diracun</option>
								</select>
							</div>
							<div class="form-group">
								<label>Keterangan Tambahan</label>
								<textarea class="form-control" name="keterangan"></textarea>
							</div>
							<div class="form-group">
								<label>Foto</label>
								<input type="file" name="image" class="form-control">
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
<link href='https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js'></script>

<script>
$( document ).ready(function() {
	$('#new-tiang1').select2({
		minimumInputLength: 5,
		ajax: {
			delay: 800,
			url: '" .  base_url("ajax/act/dropdown_tiang") . "',
			dataType: 'json'
		}
	});
	$('#new-tiang2').select2({
		minimumInputLength: 5,
		ajax: {
			delay: 800,
			url: '" .  base_url("ajax/act/dropdown_tiang") . "',
			dataType: 'json'
		}
	});
	$('#edit-tiang1').select2({
		minimumInputLength: 5,
		ajax: {
			delay: 800,
			url: '" .  base_url("ajax/act/dropdown_tiang") . "',
			dataType: 'json'
		}
	});
	$('#edit-tiang2').select2({
		minimumInputLength: 5,
		ajax: {
			delay: 800,
			url: '" .  base_url("ajax/act/dropdown_tiang") . "',
			dataType: 'json'
		}
	});
});

jQuery('#satker').dataTable({
	'processing': true,
	'serverSide': true,
	'ajax': '" . base_url("ajax/act/point") . "',
	'sDom': " . '"' . "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>" . '"' . ",
	'sPaginationType': 'full_numbers',
	'columnDefs': [ { targets: -1, orderable: false },{ targets: -2, orderable: false },{ targets: -6, orderable: false } ]
});
</script>
";
?>

<script>
	var temp;

	function edit(id) {
		toggle_edit();
		$.ajax({
			url: '<?php echo base_url("ajax/act/get_items") ?>',
			dataType: 'json',
			data: {
				'id': id,
				'table': 'point'
			}
		}).done(function(result) {
			$("#edit_id").val(id);
			$("#edit input[name='tanggal']").val(result.tanggal);
			$("#edit input[name='tinggi']").val(result.tinggi);

			$("#edit-tiang1").select2("trigger", "select", {
				data: {
					id: result.tiang1,
					text: result.tiang1
				}
			});
			$("#edit-tiang2").select2("trigger", "select", {
				data: {
					id: result.tiang2,
					text: result.tiang2
				}
			});

			$("#edit input[name='bentangan']").val(result.bentangan);
			$("#edit select[name='penanganan']").val(result.penanganan);
			$("#edit textarea[name='keterangan']").val(result.keterangan);

			$("#edit select[name='id_jenis_pohon'] option").each(function() {
				$(this).removeAttr("selected");
				tmp = $(this).val();
				if (tmp == result.id_jenis_pohon) {
					$(this).attr("selected", "selected");
				}
			});

			toggle_edit();
		}).fail(function() {
			alert("Gagal mengambil detail data");
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

	function toggle_edit() {
		var disabled = $("#edit input").attr("disabled");

		if (disabled === "disabled") {
			$("#edit input, #edit select, #edit textarea").removeAttr("disabled");
		} else {
			$("#edit input, #edit select, #edit textarea").attr("disabled", "disabled");
		}
	}
</script>

<style>
	.table img.image {
		max-width: 150px;
	}
</style>