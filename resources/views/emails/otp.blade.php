<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <!-- Icon -->
                        <div class="mb-4">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fs-1">
                            </div>
                        </div>
                        <!-- Title -->
                        <h1 class="text-primary fw-bold mb-3">
                            Email Verification
                        </h1>
                        <!-- Description -->
                        <p class="text-muted mb-4">
                            Please use the verification code below to confirm your email address.
                        </p>
                        <!-- OTP Box -->
                        <div class="bg-light border rounded-3 p-3 mb-4">
                            <h1 class="fw-bold text-dark mb-0 letter-spacing-3">
                                {{ $otp }}
                            </h1>
                        </div>
                        <!-- Expiry -->
                        <p class="text-muted">
                            This OTP will expire in <strong>2 minutes</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>