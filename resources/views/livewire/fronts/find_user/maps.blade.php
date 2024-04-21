<?php

use App\Livewire\Forms\ResetPasswordForm;
use function Livewire\Volt\{state, mount, form, title};
use App\Models\User;

title("Lihat Lokasi Anggota keluarga");

state([
    'spph',
    'phone',
    'user',
])->url();

mount(function() {
    $this->phone = preg_replace('/^08/', '628', $this->phone);
    $this->user = User::where('spph', $this->spph)->where('phone', $this->phone)->first();
    if (!$this->user) {
        return $this->redirectRoute('find_user.index');
    }
});

?>

<div>
    <div id="map" style="height: 100vh"></div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        window.location.reload();
        var map = L.map('map').setView([{{ $this->user->lat }}, {{ $this->user->lng }}], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        L.marker([{{$this->user->lat}}, {{$this->user->lng}}]).addTo(map).bindPopup("{{ $this->user->name }}");
    </script>
</div>

@assets
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endassets