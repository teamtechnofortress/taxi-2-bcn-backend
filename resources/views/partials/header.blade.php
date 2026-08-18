<nav class="bcn-header">
    <div class="bcn-header-inner container-fluid d-flex align-items-center justify-content-between px-5">

        <!-- Brand -->
        <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none bcn-brand">
            <span class="bcn-wordmark">
                <span class="d-block bcn-brand-main">BCN</span>
                <span class="d-block bcn-wordmark-sub">Online Taxi</span>
            </span>
        </a>

        <!-- Actions -->
        <div class="d-flex align-items-center gap-3">

            <a href="mailto:info@bcnonlinetaxi.es"
               class="bcn-email-link d-none d-lg-flex align-items-center gap-2 text-decoration-none">

                <svg width="14" height="14" fill="currentColor" viewBox="0 0 512 512">
                    <path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"/>
                </svg>

                <span>info@bcnonlinetaxi.es</span>
            </a>

            <span class="bcn-divider d-none d-lg-block"></span>

            <a href="https://wa.me/123456789"
               class="bcn-icon-btn bcn-icon-btn-wa d-none d-md-flex align-items-center justify-content-center"
               aria-label="Chat on WhatsApp">

                <svg width="19" height="19" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.31.63 4.474 1.727 6.33L3 29l7.36-2.164a12.44 12.44 0 0 0 5.641 1.361h.005c6.905 0 12.5-5.596 12.5-12.5S22.906 3 16.001 3z"
                          fill="#25D366"/>

                    <path d="M12.4 9.9c-.24-.53-.49-.54-.72-.55-.19-.01-.4-.01-.62-.01-.21 0-.56.08-.85.4-.29.32-1.12 1.09-1.12 2.67 0 1.57 1.15 3.09 1.31 3.3.16.21 2.22 3.56 5.48 4.85 2.71 1.07 3.26.86 3.85.81.59-.05 1.9-.78 2.17-1.53.27-.75.27-1.39.19-1.53-.08-.13-.29-.21-.61-.37-.32-.16-1.9-.94-2.19-1.05-.29-.11-.51-.16-.72.16-.21.32-.83 1.05-1.01 1.26-.19.21-.37.24-.69.08-.32-.16-1.35-.5-2.57-1.58-.95-.85-1.59-1.9-1.78-2.22-.19-.32-.02-.49.14-.65.14-.14.32-.37.48-.56.16-.19.21-.32.32-.53.11-.21.05-.4-.03-.56-.08-.16-.7-1.75-.99-2.4z"
                          fill="#fff"/>
                </svg>
            </a>

            <a href="tel:+123456789"
               class="bcn-btn-solid d-inline-flex align-items-center gap-2">

                <svg width="15" height="15" fill="currentColor" viewBox="0 0 512 512">
                    <path d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z"/>
                </svg>

                <span>Call Us</span>
            </a>

            <div class="dropdown">
                <button class="bcn-btn-ghost dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown">
                    EN
                </button>

                <ul class="dropdown-menu dropdown-menu-end bcn-dropdown">
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
</nav>

<style>
.bcn-header {
    background: linear-gradient(180deg, #534f45 0%, #140606 100%);
}

.bcn-header-inner {
    height: 76px;
}

/* Brand */
.bcn-wordmark {
    line-height: 1.05;
    font-weight: 700;
    letter-spacing: 0.06em;
    font-size: 0.95rem;
    text-transform: uppercase;
}

/* BCN */
.bcn-brand-main {
    color: #ff9900;
    font-size: 1.25rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    line-height: 1;
}

/* Online Taxi */
.bcn-wordmark-sub {
    font-weight: 400;
    letter-spacing: 0.1em;
    font-size: 0.66rem;
    color: #d6d0c5;
    text-transform: none;
    margin-top: 4px;
}

/* Email link */
.bcn-email-link {
    color: #999;
    font-size: 0.85rem;
    white-space: nowrap;
    transition: color .2s ease;
}

.bcn-email-link:hover {
    color: #ff9900;
}

.bcn-divider {
    width: 1px;
    height: 18px;
    background: rgba(255,255,255,0.12);
}

/* WhatsApp */
.bcn-icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    text-decoration: none;
    transition: all .2s ease;
}

.bcn-icon-btn-wa {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.bcn-icon-btn-wa:hover {
    background: rgba(37, 211, 102, 0.12);
    border-color: rgba(37, 211, 102, 0.4);
    transform: translateY(-1px);
}

/* Call CTA */
.bcn-btn-solid {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.55rem 1.2rem;
    border-radius: 100px;
    text-decoration: none;
    background: linear-gradient(135deg, #ffad33, #ff9900);
    color: #0d0d0d;
    border: 1px solid transparent;
    transition: all .2s ease;
}

.bcn-btn-solid:hover {
    box-shadow: 0 6px 18px rgba(255,153,0,0.35);
    transform: translateY(-1px);
}

/* Language toggle */
.bcn-btn-ghost {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 0.9rem;
    border-radius: 100px;
    background: transparent;
    border: 1px solid rgba(255,255,255,0.16);
    color: #cc932a;
    transition: border-color .2s ease;
}

.bcn-btn-ghost:hover {
    border-color: rgba(255,255,255,0.35);
}

.bcn-dropdown {
    background: #1a1a1a;
    border: 1px solid rgba(255,255,255,0.1);
}

.bcn-dropdown .dropdown-item {
    color: #cfcfcf;
    font-size: 0.9rem;
}

.bcn-dropdown .dropdown-item:hover {
    background: rgba(255,153,0,0.1);
    color: #ff9900;
}
</style>