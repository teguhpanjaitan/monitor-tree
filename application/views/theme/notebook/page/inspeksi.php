<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Inspeksi</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">Inspeksi</h3>
</div>
<section class="panel panel-default">
	<header class="panel-heading">
		<a href="#new-data" class="btn btn-success" data-toggle="modal">Tambah Data</a>
		<a href="<?= base_url("inspeksi/download") ?>" class="btn btn-info">Download</a>
	</header>
	<div class="table-responsive">
		<table id="satker" class="table table-striped b-t b-light" data-ride="datatables">
			<thead>
				<tr>
					<th style="min-width:60px">No</th>
					<th style="min-width:100px">Tanggal</th>
					<th style="min-width:100px">Jenis<br>Pohon</th>
					<th style="min-width:120px">Posisi</th>
					<th style="min-width:80px">Tinggi<br>Pengukuran</th>
					<th style="min-width:100px">HUTM<br>terdekat</th>
					<th style="min-width:120px">Rekomendasi<br>Penanganan</th>
					<th style="min-width:90px">Ujung<br>Pohon</th>
					<th style="min-width:110px">Ket.</th>
					<th style="min-width:100px">Gambar</th>
					<th style="min-width:100px"></th>
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
						<h3 class="m-t-none m-b">Data Inspeksi Baru</h3>
						<form role="form" action="<?php echo base_url("inspeksi") ?>" method="post" enctype="multipart/form-data">
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
								<label>No. Tiang 1</label>
								<!-- <input type="number" name="latitude" class="form-control" step=".000000001" required> -->
								<select id="new-tiang1" name="tiang1" style="width:100%" required>
									<option value="">Input Nomor Tiang 1</option>
								</select>
							</div>
							<div class="form-group">
								<label>No. Tiang 2</label>
								<!-- <input type="number" name="longitude" class="form-control" step=".000000001" required> -->
								<select id="new-tiang2" name="tiang2" style="width:100%" required>
									<option value="">Input Nomor Tiang 2</option>
								</select>
							</div>
							<div class="form-group">
								<label>Tanggal Pengukuran (Biarkan kosong utk tanggal sekarang)</label>
								<input type="date" name="tanggal_inspeksi" class="form-control">
							</div>
							<div class="form-group">
								<label>Tinggi Pengukuran Saat Ini (M)</label>
								<input type="number" name="tinggi_pengukuran" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Posisi pohon dari HUTM terdekat (M)</label>
								<input type="number" class="form-control" name="jarak_hutm_terdekat" step="0.01" required />
							</div>
							<div class="form-group">
								<label>Posisi ujung pohon/dahan</label>
								<input type="text" class="form-control" name="ujung_pohon" />
							</div>
							<div class="form-group">
								<label>Rekomendasi metode rintis</label>
								<select name="rekomendasi_penanganan" class="form-control" required>
									<option value="">Pilih Penanganan</option>
									<option value="tebang kandas">Tebang kandas</option>
									<option value="rabas-rabas">Rabas-rabas</option>
									<option value="diracun">Diracun</option>
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
							<input type="hidden" name="table" value="inspeksi">
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
						<h3 class="m-t-none m-b">Edit Inspeksi</h3>
						<form role="form" action="<?php echo base_url("inspeksi") ?>" method="post" enctype="multipart/form-data">
							<select name="id_jenis_pohon" class="form-control" required>
								<option value="">Pilih Jenis Pohon</option>
								<?php foreach ($jenis_pohon as $jenis) : ?>
									<option value="<?= $jenis->id ?>"><?= $jenis->name ?></option>
								<?php endforeach ?>
							</select>
							<div class="form-group">
								<label>No. Tiang 1</label>
								<!-- <input type="number" name="latitude" class="form-control" step=".000000001" required> -->
								<select id="edit-tiang1" name="tiang1" style="width:100%" required>
									<option value="">Input Nomor Tiang 1</option>
								</select>
							</div>
							<div class="form-group">
								<label>No. Tiang 2</label>
								<!-- <input type="number" name="longitude" class="form-control" step=".000000001" required> -->
								<select id="edit-tiang2" name="tiang2" style="width:100%" required>
									<option value="">Input Nomor Tiang 2</option>
								</select>
							</div>
							<div class="form-group">
								<label>Tanggal Pengukuran (Biarkan kosong utk tanggal sekarang)</label>
								<input type="date" name="tanggal_inspeksi" class="form-control">
							</div>
							<div class="form-group">
								<label>Tinggi Pengukuran Saat Ini (M)</label>
								<input type="number" name="tinggi_pengukuran" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Posisi pohon dari HUTM terdekat (M)</label>
								<input type="number" class="form-control" name="jarak_hutm_terdekat" step="0.01" required />
							</div>
							<div class="form-group">
								<label>Posisi ujung pohon/dahan</label>
								<input type="text" class="form-control" name="ujung_pohon" />
							</div>
							<div class="form-group">
								<label>Rekomendasi metode rintis</label>
								<select name="rekomendasi_penanganan" class="form-control" required>
									<option value="">Pilih Penanganan</option>
									<option value="tebang kandas">Tebang kandas</option>
									<option value="rabas-rabas">Rabas-rabas</option>
									<option value="diracun">Diracun</option>
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
							<input type="hidden" name="table" value="inspeksi">
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
			<form role="form" method="post" action="<?php echo base_url("inspeksi") ?>" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Hapus Inspeksi</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding:10px">
						<div class="col-sm-12">
							<p>Apakah yakin ingin menghapus <b id="message_confirm_delete"></b> ?</p>

							<input type="hidden" id="delete_id" name="id" value="">
							<input type="hidden" name="table" value="inspeksi">
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
		minimumInputLength: 3,
		ajax: {
			delay: 800,
			url: '" .  base_url("ajax/act/dropdown_tiang") . "',
			dataType: 'json'
		}
	});
	$('#new-tiang2').select2({
		minimumInputLength: 3,
		ajax: {
			delay: 800,
			url: '" .  base_url("ajax/act/dropdown_tiang") . "',
			dataType: 'json'
		}
	});
	$('#edit-tiang1').select2({
		minimumInputLength: 3,
		ajax: {
			delay: 800,
			url: '" .  base_url("ajax/act/dropdown_tiang") . "',
			dataType: 'json'
		}
	});
	$('#edit-tiang2').select2({
		minimumInputLength: 3,
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
	'ajax': '" . base_url("ajax/act/inspeksi") . "',
	'sDom': " . '"' . "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>" . '"' . ",
	'sPaginationType': 'full_numbers',
	'columnDefs': [ { targets: -1, orderable: false },{ targets: -2, orderable: false },{ targets: 3, orderable: false } ]
});
</script>
";
?>

<script>
	var temp;

	function edit(id) {
		toggle_edit();
		$.ajax({
			url: '<?php echo base_url("ajax/act/get_inspeksi") ?>',
			dataType: 'json',
			data: {
				'id': id
			}
		}).done(function(result) {
			$("#edit_id").val(id);
			$("#edit input[name='tanggal_inspeksi']").val(result.tanggal_inspeksi);
			$("#edit input[name='tinggi_pengukuran']").val(result.tinggi_pengukuran);

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

			$("#edit input[name='jarak_hutm_terdekat']").val(result.jarak_hutm_terdekat);
			$("#edit select[name='rekomendasi_penanganan']").val(result.rekomendasi_penanganan);
			$("#edit input[name='ujung_pohon']").val(result.ujung_pohon);
			$("#edit textarea[name='keterangan']").val(result.keterangan);
			$("#edit select[name='id_jenis_pohon']").val(result.id_jenis_pohon);

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
				'table': 'inspeksi'
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