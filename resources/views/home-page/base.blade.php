<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>AI DIGITAL MEDIA</title>
    <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>
<body>

    <div id="header">
        <div class="area-content-header">
            <div class="icon-menu-header text-right d-none">
                <img src="{{ asset('image/home-page/logo-web.png') }}" alt="Logo" style="width: 200px">
                <img src="{{ asset('image/home-page/menu.svg') }}" alt="menu bars" style="width: 60px">
            </div>
            <div class="bg-menu-header d-none"></div>
            <div class="menu-header">
                <div class="logo-web">
                    <img src="{{ asset('image/home-page/logo-web.png') }}" alt="Logo" class="w-100">
                </div>
                <div class="close-icon d-none">
                    <img src="{{ asset('image/home-page/close.svg') }}" alt="Close icon">
                </div>
                <div class="trees-menu">
                    <ul>
                        <li><a href="">about us</a></li>
                        <li><a href="">introduction</a></li>
                        <li><a href="">news</a></li>
                        <li><a href="">contact</a></li>
                    </ul>
                </div>
                <div class="login-button">
                    <a class="btn btn-danger btn-login" href="{{ route('auth.login.view') }}">Login</a>
                </div>
            </div>
            <div class="content-header">
                <div class="content content-line-1">
                    <p class="m-0">SOLO PAYMENT</p>
                </div>
                <div class="content content-line-2">
                    <p class="m-0">LEADING THE IN THE</p>
                    <p class="m-0">MODERN FINANCIAL TRADING</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row-info about-us container">
        <div class="row mt-5">
            <div class="col-7 wow bounceInLeft" data-wow-delay="0.5s">
                <h4 class="heading-highlight">ABOUT US</h4>
                <p class="m-0">The Solo Payment Inc. is a trade association created by and for financial market professionals and top investors in Wall Street USA.</p>
                <p class="m-0">As we work to incorporate and adapt these powerful advances in technology - including the emergence of digital currencies - to the world of "Finance 4.0", having an organized, strategic approach will help all participants involved in the global, distributed ledger ecosystem.</p>
            </div>
            <div class="col-5 wow bounceInRight" data-wow-delay="0.5s">
                <img src="{{ asset('image/home-page/about-us.png') }}" alt="about-us" class="w-100">
            </div>
        </div>
    </div>

    <div class="row-info introduction container">
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="heading-highlight wow fadeIn" data-wow-delay="0.5s">INTRODUCTION</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-4 wow bounceInLeft" data-wow-delay="0.5s">
                <div class="img-head">
                    <img src="{{ asset('image/home-page/intro-1.png') }}" alt="intro-image">
                </div>
                <div class="text-head">SOLO PAYMENT INC.</div>
                <div class="desciption">The Solo Payment Inc. is a trade association created by and for financial market professionals and top investors in Wall Street USA.</div>
            </div>
            <div class="col-4 wow fadeIn" data-wow-delay="0.5s">
                <div class="img-head">
                    <img src="{{ asset('image/home-page/intro-2.png') }}" alt="intro-image">
                </div>
                <div class="text-head">BLOCKCHAIN</div>
                <div class="desciption">As we work to incorporate and adapt these powerful advances in technology - including the emergence of digital currencies - to the world of "Finance 4.0", having an organized, strategic approach will help all participants involved in the global, distributed ledger ecosystem.</div>
            </div>
            <div class="col-4 wow bounceInRight" data-wow-delay="0.5s">
                <div class="img-head">
                    <img src="{{ asset('image/home-page/intro-3.png') }}" alt="intro-image">
                </div>
                <div class="text-head">FINANCE 4.0</div>
                <div class="desciption">The introduction of Blockchain is already having an impact on the world of entry-level stocks and forex trading, with the innovative MT4 platform aiming to build a single, global marketplace in which every single trader can invest transparently. This is a bold and ground-breaking project, and one which establishes a multi-layered FX trading environment where every all relevant data is stored within a single, distributed ledger.</div>
            </div>
        </div>
    </div>

    <div class="trading-box position-relative">
        <div class="row-trading container mt-5">
            <div class="row">
                <div class="col-6">
                    <div class="quote quote-left"></div>
                    <div class="quote quote-right"></div>
                    <p class="text-trading">The Solo Payment  is a financial technology platform from the financial trading organization with more than four decades of experience in advising and providing solutions to help its partners make a profitable engagement in Modern Financial Trading.</p>
                </div>
                <div class="col-6 row-image">
                    <div class="img-trading">
                        <img src="{{ asset('image/home-page/img-trading.png') }}" alt="trading" class="w-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-trading">
            <img src="{{ asset('image/home-page/bg-trading.png') }}" alt="bg-trading" class="w-100">
        </div>
    </div>

    <div class="area-solopayment">
        <div class="row-solopayment-ai container">
            <div class="row-solopayment-ai-1 wow bounceInLeft" data-wow-delay="0.5s">
                <div class="head-solopayment text-center">
                    <h3 class="">SOLO PAYMENT AI</h3>
                    <img src="{{ asset('image/home-page/solopayment-ai-icon.png') }}" alt="Solo Payment">
                </div>
                <div class="line-highlight"></div>
                <div class="content-solopayment text-center">
                    <p>SOLO PAYMENT AI has successfully developed Artificial Intelligence designed to trade Stock, Forex, Commodities and Crypto-currency. AI uses the latest research on Artificial Intelligence, data and complex algorithms to increase the success rate of modern financial transactions compared to traditional transactions.</p>
                </div>
            </div>
            <div class="row-solopayment-ai-2 wow bounceInRight" data-wow-delay="0.5s">
                <div class="head-solopayment text-center">
                    <h3 class="">CAPITAL-PROTECTED PROGRAM</h3>
                </div>
                <div class="line-highlight"></div>
                <div class="content-solopayment">
                    <p>Wallstreet AI has introduced a unique type of investment in Modern Financial Trading, through which you can trade at ease, knowing that your investment is safe and well protected by leading financial trading specialists. Now you can be a part of the largest finance markets in the world with confidence and no fear of risking your capital.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="area-statistics-ai">
        <div class="row-statistics container">
            <div class="wow fadeIn" data-wow-delay="0.5s">
                <h3 class="w-100 text-center">SOLOPAYMENT AI Statistics</h3>
                <p class="text-center w-700">The innovative MT4 platform aiming to build a sin*gle and global marketplace in which every single trader can invest transparently.</p>
                <h5 class="w-100 text-center">We are trusted by</h5>
            </div>
            <div class="row text-center">
                <div class="col-3">
                    <div class="number-content">100</div>
                    <div class="text-content">Countries</div>
                </div>
                <div class="col-3">
                    <div class="number-content">12,586,500</div>
                    <div class="text-content">Traders</div>
                </div>
                <div class="col-3">
                    <div class="number-content">568</div>
                    <div class="text-content">Milllions of IBs paid out</div>
                </div>
                <div class="col-3">
                    <div class="number-content">7,000</div>
                    <div class="text-content">Billions usd of market volume</div>
                </div>
            </div>
        </div>
    </div>

    <div class="area-partnership-method mt-4">
        <div class="heading-area">
            <h3 class="heading-highlight">WALL STREET AI PARTNERSHIP MT4 BROKERS</h3>
        </div>
        <div class="list-image">
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/cocacola.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/trade-family.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/amazone.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/intel.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/microsoft.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/bank-of-america.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/ebay.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/fedex.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/netflix.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/alphabet.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/facebook.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/solotrade.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/apple-inc.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/ford.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/pepsion.png') }}" alt="partnership">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/partnership/nvidia.png') }}" alt="partnership">
            </div>
        </div>
        <div class="heading-area mt-4">
            <h3 class="heading-highlight">PAYMENT METHODS</h3>
        </div>
        <div class="list-image">
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/master-card.png') }}" alt="payment-method">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/perfect-money.png') }}" alt="payment-method">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/usdt.png') }}" alt="payment-method">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/btc.png') }}" alt="payment-method">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/wm.png') }}" alt="payment-method">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/skrill.png') }}" alt="payment-method">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/paypal.png') }}" alt="payment-method">
            </div>
            <div class="image">
                <img src="{{ asset('image/home-page/payment-method/visa.png') }}" alt="payment-method">
            </div>
        </div>
    </div>

    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="heading-footer">
                        <img src="{{ asset('image/home-page/logo-web.png') }}" class="w-100" alt="Home Page">
                    </div>
                    <div class="content-footer">
                        <ul>
                            <li>
                                <img src="{{ asset('image/home-page/icon-home.png') }}" alt="home">New York, USA.
                            </li>
                            <li>
                                <img src="{{ asset('image/home-page/icon-email.png') }}" alt="home">info@solopayment.co
                            </li>
                            <li>
                                <img src="{{ asset('image/home-page/icon-pc.png') }}" alt="home">www.solopayment.co
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <div class="heading-menu">
                        <h5>Menu</h5>
                    </div>
                    <div class="content-menu">
                        <ul>
                            <li><a href="#">About US</a></li>
                            <li><a href="#">Introduction</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-4 col-subcribe">
                    <div class="heading-subcribe">
                        <h3>Subscribe</h3>
                    </div>
                    <div class="content-subcribe">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Your email ...">
                        <button class="btn btn-subcribe">
                            <img src="{{ asset('image/home-page/btn-subcribe.png') }}" alt="subcribe">
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="copy-right text-center">Copyright ©️ SoloPayment.co</div>
                </div>
            </div>
        </div>
    </div>

    @if(config("view.showPopup"))
        <div id="popup-top">
            <div class="bg-popup-top"></div>
            <div class="area-popup-top">
                <div class="box-close">
                    <img src="{{ asset('image/home-page/close.png') }}" alt="Close">
                </div>
                <div class="box-image">
                    <img
                        data-src-pc="{{ asset('image/home-page/popub-pc.png') }}"
                        data-src-sp="{{ asset('image/home-page/popub-sp.png') }}"
                        src="#"
                        alt="Popup"
                    />
                </div>
            </div>
        </div>
    @endif
    <script>
        const timeReopenPopup = {{config("view.timeReopenPopup")}} * 1000;
    </script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/homepage.js') }}"></script>
    <script type="text/javascript">
        new WOW().init();
    </script>
</body>
</html>
