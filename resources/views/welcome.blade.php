@extends('layouts.main')

@section('title', 'Home')

@section('content')

<section class="hero-section">

    <div class="container">

        <div class="row align-items-center">

            <!-- Left Content -->
            <div class="col-lg-4 mb-3 mb-lg-0">

                <div class="small-text">
                    <span class="dot">•</span>
                    {{ __('messages.taxi_text') }}
                </div>

                <h1 class="hero-heading">
                    {{ __('messages.make_your') }} <br>
                    {{ __('messages.booking') }} <br>
                    {{ __('messages.with_us') }}
                </h1>

                <p class="hero-description">
                    {{ __('messages.booking_desc') }}
                </p>

            </div>

            <!-- Right Form -->
            <div class="col-lg-8">

                <!-- Tabs -->
                <div class="booking-tabs">

                    <button type="button" onclick="setMode('airportFrom')">
                        {{ __('messages.from_airport') }}
                    </button>

                    <button type="button" onclick="setMode('airportTo')">
                        {{ __('messages.to_airport') }}
                    </button>

                    <!-- <button type="button" onclick="setMode('pinToPin')">
                        {{ __('messages.pin_to_pin') }}
                    </button> -->

                </div>
                @if(session('outside_city'))
    <div class="alert alert-warning mb-3">
        {{ session('outside_city') }}
    </div>
@endif

                <!-- Form -->
                <form class="booking-form"
                      method="POST"
                      action="{{ url('/booking') }}">

                    @csrf

                    <div class="row">

                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.full_name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email') }}">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ __('messages.phone') }}">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Passengers -->
                        <div class="col-md-6 mb-3">
                            <select name="passengers">
                                <option value="">{{ __('messages.select_passenger') }}</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('passengers') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('passengers') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row" id="dynamic-row"></div>

                        <!-- Travel Date -->
                        <div class="col-md-6 mb-3">
                            <input type="date" name="travel_date" min="{{ date('Y-m-d') }}" value="{{ old('travel_date') }}">
                            @error('travel_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Travel Time -->
                        <div class="col-md-6 mb-3">
                            <input type="time" name="travel_time" value="{{ old('travel_time') }}">
                            @error('travel_time') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button class="book-btn" type="submit">
                                {{ __('messages.book_now') }}
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

<script>

let debounceTimer = null;

// prevent old responses overriding new ones
let requestCounter = {
    pickup: 0,
    dropoff: 0
};

let pendingCooldown = {
    pickup: false,
    dropoff: false
};

// ── 1. Render dynamic fields
const airportData = {
    display_name: "Barcelona El Prat Josep Tarradellas Airport, Carretera de la Platja, el Prat de Llobregat, Baix Llobregat, Catalonia, 08820, Spain",
    lat: "41.2969440",
    lon: "2.0790474",
    city: "el Prat de Llobregat",
    place_id: "320090978339"
};


function setMode(type) {

    let pickupValue  = '';
    let dropoffValue = '';

    if(type === 'airportFrom') {
        pickupValue = airportData.display_name;
    }

    if(type === 'airportTo') {
        dropoffValue = airportData.display_name;
    }


    let html = `
        <div class="position-relative col-md-6 mb-3">

            <input
                type="text"
                name="pickup_address"
                id="pickup_address"
                autocomplete="off"
                value="${pickupValue}"
                placeholder="${type === 'airportFrom'
                    ? '{{ __("messages.airport") }}'
                    : '{{ __("messages.pickup") }}'}">

            <div id="pickup-results"></div>

            <input type="hidden" name="pickup_lat" value="${type === 'airportFrom' ? airportData.lat : ''}">
            <input type="hidden" name="pickup_lng" value="${type === 'airportFrom' ? airportData.lon : ''}">
            <input type="hidden" name="pickup_city" value="${type === 'airportFrom' ? airportData.city : ''}">
            <input type="hidden" name="pickup_place_id" value="${type === 'airportFrom' ? airportData.place_id : ''}">

        </div>


        <div class="position-relative col-md-6 mb-3">

            <input
                type="text"
                name="dropoff_address"
                id="dropoff_address"
                autocomplete="off"
                value="${dropoffValue}"
                placeholder="${type === 'airportTo'
                    ? '{{ __("messages.airport") }}'
                    : '{{ __("messages.dropoff") }}'}">

            <div id="dropoff-results"></div>

            <input type="hidden" name="dropoff_lat" value="${type === 'airportTo' ? airportData.lat : ''}">
            <input type="hidden" name="dropoff_lng" value="${type === 'airportTo' ? airportData.lon : ''}">
            <input type="hidden" name="dropoff_city" value="${type === 'airportTo' ? airportData.city : ''}">
            <input type="hidden" name="dropoff_place_id" value="${type === 'airportTo' ? airportData.place_id : ''}">

        </div>
    `;


    document.getElementById('dynamic-row').innerHTML = html;
}

// ── 2. Init
window.onload = function () {
    setMode('');
};
function setMode(type) {

    let pickupValue  = '';
    let dropoffValue = '';

    if(type === 'airportFrom') {

        pickupValue = airportData.display_name;

    }

    if(type === 'airportTo') {

        dropoffValue = airportData.display_name;

    }


    let html = `
        <div class="position-relative col-md-6 mb-3">

            <input
                type="text"
                name="pickup_address"
                id="pickup_address"
                autocomplete="off"
                value="${pickupValue}"
                placeholder="{{ __('messages.pickup') }}">

            <div id="pickup-results"></div>

            <input type="hidden" name="pickup_lat" value="${type === 'airportFrom' ? airportData.lat : ''}">
            <input type="hidden" name="pickup_lng" value="${type === 'airportFrom' ? airportData.lon : ''}">
            <input type="hidden" name="pickup_city" value="${type === 'airportFrom' ? airportData.city : ''}">
            <input type="hidden" name="pickup_place_id" value="${type === 'airportFrom' ? airportData.place_id : ''}">

        </div>


        <div class="position-relative col-md-6 mb-3">

            <input
                type="text"
                name="dropoff_address"
                id="dropoff_address"
                autocomplete="off"
                value="${dropoffValue}"
                placeholder="{{ __('messages.dropoff') }}">

            <div id="dropoff-results"></div>

            <input type="hidden" name="dropoff_lat" value="${type === 'airportTo' ? airportData.lat : ''}">
            <input type="hidden" name="dropoff_lng" value="${type === 'airportTo' ? airportData.lon : ''}">
            <input type="hidden" name="dropoff_city" value="${type === 'airportTo' ? airportData.city : ''}">
            <input type="hidden" name="dropoff_place_id" value="${type === 'airportTo' ? airportData.place_id : ''}">

        </div>
    `;


    document.getElementById('dynamic-row').innerHTML = html;
}

// ── 3. Input listener
document.addEventListener('keyup', function (e) {

    if (
        e.target.id !== 'pickup_address' &&
        e.target.id !== 'dropoff_address'
    ) return;

    clearTimeout(debounceTimer);

    const keyword = e.target.value.trim();
    const type = e.target.id === 'pickup_address' ? 'pickup' : 'dropoff';

    const box = document.getElementById(type + '-results');

    // 🔥 INSTANT CLEAR OLD RESULTS
    if (box) {
        box.innerHTML = '';
    }
    if (keyword.length < 3) return;
    debounceTimer = setTimeout(() => {
        searchAddress(keyword, type);
    }, 800);
});

// ── 4. API CALL
async function searchAddress(keyword, type) {
    console.log('Searching:', keyword);
    const requestId = ++requestCounter[type];
    const box = document.getElementById(type + '-results');
    try {
        if (box) {
            box.innerHTML = `<div class="autocomplete-loading">Searching...</div>`;
        }
        const response = await fetch(
            '/api/location/autocomplete?keyword=' +
            encodeURIComponent(keyword)
        );
        const data = await response.json();
        // ignore old response
        if (requestId !== requestCounter[type]) {
            console.log('Stale response ignored');
            return;
        }
        console.log('API Response:', data);
        if (data.status === 'completed') {
            renderResults(data.results || [], type);
            return;
        }
        // 🔥 RETRY WHEN NOT COMPLETED
        if (data.status === 'pending') {
            console.log('Still processing... retrying');
            setTimeout(() => {
                // check user didn't change keyword
                const currentValue =
                    document.getElementById(type + '_address').value.trim();
                if (currentValue === keyword) {
                    searchAddress(keyword, type);
                }
            }, 2000); // retry after 2 seconds
            return;
        }
    } catch (error) {
        console.error('Autocomplete error:', error);
    }
}

// ── 5. Render results
function renderResults(results, type) {

    const box = document.getElementById(type + '-results');

    if (!box) return;

    box.innerHTML = '';

    console.log(' Rendering results:', results);

    if (!results || results.length === 0) return;

    results.slice(0, 8).forEach(item => {

        const div = document.createElement('div');
        div.classList.add('autocomplete-item');
        div.textContent = item.display_name;

        div.addEventListener('click', function () {

            console.log(' Selected:', item);

            document.getElementById(type + '_address').value =
                item.display_name;

            document.querySelector(`input[name="${type}_lat"]`).value =
                item.lat || '';

            document.querySelector(`input[name="${type}_lng"]`).value =
                item.lon || '';

            document.querySelector(`input[name="${type}_city"]`).value =
    item.city ||
    item.town ||
    item.municipality ||
    '';

            document.querySelector(`input[name="${type}_place_id"]`).value =
                item.place_id || '';

            box.innerHTML = '';
        });

        box.appendChild(div);
    });

    console.log(' Rendered items:', box.children.length);
}

</script>

@endsection