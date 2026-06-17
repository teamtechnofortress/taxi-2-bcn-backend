<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-5 text-center">
                        <!-- Title -->
                        <h2 class="fw-bold mb-3 text-success">
                            Verify Your Email
                        </h2>
                        <p class="text-muted mb-4">
                            Enter the 4-digit OTP sent to your email
                        </p>
                        <!-- Error Messages -->
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('outside_city'))
                            <div class="alert alert-warning">
                                {{ session('outside_city') }}
                            </div>
                        @endif
                        <!-- Form -->
                        <form method="POST" action="{{ route('verify.email') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="text"
                                       name="otp"
                                       class="form-control form-control-lg text-center"
                                       placeholder="Enter OTP"
                                       maxlength="4"
                                       required>
                            </div>
                            <button type="submit"
                                    class="btn btn-success w-100 py-2 fw-semibold rounded-pill">
                                Verify OTP
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>