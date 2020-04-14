@inject('helper', 'App\Classes\Helpers\Helper')
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 id="footer-brand">Bottle to Body</h3>
                <div class="row">
                    <div class="d-flex col-md-4 col-sm-6">
                        <div class="footer-lists">
                            <h4>Links</h4>
                            <ul>
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li>
                                    <a href="#">About us</a>
                                </li>
                                <li>
                                    <a href="#">Regulations</a>
                                </li>
                                <li>
                                    <a href="#">Terms</a>
                                </li>
                                <li>
                                    <a href="#">Privacy Policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex col-md-4 col-sm-6">
                        <div class="footer-lists">
                            <h4>NDE Club</h4>
                            <ul>
                                <li>
                                    <a href="#">Welcome</a>
                                </li>
                                <li>
                                    <a href="#">Login</a>
                                </li>
                                <li>
                                    <a href="#">Sign up</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex col-md-4 col-sm-6">
                        <div class="footer-lists">
                            <h4>Social</h4>
                            <ul>
                                <li>
                                    <a href="#">Facebook</a>
                                </li>
                                <li>
                                    <a href="#">Twitter</a>
                                </li>
                                <li>
                                    <a href="#">Linkedin</a>
                                </li>
                                <li>
                                    <a href="#">Google+</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="index.html" id="footer-logo">
                    <img src="images/footer-logo.jpg" class="img-fluid" alt="">
                </a>
                <div class="footer-contact-info">
                    <p id="phone">
                        <i class="fab fa-whatsapp"></i>+31 622713998</p>
                    <p id="mail">
                        <i class="fas fa-at"></i>info@bottletobody.org</p>
                    <p id="fb">
                        <i class="fab fa-facebook-f"></i> /bottletobody</p>
                </div>
                <p>{!! $helper->getCopyRight() !!}</p>
            </div>
        </div>
    </div>
</footer>

