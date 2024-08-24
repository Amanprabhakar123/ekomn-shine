@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <section class="con_1_sec">
      <div class="container">
        <div class="row">
          <div class="col text-center">
            <h1 class="sec_h1 mt-0">About Us</h1>
            <p class="subtitle m-auto mx-800">Leverage eKomn platform to make your products visible to more than 20,000 verified business
              buyers for recurring and bulk orders</p>
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
            <h1 class="sec_h1 mt-0">All blog posts</h1>
          </div>
          <div class="col-md-4">
            <div class="blogcard">
              <div class="blogimg">
                <img src="{{asset('assets/images/icon/connection_3.svg')}}" alt="blog image">
              </div>
              <div class="blogbody">
                <div class="blogdate">Alec Whitten • 1 Jan 2023</div>
                <h2 class="blogtitle"><a href="">Bill Walsh leadership lessons<i class="fas fa-arrow-right"></i></a></h2>
                <p class="blogDec">Like to know the secrets of transforming a 2-14 team into a 3x Super
                  Bowl winning Dynasty?</p>
                <div class="blogkeyword">
                  <div class="keyword blue">
                    Leadership
                  </div>
                  <div class="keyword green">
                    Management
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="blogcard">
              <div class="blogimg">
                <img src="{{asset('assets/images/icon/connection_3.svg')}}" alt="blog image">
              </div>
              <div class="blogbody">
                <div class="blogdate">Demi Wilkinson • 1 Jan 2023</div>
                <h2 class="blogtitle"><a href="">PM mental models<i class="fas fa-arrow-right"></i></a></h2>
                <p class="blogDec">Mental models are simple expressions of complex processes or
                  relationshios.</p>
                <div class="blogkeyword">
                  <div class="keyword green">
                    Product
                  </div>
                  <div class="keyword blue">
                    Research
                  </div>
                  <div class="keyword red">
                    Fromeworic
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="blogcard">
              <div class="blogimg">
                <img src="{{asset('assets/images/icon/connection_3.svg')}}" alt="blog image">
              </div>
              <div class="blogbody">
                <div class="blogdate">Candice Wu • 1 Jan 2023</div>
                <h2 class="blogtitle"><a href="">What is Wireframing?<i class="fas fa-arrow-right"></i></a></h2>
                <p class="blogDec">Introduction to Wireframing and its Principles. Learn from the best in
                  the industry.</p>
                <div class="blogkeyword">
                  <div class="keyword blue">
                    Design
                  </div>
                  <div class="keyword green">
                    Research
                  </div>
                </div>
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