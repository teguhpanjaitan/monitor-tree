<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Eksekusi</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">Eksekusi</h3>
</div>
<section class="panel panel-default">
	<header class="panel-heading">
		&nbsp;
	</header>
	<div class="table-responsive">
		<table id="satker" class="table table-striped b-t b-light" data-ride="datatables">
			<thead>
				<tr>
					<th style="min-width:60px">No</th>
					<th style="min-width:100px">Jenis<br>Pohon</th>
					<th style="min-width:120px">Posisi</th>
					<th style="min-width:80px">Metode Rintis</th>
					<th style="min-width:100px">Bentangan</br>Pohon</th>
					<th style="min-width:120px">Eksekusi<br>Terakhir</th>
					<th style="min-width:90px">Eksekusi</br>Selanjutnya</th>
					<th style="min-width:100px"></th>
				</tr>
			</thead>
		</table>
	</div>
</section>

<div class="modal fade" id="edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="m-t-none m-b">Edit Eksekusi</h3>
						<form role="form" action="<?php echo base_url("eksekusi") ?>" method="post" enctype="multipart/form-data">
							<select name="id_jenis_pohon" class="form-control" required>
								<option value="">Pilih Jenis Pohon</option>
								<?php foreach ($jenis_pohon as $jenis) : ?>
									<option value="<?= $jenis->id ?>"><?= $jenis->name ?></option>
								<?php endforeach ?>
							</select>
							<div class="form-group">
								<label>Inspeksi</label>
								<select id="edit-inspeksi" name="inspeksi" style="width:100%" required>
									<option value="">Pilih Inspeksi</option>
								</select>
							</div>
							<div class="form-group">
								<label>Tanggal eksekusi</label>
								<input type="date" name="tanggal_eksekusi" class="form-control">
							</div>
							<div class="form-group">
								<label>Metode rintis</label>
								<input type="number" name="metode_rintis" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Bentangan pohon</label>
								<input type="number" name="bentangan_pohon" class="form-control" step=".01" required>
							</div>
							<div class="form-group">
								<label>Keterangan Tambahan</label>
								<textarea class="form-control" name="keterangan"></textarea>
							</div>
							<input type="hidden" id="edit_id" name="ID">
							<input type="hidden" name="table" value="eksekusi">
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
			<form role="form" method="post" action="<?php echo base_url("eksekusi") ?>" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Hapus Eksekusi</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding:10px">
						<div class="col-sm-12">
							<p>Apakah yakin ingin menghapus <b id="message_confirm_delete"></b> ?</p>

							<input type="hidden" id="delete_id" name="id" value="">
							<input type="hidden" name="table" value="eksekusi">
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
	'ajax': '" . base_url("ajax/act/eksekusi") . "',
	'sDom': " . '"' . "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>" . '"' . ",
	'sPaginationType': 'full_numbers',
	'columnDefs': [ { targets: -1, orderable: false },{ targets: 2, orderable: false } ]
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
				'table': 'inspeksi'
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