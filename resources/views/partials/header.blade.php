<nav class="navbar navbar-dark bg-dark px-5 py-5">
    
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-4 text-white">
            <div class="d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="22"
                     height="22"
                     fill="#ff9900"
                     viewBox="0 0 496 512">
                    <path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z"/>
                </svg>
                <span class="fs-5">
                    BCN Online Taxi
                </span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <svg aria-hidden="true" class="e-font-icon-svg e-fas-envelope" width="22"
                     height="22" fill="#ff9900" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path>
                </svg>
                <span>
                    info@bcnonlinetaxi.es
                </span>
            </div>
        </div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <img src="images/logo.png"
                 width="100" height="100"
                 alt="Taxi Logo">
        </div>
        <div class="d-flex align-items-center gap-4">
            <a href="https://wa.me/123456789"
               class="text-decoration-none text-white d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="22"
                     height="22"
                     fill="#ff9900"
                     viewBox="0 0 448 512">
                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157z"/>
                </svg>
                <span>WhatsApp Us</span>
            </a>
            <a href="tel:+123456789"
               class="text-decoration-none text-white d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="22"
                     height="22"
                     fill="#ff9900"
                     viewBox="0 0 512 512">
                    <path d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z"/>
                </svg>
                <span>Call Us</span>
            </a>
            <div class="d-flex align-items-center gap-2">
<div class="dropdown">
    <button class="btn btn-warning dropdown-toggle lang-btn" type="button" data-bs-toggle="dropdown">
         Language
    </button>

    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ url('/lang/en') }}">
                 English
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="{{ url('/lang/fr') }}">
                 French
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="{{ url('/lang/ar') }}">
                 Arabic
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ url('/lang/es') }}">
                 Spanish
            </a>
        </li>
    </ul>
</div>

</div>
        </div>
    </div>
</nav>
 