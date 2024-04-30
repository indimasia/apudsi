<x-filament-panels::page>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>

    <x-filament-panels::form wire:submit='search'>
        {{$this->form}}

        <x-filament-panels::form.actions 
            :actions="$this->getFormActions()"
        /> 
    </x-filament-panels::form>
    <div id="map" style="height: 70vh"></div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    <script>
        var map = L.map('map').setView([21.389082, 39.857910], 13);
        const points = JSON.parse(`{!! json_encode($points) !!}`);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        points.map(point => {
            if(!point.lat || !point.lng) return;
            L.marker([point.lat, point.lng]).addTo(map)
            .bindPopup(point.name);
        });
    </script>
</x-filament-panels::page>
