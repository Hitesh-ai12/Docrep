<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DocRep360 Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .form-control {
            display: block;
            /* width: 100%; */
            padding: .375rem .75rem;
            font-size: 1.2rem;
            font-weight: 500;
            line-height: 1.3;
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            background-clip: padding-box;
            border: var(--bs-border-width) solid #282a2a;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: var(--bs-border-radius);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            height: 100px;
        }


        .header .logo {
            height: 85px;
            margin-right: 6.5rem;
            position: sticky;
            left: 70px;
        }

        .header .form-control {
            width: 500px;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .content-area {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #00d2c3;
            color: white;
            padding: 20px 15px;
            /* border-top-right-radius: 20px; */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #00b2a8;
        }

        .sidebar hr {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .main-content {
            flex: 1;
            background: #f5f5f5;
            overflow-y: auto;
            padding: 20px;
        }

        .menu-bottom {
            margin-top: auto;
        }
    </style>
</head>
<body>

    <div class="container-wrapper">

        <!-- Sticky Header with Logo -->
        <div class="header">
            <div class="d-flex align-items-center gap-4">
                <img src="{{ asset('images/360logo.jpg') }}" alt="Logo" class="logo">
                <form class="d-flex" role="search">
                    <input class="form-control" type="search" placeholder="Search">
                </form>
            </div>
            <div class="d-flex align-items-center user-info">
                <span class="me-3">Mr. {{ Auth::user()->name }}</span>
                <img src="https://via.placeholder.com/40" alt="avatar">
            </div>
        </div>

        <!-- Sidebar + Main Content -->
        <div class="content-area">
            <div class="sidebar">
                <div>
                    <a href="{{ route('dashboard') }}"><i class="fas fa-grid"></i> Dashboard</a>
                    <a href="{{ route('users') }}"><i class="fas fa-users"></i> User Management</a>
                    <a href="{{ route('payments') }}"><i class="fas fa-credit-card"></i> Payment Management</a>
                    <a href="{{ route('subscriptions') }}"><i class="fas fa-sync"></i> Subscription & Credit Management</a>
                    <a href="{{ route('content') }}"><i class="fas fa-file-alt"></i> Content Management</a>
                    <a href="{{ route('roles') }}"><i class="fas fa-user-shield"></i> System and Role Management</a>

                    <hr>

                    <a href="{{ route('notifications') }}"><i class="fas fa-bell"></i> Notifications</a>
                    <a href="{{ route('feedback') }}"><i class="fas fa-comment-dots"></i> Feedback</a>
                    <a href="{{ route('settings') }}"><i class="fas fa-cog"></i> Settings</a>
                    <a href="{{ route('plans') }}"><i class="fas fa-layer-group"></i> Manage Plans</a>
                </div>

                <div class="menu-bottom">
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
