@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <section class="con_1_sec">
      <div class="container">
        <div class="row">
          <div class="col text-center">
            <h1 class="sec_h1 mt-0">About Us</h1>
            <p class="subtitle m-auto mx-800">A B2B platform that makes thousands of verified & ready to launch products available to online sellers. </p>
            <img src="{{asset('assets/images/icon/about_us.png')}}" alt="" class="heroimage mt30 mb-0">
          </div>
        </div>
      </div>
    </section>
    <section class="con_2_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <p class="subtitle text-center px-4">
              <span class="quote-left fas fa-quote-left me-2"></span>
              eKomn is engaged into B2B ecommerce product sourcing and ecommerce related services to micro and small enterprises through our innovative Technology platform. With our technology led innovative features and services, we aim to empower all existing and new entrepreneurs in online ecommerce space to manage their ecommerce/online business efficiently and grow profitably. Our mission is to democratize product sourcing and online ecommerce services ushering in greater employment and wealth generation.
              <span class="quote-left fas fa-quote-right ms-2"></span>
            </p>
          </div>
        </div>
      </div>
    </section>
    <section class="con_1_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="sec_h1 mt-0">eCommerce Sourcing redefined</h1>
            <p class="subtitle fs-16"> Refer our Industry leading articles. </p>
          </div>
          <div class="col-md-4">
            <div class="blogcard">
              <div class="blogimg">
                <img src="{{asset('assets/images/icon/connection_3.svg')}}" alt="blog image">
              </div>
              <div class="blogbody">
                <h2 class="blogtitle"><a href="#">The Benefits of Using a Wholesale Marketplace for Your E-commerce Business<i class="fas fa-arrow-right"></i></a></h2>
                <p class="blogDec">In today's fast-paced digital age, e-commerce has become a crucial aspect of business operations. With the rise of online wholesale marketplaces, businesses can now easily connect with suppliers and buyers worldwide, streamlining their operations and increasing their reach....</p>
                {{--<div class="blogkeyword">
                  <div class="keyword blue">
                    Leadership
                  </div>
                  <div class="keyword green">
                    Management
                  </div>
                </div>--}}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="blogcard">
              <div class="blogimg">
                <img src="{{asset('assets/images/icon/connection_3.svg')}}" alt="blog image">
              </div>
              <div class="blogbody">
                {{--<div class="blogdate">Demi Wilkinson • 1 Jan 2023</div>--}}
                <h2 class="blogtitle"><a href="#">The Importance of Product Research in Product Sourcing: A Comprehensive Guide<i class="fas fa-arrow-right"></i></a></h2>
                <p class="blogDec">Product research is a crucial step in the product sourcing process. It involves gathering data about your target audience, market trends, and competitors to ensure that you're creating a product that meets the needs of your customers....</p>
                {{--<div class="blogkeyword">
                  <div class="keyword green">
                    Product
                  </div>
                  <div class="keyword blue">
                    Research
                  </div>
                  <div class="keyword red">
                    Fromeworic
                  </div>
                </div>--}}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="blogcard">
              <div class="blogimg">
                <img src="{{asset('assets/images/icon/connection_3.svg')}}" alt="blog image">
              </div>
              <div class="blogbody">
                {{--<div class="blogdate">Candice Wu • 1 Jan 2023</div>--}}
                <h2 class="blogtitle"><a href="#">Amazon FBA Tips and Tricks: Mastering the Art of Online Selling<i class="fas fa-arrow-right"></i></a></h2>
                <p class="blogDec">Amazon FBA (Fulfillment by Amazon) is a program that allows sellers to leverage Amazon's vast customer base and logistics network to grow their online businesses. With over 12 million products listed on Amazon, it can be challenging to stand out from the competition.</p>
                {{--<div class="blogkeyword">
                  <div class="keyword blue">
                    Design
                  </div>
                  <div class="keyword green">
                    Research
                  </div>
                </div>--}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
   
  </div>
@endsection
@section('scripts')
@endsection