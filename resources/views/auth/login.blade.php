<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 20px;
        }
        @media (min-width: 768px) {
                .col-md-4 {
                    flex: 0 0 auto;
                    width: 23.333333%;
                }
            }
            button.btn.btn-primary.w-100 {
                background-color: #36cee2;
                color: black;
            }
    </style>
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-4">
        <div class="card p-4">
            <div class="text-center">
                <img src="{{ asset('images/360logo.jpg') }}" alt="Logo" class="logo"> <!-- Replace with your logo path -->
                <h4 class="mb-4">Admin Login</h4>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
