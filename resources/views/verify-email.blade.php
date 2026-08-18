<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify OTP</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(255, 153, 0, 0.10),
                    transparent 35%
                ),
                #f4f5f7;
            color: #212529;
        }

        /* =========================
           PAGE WRAPPER
        ========================= */

        .otp-wrapper {
            min-height: 100vh;
            padding: 30px 0;
        }

        /* =========================
           CARD
        ========================= */

        .otp-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 22px;
            overflow: hidden;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.10),
                0 8px 20px rgba(0, 0, 0, 0.05);
        }

        /* =========================
           HEADER
        ========================= */

        .otp-card-header {
            position: relative;

            background: linear-gradient(
                135deg,
                #ff9900 0%,
                #ffad32 55%,
                #ff8c00 100%
            );

            padding: 30px 30px 28px;

            text-align: left;
        }

        /*
         Small decorative glow
        */
        .otp-card-header::after {
            content: "";
            position: absolute;

            width: 180px;
            height: 180px;

            right: -70px;
            top: -100px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.10);
        }

        /* =========================
           TITLE ROW
        ========================= */

        .otp-title-row {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Tick on LEFT */
        .brand-icon {
            width: 34px;
            height: 34px;

            flex: 0 0 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.95);
            color: #ff9900;

            font-size: 19px;
            font-weight: 800;

            box-shadow:
                0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .otp-title {
            margin: 0;

            color: #ffffff;

            font-size: 25px;
            font-weight: 700;

            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .otp-subtitle {
            position: relative;
            z-index: 2;

            margin: 10px 0 0 46px;

            color: rgba(255, 255, 255, 0.88);

            font-size: 14px;
            line-height: 1.5;
        }

        /* =========================
           BODY
        ========================= */

        .otp-card-body {
            padding: 32px;
        }

        /* =========================
           ALERTS
        ========================= */

        .alert {
            border: none;
            border-radius: 12px;

            font-size: 14px;
            line-height: 1.5;

            padding: 13px 15px;

            text-align: left;
        }

        .alert-danger {
            color: #842029;
            background: #f8d7da;

            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            color: #664d03;
            background: #fff3cd;

            border-left: 4px solid #ff9900;
        }

        /* =========================
           LABEL
        ========================= */

        .otp-label {
            display: block;

            margin-bottom: 9px;

            color: #343a40;

            font-size: 14px;
            font-weight: 700;
        }

        /* =========================
           OTP INPUT
        ========================= */

        .otp-input {
            width: 100%;
            height: 62px;

            border: 2px solid #e1e4e8;
            border-radius: 12px;

            background: #fafafa;

            color: #212529;

            font-size: 27px;
            font-weight: 700;

            letter-spacing: 12px;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .otp-input:hover {
            border-color: #cfd3d8;
            background: #ffffff;
        }

        .otp-input:focus {
            border-color: #ff9900;

            background: #ffffff;

            box-shadow:
                0 0 0 4px rgba(255, 153, 0, 0.12);

            outline: none;
        }

        .otp-input::placeholder {
            letter-spacing: normal;

            font-size: 14px;
            font-weight: 400;

            color: #adb5bd;
        }

        /* =========================
           VERIFY BUTTON
        ========================= */

        .verify-btn {
            height: 52px;

            border: none;
            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #ff9900,
                #ffad32
            );

            color: #ffffff;

            font-size: 15px;
            font-weight: 700;

            box-shadow:
                0 8px 18px rgba(255, 153, 0, 0.22);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .verify-btn:hover {
            background: linear-gradient(
                135deg,
                #f28c00,
                #ff9900
            );

            color: #ffffff;

            transform: translateY(-1px);

            box-shadow:
                0 10px 22px rgba(255, 153, 0, 0.30);
        }

        .verify-btn:active {
            transform: translateY(0);
        }

        /* =========================
           SECURITY TEXT
        ========================= */

        .security-text {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            color: #8a9198;

            font-size: 12px;

            margin: 20px 0 0;
        }

        .security-icon {
            color: #ff9900;
            font-size: 13px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 576px) {

            .otp-wrapper {
                padding: 20px 0;
            }

            .otp-card {
                border-radius: 18px;
            }

            .otp-card-header {
                padding: 25px 22px 24px;
            }

            .otp-card-body {
                padding: 25px 20px;
            }

            .otp-title {
                font-size: 22px;
            }

            .otp-subtitle {
                margin-left: 46px;
                font-size: 13px;
            }

            .otp-input {
                height: 58px;
                font-size: 24px;
                letter-spacing: 9px;
            }

            .verify-btn {
                height: 50px;
            }
        }
    </style>
</head>

<body>

<div class="container otp-wrapper d-flex justify-content-center align-items-center">

    <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">

        <div class="otp-card">

            <!-- =========================
                 HEADER
            ========================== -->

            <div class="otp-card-header">

                <div class="otp-title-row">

                    <!-- Tick on the LEFT -->
                    <div class="brand-icon">
                        ✓
                    </div>

                    <h2 class="otp-title">
                        Verify Your Email
                    </h2>

                </div>


            </div>


            <!-- =========================
                 BODY
            ========================== -->

            <div class="otp-card-body">

                <!-- Error Message -->

                @if(session('error'))
                    <div class="alert alert-danger mb-3">
                        {{ session('error') }}
                    </div>
                @endif


                <!-- Outside City Message -->

                @if(session('outside_city'))
                    <div class="alert alert-warning mb-3">
                        {{ session('outside_city') }}
                    </div>
                @endif


                <!-- =========================
                     OTP FORM
                ========================== -->

                <form method="POST" action="{{ route('verify.email') }}">

                    @csrf

                    <div class="mb-4">

                        <label
                            for="otp"
                            class="otp-label"
                        >
                            Verification Code
                        </label>

                        <input
                            type="text"
                            id="otp"
                            name="otp"
                            class="form-control otp-input text-center"
                            placeholder="Enter OTP"
                            maxlength="4"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn verify-btn w-100"
                    >
                        Verify OTP
                    </button>

                </form>


                <!-- Security Message -->

                <p class="security-text">

                    <span class="security-icon">●</span>

                    <span>
                        Your verification code is secure and private.
                    </span>

                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>