<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="main.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <!-- HEADER -->
                    <div class="bg-warning text-dark text-center p-4">
                        <h1 class="fw-bold mb-2">
                            Taxi Booking
                        </h1>
                        <p class="mb-0 fs-5">
                            Booking Confirmation
                        </p>
                    </div>
                    <!-- BODY -->
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-dark">
                            Hello {{ $booking->name }},
                        </h3>
                        <p class="text-secondary mt-3 lh-lg">
                            Thank you for choosing our taxi service.
                            Your booking has been successfully received.
                        </p>
                        <!-- BOOKING TABLE -->
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered align-middle">
                                <tbody>
                                    <tr>
                                        <th class="bg-light">Email</th>
                                        <td>{{ $booking->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Phone</th>
                                        <td>{{ $booking->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            Pickup Location
                                        </th>
                                        <td>
                                            {{ $booking->pickup_address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            Dropoff Location
                                        </th>
                                        <td>
                                            {{ $booking->dropoff_address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            Travel Date
                                        </th>
                                        <td>
                                            {{ $booking->travel_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            Travel Time
                                        </th>
                                        <td>
                                            {{ $booking->travel_time }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">
                                            Passengers
                                        </th>
                                        <td>
                                            {{ $booking->passengers }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- BUTTON -->
                        <div class="text-center mt-5">
                            <a href="{{ url('/') }}"
                               class="btn btn-warning btn-lg rounded-pill px-5 fw-bold">
                                Visit Website
                            </a>
                        </div>
                        <p class="text-muted mt-5 small lh-lg">
                            If you have any questions,
                            feel free to contact us.
                            We look forward to serving you.
                        </p>
                    </div>
                    <!-- FOOTER -->
                    <div class="bg-dark text-center py-4">
                        <p class="text-light mb-0 small">
                            © {{ date('Y') }}
                            Taxi Booking Service.
                            All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>