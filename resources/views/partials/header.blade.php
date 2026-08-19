<a href="#main-content" class="bcn-skip-link">Skip to content</a>

<header class="bcn-header">
    <div class="bcn-header-inner container-fluid d-flex align-items-center justify-content-between">

        <!-- Brand -->
        <a href="{{ url('/') }}" class="bcn-brand d-flex align-items-center text-decoration-none">

            <span class="bcn-brand-mark" aria-hidden="true">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </span>

            <span class="bcn-wordmark">
                <span class="d-block bcn-brand-main">BCN <span class="bcn-brand-thin">Online Taxi</span></span>
            </span>

        </a>

        <!-- Actions -->
        <div class="bcn-actions d-flex align-items-center">

            <a href="mailto:info@bcnonlinetaxi.es" class="bcn-link d-none d-lg-inline-flex align-items-center">
                info@bcnonlinetaxi.es
            </a>

            <a href="tel:+123456789" class="bcn-link d-none d-md-inline-flex align-items-center">
                +1 234 567 89
            </a>

            <a href="https://wa.me/123456789"
               class="bcn-icon-btn d-none d-md-inline-flex align-items-center justify-content-center"
               aria-label="Chat on WhatsApp"
               target="_blank" rel="noopener">

                <svg width="17" height="17" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                    <path d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.31.63 4.474 1.727 6.33L3 29l7.36-2.164a12.44 12.44 0 0 0 5.641 1.361h.005c6.905 0 12.5-5.596 12.5-12.5S22.906 3 16.001 3z"
                          fill="currentColor"/>
                    <path d="M12.4 9.9c-.24-.53-.49-.54-.72-.55-.19-.01-.4-.01-.62-.01-.21 0-.56.08-.85.4-.29.32-1.12 1.09-1.12 2.67 0 1.57 1.15 3.09 1.31 3.3.16.21 2.22 3.56 5.48 4.85 2.71 1.07 3.26.86 3.85.81.59-.05 1.9-.78 2.17-1.53.27-.75.27-1.39.19-1.53-.08-.13-.29-.21-.61-.37-.32-.16-1.9-.94-2.19-1.05-.29-.11-.51-.16-.72.16-.21.32-.83 1.05-1.01 1.26-.19.21-.37.24-.69.08-.32-.16-1.35-.5-2.57-1.58-.95-.85-1.59-1.9-1.78-2.22-.19-.32-.02-.49.14-.65.14-.14.32-.37.48-.56.16-.19.21-.32.32-.53.11-.21.05-.4-.03-.56-.08-.16-.7-1.75-.99-2.4z"
                          fill="#fff"/>
                </svg>
            </a>

            <div class="dropdown bcn-lang">
                <button class="bcn-btn-ghost dropdown-toggle d-inline-flex align-items-center gap-1"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    {{ strtoupper(app()->getLocale()) }}
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <ul class="dropdown-menu dropdown-menu-end bcn-dropdown">

                    @php
                        $bcnLanguages = [
                            'en' => 'English',
                            'fr' => 'French',
                            'ar' => 'Arabic',
                            'es' => 'Spanish',
                        ];
                    @endphp

                    @foreach ($bcnLanguages as $bcnLangCode => $bcnLangLabel)
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between {{ app()->getLocale() === $bcnLangCode ? 'active' : '' }}"
                               href="{{ url('/lang/'.$bcnLangCode) }}">
                                <span>{{ $bcnLangLabel }}</span>
                                @if (app()->getLocale() === $bcnLangCode)
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M4 12l5 5L20 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>

        </div>
    </div>
</header>

<style>

:root {
    --bcn-ink: #f8fafc;
    --bcn-ink-soft: #d7deec;
    --bcn-muted: #9aa7bd;

    --bcn-line: rgba(255, 255, 255, 0.08);
    --bcn-surface: rgba(7, 8, 11, 0.88);
    --bcn-surface-hover: rgba(255, 255, 255, 0.08);

    --bcn-accent: #ffc107;
    --bcn-accent-hover: #ffb000;
    --bcn-accent-tint: rgba(255, 193, 7, 0.12);
}


/* =========================================================
   SKIP LINK
   ========================================================= */

.bcn-skip-link {
    position: absolute;
    top: -48px;
    left: 12px;

    background: var(--bcn-ink);
    color: #fff;

    padding: 10px 16px;
    border-radius: 8px;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none;
    z-index: 2000;

    transition: top 0.15s ease;
}

.bcn-skip-link:focus {
    top: 12px;
    color: #fff;
}


/* =========================================================
   HEADER SHELL
   ========================================================= */

.bcn-header {
    position: sticky;
    top: 0;
    z-index: 1000;

    background: var(--bcn-surface);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--bcn-line);
    box-shadow: 0 16px 44px rgba(0, 0, 0, 0.28);
}

.bcn-header-inner {
    height: 74px;
    max-width: 1320px;
    margin: 0 auto;
    padding-left: clamp(16px, 4vw, 40px);
    padding-right: clamp(16px, 4vw, 40px);
}


/* =========================================================
   BRAND
   ========================================================= */

.bcn-brand {
    gap: 12px;
    color: inherit;
}

.bcn-brand-mark {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 42px;
    height: 42px;
    flex: 0 0 auto;

    border-radius: 50%;
    overflow: hidden;

    background: var(--bcn-accent);
    box-shadow:
        0 0 0 1px rgba(255, 193, 7, 0.42),
        0 10px 24px rgba(0, 0, 0, 0.26);
}

.bcn-brand-mark img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.bcn-wordmark {
    line-height: 1;
}

.bcn-brand-main {
    color: var(--bcn-ink);
    font-size: 1.02rem;
    font-weight: 800;
    letter-spacing: 0;
}

.bcn-brand-thin {
    color: var(--bcn-accent);
    font-weight: 800;
    margin-left: 4px;
}


/* =========================================================
   ACTIONS
   ========================================================= */

.bcn-actions {
    gap: 22px;
}

.bcn-link {
    color: var(--bcn-ink-soft);
    font-size: 0.88rem;
    font-weight: 650;
    white-space: nowrap;
    text-decoration: none;

    transition: color 0.15s ease;
}

.bcn-link:hover,
.bcn-link:focus-visible {
    color: var(--bcn-accent);
}

/* WhatsApp icon */

.bcn-icon-btn {
    width: 34px;
    height: 34px;
    flex: 0 0 auto;

    border-radius: 8px;

    color: #25d366;
    background: rgba(255, 255, 255, 0.035);
    text-decoration: none;

    transition: color 0.15s ease, background 0.15s ease;
}

.bcn-icon-btn:hover,
.bcn-icon-btn:focus-visible {
    color: #25d366;
    background: var(--bcn-surface-hover);
}

/* Language switcher */

.bcn-btn-ghost {
    font-size: 0.85rem;
    font-weight: 750;
    letter-spacing: 0;

    padding: 7px 10px;
    border-radius: 8px;

    background: rgba(255, 255, 255, 0.035);
    border: none;
    color: var(--bcn-ink-soft);

    transition: background 0.15s ease, color 0.15s ease;
}

.bcn-btn-ghost:hover,
.bcn-btn-ghost:focus-visible {
    background: var(--bcn-surface-hover);
    color: var(--bcn-accent);
}

.bcn-btn-ghost::after {
    display: none; /* drop Bootstrap's default caret, we render our own */
}

.bcn-dropdown {
    min-width: 160px;
    margin-top: 10px;
    padding: 6px;

    background: #11151d;
    border: 1px solid var(--bcn-line);
    border-radius: 8px;

    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.34);
}

.bcn-dropdown .dropdown-item {
    color: var(--bcn-ink-soft);
    font-size: 0.87rem;
    font-weight: 500;

    padding: 8px 10px;
    border-radius: 6px;

    transition: background 0.15s ease, color 0.15s ease;
}

.bcn-dropdown .dropdown-item:hover,
.bcn-dropdown .dropdown-item:focus-visible {
    background: var(--bcn-surface-hover);
    color: var(--bcn-accent);
}

.bcn-dropdown .dropdown-item.active {
    background: var(--bcn-accent-tint);
    color: var(--bcn-accent);
}

.bcn-btn-cta {
    display: inline-flex;
    align-items: center;

    font-size: 0.87rem;
    font-weight: 800;
    letter-spacing: 0;

    padding: 11px 20px;
    border-radius: 8px;

    background: linear-gradient(180deg, #ffd76a 0%, var(--bcn-accent) 100%);
    color: #111318;

    text-decoration: none;
    white-space: nowrap;

    box-shadow:
        0 10px 24px rgba(255, 193, 7, 0.26),
        inset 0 1px 0 rgba(255, 255, 255, 0.35);

    transition:
        background 0.15s ease,
        transform 0.15s ease,
        box-shadow 0.15s ease;
}

.bcn-btn-cta:hover,
.bcn-btn-cta:focus-visible {
    background: linear-gradient(180deg, #ffcf4a 0%, var(--bcn-accent-hover) 100%);
    color: #111318;
    transform: translateY(-1px);
    box-shadow: 0 14px 28px rgba(255, 193, 7, 0.34);
}


/* Consistent keyboard focus */

.bcn-brand:focus-visible,
.bcn-link:focus-visible,
.bcn-icon-btn:focus-visible,
.bcn-btn-ghost:focus-visible,
.bcn-btn-cta:focus-visible,
.bcn-dropdown .dropdown-item:focus-visible {
    outline: 2px solid var(--bcn-accent);
    outline-offset: 2px;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 575px) {

    .bcn-header-inner {
        height: 64px;
    }

    .bcn-brand-main {
        font-size: 0.95rem;
    }

    .bcn-brand-thin {
        display: none;
    }

    .bcn-actions {
        gap: 10px;
    }

    .bcn-btn-cta {
        padding: 8px 14px;
    }
}

</style>
