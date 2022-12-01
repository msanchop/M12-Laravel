<!-- Navigation -->
<nav>
    <a href="{{ route('home') }}">Inici</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{{ route('autor_list') }}">Autors</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{{ route('llibre_list') }}">Llibres</a>
    &nbsp;&nbsp;&nbsp;
    @if(Auth::check())
    <p><b>Has fet login com {{Auth::user()->name }}</b></p>
        <form method='POST' action="http://localhost/M7/UF2/pt2e/public/logout">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
        &nbsp;&nbsp;&nbsp;
        <a href="{{ route('register') }}">Register</a>
        &nbsp;&nbsp;&nbsp;
    @endif
</nav>