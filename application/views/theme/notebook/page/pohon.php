<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Pohon</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">Pohon</h3>
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
					<th style="min-width:100px">Jenis Pohon</th>
					<th style="min-width:100px">Segmen</th>
					<th style="min-width:100px">Posisi</th>
					<th style="min-width:100px">Tinggi</th>
					<th style="max-width:50px"></th>
				</tr>
			</thead>
		</table>
	</div>
</section>

<div class="modal fade" id="confirm-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" method="post" action="<?php echo base_url("pohon") ?>" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Hapus Pohon</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding:10px">
						<div class="col-sm-12">
							<p>Apakah yakin ingin menghapus <b id="message_confirm_delete"></b> ?</p>

							<input type="hidden" id="delete_id" name="id" value="">
							<input type="hidden" name="table" value="pohon">
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
	'ajax': '" . base_url("ajax/act/pohon") . "',
	'sDom': " . '"' . "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>" . '"' . ",
	'sPaginationType': 'full_numbers',
	'columnDefs': [ { targets: -1, orderable: false },{ targets: 3, orderable: false } ]
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
				'table': 'pohon'
			}
		}).done(function(result) {
			$("#edit_id").val(id);
			$("#edit input[name='tanggal_pohon']").val(result.tanggal_pohon);
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
				'table': 'pohon'
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