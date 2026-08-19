@extends('layouts.main')

@section('title', config('app.name'))

@section('content')
<style>

/* =========================================================
   DESIGN TOKENS
   ========================================================= */

:root {
    --bg-base: #07080b;

    --surface-1: rgba(17, 19, 27, 0.88);
    --surface-2: rgba(9, 10, 14, 0.92);
    --field-bg: rgba(22, 25, 36, 0.92);
    --field-bg-hover: rgba(29, 34, 48, 0.96);
    --field-bg-focus: rgba(255, 193, 7, 0.08);

    --border-subtle: rgba(255, 255, 255, 0.09);
    --border-field: rgba(153, 170, 204, 0.2);
    --border-accent: rgba(255, 193, 7, 0.24);

    --accent-100: #ffe6a3;
    --accent-300: #ffd45a;
    --accent-500: #ffc107;
    --accent-600: #ffb000;
    --accent-700: #d89100;

    --text-primary: #f8fafc;
    --text-secondary: #d6deee;
    --text-muted: #9aa7bd;
    --text-faint: rgba(214, 222, 238, 0.56);

    --danger: #ff6b6b;

    --radius-xl: 8px;
    --radius-lg: 8px;
    --radius-md: 8px;
    --radius-sm: 6px;
    --radius-pill: 999px;

    --field-h: 50px;
    --field-h-sm: 48px;

    --shadow-card: 0 28px 90px rgba(0, 0, 0, 0.56);
    --shadow-btn: 0 14px 30px rgba(255, 193, 7, 0.28);

    --ease: cubic-bezier(0.22, 1, 0.36, 1);
}

body {
    background: var(--bg-base);
    color: var(--text-primary);
    font-family:
        Inter,
        ui-sans-serif,
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}


/* ============ Hero ============ */

.hero-section {
    position: relative;
    min-height: calc(100dvh - 74px);
    background: linear-gradient(90deg, rgba(7, 8, 11, 0.88) 0%, rgba(9, 11, 18, 0.68) 46%, rgba(7, 8, 11, 0.84) 100%),
        url('/images/bgimg.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    display: flex;
    align-items: center;
    padding: 42px 0 46px;
    isolation: isolate;
}

.hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    z-index: -1;
    background:
        linear-gradient(180deg, rgba(7, 8, 11, 0.08) 0%, rgba(7, 8, 11, 0.54) 100%),
        linear-gradient(90deg, rgba(255, 193, 7, 0.08) 0%, transparent 34%);
    pointer-events: none;
}

.small-text {
    color: var(--accent-300);
    font-size: 12.5px;
    font-weight: 800;
    letter-spacing: 0;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.dot {
    color: var(--accent-500);
    font-size: 22px;
    line-height: 0;
}

.hero-heading {
    color: var(--text-primary);
    font-size: 62px;
    font-weight: 850;
    line-height: 1.02;
    letter-spacing: 0;
    margin-top: 18px;
    text-wrap: balance;
}

.hero-description {
    color: var(--text-secondary);
    font-size: 16px;
    line-height: 1.68;
    margin-top: 22px;
    max-width: 410px;
}


/* ============ Booking card ============ */

.booking-card {
    position: relative;
    overflow: visible;
    background: linear-gradient(180deg, var(--surface-1) 0%, var(--surface-2) 100%);

    backdrop-filter: blur(22px);
    -webkit-backdrop-filter: blur(22px);

    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-xl);

    padding: 28px 44px 30px;

    box-shadow:
        var(--shadow-card),
        inset 0 1px 0 rgba(255, 255, 255, 0.07);
}

.booking-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 193, 7, 0.65), transparent);
}

.hero-section .booking-card {
    overflow: visible !important;
}

.booking-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 18px;
}

.booking-card-copy {
    max-width: 360px;
}

.booking-card-kicker {
    color: var(--accent-300);
    font-size: 11.5px;
    font-weight: 850;
    line-height: 1.2;
    margin-bottom: 5px;
    text-transform: uppercase;
}

.booking-card-title {
    color: var(--text-primary);
    font-size: 25px;
    font-weight: 700;
    line-height: 1.16;
    margin: 0;
}

.booking-card-subtitle {
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.55;
    margin: 10px 0 0;
}


/* ============ Tabs ============ */

.booking-tabs {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 3px;

    min-height: 48px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(154, 167, 189, 0.16);

    border-radius: var(--radius-pill);
    padding: 4px;

    width: fit-content;
    margin: 1px 0 0;
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, 0.04),
        0 10px 24px rgba(0, 0, 0, 0.16);
}

.airport-mode-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    background: transparent;
    border: 1px solid transparent;
    color: #cbd6ea;

    min-width: 136px;
    min-height: 38px;
    padding: 0 18px;

    border-radius: var(--radius-pill);

    font-weight: 750;
    font-size: 13.5px;

    letter-spacing: 0;
    white-space: nowrap;

    transition:
        color 0.18s ease,
        background 0.18s ease,
        border-color 0.18s ease,
        box-shadow 0.18s ease;
    cursor: pointer;
}

.airport-mode-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    width: 16px;
    height: 16px;
    margin-top: 1px;
    margin-bottom: 0;
}

.airport-mode-icon svg {
    display: block;
    width: 15px;
    height: 15px;
    opacity: 0.9;
}

.airport-mode-btn:hover {
    color: var(--accent-300);
    background: rgba(255, 255, 255, 0.055);
    border-color: rgba(255, 193, 7, 0.14);
}

.airport-mode-btn:focus-visible {
    outline: 2px solid var(--accent-500);
    outline-offset: 2px;
}

.airport-mode-btn.active,
.airport-mode-btn.active:hover {
    background: linear-gradient(180deg, #ffda70 0%, var(--accent-500) 100%);
    color: #101216;
    border-color: rgba(255, 232, 159, 0.5);

    box-shadow:
        0 8px 18px rgba(255, 193, 7, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.42);
}

.airport-mode-btn.active svg {
    opacity: 1;
}

.booking-tabs .airport-mode-btn:not(.active):hover,
.booking-tabs .airport-mode-btn[aria-selected="false"]:hover {
    color: var(--accent-300);
    background: rgba(255, 255, 255, 0.055);
    border-color: rgba(255, 193, 7, 0.16);
    box-shadow: none;
}

.booking-tabs .airport-mode-btn.active,
.booking-tabs .airport-mode-btn[aria-selected="true"] {
    background: linear-gradient(180deg, #ffda70 0%, var(--accent-500) 100%);
    color: #101216;
    border-color: rgba(255, 232, 159, 0.5);
    box-shadow:
        0 8px 18px rgba(255, 193, 7, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.42);
}

.booking-card .airport-toggle {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 4px !important;
    min-height: 48px !important;
    padding: 4px !important;
    background: rgba(18, 18, 30, 0.96) !important;
    border: 1px solid rgba(154, 167, 189, 0.2) !important;
    border-radius: var(--radius-pill) !important;
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, 0.05),
        0 12px 26px rgba(0, 0, 0, 0.18) !important;
}

.booking-card .airport-toggle .airport-toggle-btn {
    appearance: none !important;
    -webkit-appearance: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    min-width: 136px !important;
    min-height: 38px !important;
    padding: 0 18px !important;
    margin: 0 !important;
    color: #d6deee !important;
    background: transparent !important;
    border: 1px solid transparent !important;
    border-radius: var(--radius-pill) !important;
    box-shadow: none !important;
    font-size: 13.5px !important;
    font-weight: 750 !important;
    line-height: 1 !important;
}

.booking-card .airport-toggle .airport-toggle-btn:not(.active):hover,
.booking-card .airport-toggle .airport-toggle-btn[aria-selected="false"]:hover {
    color: var(--accent-300) !important;
    background: rgba(255, 255, 255, 0.055) !important;
    border-color: rgba(255, 193, 7, 0.16) !important;
    box-shadow: none !important;
}

.booking-card .airport-toggle .airport-toggle-btn.active,
.booking-card .airport-toggle .airport-toggle-btn[aria-selected="true"] {
    color: #101216 !important;
    background: linear-gradient(180deg, #ffda70 0%, var(--accent-500) 100%) !important;
    border-color: rgba(255, 232, 159, 0.5) !important;
    box-shadow:
        0 8px 18px rgba(255, 193, 7, 0.22),
        inset 0 1px 0 rgba(255, 255, 255, 0.42) !important;
}


/* =========================================================
   BOOKING FORM
   ========================================================= */

/*
 * Bootstrap .row uses negative margins and .col-md-6 uses
 * horizontal padding. These rules keep every booking-form
 * row and column behaving consistently.
 */

.booking-form {
    width: 100%;
    min-width: 0;
}

.booking-group {
    padding-top: 14px;
    margin-top: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.07);
}

.booking-group:first-of-type {
    padding-top: 0;
    margin-top: 0;
    border-top: none;
}

.booking-group-header {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 9px;
}

.booking-group-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 19px;
    height: 19px;
    flex: 0 0 auto;
    border-radius: 50%;
    background: rgba(255, 193, 7, 0.14);
    color: var(--accent-300);
    font-size: 11px;
    font-weight: 850;
}

.booking-group-title {
    color: var(--text-primary);
    font-size: 13.25px;
    font-weight: 800;
    line-height: 1.2;
}

.booking-form .row {
    --bs-gutter-x: 22px;
    --bs-gutter-y: 9px;
    width: 100%;
    min-width: 0;
    margin-left: 0;
    margin-right: 0;
}

.booking-form .mb-3 {
    margin-bottom: 9px !important;
}

.booking-form .row > [class*="col-"] {
    min-width: 0;
    box-sizing: border-box;
}

.field-error {
    display: block;
    margin-top: 6px;
    color: var(--danger);
    font-size: 12.5px;
}


/*
 * Every plain text/select field shares exactly the same
 * dimensions and visual language.
 */

.booking-form input,
.booking-form select {
    box-sizing: border-box;

    display: block;

    width: 100%;
    max-width: 100%;
    min-width: 0;

    height: var(--field-h);
    min-height: var(--field-h);

    margin: 0;

    padding: 0 18px 0 48px;

    background-color: var(--field-bg);

    border: 1px solid var(--border-field);
    border-radius: var(--radius-md);

    color: var(--text-primary);

    font-size: 14.5px;
    font-weight: 600;

    line-height: var(--field-h);

    outline: none;

    background-repeat: no-repeat;
    background-position: 17px center;
    background-size: 17px 17px;

    -webkit-appearance: none;
    appearance: none;

    overflow: hidden;
    text-overflow: ellipsis;

    transition:
        border-color 0.2s ease,
        background-color 0.2s ease,
        box-shadow 0.2s ease;

    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, 0.035),
        0 1px 0 rgba(255, 255, 255, 0.02);
}

.booking-form input:hover,
.booking-form select:hover {
    background-color: var(--field-bg-hover);
    border-color: rgba(214, 222, 238, 0.34);
}


/* Placeholder */

.booking-form input::placeholder {
    color: rgba(154, 167, 189, 0.82);
    opacity: 1;
}


/* Select */

.booking-form select {
    cursor: pointer;

    line-height: normal;

    background-image:
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M6 9l6 6 6-6' fill='none' stroke='white' stroke-opacity='0.5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"),
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Ccircle cx='9' cy='8' r='3' fill='%23ffc107' fill-opacity='0.82'/%3E%3Ccircle cx='16' cy='9' r='2.4' fill='%23c9d2e3' fill-opacity='0.55'/%3E%3Cpath d='M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6' fill='%23ffc107' fill-opacity='0.82'/%3E%3C/svg%3E");

    background-position:
        right 16px center,
        17px center;

    background-size:
        13px 13px,
        17px 17px;
}

.booking-form select option {
    background: #11151d;
    color: var(--text-primary);
}


/* Focus */

.booking-form input:focus,
.booking-form select:focus {
    outline: none;

    border-color: var(--accent-500);

    background-color: rgba(22, 25, 36, 0.98);

    box-shadow:
        0 0 0 3px rgba(255, 193, 7, 0.16),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
}

.booking-form input:invalid:not(:placeholder-shown) {
    border-color: var(--danger);
}


/* =========================================================
   FIELD ICONS
   ========================================================= */

input[name="name"] {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Ccircle cx='12' cy='8' r='4' fill='%23ffc107' fill-opacity='0.82'/%3E%3Cpath d='M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8' fill='%23ffc107' fill-opacity='0.82'/%3E%3C/svg%3E");
}

input[name="email"] {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect x='3' y='5' width='18' height='14' rx='2' fill='none' stroke='%23ffc107' stroke-opacity='0.82' stroke-width='1.6'/%3E%3Cpath d='M4 6l8 7 8-7' fill='none' stroke='%23ffc107' stroke-opacity='0.82' stroke-width='1.6'/%3E%3C/svg%3E");
}

input[name="phone"] {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M6.6 3.4c1 3 2.2 5.4 4.3 7.5s4.5 3.3 7.5 4.3l2-2c2 .9 3 1.9 4 3.6l-2.2 3.4c-8.4.6-16.5-7.5-15.9-15.9l3.4-2.2z' fill='%23ffc107' fill-opacity='0.82'/%3E%3C/svg%3E");
}


/* =========================================================
   LOCATION FIELD (search + selected "chip" states)
   ========================================================= */

/*
 * Modern rideshare-style pattern: while typing you get a
 * normal single-line input with live suggestions; once a
 * place is picked it becomes a two-line chip (short name +
 * full address beneath it), so the complete address stays
 * readable without shrinking the font to fit one line.
 */

.location-field {
    position: relative;
    width: 100%;
    min-width: 0;
    z-index: 1;
}

.location-field:focus-within {
    z-index: 10010;
}

.location-icon {
    position: absolute;
    left: 17px;
    top: 50%;
    transform: translateY(-50%);
    width: 17px;
    height: 17px;
    pointer-events: none;
    opacity: 0.9;
    z-index: 2;
}

.location-field input[name$="_search"] {
    padding-left: 48px;
}

.location-clear-btn {
    position: absolute;

    top: 50%;
    right: 12px;

    transform: translateY(-50%);

    width: 22px;
    height: 22px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0;
    margin: 0;

    border: none;
    border-radius: 50%;

    background: rgba(255, 255, 255, 0.08);

    color: var(--text-secondary);

    font-size: 14px;
    line-height: 1;

    cursor: pointer;

    z-index: 5;

    transition:
        background 0.2s ease,
        color 0.2s ease,
        transform 0.2s ease;
}

.location-clear-btn:hover {
    background: rgba(255, 193, 7, 0.16);
    color: var(--accent-500);
    transform: translateY(-50%) scale(1.08);
}

.location-clear-btn:focus-visible {
    outline: 2px solid var(--accent-500);
    outline-offset: 2px;
}

/* Selected-location chip */

.location-chip {
    display: none;
    align-items: flex-start;
    gap: 12px;

    width: 100%;
    box-sizing: border-box;

    min-height: var(--field-h);

    padding: 11px 40px 11px 16px;

    background: rgba(255, 193, 7, 0.09);

    border: 1px solid var(--border-accent);
    border-radius: var(--radius-md);

    cursor: default;
}

.location-chip.show {
    display: flex;
}

.location-chip:focus-within,
.location-chip.is-focused {
    border-color: var(--accent-500);
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.14);
}

.location-chip-icon {
    flex: 0 0 auto;
    width: 17px;
    height: 17px;
    margin-top: 2px;
    opacity: 0.75;
}

.location-chip-text {
    flex: 1 1 auto;
    min-width: 0;
}

.location-chip-primary {
    color: var(--accent-300);
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.35;

    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
}

.location-chip-secondary {
    color: var(--text-secondary);
    font-size: 12px;
    line-height: 1.4;
    margin-top: 2px;

    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}


/* =========================================================
   AUTOCOMPLETE DROPDOWN
   ========================================================= */

.location-results {
    position: absolute;

    top: calc(100% + 8px);
    left: 0;
    right: 0;

    background: rgba(17, 21, 29, 0.98);

    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-md);

    box-shadow:
        0 18px 44px rgba(0, 0, 0, 0.55),
        inset 0 1px 0 rgba(255, 255, 255, 0.04);

    z-index: 9999;

    max-height: 250px;

    overflow-y: auto;
    overflow-x: hidden;

    scrollbar-width: thin;
    scrollbar-color: var(--accent-500) #000;
}

.location-results:empty {
    display: none;
    height: 0;
    max-height: 0;
    padding: 0;
    overflow: hidden;
    border: 0;
    background: transparent;
    box-shadow: none;
}

.location-results:not(:empty) {
    display: block;
}

#pickup-results:empty,
#dropoff-results:empty {
    display: none;
    height: 0;
    max-height: 0;
    padding: 0;
    overflow: hidden;
    border: 0;
    background: transparent;
    box-shadow: none;
}

#pickup-results:not(:empty),
#dropoff-results:not(:empty) {
    display: block;
}

.location-results::-webkit-scrollbar {
    width: 7px;
}

.location-results::-webkit-scrollbar-track {
    background: #000;
    border-radius: var(--radius-md);
}

.location-results::-webkit-scrollbar-thumb {
    background: var(--accent-500);
    border-radius: var(--radius-md);
}

.location-results::-webkit-scrollbar-thumb:hover {
    background: var(--accent-600);
}

.autocomplete-item {
    display: flex;
    align-items: center;

    gap: 10px;

    padding: 12px 16px;

    color: var(--text-secondary);

    font-size: 13.5px;
    line-height: 1.35;

    border-bottom: 1px solid rgba(255, 255, 255, 0.05);

    cursor: pointer;

    transition: 0.15s ease;
}

.autocomplete-item::before {
    content: '';

    flex: 0 0 auto;

    width: 14px;
    height: 14px;

    opacity: 0.6;

    background-repeat: no-repeat;
    background-size: contain;

    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 2C7.6 2 4 5.6 4 10c0 6 8 12 8 12s8-6 8-12c0-4.4-3.6-8-8-8zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z' fill='white'/%3E%3C/svg%3E");
}

.autocomplete-item:last-child {
    border-bottom: none;
}

.autocomplete-item:hover,
.autocomplete-item:focus-visible {
    background: rgba(255, 193, 7, 0.11);
    color: var(--accent-500);
}

.autocomplete-loading,
.autocomplete-empty {
    padding: 12px 16px;
    color: var(--text-muted);
    font-size: 13px;
}

.booking-card .bcn-location-results {
    position: absolute !important;
    top: calc(100% + 8px) !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 10020 !important;
    display: block !important;
    max-height: 238px !important;
    padding: 6px !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    background: rgba(12, 14, 22, 0.98) !important;
    border: 1px solid rgba(154, 167, 189, 0.18) !important;
    border-radius: 8px !important;
    box-shadow:
        0 18px 44px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
    scrollbar-width: thin !important;
    scrollbar-color: var(--accent-500) rgba(255, 255, 255, 0.08) !important;
}

.booking-card .bcn-location-results:empty,
.booking-card #pickup-results.bcn-location-results:empty,
.booking-card #dropoff-results.bcn-location-results:empty {
    display: none !important;
    height: 0 !important;
    max-height: 0 !important;
    padding: 0 !important;
    overflow: hidden !important;
    border: 0 !important;
    background: transparent !important;
    box-shadow: none !important;
}

.booking-card .bcn-location-results:not(:empty),
.booking-card #pickup-results.bcn-location-results:not(:empty),
.booking-card #dropoff-results.bcn-location-results:not(:empty) {
    display: block !important;
}

.booking-card .bcn-autocomplete-item {
    display: grid !important;
    grid-template-columns: 16px minmax(0, 1fr) !important;
    align-items: start !important;
    column-gap: 10px !important;
    width: 100% !important;
    min-height: 42px !important;
    padding: 10px 12px !important;
    margin: 0 !important;
    color: var(--text-secondary) !important;
    background: transparent !important;
    border: 0 !important;
    border-radius: 6px !important;
    box-shadow: none !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    line-height: 1.35 !important;
    text-align: left !important;
    cursor: pointer !important;
}

.booking-card .bcn-autocomplete-item::before {
    content: '' !important;
    width: 14px !important;
    height: 14px !important;
    margin-top: 2px !important;
    opacity: 0.72 !important;
    background-repeat: no-repeat !important;
    background-size: contain !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 2C7.6 2 4 5.6 4 10c0 6 8 12 8 12s8-6 8-12c0-4.4-3.6-8-8-8zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z' fill='%23ffd45a'/%3E%3C/svg%3E") !important;
}

.booking-card .bcn-autocomplete-item:hover,
.booking-card .bcn-autocomplete-item:focus-visible {
    color: var(--text-primary) !important;
    background: rgba(255, 193, 7, 0.1) !important;
    outline: none !important;
}

.booking-card .bcn-autocomplete-item + .bcn-autocomplete-item {
    margin-top: 2px !important;
}

.booking-card .bcn-autocomplete-message {
    padding: 11px 12px !important;
    color: var(--text-muted) !important;
    background: transparent !important;
    border: 0 !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    line-height: 1.35 !important;
}


/* =========================================================
   DATE / TIME
   ========================================================= */

input[type="date"],
input[type="time"] {
    color-scheme: dark;
    cursor: pointer;
    padding-left: 18px;
}

input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
    filter:
        invert(72%)
        sepia(93%)
        saturate(748%)
        hue-rotate(360deg)
        brightness(101%)
        contrast(101%);

    cursor: pointer;
}

input[type="date"]:invalid {
    border-color: var(--danger);
}


/* =========================================================
   BOOKING ERROR
   ========================================================= */

#booking-error {
    display: flex;
    align-items: center;
    gap: 10px;

    border-radius: var(--radius-md);
    font-size: 14px;
}


/* =========================================================
   SUBMIT
   ========================================================= */

.booking-submit-row {
    --bs-gutter-y: 0;
    margin-top: 10px;
}

.booking-submit-row > [class*="col-"] {
    padding-top: 0;
}

.book-btn {
    position: relative;
    overflow: hidden;

    width: 100%;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    min-height: 52px;

    background: linear-gradient(180deg, #ffdb72 0%, #ffc22e 52%, #f5a900 100%);

    border: 1px solid rgba(255, 226, 147, 0.42);

    padding: 0 18px;

    border-radius: var(--radius-md);

    font-size: 15.5px;
    font-weight: 850;

    letter-spacing: 0;

    margin-top: 0;

    box-shadow:
        0 14px 28px rgba(255, 193, 7, 0.24),
        inset 0 1px 0 rgba(255, 255, 255, 0.52);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;

    color: #101216;

    cursor: pointer;
}

.book-btn:hover {
    transform: translateY(-2px);
    background: linear-gradient(180deg, #ffd463 0%, #ffba20 52%, #e99e00 100%);
    box-shadow:
        0 16px 32px rgba(255, 193, 7, 0.31),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
}

.book-btn:active {
    transform: translateY(0);
}

.book-btn:focus-visible {
    outline: 2px solid var(--accent-100);
    outline-offset: 2px;
}


/* =========================================================
   MOTION
   ========================================================= */

@media (prefers-reduced-motion: reduce) {

    .sv {
        animation: none !important;
    }

    .book-btn:hover {
        transform: none;
    }
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 991px) {

    .hero-section {
        min-height: auto;
        align-items: center;
        padding: 90px 0 40px;
        background-attachment: scroll;
    }

    .hero-content {
        text-align: center;
        margin-bottom: 32px;
    }

    .small-text {
        justify-content: center;
    }

    .hero-heading {
        font-size: 42px;
    }

    .hero-description {
        margin-left: auto;
        margin-right: auto;
    }

    .booking-tabs {
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .booking-card-header {
        flex-direction: column;
        gap: 18px;
    }

    .booking-card-copy {
        max-width: none;
    }

    .booking-card-title {
        font-size: 23px;
    }

    .booking-card {
        padding: 24px;
        border-radius: var(--radius-xl);
    }
}

@media (max-height: 820px) and (min-width: 992px) {

    .hero-section {
        padding: 28px 0 30px;
    }

    .hero-heading {
        font-size: 56px;
        margin-top: 14px;
    }

    .hero-description {
        margin-top: 16px;
        line-height: 1.55;
    }

    .booking-card {
        padding: 24px 42px 26px;
    }

    .booking-card-header {
        margin-bottom: 15px;
    }

    .booking-card-kicker {
        font-size: 11.5px;
    }

    .booking-card-title {
        font-size: 23px;
    }

    .booking-tabs {
        min-height: 44px;
        padding: 4px;
    }

    .booking-tabs button {
        min-width: 128px;
        min-height: 36px;
        padding: 0 16px;
    }

    .booking-card .airport-toggle .airport-toggle-btn {
        min-width: 128px !important;
        min-height: 36px !important;
        padding: 0 16px !important;
    }

    .booking-group {
        padding-top: 12px;
        margin-top: 12px;
    }

    .booking-group-header {
        margin-bottom: 8px;
    }

    .booking-form .mb-3 {
        margin-bottom: 8px !important;
    }

    .booking-submit-row {
        margin-top: 8px;
    }
}

@media (max-width: 768px) {

    .hero-heading {
        font-size: 32px;
    }

    .hero-description {
        font-size: 14.5px;
    }

    .booking-form input,
    .booking-form select {
        height: var(--field-h-sm);
        min-height: var(--field-h-sm);
        font-size: 13.5px;
        line-height: var(--field-h-sm);
    }

    .location-chip {
        min-height: var(--field-h-sm);
        padding: 9px 36px 9px 14px;
    }

    .location-chip-primary {
        font-size: 13px;
    }

    .location-chip-secondary {
        font-size: 11.5px;
    }

    .booking-card {
        padding: 18px;
    }

    .booking-card-header {
        margin-bottom: 22px;
    }

    .booking-card-subtitle {
        font-size: 13.5px;
    }

    .booking-group {
        padding-top: 18px;
        margin-top: 18px;
    }

    .location-clear-btn {
        width: 26px;
        height: 26px;
        right: 8px;
        font-size: 18px;
    }

    .booking-tabs {
        justify-content: flex-end;
        width: 100%;
        margin-left: 0;
    }

    .airport-mode-btn {
        flex: 1 1 0;
        min-width: 0;
        padding: 0 12px;
        font-size: 12.5px;
    }

    .booking-card .airport-toggle {
        width: 100% !important;
    }

    .booking-card .airport-toggle .airport-toggle-btn {
        flex: 1 1 0 !important;
        min-width: 0 !important;
        padding: 0 12px !important;
        font-size: 12.5px !important;
    }

    .booking-submit-row {
        margin-top: 8px;
    }

    .book-btn {
        min-height: var(--field-h-sm);
        font-size: 14.5px;
    }
}


/* =========================================================
   FOOTER
   ========================================================= */

footer.road-footer {
    position: relative;
    height: 95px;
    background: linear-gradient(180deg, #11151d 0%, #080a0d 100%);
    overflow: hidden;
}

.road-strip {
    position: absolute;
    bottom: 20px;
    width: 100%;
    height: 4px;

    background: repeating-linear-gradient(
        90deg,
        var(--accent-500) 0 24px,
        transparent 24px 48px
    );

    opacity: 0.78;
}

.cars-lane {
    position: absolute;
    bottom: 28px;
    width: 100%;
    height: 60px;
}

.sv {
    position: absolute;
    animation: drive linear infinite;
}

.s1 { animation-duration: 7s;  bottom: 4px; }
.s2 { animation-duration: 10s; bottom: 0px; animation-delay: -3s; }
.s3 { animation-duration: 9s;  bottom: 2px; animation-delay: -5s; }
.s4 { animation-duration: 12s; bottom: 0px; animation-delay: -1s; }

@keyframes drive {
    0%   { left: -120px; }
    100% { left: 105%; }
}

.lang-btn {
    border-radius: var(--radius-md);
    font-weight: 600;
}

.dropdown-menu {
    border-radius: var(--radius-md);
    overflow: hidden;
}

.dropdown-item {
    font-weight: 500;
    transition: 0.2s;
}

.dropdown-item:hover {
    background: var(--accent-500);
    color: #111;
}

</style>


<section class="hero-section" id="main-content">

    <div class="container">

        <div class="row align-items-center">

            <!-- Left Content -->
            <div class="col-lg-4 mb-lg-0 hero-content">

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

                    <div class="booking-card-header">

                        <div class="booking-card-copy">
                            <div class="booking-card-kicker">
                                {{ __('messages.form_kicker') }}
                            </div>

                            <h2 class="booking-card-title">
                                {{ __('messages.form_title') }}
                            </h2>
                        </div>

                        <!-- Tabs -->
                        <div class="booking-tabs airport-toggle" role="tablist" aria-label="Trip direction">

                            <button
                                type="button"
                                class="airport-mode-btn airport-toggle-btn"
                                data-mode="airportFrom"
                                role="tab"
                                aria-selected="false"
                                onclick="setMode('airportFrom')"
                            >
                                <span class="airport-mode-icon from-airport" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 22h20"/>
                                        <path d="M3.77 10.77 2 9l2.5-2.5 1.77 1.77c.59.59 1.47.78 2.25.49l2.1-.78-3.4-3.4L9.64 2l6.06 4.54 4.44-1.65a2.4 2.4 0 0 1 3.08 1.41 2.4 2.4 0 0 1-1.41 3.08L8.96 14.15a4 4 0 0 1-4.18-.93l-1.01-1.01z"/>
                                    </svg>
                                </span>
                                {{ __('messages.from_airport') }}
                            </button>

                            <button
                                type="button"
                                class="airport-mode-btn airport-toggle-btn"
                                data-mode="airportTo"
                                role="tab"
                                aria-selected="false"
                                onclick="setMode('airportTo')"
                            >
                                <span class="airport-mode-icon to-airport" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 22h20"/>
                                        <path d="M6.36 17.4 4 17l-2-4 1.1-.55a2 2 0 0 1 1.8 0l1.03.52a2 2 0 0 0 1.8 0L9 12.3 5 6l1.35-.67a2 2 0 0 1 2.11.2l4.65 3.49a2 2 0 0 0 2.04.22l3.15-1.48a2.4 2.4 0 1 1 2.04 4.35L6.36 17.4z"/>
                                    </svg>
                                </span>
                                {{ __('messages.to_airport') }}
                            </button>

                        </div>

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
                        novalidate
                    >

                        @csrf

                        <section class="booking-group" aria-labelledby="passenger-details-title">
                            <div class="booking-group-header">
                                <span class="booking-group-number">1</span>
                                <span class="booking-group-title" id="passenger-details-title">
                                    {{ __('messages.passenger_details') }}
                                </span>
                            </div>

                            <!-- Personal Information -->
                            <div class="row">

                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="sr-only">{{ __('messages.full_name') }}</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
                                    placeholder="{{ __('messages.full_name') }}"
                                    autocomplete="name"
                                >

                                @error('name')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="sr-only">{{ __('messages.email') }}</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    placeholder="{{ __('messages.email') }}"
                                    autocomplete="email"
                                >

                                @error('email')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="sr-only">{{ __('messages.phone') }}</label>
                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="{{ __('messages.phone') }}"
                                    autocomplete="tel"
                                >

                                @error('phone')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Passengers -->
                            <div class="col-md-6 mb-3">
                                <label for="passengers" class="sr-only">{{ __('messages.select_passenger') }}</label>
                                <select name="passengers" id="passengers">

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
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            </div>
                        </section>


                        <section class="booking-group" aria-labelledby="route-details-title">
                            <div class="booking-group-header">
                                <span class="booking-group-number">2</span>
                                <span class="booking-group-title" id="route-details-title">
                                    {{ __('messages.route_details') }}
                                </span>
                            </div>

                            <!-- Pickup / Dropoff -->
                            <div class="row" id="dynamic-row"></div>
                        </section>


                        <section class="booking-group" aria-labelledby="schedule-details-title">
                            <div class="booking-group-header">
                                <span class="booking-group-number">3</span>
                                <span class="booking-group-title" id="schedule-details-title">
                                    {{ __('messages.schedule_details') }}
                                </span>
                            </div>

                            <!-- Travel Date / Time -->
                            <div class="row">

                            <!-- Travel Date -->
                            <div class="col-md-6 mb-3">
                                <label for="travel_date" class="sr-only">{{ __('messages.travel_date') ?? 'Travel date' }}</label>
                                <input
                                    type="date"
                                    name="travel_date"
                                    id="travel_date"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('travel_date') }}"
                                >

                                @error('travel_date')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Travel Time -->
                            <div class="col-md-6 mb-3">
                                <label for="travel_time" class="sr-only">{{ __('messages.travel_time') ?? 'Travel time' }}</label>
                                <input
                                    type="time"
                                    name="travel_time"
                                    id="travel_time"
                                    value="{{ old('travel_time') }}"
                                >

                                @error('travel_time')
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>

                            </div>
                        </section>


                        <!-- Submit -->
                        <div class="row booking-submit-row">
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

    </div>

</section>


<script>

let debounceTimer = null;

// Prevent old responses overriding new ones
let requestCounter = { pickup: 0, dropoff: 0 };

// Shared pin icon used for the location field + selected chip
const LOCATION_PIN_SVG =
    "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 2C7.6 2 4 5.6 4 10c0 6 8 12 8 12s8-6 8-12c0-4.4-3.6-8-8-8zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z' fill='white' fill-opacity='0.6'/%3E%3C/svg%3E";


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
// 1. Set active airport tab
// =========================================================

function setActiveModeButton(type) {

    document.querySelectorAll('.airport-mode-btn').forEach(button => {
        button.classList.remove('active');
        button.setAttribute('aria-selected', 'false');
    });

    const activeButton =
        document.querySelector(`.airport-mode-btn[data-mode="${type}"]`);

    if (activeButton) {
        activeButton.classList.add('active');
        activeButton.setAttribute('aria-selected', 'true');
    }
}


// =========================================================
// 2. Split a full address into a short primary line and a
//    secondary detail line, for the selected-location chip.
// =========================================================

function splitAddress(displayName) {

    const parts = (displayName || '').split(',');

    const primary = (parts.shift() || '').trim();
    const secondary = parts.join(',').trim();

    return { primary, secondary };

}


function escapeHtml(value) {
    return String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}


function getLocationState(type) {

    const address = document.getElementById(type + '_address')?.value || '';

    if (!address) {
        return null;
    }

    return {
        display_name: address,
        lat: document.querySelector(`input[name="${type}_lat"]`)?.value || '',
        lon: document.querySelector(`input[name="${type}_lng"]`)?.value || '',
        city: document.querySelector(`input[name="${type}_city"]`)?.value || '',
        place_id: document.querySelector(`input[name="${type}_place_id"]`)?.value || ''
    };

}


function normalizeLocationText(value) {
    return String(value || '').trim().replace(/\s+/g, ' ').toLowerCase();
}


function isSameLocation(first, second) {

    if (!first || !second) {
        return false;
    }

    if (first.place_id && second.place_id && first.place_id === second.place_id) {
        return true;
    }

    if (first.lat && first.lon && second.lat && second.lon) {
        return first.lat === second.lat && first.lon === second.lon;
    }

    return normalizeLocationText(first.display_name) === normalizeLocationText(second.display_name);

}


// =========================================================
// 3. Render the markup for one location field (pickup/dropoff)
// =========================================================

function locationFieldHtml(type, placeholder, prefill) {

    const hasPrefill = !!(prefill && prefill.display_name);

    const primary = hasPrefill ? splitAddress(prefill.display_name).primary : '';
    const secondary = hasPrefill ? splitAddress(prefill.display_name).secondary : '';
    const safePlaceholder = escapeHtml(placeholder);
    const safeDisplayName = hasPrefill ? escapeHtml(prefill.display_name) : '';
    const safePrimary = hasPrefill ? escapeHtml(primary) : '';
    const safeSecondary = hasPrefill ? escapeHtml(secondary) : '';
    const safeLat = hasPrefill ? escapeHtml(prefill.lat) : '';
    const safeLon = hasPrefill ? escapeHtml(prefill.lon) : '';
    const safeCity = hasPrefill ? escapeHtml(prefill.city) : '';
    const safePlaceId = hasPrefill ? escapeHtml(prefill.place_id) : '';

    return `
        <div class="col-md-6 mb-3">

            <div class="location-field" data-type="${type}">

                <!-- Search input -->
                <div class="location-input-wrapper" id="${type}-search-wrapper" style="${hasPrefill ? 'display:none;' : ''}">

                    <img class="location-icon" src="${LOCATION_PIN_SVG}" alt="" aria-hidden="true">

                    <label for="${type}_address_search" class="sr-only">${safePlaceholder}</label>
                    <input
                        type="text"
                        id="${type}_address_search"
                        name="${type}_address_search"
                        autocomplete="off"
                        placeholder="${safePlaceholder}"
                    >

                    <div class="location-results bcn-location-results" id="${type}-results"></div>

                </div>

                <!-- Selected location chip -->
                <div class="location-chip ${hasPrefill ? 'show' : ''}" id="${type}-chip" tabindex="0">

                    <img class="location-chip-icon" src="${LOCATION_PIN_SVG}" alt="" aria-hidden="true">

                    <div class="location-chip-text" title="${safeDisplayName}">
                        <div class="location-chip-primary" id="${type}-chip-primary">${safePrimary}</div>
                        <div class="location-chip-secondary" id="${type}-chip-secondary">${safeSecondary}</div>
                    </div>

                    <button
                        type="button"
                        class="location-clear-btn"
                        id="${type}-clear"
                        aria-label="Clear ${type} location"
                    >&times;</button>

                </div>

                <!-- Actual submitted value + place data -->
                <input type="hidden" name="${type}_address" id="${type}_address" value="${safeDisplayName}">
                <input type="hidden" name="${type}_lat" value="${safeLat}">
                <input type="hidden" name="${type}_lng" value="${safeLon}">
                <input type="hidden" name="${type}_city" value="${safeCity}">
                <input type="hidden" name="${type}_place_id" value="${safePlaceId}">

            </div>

        </div>
    `;

}


// =========================================================
// 4. Set booking mode (empty / from airport / to airport)
// =========================================================

function setMode(type) {

    const currentPickup = getLocationState('pickup');
    const currentDropoff = getLocationState('dropoff');

    setActiveModeButton(type);

    let pickupPrefill = currentPickup;
    let dropoffPrefill = currentDropoff;

    if (type === 'airportFrom') {
        pickupPrefill = airportData;
        dropoffPrefill = isSameLocation(currentDropoff, airportData) ? null : currentDropoff;
    }

    if (type === 'airportTo') {
        pickupPrefill = isSameLocation(currentPickup, airportData) ? null : currentPickup;
        dropoffPrefill = airportData;
    }

    const pickupPlaceholder =
        type === 'airportFrom' ? '{{ __("messages.airport") }}' : '{{ __("messages.pickup") }}';

    const dropoffPlaceholder =
        type === 'airportTo' ? '{{ __("messages.airport") }}' : '{{ __("messages.dropoff") }}';

    document.getElementById('dynamic-row').innerHTML =
        locationFieldHtml('pickup', pickupPlaceholder, pickupPrefill) +
        locationFieldHtml('dropoff', dropoffPlaceholder, dropoffPrefill);

    setupLocationField('pickup');
    setupLocationField('dropoff');

}


// =========================================================
// 5. Wire up one location field's clear button + focus ring
// =========================================================

function setupLocationField(type) {

    const clearButton = document.getElementById(type + '-clear');
    const chip = document.getElementById(type + '-chip');

    if (chip) {

        chip.addEventListener('focus', () => chip.classList.add('is-focused'));
        chip.addEventListener('blur', () => chip.classList.remove('is-focused'));

    }

    if (!clearButton) {
        return;
    }

    clearButton.addEventListener('click', function () {
        resetLocationField(type);
        clearBookingError();

        const searchInput = document.getElementById(type + '_address_search');
        if (searchInput) {
            searchInput.focus();
        }
    });

}


// =========================================================
// 6. Reset a location field back to empty "search" state
// =========================================================

function resetLocationField(type) {

    const searchWrapper = document.getElementById(type + '-search-wrapper');
    const searchInput = document.getElementById(type + '_address_search');
    const chip = document.getElementById(type + '-chip');
    const resultsBox = document.getElementById(type + '-results');

    if (searchWrapper) searchWrapper.style.display = '';
    if (searchInput) searchInput.value = '';
    if (chip) chip.classList.remove('show');
    if (resultsBox) resultsBox.innerHTML = '';

    ['_address', '_lat', '_lng', '_city', '_place_id'].forEach(function (suffix) {
        const field = document.querySelector(`input[name="${type}${suffix}"]`);
        if (field) field.value = '';
    });

}


// =========================================================
// 7. Select a location from autocomplete results
// =========================================================

function selectLocation(type, item) {

    const displayName = item.display_name || '';
    const { primary, secondary } = splitAddress(displayName);

    const hiddenAddress = document.getElementById(type + '_address');
    const lat = document.querySelector(`input[name="${type}_lat"]`);
    const lng = document.querySelector(`input[name="${type}_lng"]`);
    const city = document.querySelector(`input[name="${type}_city"]`);
    const placeId = document.querySelector(`input[name="${type}_place_id"]`);

    if (hiddenAddress) hiddenAddress.value = displayName;
    if (lat) lat.value = item.lat || '';
    if (lng) lng.value = item.lon || '';
    if (city) city.value = item.city || item.town || item.municipality || '';
    if (placeId) placeId.value = item.place_id || '';

    const chip = document.getElementById(type + '-chip');
    const chipPrimary = document.getElementById(type + '-chip-primary');
    const chipSecondary = document.getElementById(type + '-chip-secondary');
    const searchWrapper = document.getElementById(type + '-search-wrapper');
    const resultsBox = document.getElementById(type + '-results');

    if (chipPrimary) chipPrimary.textContent = primary;
    if (chipSecondary) chipSecondary.textContent = secondary;
    if (chip) {
        chip.querySelector('.location-chip-text').setAttribute('title', displayName);
        chip.classList.add('show');
    }
    if (searchWrapper) searchWrapper.style.display = 'none';
    if (resultsBox) resultsBox.innerHTML = '';

    clearBookingError();

}


// =========================================================
// 8. Initial state
// =========================================================

setMode('');


// =========================================================
// 9. Location input listener (debounced autocomplete)
// =========================================================

document.addEventListener('input', function (e) {

    if (!e.target.id || !e.target.id.endsWith('_address_search')) {
        return;
    }

    const type = e.target.id === 'pickup_address_search' ? 'pickup' : 'dropoff';

    clearTimeout(debounceTimer);

    const keyword = e.target.value.trim();
    const box = document.getElementById(type + '-results');

    if (box) box.innerHTML = '';

    if (keyword.length < 3) {
        return;
    }

    debounceTimer = setTimeout(() => searchAddress(keyword, type), 800);

});


// =========================================================
// 10. Location input blur — hide dropdown, clear stray text
// =========================================================

document.addEventListener('focusout', function (e) {

    if (!e.target.id || !e.target.id.endsWith('_address_search')) {
        return;
    }

    const input = e.target;
    const type = input.id === 'pickup_address_search' ? 'pickup' : 'dropoff';
    const box = document.getElementById(type + '-results');

    if (box) box.innerHTML = '';

    // User typed something but never picked a suggestion — clear it.
    if (input.value.trim() !== '') {
        input.value = '';
    }

});


// =========================================================
// 11. API CALL
// =========================================================

async function searchAddress(keyword, type) {

    const requestId = ++requestCounter[type];
    const box = document.getElementById(type + '-results');

    try {

        if (box) {
            box.innerHTML = `<div class="autocomplete-loading bcn-autocomplete-message">Searching...</div>`;
        }

        const response = await fetch(
            '/api/location/autocomplete?keyword=' + encodeURIComponent(keyword)
        );

        const data = await response.json();

        if (requestId !== requestCounter[type]) {
            return; // stale response, ignore
        }

        if (data.status === 'completed') {
            renderResults(data.results || [], type);
            return;
        }

        if (data.status === 'pending') {

            const retryAfter = Math.max(Number(data.retry_after || 2), 1) * 1000;

            setTimeout(() => {

                const input = document.getElementById(type + '_address_search');
                if (!input) return;

                if (input.value.trim() === keyword) {
                    searchAddress(keyword, type);
                }

            }, retryAfter);

        }

    } catch (error) {
        console.error('Autocomplete error:', error);
    }

}


// =========================================================
// 12. Render autocomplete results
// =========================================================

function renderResults(results, type) {

    const box = document.getElementById(type + '-results');
    if (!box) return;

    box.innerHTML = '';

    if (!results || results.length === 0) {
        box.innerHTML = `<div class="autocomplete-empty bcn-autocomplete-message">No matches found</div>`;
        return;
    }

    results.slice(0, 8).forEach(item => {

        const div = document.createElement('div');
        div.classList.add('autocomplete-item', 'bcn-autocomplete-item');
        div.setAttribute('role', 'option');
        div.setAttribute('tabindex', '0');
        div.textContent = item.display_name;

        div.addEventListener('mousedown', function () {
            selectLocation(type, item);
        });

        div.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                selectLocation(type, item);
            }
        });

        box.appendChild(div);

    });

}


// =========================================================
// 13. Date & Time — click anywhere on the bar to open the
//     native picker (not just the small calendar/clock icon)
// =========================================================

document.addEventListener('click', function (e) {

    const target = e.target;

    if (target.tagName === 'INPUT' && (target.type === 'date' || target.type === 'time')) {

        if (typeof target.showPicker === 'function') {
            try {
                target.showPicker();
            } catch (err) {
                // showPicker() can throw if called too soon after
                // another picker closes — safe to ignore.
            }
        }

    }

});


// =========================================================
// 14. Travel date — block past dates
//     The `min` attribute already stops most browsers from
//     letting the user pick a past date in the calendar UI,
//     but some browsers still allow a past date to be typed
//     in manually, so this re-validates on every change.
// =========================================================

document.addEventListener('change', function (e) {

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
        input.setCustomValidity('Please choose today or a future date.');
        input.reportValidity();
        input.value = '';
    } else {
        input.setCustomValidity('');
    }

});


// =========================================================
// 15. Booking error banner helpers
// =========================================================

function showBookingError(message) {

    let errorBox = document.getElementById('booking-error');

    if (!errorBox) {

        errorBox = document.createElement('div');
        errorBox.id = 'booking-error';
        errorBox.className = 'alert alert-danger mb-3';
        errorBox.setAttribute('role', 'alert');

        const form = document.getElementById('bookingForm');
        form.parentNode.insertBefore(errorBox, form);

    }

    errorBox.textContent = message;
    errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

}

function clearBookingError() {
    const errorBox = document.getElementById('booking-error');
    if (errorBox) errorBox.remove();
}


// =========================================================
// 16. Block submit when pickup and dropoff are the same
//     Checks BOTH the saved address text (case/whitespace
//     insensitive) AND the saved lat/lng, so it still catches
//     the case where the same place is written slightly
//     differently but was selected from autocomplete twice.
// =========================================================

document.addEventListener('submit', function (e) {

    if (e.target.id !== 'bookingForm') {
        return;
    }

    const pickupAddress = document.getElementById('pickup_address');
    const dropoffAddress = document.getElementById('dropoff_address');

    if (!pickupAddress || !dropoffAddress) {
        return;
    }

    const pickupText = pickupAddress.value.trim().toLowerCase();
    const dropoffText = dropoffAddress.value.trim().toLowerCase();

    const pickupLat = document.querySelector('input[name="pickup_lat"]')?.value || '';
    const pickupLng = document.querySelector('input[name="pickup_lng"]')?.value || '';
    const dropoffLat = document.querySelector('input[name="dropoff_lat"]')?.value || '';
    const dropoffLng = document.querySelector('input[name="dropoff_lng"]')?.value || '';

    const sameText = pickupText !== '' && pickupText === dropoffText;

    const sameCoords =
        pickupLat !== '' &&
        pickupLng !== '' &&
        pickupLat === dropoffLat &&
        pickupLng === dropoffLng;

    if (sameText || sameCoords) {
        e.preventDefault();
        showBookingError('Pickup and drop-off location cannot be the same. Please choose a different location.');
    } else {
        clearBookingError();
    }

});

</script>

@endsection
