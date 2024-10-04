<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

@include('dashboards.user.layouts.includes.head')

<body>
  <style> 
   footer a {
    color: #ffffff !important
   }
   .footer-heading {
    color: #b3722a;
    font-size: 16px;
    font-weight: 600;
    line-height: 35px;
   }
</style>
    <div class="wrapper dashboard-wrapper">
    <nav class="navbar navbar-expand-lg navbar-white bg-white py-3" >
      <div class="container-fluid">
          <a href="https://maihomm.com/" class="navbar-brand"><img src="{{ $web_assets }}/images/Maihomm-web-logo.png" style="width: 66% !important" alt="Maihomm"></a>
          <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse" style="font-size: 17px; font-family:'Montserrat', sans-serif; font-weight: 500; letter-spacing: normal;">
              <div class="navbar-nav">
                  <a href="https://maihomm.com/" class="nav-item nav-link mx-lg-4 text-black">Home</a>
                  <div class="nav-item dropdown mx-lg-4">
                      <a href="#" class="nav-link dropdown-toggle text-black" data-bs-toggle="dropdown">Learn More</a>
                      <div class="dropdown-menu" style="width: 400px;">
                        <div class="row p-4">
                          <div class="col-sm-6">  <a href="https://maihomm.com/about-us/">
                            <div class="d-flex align-items-center mb-4">
                              <div class="mr-2"><img src="{{ $web_assets }}/images/About-300x300.png" alt="icon" style="width: 33px !important" /></div>
                              <div class="text-black"> About Us</div>
                            </div>
                            </a>
                          </div>
                          <div class="col-sm-6">  <a href="https://maihomm.com/faqs/">
                            <div class="d-flex align-items-center mb-4">
                              <div class="mr-2"><img src="{{ $web_assets }}/images/FAQ-300x300.png" alt="icon" style="width: 33px !important" /></div>
                              <div class="text-black"> FAQs</div>
                            </div>
                            </a>
                          </div>
                          <div class="col-sm-6">  <a href="https://maihomm.com/insights/">
                            <div class="d-flex align-items-center mb-4">
                              <div class="mr-2"><img src="{{ $web_assets }}/images/Insights-300x300.png" alt="icon" style="width: 33px !important"  /></div>
                              <div class="text-black"> Insights </div>
                            </div>
                            </a>
                          </div>
                          <div class="col-sm-6">  <a href="https://maihomm.com/partners/">
                            <div class="d-flex align-items-center mb-4">
                              <div class="mr-2"><img src="{{ $web_assets }}/images/Partners-300x300.png" alt="icon" style="width: 33px !important"/></div>
                              <div class="text-black"> Partners </div>
                            </div>
                            </a>
                          </div>
                          
                        </div>
                    </div>
                  </div>
                  <div class="nav-item dropdown mx-lg-4 ">
                      <a href="#" class="nav-link dropdown-toggle text-black" data-bs-toggle="dropdown">Our Offerings</a>
                      <div class="dropdown-menu" style="width: 470px;">
                          <div class="row p-2">
                            <div class="col-sm-6">  <a href="https://maihomm.com/how-it-works/">
                              <div class="d-flex align-items-center mb-4">
                                <div class="mr-2"><img src="{{ $web_assets }}/images/How-it-works-300x300.png" alt="icon" style="width: 33px !important" /></div>
                                <div class="text-black"> How it works</div>
                              </div>
                              </a>
                            </div>
                            <div class="col-sm-6">  <a href="https://maihomm.com/investment-options/">
                              <div class="d-flex align-items-center mb-4">
                                <div class="mr-2"><img src="{{ $web_assets }}/images/investment-option-300x300.png" alt="icon" style="width: 33px !important" /></div>
                                <div class="text-black"> investment options</div>
                              </div>
                              </a>
                            </div>
                            <div class="col-sm-6">  <a href="https://maihomm.com/book-appointment/">
                              <div class="d-flex align-items-center mb-4">
                                <div class="mr-2"><img src="{{ $web_assets }}/images/Schedule-appointment.png" alt="icon" style="width: 33px !important" /></div>
                                <div class="text-black"> Book Appointment </div>
                              </div>
                              </a>
                            </div>
                            <div class="col-sm-6">  <a href="https://maihomm.com/sell/">
                              <div class="d-flex align-items-center mb-4">
                                <div class="mr-2"><img src="{{ $web_assets }}/images/Sell-300x300.png" alt="icon" style="width: 33px !important" /></div>
                                <div class="text-black"> Sell </div>
                              </div>
                              </a>
                            </div>
                            
                          </div>
                      </div>
                  </div>
                  <a href="#" class="nav-item nav-link mx-lg-4 text-black">Properties</a>
              </div>
              <div class="navbar-nav justify-content-around ">
                 <div> <a href="{{ route('login') }}" class="nav-item nav-link"><button type="button" class="btn btn-outline-warning " style="color: #000000; border-width: 3px; border-radius: 0; border-color: #DEA739; font-size: 14px; font-family:'Montserrat', sans-serif; font-weight: 500; letter-spacing: normal;">Login/signup</button></a></div> 
                 <div> <a href="https://maihomm.com/book-appointment/" class="nav-item nav-link"><button type="button" class="btn btn-warning " style="color: #ffffff; border-radius: 0; background-color: #DEA739; border-width: 3px; border-color: #DEA739; font-size: 14px; font-family:'Montserrat', sans-serif; font-weight: 500; letter-spacing: normal;">Contact</button></a></div> 
              </div>
          </div>
      </div>
  </nav>
  <section class="px-5 text-white" style="background-image:url('{{ $web_assets }}/images/p-hero.png'); background-repeat: initial; background-size: contain; padding: 168px 5px;">
 <h2 class="" style="font-weight: 600; color: #ffffff;" >Maihomm</h2>
 <h5 class="pl-4" style="font-weight: 200; border-left-style: solid; border-left-width: 15px; border-left-color: #DEA739; color: #ffffff !important"> Simplifying home ownership globally for<br />  home buyers through fractional investment.
 </h5>
  </section>
        <div class="d-flex flex-wrap flex-xl-nowrap">
            <div class="page-content">
                @yield("content")
            </div>
        </div>
    </div>
    <footer class=" text-light" style="background-color: #000; background-image: url('{{ $web_assets }}/images/footer-bg-webn.png'); background-repeat: initial; background-size: contain; padding: 168px 5px; ">
			<div class="container ">
				  <div class="row border-bottom mb-5 pb-4 align-items-center">
    <div class="col-md-6 mb-md-0 mb-4">
      <div class="d-flex align-items-center">
        <h2 class="logo mr-3"><a href="#"><img src="{{ $web_assets }}/images/Maihomm-icon-@2x.png"/></a></h2>
        <p>Simplifying home ownership globally for home buyers through fractional investment.</p>
      </div>
    </div>
    <div class="col-md-6 mb-md-0 mb-4 text-md-right">
      <!-- <ul class="ftco-footer-social p-0 mb-0">
        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><span class="ion-logo-twitter"></span></a></li>
        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><span class="ion-logo-facebook"></span></a></li>
        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><span class="ion-logo-instagram"></span></a></li>
      </ul>
      <ul class="list-unstyled" style="color: white;">
        <li>
          <a href="mailto:info@maihomm.com">
            <span class="">info@maihomm.com</span>
          </a>
        </li>
        <li>
          <a href="mailto:support@maihomm.com">
            <span>support@maihomm.com</span>
          </a>
        </li>
        <li>
          <span>
            <i class="fas fa-check"></i>
          </span>
          <span>+44 783 037 9088</span>
        </li>
        <li>
          <a href="tel:+234907%20675%202915">
            <span>+234 907 675 2915</span>
          </a>
        </li>
      </ul> -->
    </div>
  </div>


				<div class="row">
    <div class="col-md-6 col-lg-3 mb-md-0 mb-4">
        <h2 class="footer-heading">Site Links</h2>
        <div class="block-23 mb-3">
            <ul class="list-unstyled block-23 mb-3">
                <li><a href="https://maihomm.com/properties"><span>Properties</span></a></li>
                <li><a href="https://maihomm.com/insights"><span>Insights</span></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-md-0 mb-4">
        <h2 class="footer-heading">Legal</h2>
        <div class="block-23 mb-3 ">
            <ul class="list-unstyled block-23 mb-3">
                <li><a href="https://maihomm.com/disclaimer"><span>Disclaimer</span></a></li>
                <li><a href="https://maihomm.com/terms-and-conditions"><span>Terms and conditions</span></a></li>
                <li><a href="https://maihomm.com/privacy-policy"><span>Privacy Policy</span></a></li>
                <li><a href="https://maihomm.com/cookie-notice"><span>Cookie Notice</span></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-md-0 mb-4">
        <h2 class="footer-heading">Useful links</h2>
        <div class="block-23 mb-3">
            <ul class="list-unstyled">
                <li><a href="https://maihomm.com/book-appointment"><span>Book Appointment</span></a></li>
                <li><a href="https://maihomm.com/faqs"><span>FAQs</span></a></li>
                <li><a href="https://maihomm.com/about-us/"><span>Join the Team</span></a></li>
                <li><a href="https://maihomm.com/insights"><span>Insights</span></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-md-0 mb-4">
        <h2 class="footer-heading">Subscribe to our newsletter</h2>
        <div class="block-24">
            <form action="#" class="subscribe-form">
                <div class="form-group">
                    <input type="text" class="form-control rounded-left" placeholder="Enter email address">
                </div>
            </form>
        </div>
    </div>

	<div class="">
		<div class="">
    <h2  style="color: white; font-size: 14px; margin-left: 95px;">COMING SOON!</h2>
    <img src="{{ $web_assets }}/images/app-store-1024x303.png" alt="" style="width: 150px; ">
      &nbsp; &nbsp; &nbsp; &nbsp;
      <img src="{{ $web_assets }}/images/google-play.png" alt="" style="width: 150px;">
		</div>
	  </div>

	  <div class="row mt-5">

		<h4 class="footer-heading">DISCLAIMER</h4>
		<p class="pl-4 ml-2" style="font-size: 12px; border-left-style: solid; border-left-width: 7px; border-left-color: #BB7E2E;">
			Our website is a marketplace that allows you to invest directly in any property that you so desire. All investments are done as an agreement to be bound by the Terms & Conditions of Maihomm. Maihomm’s name and logo are registered, and its services, strategies, and trademarks are protected. 


		</p>
	  </div>
	  
</div>

		</footer>
    <div class="container-fluid">  
    <div class="row pt-4" style="background-color: #BB7E2E; color: #ffffff">
          <div class="col-md-6 col-lg-8">
            <p class="copyright">
   &copy;<script>document.write(new Date().getFullYear());</script> Mailcomm. All rights reserved.</p>
          </div>
          <div class="col-md-6 col-lg-4 text-md-right">
          	<p class="copyright"> <a href="http://wildfire.ng/" target="_blank" style="color: #ffffff">Designed by Wildfire NG</a>
  </p>
          </div>
        </div>
			</div>
  </div>
    @include('dashboards.user.layouts.includes.scripts')
    @include('dashboards.user.layouts.includes.symbols')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

