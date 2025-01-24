<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getVisibleWidgets()"
    />
    <div class="space-y-6">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-4">User Locations</h2>
            <div class="p-4 bg-white rounded-lg shadow-sm mb-4">
                <form id="user-search-form" class="flex justify-end">
                    <div class="relative">
                        <input type="text" id="search-input"
                            class="pl-10 pr-4 py-1.5 w-48 text-sm text-gray-700 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-400 focus:border-blue-400 focus:outline-none transition duration-200 ease-in-out shadow-sm"
                            placeholder="Search location..." />
                        <svg class="w-4 h-4 absolute left-3 top-2.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 16.65z" />
                        </svg>
                    </div>
                </form>
            </div>
            
            
            
            
            <div id="user-map" style="height: 450px; width: 100%; position: relative; z-index: 0;"></div>
        </div>

        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var map = L.map('user-map').setView([-5.00000000, 120.00000000], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                L.Control.geocoder({
                    defaultMarkGeocode: true
                }).addTo(map);

                var users = @json($this->getUserLocations());
    var markers = [];

    function updateMap() {
        markers.forEach(function(marker) {
            map.removeLayer(marker);
        });
        markers = [];

        var searchQuery = document.getElementById('search-input').value.trim().toLowerCase();

        users.forEach(function(user) {
            if (user.lat && user.lng) {
                var userString = [
                    user.name,
                    user.phone,
                    user.province_code,
                    user.city_code,
                    user.district_code,
                    user.village_code,
                    user.lat.toString(),
                    user.lng.toString()
                ].join(' ').toLowerCase();

                if (userString.includes(searchQuery)) {
                    var marker = L.marker([user.lat, user.lng]).addTo(map);
                    marker.bindPopup('<strong>' + user.name + '</strong><br>' + 'Phone: ' + user.phone + '<br>' + 'Last Online: ' + user.last_online + '<br>' + 'Latitude: ' + user.lat + '<br>' + 'Longitude: ' + user.lng + '<br>' + 'Province: ' + user.province_code + '<br>' + 'City: ' + user.city_code + '<br>' + 'District: ' + user.district_code + '<br>' + 'Village: ' + user.village_code);
                    markers.push(marker);
                }
            }
        });
    }

    document.getElementById('user-search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        updateMap();
    });

    updateMap();

                var mapElement = document.getElementById('user-map');
                if (mapElement) {
                    mapElement.style.zIndex = 0;
                }

                var navbar = document.querySelector('.filament-sidebar');
                if (navbar) {
                    navbar.style.zIndex = 1000;
                }
            });
        </script>
    </div>
</x-filament-panels::page>
