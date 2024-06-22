<?php
  if (!file_exists("db_connection.php")) {
    if(file_exists("install.php")){
      header("Location: install.php");
      exit;
    }
    else{
      echo "Błąd połączenia";
      exit;
    }
  }

  include "db_connection.php";

  if (!$conn) {
    if(file_exists("install.php")){
      header("Location: install.php");
      exit;
    }
    else{
      echo "Błąd połączenia";
      exit;
    }
  }
?>

<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="Smart Home, Future, Device, Devices, Dashboard" />
    <meta name="description" content="Smart Home internet application" />
    <meta name="author" content="Bartosz Majczyk, Mateusz Pałka" />
    
    <title>Smart Future</title>
    
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />
    <!-- font awesome style -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />

  </head>

  <body>
    <div class="hero_area">
      <!-- header section strats -->
      <header class="header_section long_section px-0">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <img src="images/fevicon.png" id="logo-image">
          <a class="navbar-brand" href="index.php">
            <span>
              SMART FUTURE
            </span>
          </a>
          <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
          </div>
          <div class="quote_btn-container">
            <a href="">
              <span>
                <a href="logowanie.php" id="login-link">Logowanie</a>
              </span>
            </a>
          </div>
        </nav>
      </header>
      <!-- end header section -->

      <!-- slider section -->
      <section class="slider_section long_section">
        <div id="customCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container ">
                <div class="row">
                  <div class="col-md-5">
                    <div class="detail-box">
                      <h1>
                        kompatybilność
                      </h1>
                      <p>
                        Smart Future zapewnia panel sterowania wspierający każde certyfikowane urządzenie Smart na rynku. Ponadto Smart Future pozwala na kompatybilność między urządzeniami różnych producentów.
                      </p>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                      <img src="images/puzzle.png" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="container ">
                <div class="row">
                  <div class="col-md-5">
                    <div class="detail-box">
                      <h1>
                        Komfort
                      </h1>
                      <p>
                        Korzystaj z naszego panelu gdziekolwiek jesteś i z jakiego urządzenia chcesz. Nasz wygodny panel dostosowany jest pod większość współczesnych mobilnych jak i stacjonarnych urządzeń.
                      </p>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                      <img src="images/Comfort.png" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="container ">
                <div class="row">
                  <div class="col-md-5">
                    <div class="detail-box">
                      <h1>
                        Kreatywność<br>
                      </h1>
                      <p>
                        Dostosuj swoje urządzenia jak tylko pragniesz. Przenieś swoją abstrakcyjną wyobraźnię na inteligentne urządzenia a my ci w tym spróbujemy pomóc. Dołącz do nas i sam zobacz jakie to proste!
                      </p>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                      <img src="images/creativity.png" id="creativity-img" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <ol class="carousel-indicators">
            <li data-target="#customCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#customCarousel" data-slide-to="1"></li>
            <li data-target="#customCarousel" data-slide-to="2"></li>
          </ol>
        </div>
      </section>
      <!-- end slider section -->
    </div>

    <!-- devices section -->
    <section class="devices_section layout_padding">
      <div class="container">
        <div class="heading_container">
          <h2>
            Urządzenia Smart
          </h2>
          <p>
            To tylko przykłady najpopularniejszych urządzeń, które są kompatybilne ze Smart Future. Jeśli twoje urządzenie nie znajduje się poniżej to i tak nie ma powodu do obaw, spróbuj je zarejestrować a jeśli ci się uda będzie to oznaczało, że Smart Future je wspiera!
          </p>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4">
            <div class="box">
              <div class="img-box">
                <img src="images/Termostat.png" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Termostat
                </h5>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="box">
              <div class="img-box">
                <img src="images/VideoDzwonek.png" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Viedo Dzwonek do drzwi
                </h5>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="box">
              <div class="img-box">
                <img src="images/Kamera.png" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Kamera
                </h5>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="box">
              <div class="img-box">
                <img src="images/Zamek.png" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Zamek do drzwi
                </h5>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="box">
              <div class="img-box">
                <img src="images/CzujnikDymu.png" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Czujnik dymu
                </h5>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="box">
              <div class="img-box">
                <img src="images/Zarowka.png" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  Żarówka
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- end furniture section -->


    <!-- about section -->

    <section class="about_section layout_padding long_section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="img-box">
              <img src="images/aboutus.png" id="aboutus" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-box">
              <div class="heading_container">
                <h2>
                  O nas
                </h2>
              </div>
              <p>
                Smart Future to innowacyjna firma, która dostarcza zaawansowaną aplikację internetową, służącą jako wszechstronny panel do sterowania różnorodnymi urządzeniami Smart. 
                Nasze motto, oparte na trzech "K" - Komforcie, Kompatybilności i Kreatywności - jest centralnym punktem naszej działalności. 
                Zapewniamy naszym klientom nie tylko wygodę w zarządzaniu ich urządzeniami smart, ale także gwarantujemy kompatybilność z różnymi producentami oraz platformami. 
                Ponadto, poprzez naszą aplikację, dajemy użytkownikom możliwość wyrażenia swojej kreatywności poprzez personalizację i dostosowywanie ustawień do swoich potrzeb, co sprawia, że ich doświadczenie z inteligentnymi urządzeniami staje się jeszcze bardziej satysfakcjonujące. 
                Dołącz do Smart Future i odkryj, jak łatwo możesz uczynić swoje życie jeszcze bardziej inteligentnym.
              </div>
          </div>
        </div>
      </div>
    </section>

    <!-- end about section -->

    <!-- client section -->

    <section class="client_section layout_padding-bottom">
      <div class="container">
        <div class="heading_container">
          <h2>
            Oni nam zaufali
          </h2>
        </div>
        <div id="carouselExample2Controls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row">
                <div class="col-md-11 col-lg-10 mx-auto">
                  <div class="box">
                    <div class="img-box">
                      <img src="images/Wojciech.jpg" alt="" />
                    </div>
                    <div class="detail-box">
                      <div class="name">
                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                        <h6>
                          Wojciech
                        </h6>
                      </div>
                      <p>
                        Smart Future nie ma sobie równych. Sprawny i ergonomiczny dashboard wyróżnia tę aplikację nad konkurencją a kompatybilność jest czymś czego żadna inna aplikacja nie robi tak dobrze jak Smart Future.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="row">
                <div class="col-md-11 col-lg-10 mx-auto">
                  <div class="box">
                    <div class="img-box">
                      <img src="images/Karolina.jpg" alt="" />
                    </div>
                    <div class="detail-box">
                      <div class="name">
                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                        <h6>
                          Karolina
                        </h6>
                      </div>
                      <p>
                        Najlepszy panel na rynku, wcześniej musiałam mieć wszystkie urządzenia w kilku różnych miejscach ale nie jest to już problemem odkąd korzystam ze Smart Future. Teraz wszystkie moje urządzenia znajdują się w jednym miejscu a ja zaoszczędzam swój cenny czas na inne rzeczy.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="row">
                <div class="col-md-11 col-lg-10 mx-auto">
                  <div class="box">
                    <div class="img-box">
                      <img src="images/Mariusz.jpg" alt="" />
                    </div>
                    <div class="detail-box">
                      <div class="name">
                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                        <h6>
                          Mariusz
                        </h6>
                      </div>
                      <p>
                        Niedawno zakupiłem tanie urządzenie z chińskiej republiki ludowej, niestety producent nie dostarczył mi żadnego panelu zarządzania. Na szczęście trafiłem na Smart Future, które pozwoliło mi na zarejestrowanie mojego sprzętu! Po prostu świetna aplikacja.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel_btn-container">
            <a class="carousel-control-prev" href="#carouselExample2Controls" role="button" data-slide="prev">
              <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample2Controls" role="button" data-slide="next">
              <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- end client section -->

    <!-- contact section -->
    <section class="contact_section  long_section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="form_container">
              <div class="heading_container">
                <h2>
                  Kontakt
                </h2>
              </div>
              <form method="post" action="">
                <div class="txt_field">
                  <input type="text" placeholder="Imię" required/>
                  <span></span>
                </div>
                <div class="txt_field">
                  <input type="text" placeholder="Numer tel." required/>
                  <span></span>
                </div>
                <div class="txt_field">
                  <input type="email" placeholder="Email" required/>
                  <span></span>
                </div>
                <div class="txt_field">
                  <input type="text" class="message-box" placeholder="Wiadomość" required/>
                  <span></span>
                </div>
                <div class="btn_box">
                  <button>
                    Wyślij
                  </button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <div class="map_container">
              <div class="map">
                <div id="googleMap">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2468.7005685745594!2d19.463046812042574!3d51.77508097175813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471bcb27e88bf415%3A0x8b2890d178bb78c2!2sPolskiej%20Organizacji%20Wojskowej%203%2F5%2C%2090-255%20%C5%81%C3%B3d%C5%BA!5e0!3m2!1spl!2spl!4v1716507547357!5m2!1spl!2spl" width="500" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end contact section -->
    
    <!-- info section -->
    <section class="info_section long_section">

      <div class="container">
        <div class="contact_nav">
          <a href="tel:48572797538">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <span>
              +48 572-797-538
            </span>
          </a>
          <a href="mailto:SmartFuture@gmail.com">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <span>
              SmartFuture@gmail.com
            </span>
          </a>
          <a href="https://maps.app.goo.gl/KXwD48rzqR5kjT7D9" target="_blank">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <span>
              ul. POW 3/5<br>
              90-255 Łódź
            </span>
          </a>
          
        </div>
      </section>
    <!-- end info_section -->

    <!-- weather section -->

    <section class="weather">
      <div class="container">
        <div id="ww_0eb4c851f9013" v='1.3' loc='auto' a='{"t":"responsive","lang":"pl","sl_lpl":1,"ids":[],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>
          More forecasts: 
            <a href="https://oneweather.org/warsaw/30_days/" id="ww_0eb4c851f9013_u" target="_blank">Warsaw weather 30 days</a>
        </div>
          <script async src="https://app2.weatherwidget.org/js/?id=ww_0eb4c851f9013">
          </script>
      </div>
    </section>

    <!-- end weather section -->

    <!-- footer section -->
    <footer class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a>
          Distribution <a href="https://themewagon.com">ThemeWagon</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->


    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>

  </body>
</html>