<input type="hidden" id="coordinates" {{ $attributes->merge(['wire:model.defer' => 'data.coordinates']) }}>

<div id="map" style="height: 400px; border-radius: 10px; overflow: hidden; margin-bottom:16px"></div>

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />



<style>
    #map {
        margin-top: 10px !important;
    }
</style>



    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([-6.6, 106.8], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            var drawnItems = new L.FeatureGroup().addTo(map);
            var drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems
                },
                draw: {
                    polygon: true,
                    polyline: false,
                    rectangle: false,
                    circle: false,
                    marker: false,
                    circlemarker: false
                }
            });
            map.addControl(drawControl);

            // Restore polygon if value exists
            let el = document.getElementById('coordinates');
            let val = el.value;
            if (val) {
                try {
                    let coords = JSON.parse(val);
                    if (Array.isArray(coords) && coords.length) {
                        let poly = L.polygon(coords.map(pt => [pt[1], pt[0]]));
                        drawnItems.addLayer(poly);
                        map.fitBounds(poly.getBounds());
                    }
                } catch (e) {}
            }

            map.on(L.Draw.Event.CREATED, function(event) {
                drawnItems.clearLayers();
                drawnItems.addLayer(event.layer);
                var geojson = event.layer.toGeoJSON().geometry.coordinates[0];
                el.value = JSON.stringify(geojson);
                el.dispatchEvent(new Event('input'));
            });
            map.on('draw:edited', function(e) {
                var layers = e.layers;
                layers.eachLayer(function(layer) {
                    var geojson = layer.toGeoJSON().geometry.coordinates[0];
                    el.value = JSON.stringify(geojson);
                    el.dispatchEvent(new Event('input'));
                });
            });
        });
    </script>
@endpush
