@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <section class="con_1_sec">
      <div class="container">
        <div class="row">
          <div class="col text-center">
            <h1 class="sec_h1">Connect Your Amazon Store<br>and put your business growth on auto mode</h1>
            <p class="subtitle">Leverage eKomn platform to source and Launch new products on your Amazon store in quick time</p>
            <a href="{{route('buyer.login')}}" class="btnekomn btn my-1">Connect my Store Now</a>
            <img src="{{asset('assets/images/icon/connection_1.svg')}}" alt="" class="heroimage">
          </div>
        </div>
      </div>
    </section>
    <section class="con_2_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-5 order-md-last order-sm-first">
            <div class="sectionImage">
              <img src="{{asset('assets/images/icon/connection_2.svg')}}" alt="" class="d-block">
            </div>
          </div>
          <div class="col-sm-12 col-md-1"></div>
          <div class="col-sm-12 col-md-6 order-md-first order-sm-last">
            <h2 class="sec_h2">Access to reliable Product Suppliers to sell on Amazon</h2>
            <p class="subtitle">
              eKomn houses thousands of verified wholesale product suppliers based in India. This gives you access to thousands of winning products to dropship on Amazon and do Bulk buy covering a wide range of categories, with fast shipping and real-time tracking. We want you to focus on your business growth and let us manage your Product Sourcing and Logistics. You sell, and we will take care of the rest!
            </p>
            <a href="{{route('buyer.login')}}" class="btnekomn btn">Connect my Store Now</a>
          </div>
        </div>
      </div>
    </section>
    <section class="con_1_sec">
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
            <a href="{{route('buyer.login')}}"class="btnekomn btn">Connect my Store Now</a>
          </div>
        </div>
      </div>
    </section>
    <section class="con_3_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="sec_h1 text-center">Benefits of Amazon Integration with eKomn</h1>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <img src="{{asset('assets/images/icon/connection_benefits_1.svg')}}" alt="" class="benifitIco">
              <h3 class="fs-20 bold text-center">Sales Order Management</h3>
              <p class="mb20 opacity-75 fs-16">Our seamlessly connected sales order management automates complete order processing with integrated workflow. Efficiently track your orders from Dispatch to Delivery.</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <img src="{{asset('assets/images/icon/connection_benefits_2.svg')}}" alt="" class="benifitIco">
              <h3 class="fs-20 bold text-center">Faster Shipments</h3>
              <p class="mb20 opacity-75 fs-16">No manual interventions. All you have to do is verify order details and confirm on eKomn platform. Rest will be managed by eKomn and our network of verified suppliers.</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="benifitBox">
              <img src="{{asset('assets/images/icon/connection_benefits_3.svg')}}" alt="" class="benifitIco">
              <h3 class="fs-20 bold text-center">Product Stock management</h3>
              <p class="mb20 opacity-75 fs-16">No manual daily checks on product stocks. Once your Amazon Store is connected, product stocks will be updated automatically</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="con_1_sec">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="main-service">Other Services</div>
            <div class="services">
              <div class="service-item">
                <div class="service-item-hed">
                  Inventory Management 
                </div>
                <div class="service-item-body">
                  <img src="{{asset('assets/images/icon/other_serv_1.svg')}}" alt="">
                  <p class="light-text mt20 text-center mb0">Have the right stock, at the right levels, in the right place, at the right time, and at the right cost
                  </p>
                </div>
              </div>
              <div class="service-item">
                <div class="service-item-hed">Sales Order Management</div>
                <div class="service-item-body">
                  <img src="{{asset('assets/images/icon/other_serv_2.svg')}}" alt="">
                  <p class="light-text mt20 text-center mb0">A comprehensive sales order management automates complete order processing with integrated work flow.</p>
                </div>
              </div>
              <div class="service-item">
                <div class="service-item-hed">Procurement & FBA Shipments</div>
                <div class="service-item-body">
                  <img src="{{asset('assets/images/icon/other_serv_3.svg')}}" alt="">
                  <p class="light-text mt20 text-center mb0">Raise the bar of your workflow; issue purchase orders, automatically create shipments to Amazon and do a lot more in easy one-two-three clicks.</p>
                </div>
              </div>
              <div class="service-item">
                <div class="service-item-hed">Returns and Claims</div>
                <div class="service-item-body">
                  <img src="{{asset('assets/images/icon/other_serv_4.svg')}}" alt="">
                  <p class="light-text mt20 text-center mb0">Effective inventory control gives a positive impact on the returns process and will help organizations to better manage this area of the customer experience.</p>
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
              <div class="faq-question">I am not a technical person, Can I integrate my Amazon India store on my own?</div>
              <div class="faq-answer">Yes. We have taken care of all technical aspects. Any user with basic understanding of computers can set up the Amazon integration with the help of our step-by-step instructions.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">Is it necessary for me to connect my Amazon Store with my eKomn panel?</div>
              <div class="faq-answer">It is your choice. The integration will help you eliminate manual efforts to manage your daily orders and stock inventory that can be very effort intensive. A user can alway deactivate integration as per their needs.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">Are there any Integration charges that a user must pay?</div>
              <div class="faq-answer">The access to Integration feature is plan based. Please check our Subscription plans.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">Can I also set pricing options for selected products through my eKomn panel to my Amazon store?</div>
              <div class="faq-answer">The product pricing is subject to platform specific guidelines. Moreover, eKomn will provide you with wholesale product rates and users are free to mark selling rates or MRP rates for selected products.</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
@endsection