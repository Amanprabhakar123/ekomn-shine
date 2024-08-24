@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <section class="con_1_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-5 order-md-last order-sm-first">
            <div class="sectionImage">
              <img src="{{asset('assets/images/icon/Be-a-supplier.png')}}" alt="" class="d-block">
            </div>
          </div>
          <div class="col-sm-12 col-md-1"></div>
          <div class="col-sm-12 col-md-6 order-md-first order-sm-last">
            <div class="mainsect">
              <h2 class="sec_h2">Expand your Sales & Reach to PAN India Business Buyers</h2>
              <p class="subtitle">
                Leverage eKomn platform to make your products visible to more than 20,000 verified business buyers for recurring and bulk orders
              </p>
              <a href="{{route('supplier.register')}}" class="btnekomn btn">Join the Marketplace</a>
              <a href="{{route('supplier.login')}}" class="btnekomn-border btn ms-2">Log In</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="con_3_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-5">
            <div class="sectionImage">
            <img src="{{asset('assets/images/icon/connection_3.svg')}}" alt="" class="d-block">
            </div>
          </div>
          <div class="col-sm-12 col-md-1"></div>
          <div class="col-sm-12 col-md-6">
            <h2 class="sec_h2">Select & Import Winning Dropshipping Products for Your Amazon Store and other channels</h2>
            <p class="subtitle">
              eKomn is a tech enabled B2B platform that helps you connect to your
              Amazon store and manage Orders automatically. We constantly update
              our product database, finding trending and profitable items to sell through
              Amazon dropshipping has never been that straightforward!
            </p>
            <button class="btnekomn btn">Connect my Store Now</button>
          </div>
        </div>
      </div>
    </section>
    <section class="con_1_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="sec_h1 text-center">Benefits of becoming a supplier with <span class="a_color">eKomn</span></h1>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <div class="supbenifitIco sup_bg_1"><i class="fas fa-chart-line"></i></div>
              <h3 class="fs-20 bold text-center">Reach to more than 20,000 online sellers in India actively looking for products</h3>
              <p class="mb20 opacity-75 fs-16">eKomn has partnered with Marketplace sellers, Social sellers and Multi channel sellers in India for their product sourcing needs.</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <div class="supbenifitIco sup_bg_2"><i class="fas fa-compress-arrows-alt"></i></div>
              <h3 class="fs-20 bold text-center">Super charge your sales growth with seamlessly integrated selling programs</h3>
              <p class="mb20 opacity-75 fs-16">
                With eKomn, now manage your incoming orders in various categories like Dropship, Bulk Sell and Resell. Register and list your products and let us help you grow your sales</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <div class="supbenifitIco sup_bg_3"><i class="fas fa-bezier-curve"></i></div>
              <h3 class="fs-20 bold text-center">Get access to our pioneering Sourcing Lead program</h3>
              <p class="mb20 opacity-75 fs-16">
                Get assured buying leads directly in your inbox. Just accept the lead, dispatch goods and collect your payment</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-md-center">
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <div class="supbenifitIco sup_bg_4"><i class="fas fa-truck"></i></div>
              <h3 class="fs-20 bold text-center">Set your quantity based bulk rates for each product and get bulk orders on auto mode</h3>
              <p class="mb20 opacity-75 fs-16">Sell with super speed. No more negotiations and repeated calls. Set competitive wholesale quantity based rates and sell whole heartedly!!</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <div class="supbenifitIco sup_bg_5"><i class="fas fa-handshake"></i></div>
              <h3 class="fs-20 bold text-center">Excellent support!! Catalog creation to Order management to Daily operations</h3>
              <p class="mb20 opacity-75 fs-16">
                From Catalog upload to order management and trainings, we will guide you at every step to grow your
                business</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="process_sec" style="background-color: #FFF8E9;">
      <h1 class="sec_h1 text-center">Supplier’s Testimonials</h1>
      <p class="subtitle mx-800 text-center m-auto">
        We give wings to your eCommerce enterprise! With 10K+ products across top categories, our clients' businesses soar.</p>
      <div class="row justify-content-md-center mt40">
        <div class="col-sm-12 col-md-10">      
          <div class="testimonial_owl owl-carousel owl-theme">
            <div class="item">
              <div class="testimonalBlock">
                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                <div class="clientWords"  title=" Partnering with eKomn has opened up new avenues for our business. Their platform has connected us with a wide range of reliable buyers, helping us grow our customer base significantly. The product listing service is seamless, and their support team has always been there to assist whenever needed. We're thrilled with the results!">
                  <div class="clientimg">
                    <img src="{{asset('assets/images/web/Rajesh-Kumar.png')}}" alt="" />
                  </div>
                  <div class="authorName">
                    <h4>Rajesh Kumar</h4>
                    <span>Founder & CEO Of SuperiorCraft Pvt. Ltd.</span>
                  </div>
                  <div class="authorContent">
                    <span class="quote-left fas fa-quote-left me-2"></span>
                    <span class="authorContentPara">
                    Partnering with eKomn has opened up new avenues for our business. Their platform has connected us with a wide range of reliable buyers, helping us grow our customer base significantly. The product listing service is seamless, and their support team has always been there to assist whenever needed. We're thrilled with the results!
                    </span>
                    <span class="quote-left fas fa-quote-right ms-2"></span>
                  </div>
                </div>
              </div>              
            </div>
            <div class="item">
              <div class="testimonalBlock">
                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                <div class="clientWords" title="Thanks to eKomn, our products are now reaching a broader audience pan India. The platform's user-friendly interface and extensive buyer network have significantly boosted our sales. Their product returns management service has also been a game-changer, reducing our operational headaches.">
                  <div class="clientimg">
                    <img src="{{asset('assets/images/web/Arun-Sharma.png')}}" alt="" />
                  </div>
                  <div class="authorName">
                    <h4>Arun Sharma</h4>
                    <span>Head of Sales of PureTech Solutions</span>
                  </div>
                  <div class="authorContent">
                    <span class="quote-left fas fa-quote-left me-2"></span>
                    <span class="authorContentPara">
                    Thanks to eKomn, our products are now reaching a broader audience pan India. The platform's user-friendly interface and extensive buyer network have significantly boosted our sales. Their product returns management service has also been a game-changer, reducing our operational headaches.
                    </span>
                    <span class="quote-left fas fa-quote-right ms-2"></span>
                  </div>
                </div>
              </div>              
            </div>
            <div class="item">
              <div class="testimonalBlock">
                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                <div class="clientWords" title="We’ve been highly impressed with the results from using eKomn. Their product marketing services have significantly increased our visibility among potential buyers, and their review management system has helped maintain our strong reputation. It’s been a win-win partnership for us.">
                  <div class="clientimg">
                    <img src="{{asset('assets/images/web/Manoj-Desai.png')}}" alt="" />
                  </div>
                  <div class="authorName">
                    <h4>Manoj Desai</h4>
                    <span>Ops Head of InnovativeTech Industries</span>
                  </div>
                  <div class="authorContent">
                    <span class="quote-left fas fa-quote-left me-2"></span>
                    <span class="authorContentPara">
                    We’ve been highly impressed with the results from using eKomn. Their product marketing services have significantly increased our visibility among potential buyers, and their review management system has helped maintain our strong reputation. It’s been a win-win partnership for us.
                    </span>
                    <span class="quote-left fas fa-quote-right ms-2"></span>
                  </div>
                </div>
              </div>              
            </div>
            <div class="item">
              <div class="testimonalBlock">
                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                <div class="clientWords" title="Working with eKomn has been a fantastic experience. The platform’s extensive network of buyers has led to a noticeable increase in our sales. Their online consulting services have also provided us with valuable advice on how to better position our products on the platform. We’re excited to continue this partnership!">
                  <div class="clientimg">
                    <img src="{{asset('assets/images/web/Anjali-Gupta.png')}}" alt="" />
                  </div>
                  <div class="authorName">
                    <h4>Anjali Gupta</h4>
                    <span>Sales Manager of NatureBest Organics</span>
                  </div>
                  <div class="authorContent">
                    <span class="quote-left fas fa-quote-left me-2"></span>
                    <span class="authorContentPara">
                    Working with eKomn has been a fantastic experience. The platform’s extensive network of buyers has led to a noticeable increase in our sales. Their online consulting services have also provided us with valuable advice on how to better position our products on the platform. We’re excited to continue this partnership!
                    </span>
                    <span class="quote-left fas fa-quote-right ms-2"></span>
                  </div>
                </div>
              </div>              
            </div>
            <div class="item">
              <div class="testimonalBlock">
                <h3 class="unitext">𝓞𝓾𝓻 𝓒𝓵𝓲𝓮𝓷𝓽 𝓢𝓪𝔂𝓼</h3>
                <div class="clientWords" title="Since joining eKomn, we’ve seen a significant uptick in orders. The product listing process is straightforward, and the platform's reach among India buyers is impressive. Their payment cycle is shortest which is crucial in our industry and payment statements are super simple to review and understand. Pure delight!!">
                  <div class="clientimg">
                    <img src="{{asset('assets/images/web/Vikram-Singh.png')}}" alt="" />
                  </div>
                  <div class="authorName">
                    <h4>Vikram Singh</h4>
                    <span>Owner of TechVision Electronics</span>
                  </div>
                  <div class="authorContent">
                    <span class="quote-left fas fa-quote-left me-2"></span>
                    <span class="authorContentPara">
                    Since joining eKomn, we’ve seen a significant uptick in orders. The product listing process is straightforward, and the platform's reach among India buyers is impressive. Their payment cycle is shortest which is crucial in our industry and payment statements are super simple to review and understand. Pure delight!!
                    </span>
                    <span class="quote-left fas fa-quote-right ms-2"></span>
                  </div>
                </div>
              </div>              
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="faq-section">
      <div class="container">
        <h2 class="faq-title bold">Frequently Asked Questions</h2>
        <div class="row">
          <div class="col-lg-6 col-sm-12">
            <div class="faqImg">
              <img src="{{asset('assets/images/icon/faq.png')}}" alt="faq image">
            </div>
          </div>
          <div class="col-lg-6 col-sm-12">
            <div class="faq-item active">
              <div class="faq-question">Are there any charges for selling on eKomn platform?</div>
              <div class="faq-answer">There are no charges at all to list and sell products on eKomn. As a supplier, you must make sure you dispatch good quality products on time.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">Are there any eligibility criterias to become a supplier on eKomn?</div>
              <div class="faq-answer">Yes, you must be a registered business entity with GSTN from any state in India. Apart from GSTN, you must be an active supplier in any product category.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">Are there any restricted category of goods that can not be sold in eKomn platform?</div>
              <div class="faq-answer">Except for Food & Grocery and Industrial goods, a supplier can be registered in any other consumer product category</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">How much business i can expect through eKomn platform?</div>
              <div class="faq-answer">It would be unfair to put any limits here. We are committed to engage and support over 1 mn buyers enterprises in India by 2027. A large part of this business will go to our Suppliers with a consistent and good track record.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">How much time does it take to get registered on eKomn</div>
              <div class="faq-answer">Not much. Most of our Suppliers are on-boarded within 24 hours. Few mandatory documents (GST/PAN, Bank details, Shipping address) and a good quality product catalog is all you need to initiate your registration.</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    var owl = $('.testimonial_owl.owl-carousel');
    owl.owlCarousel({
        items: 3,
        center: true,
        loop: true,
        margin: 0,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplayHoverPause: true,
        smartSpeed: 600,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
});
</script>
@endsection