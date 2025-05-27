<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
<title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    @yield('style')
</head>
 <body>
    <!--start nav bar-->
    <nav>
        <div class="continer">
            <a href="">Logo</a>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                @guest
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Signup</a></li>
                @else
                @if (Auth::user()->account_type)
                <li><a href="/teacher/add">New exam</a></li>
                <li><a href="/exams">Exams</a></li>
                @else
                <li><a href="/exams">Exams</a></li>
                @endif
                <li><a href="/profile">Profile</a></li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit">Log out</button>
                    </form>
                </li>
                @endguest
            </ul>
            <div class="open-men button" id="open-men">
                <span class="icon i"></span>
                <span class="icon i"></span>
                <span class="icon"></span>
            </div>
        </div>
    </nav>
    <!--end nav bar-->
    <!--start section-->
    @yield('section')
    <!--end section-->
    <script src="{{asset('JS/main.js')}}"></script>
    @yield('js')
</body>
</html>