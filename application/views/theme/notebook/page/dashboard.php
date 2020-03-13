<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
</ul>

<section class="panel panel-default">
	<header class="panel-heading font-bold">
		Dashboard
	</header>
	<div class="table-responsive" style="padding:20px">
		<div id="flot-placeholder" style="height:400px">
			<div class="row">
				<div class="col-lg-5 col-lg-offset-1 text-center">
					<!-- small box -->
					<div class="small-box bg-warning wrapper-md text-center">
						<div class="inner">
							<h3 style="margin-top:0 !important"><?= $pohon ?></h3>
							<p>Pohon dipantau</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
						<a href="/point" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>

				<div class="col-lg-5 text-center">
					<!-- small box -->
					<div class="small-box bg-danger wrapper-md text-center">
						<div class="inner">
							<h3 style="margin-top:0 !important"><?= $pohon_alert ?></h3>
							<p>Pohon harus ditangani</p>
						</div>
						<div class="icon">
							<i class="ion ion-pie-graph"></i>
						</div>
						<a href="/map" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>
		</div>
	</div>
</section>

<?php
global $template;
$template->footer_add = '<script></script>';
