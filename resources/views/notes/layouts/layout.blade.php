<!DOCTYPE html>
<html>
<head>
    <title>Laravel CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>


<div class="container">

      
<h1>My Notes</h1>

@auth
    <p>Welcome, {{ auth()->user()->name }}!</p>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</button>
    </form>
@endauth
    @yield('content')
</div>
      
</body>
</html>