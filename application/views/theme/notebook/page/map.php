<style>
	.control .form-group {
		margin-top: 10px;
		margin-bottom: 0px !important;
	}
</style>
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="#">Monitoring</a></li>
</ul>
<div class="m-b-md normal" id="filter-section">
	<h3 class="m-b-none">Monitoring</h3>
	<div id="ld4">
		<div>
		</div>
		<div>
		</div>
		<div>
		</div>
		<div>
		</div>
	</div>
	<p style="clear:both"></p>
</div>
<section class="panel panel-default">
	<div id="control-fly" class="form-group col-sm-12 fly" style="height:60px;position:fixed;top:0px;left:0px;width:100%;display:none;background-color:#25313e;z-index:110;">
		<div class="form-group col-sm-12">
			<a href="#" class="fullscreen-control" onclick="fullscreen_map_control()" style="font-size:15px;color:#adbece;font-weight: bold;font-size: 14px;">Mode Fullscreen Map</a>
		</div>
	</div>
	<div id="map"></div>
</section>
<input type="hidden" id="satker-cache" value="" />
<input type="hidden" id="kegiatan-cache" value="" />
<p id="notification" style="position:fixed;top:0;right:0;width:50%;z-index:120;"></p>
<?php
global $template;
$template->footer_add = "<script src='https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js'></script>
<script src='https://maps.googleapis.com/maps/api/js?key=$gmap_key&callback=initMap' async defer></script>
<script src='" . base_url("assets/notebook/") . "/js/datatables/jquery.dataTables.min.js'></script>
";
?>

<style>
	#map {
		height: 600px;
	}
</style>

<script>
	function message(id) {
		$("#message input[name='user_id']").val(id);
		$.ajax({
			url: '<?php echo base_url("ajax/act/get_items") ?>',
			dataType: 'json',
			data: {
				'id': id,
				'table': 'users'
			}
		}).done(function(result) {
			$("#display-name").val(result.display_name);
		}).fail(function() {
			alert("Gagal mengambil detail data user")
		});
	}

	var tiangMarkers = [];
	var treeMarkers = [];
	var map;
	var geocoder;
	var trafficLayer;
	var zoomLimit = 15;

	function initMap() {
		geocoder = new google.maps.Geocoder();
		map = new google.maps.Map(document.getElementById('map'), {
			// center: {lat: -6.405817, lng: 106.064018},
			center: {
				lat: 0.6694542,
				lng: 99.7062634
			},
			zoom: 12
		});

		trafficLayer = new google.maps.TrafficLayer();
		trafficLayer.setMap(map);
		load_all_tiangs();
		load_all_tree();
		showCurrentLocation();

		map.addListener('zoom_changed', function() {
			clearMapMarkers();
			load_all_tiangs();
			load_all_tree();
			showCurrentLocation();
		});

		map.addListener('dragend', function() {
			var zoom = map.getZoom();
			if (zoom > zoomLimit) {
				clearMapMarkers();
				load_all_tiangs();
				load_all_tree();
				showCurrentLocation();
			}
		});
	}

	function addPMarker(lat, long, contentString, theicon, tiang = true) {
		var myLatLng = new google.maps.LatLng(lat, long);

		if (theicon == '') {
			theicon = "<?php echo base_url("assets/icons/tree.png") ?>";
		}

		var marker = new google.maps.Marker({
			position: myLatLng,
			draggable: false,
			map: map,
			icon: theicon
		});

		if (contentString !== '') {
			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			marker.addListener('click', function() {
				infowindow.open(map, marker);
			});
		}

		if (tiang) {
			tiangMarkers.push(marker);
		} else {
			treeMarkers.push(marker);
		}
	}

	function load_all_tiangs() {

		if (map.getBounds() !== undefined) {
			var mapSouthWest = map.getBounds().getSouthWest();
			var mapNorthEast = map.getBounds().getNorthEast();
			var southwest = encodeURI(mapSouthWest.lat() + ";" + mapSouthWest.lng());
			var northeast = encodeURI(mapNorthEast.lat() + ";" + mapNorthEast.lng());
			var zoom = map.getZoom();
		}
		var content = "";

		$("#ld4").css("display", "flex");

		$.ajax({
			url: '<?php echo base_url("ajax/act/tiang/") ?>',
			type: "get",
			dataType: 'json',
			data: {
				southwest: southwest,
				northeast: northeast,
				zoom: zoom
			}
		}).done(function(result) {
			var zoom = map.getZoom();
			if (result !== null) {
				$.each(result, function(i, val) {
					content = "";
					if (zoom > zoomLimit) {
						content += "<p>Nomor Tiang : " + val[0] + "</p>";
						content += "<p>Kode Hantaran : " + val[2] + "</p>";
						addPMarker(val[5], val[6], content, "<?php echo base_url("assets/icons/pole.png") ?>");
					} else {
						content += "<p>Group Kode Hantaran : " + val[2] + "</p>";
						if (val[7] == true) {
							addPMarker(val[5], val[6], content, "<?php echo base_url("assets/icons/poles-red.png") ?>");
						} else {
							addPMarker(val[5], val[6], content, "<?php echo base_url("assets/icons/poles.png") ?>");
						}
					}
				});
			}
			$("#ld4").css("display", "none");
		}).fail(function() {
			//fail function
			$("#ld4").css("display", "none");
		});
	}

	function load_all_tree() {
		if (map.getBounds() !== undefined) {
			var mapSouthWest = map.getBounds().getSouthWest();
			var mapNorthEast = map.getBounds().getNorthEast();
			var southwest = encodeURI(mapSouthWest.lat() + ";" + mapSouthWest.lng());
			var northeast = encodeURI(mapNorthEast.lat() + ";" + mapNorthEast.lng());
			var zoom = map.getZoom();
		} else {
			return;
		}
		var content = "";

		if (zoom <= zoomLimit) {
			return;
		}

		$.ajax({
			url: '<?php echo base_url("ajax/act/get_all_tree") ?>',
			type: "get",
			dataType: 'json',
			data: {
				southwest: southwest,
				northeast: northeast,
				zoom: zoom
			},
		}).done(function(result) {
			$.each(result, function(i, val) {
				content = "";
				content = "<p>Pohon " + val.jenis_pohon + "</p>";
				content += "<p>Kode Hantaran : " + val.segmen + "</p>";
				content += "<p>Prediksi tinggi : " + val.tinggi + " m </p>";
				content += "<p>Posisi : " + val.latitude + "," + val.longitude + " </p>";

				if (val.image !== "") {
					content += "<a href='images/" + val.image + "' target='_blank'><img style='max-height:250px' src='images/" + val.image + "'/></a>";
				}

				if (parseFloat(val.tinggi) >= <?= get_tinggi_pohon_limit() ?>) {
					addPMarker(val.latitude, val.longitude, content, "<?php echo base_url("assets/icons/tree-red.png") ?>");
				} else {
					addPMarker(val.latitude, val.longitude, content, '');
				}
			});
		}).fail(function() {
			//fail function
		});
	}

	function clearMapMarkers() {
		for (var i = 0; i < tiangMarkers.length; i++) {
			tiangMarkers[i].setMap(null);
		}

		for (var i = 0; i < treeMarkers.length; i++) {
			treeMarkers[i].setMap(null);
		}

		tiangMarkers = [];
		treeMarkers = [];
	}

	function showCurrentLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			console.log("GPS feature not available");
		}
	}

	function showPosition(position) {
		var lat = position.coords.latitude;
		var lng = position.coords.longitude;
		addPMarker(lat, lng, 'Lokasi Anda Saat Ini', "<?php echo base_url("assets/icons/person.png") ?>");
	}

	function timeConverter(UNIX_timestamp) {
		var a = new Date(UNIX_timestamp * 1000);
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var year = a.getFullYear();
		var month = months[a.getMonth()];
		var date = a.getDate();
		var hour = a.getHours();
		var min = a.getMinutes();
		var sec = a.getSeconds();
		var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
		return time;
	}

	function fullscreen_map_control() {

		var html = $(".fullscreen-control").html();
		if (html == "Mode Fullscreen Map") {
			$(".fullscreen-control").html("Keluar dari Mode Fullscreen Map");
			var h = screen.height;
			h = h - 60;
			$("#map").height(h);
			$("#map").css("width", "100%");
			$("#map").css("position", "fixed");
			$("#map").css("top", "60px");
			$("#map").css("left", "0px");
			$("#map").css("right", "0px");
			$("#map").css("z-index", "100");
			$("#control-fly").show();
		} else {
			$(".fullscreen-control").html("Mode Fullscreen Map");
			$("#map").height("500");
			$("#map").css("width", "100%");
			$("#map").css("position", "relative");
			$("#map").css("top", "0px");
			$("#map").css("left", "0px");
			$("#map").css("right", "0px");
			$("#map").css("z-index", "100");
			$("#control-fly").hide();
		}


		google.maps.event.trigger(map, "resize");

		// initMap();
		// alert(h);
	}
</script>
<style>
	.loader {
		width: 50vw;
		height: 50vh;
		border: 1px solid mistyrose;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	#ld4 {
		position: absolute;
		display: none;
		width: 25%;
		justify-content: space-between;
		left: 40%;
		top: 60px;
	}

	#ld4 div {
		height: 15px;
		width: 15px;
		border-radius: 50%;
		background: #D91E36;
	}

	#ld4 div:nth-child(1) {
		animation: ld4 3s linear infinite 0s;
	}

	#ld4 div:nth-child(2) {
		animation: ld4 3s linear infinite 0.15s;
	}

	#ld4 div:nth-child(3) {
		animation: ld4 3s linear infinite 0.3s;
	}

	#ld4 div:nth-child(4) {
		animation: ld4 3s linear infinite 0.45s;
	}

	@keyframes ld4 {
		0% {
			opacity: 0;
			transform: scale(0.3);
			background: #59CD90;
		}

		25% {
			opacity: 1;
			transform: scale(1.8);
			background: #0072BB;
		}

		50% {
			opacity: 0;
			transform: scale(0.3);
			background: #FE4A49;
		}

		75% {
			opacity: 1;
			transform: scale(1.8);
			background: #FED766;
		}

		100% {
			opacity: 0;
		}
	}
</style>