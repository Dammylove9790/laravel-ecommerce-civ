@extends('layouts.app')
@section('title', 'About Us')


@section('content')
  <!-- ##### Breadcrumb Area Start ##### -->
  <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{asset('img/bg-img/18.jpg')}});">
    <div class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-12">
          <div class="breadcrumb-text">
            <h2>About Us</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="famie-breadcrumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('pages.index')}}"><i class="fa fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">About</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- ##### Breadcrumb Area End ##### -->

  <!-- ##### Famie Benefits Area Start ##### -->
  <section class="famie-benefits-area pb-5">
    <div class="container">
      <div class="row justify-content-center">
        <!-- Single Benefits Area -->
        <div class="col-12 col-sm-4 col-lg">
          <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="100ms">
            <img src="{{asset('img/core-img/digger.png')}}" alt="">
            <h5>Best Services</h5>
          </div>
        </div>

        <!-- Single Benefits Area -->
        <div class="col-12 col-sm-4 col-lg">
          <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="300ms">
            <img src="{{asset('img/core-img/windmill.png')}}" alt="">
            <h5>Farm Experiences</h5>
          </div>
        </div>

        <!-- Single Benefits Area -->
        <div class="col-12 col-sm-4 col-lg">
          <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="500ms">
            <img src="{{asset('img/core-img/cereals.png')}}" alt="">
            <h5>100% Natural</h5>
          </div>
        </div>

        <!-- Single Benefits Area -->
        <div class="col-12 col-sm-4 col-lg">
          <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="700ms">
            <img src="{{asset('img/core-img/tractor.png')}}" alt="">
            <h5>Farm Equipment</h5>
          </div>
        </div>

        <!-- Single Benefits Area -->
        <div class="col-12 col-sm-4 col-lg">
          <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="900ms">
            <img src="{{asset('img/core-img/sunrise.png')}}" alt="">
            <h5>Organic food</h5>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ##### Famie Benefits Area End ##### -->

  <!-- ##### About Us Area Start ##### -->
  <section class="about-us-area">
    <div class="container">
      <div class="row align-items-center">

        <!-- About Us Content -->
        <div class="col-12 col-md-8">
          <div class="about-us-content mb-100">
            <!-- Section Heading -->
            <div class="section-heading">
              <p>About us</p>
              <h2><span>Let Us</span> Tell You Our Story</h2>
              <img src="{{asset('img/core-img/decor.png')}}" alt="">
            </div>
            <p>
              Wefarm is  a Nigeria's largest digital market for farmers and buyers. It's a platform for buying and selling quality and healthy Agricultural produce. We provide the largest varieties of Agricultural produce ranging from domestic consumables to industrial Agricultural products.
            </p>
            <p>
              Wefarm is an idea borne out of combating inaccessible quality food and poverty. We recognize the potential of the Agricultural sector to be a chief driver of our economy and the necessity of providing seamless access to available quality Agricultural products. We are contributing our quota by providing largest digital market where farmers can maximize their products from sales and buyers can buy quality Agricultural products at the cheapest price possible. 
            </p>
            <p>
              We are empowering rural farmers by giving them access to vast market of buyers. This will by extension increase capacity of production to ensure food security.  With our team of smart people and tools, our platform pride in running a simple, fast, easy-to-use and seamless service.
            </p>
            <ul>
                <li>Farmers empowered</li>
                <li>Farms sponsored</li>
                <li> Acres cultivated</li>
                <li> Farm sponsors and community members</li>
              </ul>
          </div>
        </div>

        <!-- Famie Video Play -->
        <div class="col-12 col-md-4">
          <div class="famie-video-play mb-100">
            <img src="{{asset('img/bg-img/6.jpg')}}" alt="">
          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- ##### About Us Area End ##### -->

  <!-- ##### Team Member Area Start ##### -->
  <section class="team-member-area section-padding-100-0">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Section Heading -->
          <div class="section-heading text-center">
            <p>MEET OUR TEAM</p>
            <h2><span>The Great Team</span> Will Always Help You</h2>
            <img src="{{asset('img/core-img/decor2.png')}}" alt="">
          </div>
        </div>
      </div>

      <div class="row">

        <!-- Single Team Member -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="100ms">
            <!-- Team Thumbnail -->
            <div class="team-img">
              <img src="{{asset('img/bg-img/femiLateef.jpg')}}" alt="" style="width:100%; height:256px;">
              <!-- Social Info -->
              <div class="team-social-info">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Instagram"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <!-- Team Member Info -->
            <div class="team-member-info">
              <h5>Mr. Lateef Femi</h5>
            </div>
          </div>
        </div>

        <!-- Single Team Member -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="300ms">
            <!-- Team Thumbnail -->
            <div class="team-img">
              <img src="{{asset('img/bg-img/doctor1.png')}}" alt="" style="width:100%; height:256px;">
              <!-- Social Info -->
              <div class="team-social-info">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Instagram"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <!-- Team Member Info -->
            <div class="team-member-info">
              <h5>Dr. Samuel Sanusi</h5>
            </div>
          </div>
        </div>

        <!-- Single Team Member -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="500ms">
            <!-- Team Thumbnail -->
            <div class="team-img">
              <img src="{{asset('img/bg-img/favour.jpeg')}}" alt="" style="width:100%; height:256px;">
              <!-- Social Info -->
              <div class="team-social-info">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Instagram"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <!-- Team Member Info -->
            <div class="team-member-info">
              <h5>Mr. Johnson Lucky</h5>
            </div>
          </div>
        </div>

        <!-- Single Team Member -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="700ms">
            <!-- Team Thumbnail -->
            <div class="team-img">
              <img src="{{asset('img/bg-img/sunday.jpg')}}" alt="" style="width:100%; height:256px;">
              <!-- Social Info -->
              <div class="team-social-info">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Instagram"><i class="fa fa-instagram"></i></a>
              </div>
            </div>
            <!-- Team Member Info -->
            <div class="team-member-info">
              <h5>Mr. Sunday Omolewu</h5>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- ##### Team Member Area End ##### -->

@endsection