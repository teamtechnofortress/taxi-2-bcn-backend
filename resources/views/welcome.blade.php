@extends('layouts.main')

@section('title', 'Home')

@section('content')

<section class="hero-section">

    <div class="container">

        <div class="row align-items-center">

            <!-- Left Content -->
            <div class="col-lg-4 mb-lg-0">

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

                <div class="booking-card">

                    <!-- Tabs -->
                    <div class="booking-tabs">

                        <button
                            type="button"
                            class="airport-mode-btn"
                            data-mode="airportFrom"
                            onclick="setMode('airportFrom')"
                        >
                            {{ __('messages.from_airport') }}
                        </button>

                        <button
                            type="button"
                            class="airport-mode-btn"
                            data-mode="airportTo"
                            onclick="setMode('airportTo')"
                        >
                            {{ __('messages.to_airport') }}
                        </button>

                        <!--
                        <button
                            type="button"
                            class="airport-mode-btn"
                            data-mode="pinToPin"
                            onclick="setMode('pinToPin')"
                        >
                            {{ __('messages.pin_to_pin') }}
                        </button>
                        -->

                    </div>

                    @if(session('outside_city'))
                        <div class="alert alert-warning mb-3">
                            {{ session('outside_city') }}
                        </div>
                    @endif

                    <!-- Server-side "same location" message, in case JS is disabled -->
                    @error('same_location')
                        <div class="alert alert-danger mb-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Form -->
                    <form
                        id="bookingForm"
                        class="booking-form"
                        method="POST"
                        action="{{ url('/booking') }}"
                    >

                        @csrf

                        <div class="row">

                            <!-- Name -->
                            <div class="col-md-6 mb-3">

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="{{ __('messages.full_name') }}"
                                >

                                @error('name')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="{{ __('messages.email') }}"
                                >

                                @error('email')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="{{ __('messages.phone') }}"
                                >

                                @error('phone')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- Passengers -->
                            <div class="col-md-6 mb-3">

                                <select name="passengers">

                                    <option value="">
                                        {{ __('messages.select_passenger') }}
                                    </option>

                                    @for ($i = 1; $i <= 10; $i++)

                                        <option
                                            value="{{ $i }}"
                                            {{ old('passengers') == $i ? 'selected' : '' }}
                                        >
                                            {{ $i }}
                                        </option>

                                    @endfor

                                </select>

                                @error('passengers')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div
                                class="row"
                                id="dynamic-row"
                            ></div>

                            <!-- Travel Date -->
                            <div class="col-md-6 mb-3">

                                <input
                                    type="date"
                                    name="travel_date"
                                    id="travel_date"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('travel_date') }}"
                                >

                                @error('travel_date')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- Travel Time -->
                            <div class="col-md-6 mb-3">

                                <input
                                    type="time"
                                    name="travel_time"
                                    id="travel_time"
                                    value="{{ old('travel_time') }}"
                                >

                                @error('travel_time')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- Submit -->
                            <div class="col-12">

                                <button
                                    class="book-btn"
                                    type="submit"
                                >
                                    {{ __('messages.book_now') }}
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<script>

let debounceTimer = null;

// Prevent old responses overriding new ones
let requestCounter = {
    pickup: 0,
    dropoff: 0
};

let pendingCooldown = {
    pickup: false,
    dropoff: false
};


// =========================================================
// Airport data
// =========================================================

const airportData = {

    display_name:
        "Barcelona El Prat Josep Tarradellas Airport, Carretera de la Platja, el Prat de Llobregat, Baix Llobregat, Catalonia, 08820, Spain",

    lat: "41.2969440",

    lon: "2.0790474",

    city: "el Prat de Llobregat",

    place_id: "320090978339"

};


// =========================================================
// Auto-fit the font size of a locked (readonly) location
// input so the FULL address is visible on one line instead
// of being cut off with "...". Shrinks in 0.5px steps from
// the field's normal size down to a sensible minimum.
// =========================================================

function fitLocationText(input) {

    if (!input) {
        return;
    }

    const maxFontSize = 13;   // matches the CSS default for [readonly]
    const minFontSize = 9.5;  // never shrink smaller than this

    let fontSize = maxFontSize;

    input.style.fontSize = fontSize + 'px';

    // scrollWidth = full content width the text actually needs
    // clientWidth = visible width available inside the input
    while (
        input.scrollWidth > input.clientWidth &&
        fontSize > minFontSize
    ) {

        fontSize -= 0.5;

        input.style.fontSize = fontSize + 'px';

    }

}


function resetLocationFont(input) {

    if (!input) {
        return;
    }

    // Clear the inline override so it falls back to the
    // normal (non-readonly) field font-size from the CSS.
    input.style.fontSize = '';

}


// Re-fit any currently-locked location fields if the window
// is resized (their available width can change on breakpoints).
window.addEventListener('resize', function () {

    ['pickup_address', 'dropoff_address'].forEach(function (id) {

        const input = document.getElementById(id);

        if (input && input.hasAttribute('readonly')) {

            fitLocationText(input);

        }

    });

});


// =========================================================
// 1. Set active airport button
// =========================================================

function setActiveModeButton(type) {

    const buttons =
        document.querySelectorAll('.airport-mode-btn');

    buttons.forEach(button => {

        button.classList.remove('active');

    });

    const activeButton =
        document.querySelector(
            `.airport-mode-btn[data-mode="${type}"]`
        );

    if (activeButton) {

        activeButton.classList.add('active');

    }
}


// =========================================================
// 2. Render dynamic fields
// =========================================================

function setMode(type) {

    // Keep clicked button active
    setActiveModeButton(type);

    let pickupValue = '';

    let dropoffValue = '';

    let pickupSelected = false;

    let dropoffSelected = false;


    if (type === 'airportFrom') {

        pickupValue =
            airportData.display_name;

        pickupSelected = true;

    }


    if (type === 'airportTo') {

        dropoffValue =
            airportData.display_name;

        dropoffSelected = true;

    }


    const html = `

        <!-- Pickup -->
        <div class="position-relative col-md-6 mb-3">

            <div class="location-input-wrapper">

                <input
                    type="text"
                    name="pickup_address"
                    id="pickup_address"
                    autocomplete="off"
                    value="${pickupValue}"
                    placeholder="${type === 'airportFrom'
                        ? '{{ __("messages.airport") }}'
                        : '{{ __("messages.pickup") }}'}"
                    ${pickupSelected ? 'readonly' : ''}
                >

                <button
                    type="button"
                    class="location-clear-btn ${pickupSelected ? 'show' : ''}"
                    id="pickup-clear"
                    aria-label="Clear pickup location"
                >
                    &times;
                </button>

            </div>

            <div id="pickup-results"></div>

            <input
                type="hidden"
                name="pickup_lat"
                value="${type === 'airportFrom'
                    ? airportData.lat
                    : ''}"
            >

            <input
                type="hidden"
                name="pickup_lng"
                value="${type === 'airportFrom'
                    ? airportData.lon
                    : ''}"
            >

            <input
                type="hidden"
                name="pickup_city"
                value="${type === 'airportFrom'
                    ? airportData.city
                    : ''}"
            >

            <input
                type="hidden"
                name="pickup_place_id"
                value="${type === 'airportFrom'
                    ? airportData.place_id
                    : ''}"
            >

        </div>


        <!-- Dropoff -->
        <div class="position-relative col-md-6 mb-3">

            <div class="location-input-wrapper">

                <input
                    type="text"
                    name="dropoff_address"
                    id="dropoff_address"
                    autocomplete="off"
                    value="${dropoffValue}"
                    placeholder="${type === 'airportTo'
                        ? '{{ __("messages.airport") }}'
                        : '{{ __("messages.dropoff") }}'}"
                    ${dropoffSelected ? 'readonly' : ''}
                >

                <button
                    type="button"
                    class="location-clear-btn ${dropoffSelected ? 'show' : ''}"
                    id="dropoff-clear"
                    aria-label="Clear dropoff location"
                >
                    &times;
                </button>

            </div>

            <div id="dropoff-results"></div>

            <input
                type="hidden"
                name="dropoff_lat"
                value="${type === 'airportTo'
                    ? airportData.lat
                    : ''}"
            >

            <input
                type="hidden"
                name="dropoff_lng"
                value="${type === 'airportTo'
                    ? airportData.lon
                    : ''}"
            >

            <input
                type="hidden"
                name="dropoff_city"
                value="${type === 'airportTo'
                    ? airportData.city
                    : ''}"
            >

            <input
                type="hidden"
                name="dropoff_place_id"
                value="${type === 'airportTo'
                    ? airportData.place_id
                    : ''}"
            >

        </div>

    `;


    document.getElementById(
        'dynamic-row'
    ).innerHTML = html;


    // Setup clear buttons
    setupLocationClearButton('pickup');

    setupLocationClearButton('dropoff');


    // Fit the airport address text if it was auto-filled
    if (pickupSelected) {

        fitLocationText(
            document.getElementById('pickup_address')
        );

    }

    if (dropoffSelected) {

        fitLocationText(
            document.getElementById('dropoff_address')
        );

    }

}


// =========================================================
// 3. Clear selected location
// =========================================================

function setupLocationClearButton(type) {

    const clearButton =
        document.getElementById(
            type + '-clear'
        );


    if (!clearButton) {
        return;
    }


    clearButton.addEventListener(
        'click',
        function () {

            const input =
                document.getElementById(
                    type + '_address'
                );


            if (!input) {
                return;
            }


            // Clear visible location
            input.value = '';


            // Make input editable again
            input.removeAttribute(
                'readonly'
            );


            // Back to the normal field font-size
            resetLocationFont(input);


            // Clear hidden location data
            const lat =
                document.querySelector(
                    `input[name="${type}_lat"]`
                );

            const lng =
                document.querySelector(
                    `input[name="${type}_lng"]`
                );

            const city =
                document.querySelector(
                    `input[name="${type}_city"]`
                );

            const placeId =
                document.querySelector(
                    `input[name="${type}_place_id"]`
                );


            if (lat) {
                lat.value = '';
            }

            if (lng) {
                lng.value = '';
            }

            if (city) {
                city.value = '';
            }

            if (placeId) {
                placeId.value = '';
            }


            // Hide clear button
            clearButton.classList.remove(
                'show'
            );


            // Clear autocomplete results
            const resultsBox =
                document.getElementById(
                    type + '-results'
                );


            if (resultsBox) {

                resultsBox.innerHTML = '';

            }


            // Focus input
            input.focus();


            // Re-check the same-location state now that one side changed
            clearBookingError();

        }
    );

}


// =========================================================
// 4. Initial state
// =========================================================

window.onload = function () {

    setMode('');

};


// =========================================================
// 5. Location input listener
// =========================================================

document.addEventListener(
    'input',
    function (e) {

        if (
            e.target.id !== 'pickup_address' &&
            e.target.id !== 'dropoff_address'
        ) {
            return;
        }


        // Do not search while selected location is locked
        if (
            e.target.hasAttribute('readonly')
        ) {
            return;
        }


        clearTimeout(
            debounceTimer
        );


        const keyword =
            e.target.value.trim();


        const type =
            e.target.id === 'pickup_address'
                ? 'pickup'
                : 'dropoff';


        const box =
            document.getElementById(
                type + '-results'
            );


        // Clear old results immediately
        if (box) {

            box.innerHTML = '';

        }


        if (keyword.length < 3) {

            return;

        }


        debounceTimer =
            setTimeout(
                () => {

                    searchAddress(
                        keyword,
                        type
                    );

                },
                800
            );

    }
);


// =========================================================
// 6. Location input blur
// =========================================================

document.addEventListener(
    'focusout',
    function (e) {

        if (
            e.target.id !== 'pickup_address' &&
            e.target.id !== 'dropoff_address'
        ) {
            return;
        }


        const input = e.target;


        const type =
            input.id === 'pickup_address'
                ? 'pickup'
                : 'dropoff';


        const box =
            document.getElementById(
                type + '-results'
            );


        // Always hide autocomplete dropdown
        if (box) {

            box.innerHTML = '';

        }


        /*
         * If the location was already selected,
         * keep it because it is readonly.
         */
        if (
            input.hasAttribute('readonly')
        ) {
            return;
        }


        /*
         * User typed something but did not
         * select a suggestion.
         *
         * Clear the input.
         */
        if (input.value.trim() !== '') {

            input.value = '';

        }

    }
);


// =========================================================
// 7. API CALL
// =========================================================

async function searchAddress(
    keyword,
    type
) {

    console.log(
        'Searching:',
        keyword
    );


    const requestId =
        ++requestCounter[type];


    const box =
        document.getElementById(
            type + '-results'
        );


    try {

        if (box) {

            box.innerHTML = `
                <div class="autocomplete-loading">
                    Searching...
                </div>
            `;

        }


        const response =
            await fetch(
                '/api/location/autocomplete?keyword=' +
                encodeURIComponent(keyword)
            );


        const data =
            await response.json();


        // Ignore old response
        if (
            requestId !==
            requestCounter[type]
        ) {

            console.log(
                'Stale response ignored'
            );

            return;

        }


        console.log(
            'API Response:',
            data
        );


        if (
            data.status === 'completed'
        ) {

            renderResults(
                data.results || [],
                type
            );

            return;

        }


        // Retry when pending
        if (
            data.status === 'pending'
        ) {

            console.log(
                'Still processing... retrying'
            );


            setTimeout(
                () => {

                    const input =
                        document.getElementById(
                            type + '_address'
                        );


                    if (!input) {
                        return;
                    }


                    const currentValue =
                        input.value.trim();


                    if (
                        currentValue === keyword &&
                        !input.hasAttribute(
                            'readonly'
                        )
                    ) {

                        searchAddress(
                            keyword,
                            type
                        );

                    }

                },
                2000
            );


            return;

        }

    } catch (error) {

        console.error(
            'Autocomplete error:',
            error
        );

    }

}


// =========================================================
// 8. Render autocomplete results
// =========================================================

function renderResults(
    results,
    type
) {

    const box =
        document.getElementById(
            type + '-results'
        );


    if (!box) {
        return;
    }


    box.innerHTML = '';


    console.log(
        'Rendering results:',
        results
    );


    if (
        !results ||
        results.length === 0
    ) {

        return;

    }


    results
        .slice(0, 8)
        .forEach(item => {

            const div =
                document.createElement(
                    'div'
                );


            div.classList.add(
                'autocomplete-item'
            );


            // Show complete location
            div.textContent =
                item.display_name;


            div.addEventListener(
                'mousedown',
                function () {

                    console.log(
                        'Selected:',
                        item
                    );


                    const input =
                        document.getElementById(
                            type + '_address'
                        );


                    if (!input) {
                        return;
                    }


                    // Complete location
                    input.value =
                        item.display_name;


                    // Lock location
                    input.setAttribute(
                        'readonly',
                        'readonly'
                    );


                    // Shrink font so the FULL address is
                    // visible instead of being truncated
                    fitLocationText(input);


                    // Save latitude
                    const lat =
                        document.querySelector(
                            `input[name="${type}_lat"]`
                        );


                    if (lat) {

                        lat.value =
                            item.lat || '';

                    }


                    // Save longitude
                    const lng =
                        document.querySelector(
                            `input[name="${type}_lng"]`
                        );


                    if (lng) {

                        lng.value =
                            item.lon || '';

                    }


                    // Save city
                    const city =
                        document.querySelector(
                            `input[name="${type}_city"]`
                        );


                    if (city) {

                        city.value =
                            item.city ||
                            item.town ||
                            item.municipality ||
                            '';

                    }


                    // Save place ID
                    const placeId =
                        document.querySelector(
                            `input[name="${type}_place_id"]`
                        );


                    if (placeId) {

                        placeId.value =
                            item.place_id || '';

                    }


                    // Show × button
                    const clearButton =
                        document.getElementById(
                            type + '-clear'
                        );


                    if (clearButton) {

                        clearButton.classList.add(
                            'show'
                        );

                    }


                    // Hide dropdown
                    box.innerHTML = '';


                    // Re-check the same-location state now that one side changed
                    clearBookingError();

                }
            );


            box.appendChild(div);

        });


    console.log(
        'Rendered items:',
        box.children.length
    );

}


// =========================================================
// 9. Date & Time — click anywhere on the bar to open the
//    native picker (not just the small calendar/clock icon)
// =========================================================

document.addEventListener(
    'click',
    function (e) {

        const target = e.target;

        if (
            target.tagName === 'INPUT' &&
            (target.type === 'date' || target.type === 'time')
        ) {

            if (typeof target.showPicker === 'function') {

                try {

                    target.showPicker();

                } catch (err) {

                    // showPicker() can throw if called too soon
                    // after another picker closes — safe to ignore.

                }

            }

        }

    }
);


// =========================================================
// 10. Travel date — block past dates
//     The `min` attribute already stops most browsers from
//     letting the user pick a past date in the calendar UI,
//     but some browsers still allow a past date to be typed
//     in manually, so this re-validates on every change.
// =========================================================

document.addEventListener(
    'change',
    function (e) {

        if (e.target.id !== 'travel_date') {
            return;
        }

        const input = e.target;

        if (!input.value) {
            input.setCustomValidity('');
            return;
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const chosen = new Date(input.value + 'T00:00:00');

        if (chosen < today) {

            input.setCustomValidity(
                'Please choose today or a future date.'
            );

            input.reportValidity();

            input.value = '';

        } else {

            input.setCustomValidity('');

        }

    }
);


// =========================================================
// 11. Booking error banner helpers
// =========================================================

function showBookingError(message) {

    let errorBox =
        document.getElementById('booking-error');

    if (!errorBox) {

        errorBox = document.createElement('div');
        errorBox.id = 'booking-error';
        errorBox.className = 'alert alert-danger mb-3';

        const form =
            document.getElementById('bookingForm');

        form.parentNode.insertBefore(errorBox, form);

    }

    errorBox.textContent = message;

    errorBox.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });

}


function clearBookingError() {

    const errorBox =
        document.getElementById('booking-error');

    if (errorBox) {

        errorBox.remove();

    }

}


// =========================================================
// 12. Block submit when pickup and dropoff are the same
//     Checks BOTH the visible address text (case/whitespace
//     insensitive) AND the saved lat/lng, so it still catches
//     the case where the same place is written slightly
//     differently but was selected from autocomplete twice.
// =========================================================

document.addEventListener(
    'submit',
    function (e) {

        if (e.target.id !== 'bookingForm') {
            return;
        }

        const pickupInput =
            document.getElementById('pickup_address');

        const dropoffInput =
            document.getElementById('dropoff_address');

        if (!pickupInput || !dropoffInput) {
            return;
        }

        const pickupText =
            pickupInput.value.trim().toLowerCase();

        const dropoffText =
            dropoffInput.value.trim().toLowerCase();

        const pickupLat =
            document.querySelector('input[name="pickup_lat"]')?.value || '';

        const pickupLng =
            document.querySelector('input[name="pickup_lng"]')?.value || '';

        const dropoffLat =
            document.querySelector('input[name="dropoff_lat"]')?.value || '';

        const dropoffLng =
            document.querySelector('input[name="dropoff_lng"]')?.value || '';

        const sameText =
            pickupText !== '' && pickupText === dropoffText;

        const sameCoords =
            pickupLat !== '' &&
            pickupLng !== '' &&
            pickupLat === dropoffLat &&
            pickupLng === dropoffLng;

        if (sameText || sameCoords) {

            e.preventDefault();

            showBookingError(
                'Pickup and drop-off location cannot be the same. Please choose a different location.'
            );

        } else {

            clearBookingError();

        }

    }
);

</script>

@endsection