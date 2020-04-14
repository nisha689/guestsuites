@inject('request', 'Illuminate\Http\Request')
<header class="header">
    <div class="container">
        <div class="top-bar">
            <div class="dropdown text-right">
                <button class="btn dropdown-toggle" type="button" id="langdropdown" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    EN
                    <img src="images/eng.jpg" alt="">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">NE
                        <img src="images/ned.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light main-nav home">
            <div class="dropdown account-dropdown order-lg-4">
                <button class="account-btn dropdown-toggle" type="button" id="account-btn" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"> <img src="images/profile-small.png" alt=""> <i
                            class="fas fa-bars"></i></button>
                <div class="dropdown-menu" aria-labelledby="account-btn">
                    <a class="dropdown-item" href="cms-home.html">Dash Home</a>
                    <a class="dropdown-item" href="competitions.html">Competitions</a>
                    <a class="dropdown-item" href="patterns.html">Patterns</a>
                    <a class="dropdown-item" href="riders.html">Riders</a>
                    <a class="dropdown-item" href="jury.html">Jury</a>
                    <a class="dropdown-item" href="transactions.html">Transactions</a>
                    <a class="dropdown-item" href="finance-center.html">Finance center</a>
                    <a class="dropdown-item" href="profile.html">Profile</a>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </div>

            <a class="navbar-brand order-lg-1" href="index.html">
                <img src="images/logo.jpg" class="img-fluid" alt="">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-lg-2" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="competitions.html">Competitions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Jury</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">Who we are</a>
                    </li>
                    <li class="nav-item dropdown linkDropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Download the app
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <p>Enter your mobile number <br> to receive the app download link</p>
                            <form action="">
                                <input type="text" class="form-control mb-2" placeholder="Mobile #">
                                <button type="submit" class="btn btn-pink btn-block">Send link</button>
                            </form>
                        </div>
                    </li>
                </ul>
                <div class="cart" id="cart-mobile">
                    <a href="cart.html">
                        <i class="fas fa-shopping-cart"></i>
                        <span>$15</span>
                    </a>
                </div>
            </div>
            <div class="cart order-lg-4" id="cart-desktop">
                <a href="cart.html">
                    <i class="fas fa-shopping-cart"></i>
                    <span>$15</span>
                </a>
            </div>
        </nav>
    </div>
</header>
