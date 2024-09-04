<!DOCTYPE html>
<html>
<head>
    <title>Driver Tracking</title>
    <script src="https://cdn.leafletjs.com/leaflet/v1.7.1/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.leafletjs.com/leaflet/v1.7.1/leaflet.css" />
</head>
<body>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script>
        var map = L.map('map').setView([-6.311555, 107.099597], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var driverMarker = L.marker([-6.311555, 107.099597]).addTo(map);

        var ws = new WebSocket('ws://localhost:80');

        ws.onopen = function() {
            console.log('WebSocket connection established');
        };

        ws.onmessage = function(event) {
            var data = JSON.parse(event.data);
            if (data.latitude && data.longitude) {
                var lat = data.latitude;
                var lng = data.longitude;
                driverMarker.setLatLng([lat, lng]);
                map.setView([lat, lng]);
            }
        };

        ws.onclose = function() {
            console.log('WebSocket connection closed');
        };

        ws.onerror = function(error) {
            console.error('WebSocket error: ' + error);
        };
    </script>
</body>
</html>
