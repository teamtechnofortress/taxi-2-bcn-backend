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

<a href="https://wa.me/123456789"
   class="bcn-floating-whatsapp"
   aria-label="Chat on WhatsApp"
   target="_blank"
   rel="noopener">
    <svg viewBox="0 0 16 16" aria-hidden="true">
        <path fill="currentColor" d="M13.601 2.326A7.86 7.86 0 0 0 8.008 0C3.582 0 .002 3.58 0 7.994a7.96 7.96 0 0 0 1.064 3.973L0 16l4.143-1.087a7.95 7.95 0 0 0 3.858.982h.003c4.415 0 7.996-3.58 7.998-7.994a7.95 7.95 0 0 0-2.401-5.575zM8.004 14.54a6.6 6.6 0 0 1-3.356-.92l-.24-.143-2.456.644.656-2.394-.156-.246a6.58 6.58 0 0 1-1.007-3.487c.001-3.616 2.944-6.558 6.562-6.558a6.52 6.52 0 0 1 4.658 1.932 6.54 6.54 0 0 1 1.926 4.63c-.002 3.617-2.945 6.542-6.587 6.542zm3.614-4.922c-.197-.099-1.17-.578-1.353-.644-.182-.066-.315-.099-.445.099-.132.197-.512.644-.627.776-.115.132-.231.148-.428.05-.197-.1-.832-.307-1.584-.979-.586-.522-.981-1.166-1.096-1.364-.115-.197-.012-.304.087-.403.089-.088.197-.23.296-.346.099-.115.132-.197.197-.33.066-.132.033-.247-.016-.346-.05-.099-.446-1.075-.611-1.47-.161-.388-.325-.335-.445-.34-.115-.005-.247-.006-.379-.006a.73.73 0 0 0-.527.247c-.182.198-.692.677-.692 1.652s.709 1.916.807 2.048c.099.132 1.394 2.132 3.383 2.99.473.204.841.326 1.129.417.474.151.906.13 1.248.079.381-.057 1.17-.479 1.336-.941.165-.462.165-.858.115-.941-.049-.083-.181-.132-.378-.231z"/>
    </svg>
</a>

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

/* Floating WhatsApp */

.bcn-floating-whatsapp {
    position: fixed;
    left: 28px;
    bottom: 30px;
    z-index: 1100;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    width: 54px;
    height: 54px;

    color: #ffffff;
    background: #25d366;
    border: 1px solid #25d366;
    border-radius: 50%;
    text-decoration: none;

    box-shadow: none;

    transition:
        background 0.16s ease,
        border-color 0.16s ease;
}

.bcn-floating-whatsapp:hover,
.bcn-floating-whatsapp:focus-visible {
    color: #ffffff;
    background: #1fbd5a;
    border-color: #1fbd5a;
    box-shadow: none;
}

.bcn-floating-whatsapp svg {
    display: block;
    width: 27px;
    height: 27px;
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
.bcn-floating-whatsapp:focus-visible,
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

    .bcn-floating-whatsapp {
        left: 18px;
        bottom: 22px;
        width: 50px;
        height: 50px;
    }

    .bcn-floating-whatsapp svg {
        width: 23px;
        height: 23px;
    }
}

</style>
