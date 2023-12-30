<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="home.html">
            <img src="images/logo.jpg" alt="Logo" width="30" height="24">
            Moje webová stránka
        </a>

        <!-- Toggler/collapsible Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Middle Content Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach($pages as $page)
                    <li class="nav-item">
                        <a class="nav-link" href="{{$page['link']}}">{{$page['name']}}</a>
                    </li>
                @endforeach
            </ul>

            <!-- Right Side - Login/Register/Profile -->
            <div class="d-flex">
                <button class="btn btn-outline-success" type="submit">Login</button>
                <button class="btn btn-outline-primary" type="submit">Register</button>
                <!-- Profile button - visible when logged in -->
                <button class="btn btn-outline-info" type="submit">Profile</button>
            </div>
        </div>
    </div>
</nav>