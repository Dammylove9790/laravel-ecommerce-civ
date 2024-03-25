  <!-- <i class="fa-brands fa-whatsapp whatsapp-icon animate__animated"></i> -->
  <footer id="footer-section" class="footer_section bg-dark text-white py-2 w-100 ">
    <div class="container my-5">
      <h1 class="text-center"> Grab the latest deal by shopping with us. </h1>
      <p class="">Priccado is your number one online shopping site in Cote D'ivoire. We are an online store where you can purchase all your electronics, as well as books, home appliances, kiddies items, fashion items for men, women, and children; cool gadgets, computers, groceries, automobile parts, and more on the go. What more? You can have them delivered directly to you. Shop online with great ease as you pay with UkayPay which guarantees you the safest online shopping payment method, allowing you to make stress free payments. Whatever it is you wish to Whatsapp Buy, we offers you all and lots more at prices which you can trust.</p>

      
      <div class="container-fluid mt-5 mx-3">
        <div class="row d-flex justify-content-lg-between ">

          <div class="col-lg-2 col-md-3 col-sm-4 mb-5">
            <h4>About UKAY-Shop</h4>
            <p><a href="#">About us</a></p> 
            <p><a href="#">Terms and Conditions</a></p> 
            <p><a href="#">Flash Sales</a></p>
          </div>
          
          <div class="col-lg-2 col-md-3 col-sm-4 mb-5">
            <h4>Socials Links</h4>
            <p><a href="https://www.facebook.com/people/Priccaddo/100063824117168">Facebook</a></p>
            <p><a href="#">Instagram</a></p>
            <p><a href="#">Twitter</a></p>
            <p><a href="#">Youtube</a></p>
          </div>
          
          <div class="col-lg-2 col-md-3 col-sm-4 mb-5">
            <h4>Need Help</h4>
            <p><a href="#">Help Center</a></p>
            <p><a href="#">Contact Us</a></p>
            <p><a href="#">Make Enquiry</a></p>
            <p><a href="#">Report an Issue</a></p>
            <p><a href="#">Dispute Resolution Policy</a></p>
            
          </div>
        </div>
        
      </div>

      <div class="text-center mb-3 d-flex justify-content-center">
        <small class="">
          &copy; <script> document.write(new Date().getFullYear())</script>
        Developed by <a href="" class="">Kaytech Nigeria.</a>
        </small>
      </div>
    </div>


  </footer>

  <a href="https://wa.me/+22504099410" target="_blank" class="whatsapp-icon" data-toggle="tooltip" data-placement="left" title="Need help?">
    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
  </a>

  @yield('js')
  <!-- ##### All Javascript Files ##### -->
  <!-- jquery 2.2.4  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <!-- Popper js -->
  {{-- <script src="{{asset('js/popper.min.js')}}"></script> --}}
  <!-- Bootstrap js -->
  {{-- <script src="{{asset('js/bootstrap.min.js')}}"></script> --}}
  <!-- Owl Carousel js -->
  <script src="{{asset('js/owl.carousel.min.js')}}"></script>
  <!-- Classynav -->
  <script src="{{asset('js/classynav.js')}}"></script>
  <!-- Wow js -->
  <script src="{{asset('js/wow.min.js')}}"></script>
  <!-- Sticky js -->
  <script src="{{asset('js/jquery.sticky.js')}}"></script>
  <!-- Magnific Popup js -->
  <script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
  <!-- Scrollup js -->
  <script src="{{asset('js/jquery.scrollup.min.js')}}"></script>
  <!-- Jarallax js -->
  <script src="{{asset('js/jarallax.min.js')}}"></script>
  <!-- Jarallax Video js -->
  <script src="{{asset('js/jarallax-video.min.js')}}"></script>
  <!-- Active js -->
  <script src="{{asset('js/active.js')}}"></script>
  <script>
    let locale_price = document.querySelectorAll(".localePrice");
    for(let loc = 0; loc < locale_price.length; loc++){
        locale_price[loc].innerHTML = Number(locale_price[loc].innerHTML).toLocaleString()
    }
  </script>
  
</body>
</html>
