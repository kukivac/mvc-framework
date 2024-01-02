<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{getLink('/')}}">
            <img src="{{getLink('/images/logo.jpg')}}" alt="Logo" width="30" height="24">
            Moje webová stránka
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach($pages as $page)
                    <li class="nav-item">
                        <a class="nav-link" href="{{getLink($page['link'])}}">{{$page['name']}}</a>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex">
                @if($logged_in_user)
{{--                    Profil už se mi nechtěl dělat--}}
{{--                    <a href="{{getLink('/user/profile')}}" class="btn btn-outline-info me-2" type="button">Profile</a>--}}
                    <a href="{{getLink('/user/logout')}}" class="btn btn-outline-warning" type="button">Logout</a>
                @else
                    <a href="{{getLink('/user/login')}}" class="btn btn-outline-success me-2" type="button">Login</a>
                    <a href="{{getLink('/user/register')}}" class="btn btn-outline-primary" type="button">Register</a>
                @endif
            </div>
        </div>
    </div>
</nav>