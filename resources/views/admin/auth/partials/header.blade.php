<header class="btb-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark header_login">
            <a href="{{ url('/')}}" class="navbar-brand">
                <img src="{{ url('images/logo.png') }}" class="img-fluid" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#btbMainMenu"
                    aria-controls="btbMainMenu" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <i class="fas fa-bars"></i>-->
                <span class="navbar-toggler-icon" style="color: #fff;"></span>
            </button>

            <div id="btbMainMenu" class="collapse navbar-collapse">

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ url('/')}}" aria-current="page" class="nav-link">Home</a></li>
                    <li class="nav-item"><a
                            href="{{ url('/') }}" class="nav-link">About us</a></li>
                    <li class="nav-item"><a
                            href="{{ url('/')}}#download_app" class="nav-link">Download the App</a></li>
                    <li class="nav-item"><a
                            href="{{ url('/') }}" class="nav-link">Contact us</a></li>
                    <li class="nav-item"><a
                            href="{{ url('admin_login') }}" class="nav-link">Login</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
