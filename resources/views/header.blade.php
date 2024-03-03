<div id="" class="container-fluid header d-flex justify-content-center align-items-center ">
    <div class="row justify-content-center h-100 w-100">
      <div class="col-lg-5 col-md-6 align-self-center animate__bounceInRight animate__slow ">
        <span class="d-flex justify-content-center animate__animated animate__bounce animate__infinite animate__slow ">
          <span id="slogan" class="col-md-12 col-sm-10 px-5">Shopping at your Doorstep</span>
        </span>
      </div>
  
      <div class="col-lg-7 col-md-6 p-lg-0 pt-3 pb-5 align-self-center text-center ">
        <div class="col-lg-8 col-md-10 col-sm-11 col-12 form-group mt-3 mx-auto">
          <label for="search" class="product-lookup text-white">Product Lookup...</label>
          <form action="{{route('pages.searchProduct')}}" method="get">
            
            <input type="search" name="search" id="search_input" placeholder="What are you looking for?">
            <div class="col form-group mt-3 mx-auto">
              <button type="submit" id="search_word" class="btn btn-warning px-4"> Search <i class="fas fa-search mx-2"></i> </button>
            </div>
            
          </form>
        </div>
      </div>
  
    </div>
  </div>
  