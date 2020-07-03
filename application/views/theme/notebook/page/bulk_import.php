<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Bulk Import</a></li>
</ul>
<div class="m-b-md">
	<h3 class="m-b-none">Bulk Import</h3>
</div>
<section class="panel panel-default">
	<header class="panel-heading">
		Import Data Inspeksi
	</header>
	<div class="table-responsive" style="padding:20px">
		<div id="flot-placeholder" style="height:400px">
			<div class="col-sm-10">
				<form role="form" action="" method="post" enctype="multipart/form-data">
					<p style="font-weight:bolder">Data yang akan di-upload adalah format csv</p>
					<p style="font-weight:bolder">Baris pertama akan diabaikan, maka bisa dijadikan sebagai header tabel</p>
					<p style="font-weight:bolder">Silahkan mengikuti format : "No.;Jenis Pohon;Alamat;Penyulang;LOCATION 1;LOCATION 2;NO TIANG 1;NO TIANG 2;Tanggal Inspeksi;Tinggi pengukuran (M);Limit tinggi (M);Posisi Pohon dari hutm terdekat (M);rekomendasi metode rintis;Posisi ujung pohon/dahan"</p>
					<br>
					<div class="form-group">
						<label>Input File</label>
						<input type="file" name="file" class="form-control" required>
					</div>
					<input type="hidden" name="act" value="import"><br>
					<button type="submit" class="btn btn-sm btn-success pull-left text-uc m-t-n-xs"><strong>Tambahkan</strong></button>
				</form>
				<div style="clear:both"></div>
				<?php if (isset($errors)) : ?>
					<br>
					<?php if (!empty($errors)) : ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<i class="fa fa-ban-circle"></i>
							<?php
							foreach ($errors as $error) {
								echo $error . "<br>";
							}
							?>
						</div>
					<?php else : ?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<i class="fa fa-ok-sign"></i>
							Data berhasil di Import
						</div>
					<?php endif ?>
				<?php endif ?>
			</div>
		</div>
	</div>
</section>

<?php
global $template;
$template->footer_add = "";
