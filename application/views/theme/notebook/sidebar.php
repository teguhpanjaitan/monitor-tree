<!-- .aside -->
<aside class="bg-dark lter aside-sm hidden-print hidden-xs" id="nav">
	<section class="vbox">
		<section class="w-f scrollable">
			<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

				<!-- nav -->
				<nav class="nav-primary hidden-xs">
					<ul class="nav">
						<li <?php if ($_SERVER[REQUEST_URI] == "/") echo "class='active'" ?>>
							<a href="/">
								<i class="fa fa-dashboard icon">
									<b class="bg-warning"></b>
								</i>
								<span>Dashboard</span>
							</a>
						</li>
						<li <?php if (
								strpos($_SERVER[REQUEST_URI], 'jenis_pohon') !== false
								|| strpos($_SERVER[REQUEST_URI], 'pohon') !== false 
								|| strpos($_SERVER[REQUEST_URI], 'inspeksi') !== false 
								|| strpos($_SERVER[REQUEST_URI], 'eksekusi') !== false 
								|| strpos($_SERVER[REQUEST_URI], 'bulk_import') !== false
							) echo "class='active'" ?>>
							<a href="#">
								<i class="fa fa-table icon">
									<b class="bg-success"></b>
								</i>
								<span>Kelola</span>
							</a>
							<ul class="nav lt">
								<li <?php if (strpos($_SERVER[REQUEST_URI], 'jenis_pohon') !== false) echo "class='active'" ?>>
									<a href="/jenis_pohon">
										<i class="fa fa-angle-right"></i>
										<span>Jenis Pohon</span>
									</a>
								</li>
							</ul>
							<ul class="nav lt">
								<li <?php if (strpos($_SERVER[REQUEST_URI], 'the_pohon') !== false) echo "class='active'" ?>>
									<a href="/the_pohon">
										<i class="fa fa-angle-right"></i>
										<span>Pohon</span>
									</a>
								</li>
							</ul>
							<ul class="nav lt">
								<li <?php if (strpos($_SERVER[REQUEST_URI], 'inspeksi') !== false) echo "class='active'" ?>>
									<a href="inspeksi">
										<i class="fa fa-angle-right"></i>
										<span>Inspeksi</span>
									</a>
								</li>
							</ul>
							<ul class="nav lt">
								<li <?php if (strpos($_SERVER[REQUEST_URI], 'eksekusi') !== false) echo "class='active'" ?>>
									<a href="eksekusi">
										<i class="fa fa-angle-right"></i>
										<span>Eksekusi</span>
									</a>
								</li>
							</ul>
							<ul class="nav lt">
								<li <?php if (strpos($_SERVER[REQUEST_URI], 'bulk_import') !== false) echo "class='active'" ?>>
									<a href="/bulk_import">
										<i class="fa fa-angle-right"></i>
										<span>Bulk Import</span>
									</a>
								</li>
							</ul>
						</li>
						<li <?php if (strpos($_SERVER[REQUEST_URI], 'map') !== false) echo "class='active'" ?>>
							<a href="/map">
								<i class="fa fa-map-marker icon">
									<b class="bg-primary dker"></b>
								</i>
								<span>Monitoring</span>
							</a>
						</li>
						<li <?php if (strpos($_SERVER[REQUEST_URI], 'user') !== false) echo "class='active'" ?>>
							<a href="/user">
								<i class="fa fa-user icon">
									<b class="bg-danger"></b>
								</i>
								<span>Kredensial</span>
							</a>
						</li>
					</ul>
				</nav>
				<!-- / nav -->

			</div>
		</section>

		<footer class="footer lt hidden-xs b-t b-dark">
			<a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
				<i class="fa fa-angle-left text"></i>
				<i class="fa fa-angle-right text-active"></i>
			</a>
		</footer>
	</section>
</aside>
<!-- /.aside -->