<!DOCTYPE html>
<html>

<head>
  <title>Store Locator</title>

  <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
  <script type="text/javascript" async defer src="https://maps.google.com/maps/api/js?key=AIzaSyCG39EpX8oGAXWTHK-CPU_uZgtyFRkERRU&callback=initMap&libraries=places"></script>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <style type="text/css">
    #mymap {
      border: 1px solid red;
      width: 800px;
      height: 500px;
    }
  </style>
</head>

<body>
  <h4 class="text-center">Store Locator</h4>
  <hr>
  <div class="row">
    <div class="col-md-4">
      <ul class="list-store">
        @if($locations)
        @foreach($locations as $loc)
        <li class="list-group-item">{{ $loc->title }}</li>
        @endforeach
        @else
        <li>No store found !!</li>
        @endif

      </ul>
    </div>
    <div class="col-md-8">
      <div id="mymap"></div>
    </div>
  </div>
  <form>
    @csrf
  </form>
  <input type="hidden" id="latitude" name="latitude" class="form-control">
  <input type="hidden" id="longitude" name="longitude" class="form-control">
</body>

</html>

<script type="text/javascript">
  function initMap() {
    const myLatLng = {
      lat: 22.2734719,
      lng: 70.7512559
    };
    const map = new google.maps.Map(document.getElementById("mymap"), {
      zoom: 5,
      center: myLatLng,
    });

    var locations = <?php print_r(json_encode($locations)) ?>;

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i].latitude, locations[i].longitude),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i].title + '<br>' + locations[i].address);
          infowindow.open(map, marker);
        }
      })(marker, i));

    }
  }

  // get current location if user and sort by nearest store locations in ascending order

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        $.ajax({
          headers: {
            "Accept": 'application/json'
          },
          type: 'POST',
          url: '<?php echo url('/') ?>' + '/near-by-stores',
          data: {
            "_token": "{{ csrf_token() }}",
            pos
          },
          success: function(data) {
            $('.list-store').empty();
            $.each(JSON.parse(data), function(key, val) {
              $('.list-store').append('<li class="list-group-item">' + val.title + '<small style="float: right">Distance: ' + Math.round(val.distance) + ' km</small></li>');
            });
          }
        });
      },
      () => {
        handleLocationError();
      }
    );
  } else {
    // Browser doesn't support Geolocation
    handleLocationError();
  }

  window.initMap = initMap;

  function handleLocationError() {
    alert('You need to allow the GPS location in order to get the nearest by stores !!');
  }
</script>