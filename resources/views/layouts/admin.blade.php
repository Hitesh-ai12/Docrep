<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DocRep360 Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; }
        .sidebar {
            width: 250px;
            background-color: #00d2c3;
            color: white;
            min-height: 100vh;
            padding: 20px 15px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #00b2a8;
            border-radius: 5px;
        }
        .header {
            background: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .main-content {
            flex: 1;
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4>DocRep360</h4>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('users') }}">User Management</a>
        <a href="{{ route('payments') }}">Payment Management</a>
        <a href="{{ route('subscriptions') }}">Subscription & Credit Management</a>
        <a href="{{ route('content') }}">Content Management</a>
        <a href="{{ route('roles') }}">System and Role Management</a>
        <a href="{{ route('notifications') }}">Notifications</a>
        <a href="{{ route('feedback') }}">Feedback</a>
        <a href="{{ route('settings') }}">Settings</a>
        <a href="{{ route('plans') }}">Manage Plans</a>
        <a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   Log out
</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        <div class="header">
            <form class="d-flex" role="search">
                <input class="form-control" type="search" placeholder="Search">
            </form>
            <div>
                <span class="me-3">Mr. {{ Auth::user()->name }}</span>
                <img src="https://via.placeholder.com/40" class="rounded-circle" alt="avatar">
            </div>
        </div>

        <div class="p-4">
            @yield('content')
        </div>
    </div>
</body>
</html>
