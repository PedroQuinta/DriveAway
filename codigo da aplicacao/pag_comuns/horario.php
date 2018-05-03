
<div id="location_address" class="">
	<div class="col-sm-1"></div>
	<div class="borda col-sm-5 ">

		<!-- MORADA -->
		<h4 class="oi oi-map-marker">Morada</h4>
		<div class="morada" class="rounded">
			<address>
				<strong>Escola de condução DriveAway</strong><br>
				Rua Comandante Pinho e Freitas n.º 5<br>
				3750-127 Águeda<br>
				GPS: N 40.574452 | W -8.444128<br>
			</address>
		</div>
		<!-- CONTACTOS-->
		<h4>Contactos</h4>
		<div class="contactos rounded">

			<i class="glyphicon glyphicon-earphone"></i>:255 255 255 (Águeda) <br>
			Escola Porto: <i>Brevemente</i><br>
			Escola Lisboa:<i>Brevemente</i><br>
			Email: <a href="mailto: alpha.agueda@ecalpha@.com">alpha.agueda@ecalpha.com</a>
		</div>
		<!-- HORARIO-->
		<h4>Horário</h4>
		<div class="horario" class="rounded">

			<p>&#9679; Semana: 9:00h - 21:00h.</p>
			<p>&#9679; Sábado: 9:00h - 13:00h.</p>

		</div>
	</div>
	<div class="wid col-sm-5">

		<!-- LOCALOZACAO-->
		<h4>Localização</h4>
		<div id="map"></div>
	</div>
</div>

<!-- SCRIPT DO GOOGLE MAPS-->
<script>
	var map;
	var parks = [{"Escola":"DriveAway","coords":[ 40.574452, -8.444128 ]}];
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 10,
			center: new google.maps.LatLng(40.574452, -8.444128 ),
			mapTypeId: 'roadmap'
		});
		mashParks(parks);
	}

	function mashParks(results) {
		for (var i = 0; i < results.length; i++) {
			var coords = results[i].coords;
			var latLng = new google.maps.LatLng(coords[0], coords[1]);
			var marker = new google.maps.Marker({
				position: latLng,
				map: map,
				label:results[i].park
			});
		}
	}

</script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5kMRS-W-XioXuL34jpP7VHCvhGfRx-bc&callback=initMap">
</script>



		
		