@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <section class="contact-section">
      <div class="container contContainer p-0">
        <div class="row g-0">
          <div class="col-sm-12 col-lg-5">
            <div class="contImg">
              <div class="ekContactInfo">
                <h3>Contact Information</h3>
                <div class="infoCenter">
                  <i class="far fa-envelope-open icon"></i>
                  <h4 class="fs-16 bold">Mail Address</h4>
                  <a href="mailto:example@example.com">example@example.com</a>
                </div>
                <div class="infoCenter">
                  <i class="fas fa-map-marker-alt icon"></i>
                  <h4 class="fs-16 bold">Office Address</h4>
                  <p>Ocus Quantum, Ocus Quantum Internal Rd,<br> Sector 51, Gurugram, Samaspur,<br> Haryana 122003</p>
                </div>
                <div class="infoCenter">
                  <i class="fas fa-phone-alt icon"></i>
                  <h4 class="fs-16 bold">Call Us</h4>
                  <a href="tel:+917827821676">+91 7827821676</a>
                </div>
                <div class="socialLinks bigSize">
                  <a href=""><i class="fab fa-youtube"></i></a>
                  <a href=""><i class="fab fa-linkedin-in"></i></a>
                  <a href=""><i class="fab fa-pinterest-p"></i></a>
                  <a href=""><i class="fab fa-whatsapp"></i></a>
                  <a href=""><i class="fab fa-facebook-f"></i></a>
                  <a href=""><i class="fab fa-twitter"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-7">
            <div class="contactForm">
              <h2>Get in Touch</h2>
              <form>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="*First Name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="*Email Address">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="*Contact Number">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <h4 class="fs-16 bold mb-1">Select subject?</h4>
                  <ul class="categoryList listnone">
                    <li>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="query" id="query1" />
                        <label class="form-check-label" for="query1">
                          General Inquiry
                        </label>
                      </div>
                    </li>
                    <li>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="query" id="query2" />
                        <label class="form-check-label" for="query2">
                          Product Support
                        </label>
                      </div>
                    </li>
                    <li>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="query" id="query3" />
                        <label class="form-check-label" for="query3">
                          Billing Issue
                        </label>
                      </div>
                    </li>
                    <li>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="query" id="query4" />
                        <label class="form-check-label" for="query4">
                          Partnership
                        </label>
                      </div>
                    </li>
                    <li>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="query" id="query5" />
                        <label class="form-check-label" for="query5">
                          Other
                        </label>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                  <label class="fs-16 bold">Message</label>
                  <textarea class="form-control resizer_none" rows="4" placeholder="Type your message"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btnekomn btnround py-2 px-4">Send Message</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="conover"></div>
    </section>
    <section class="faq-section">
      <div class="container">
        <h2 class="faq-title">Frequently Asked Questions</h2>
        <div class="row">
          <div class="col-lg-6 col-sm-12">
            <div class="faqImg">
              <img src="{{asset('assets/images/icon/faq.png')}}" alt="faq image">
            </div>
          </div>
          <div class="col-lg-6 col-sm-12">
            <div class="faq-item active">
              <div class="faq-question">What products do you offer?</div>
              <div class="faq-answer">We offer a wide range of products including electronics, home goods, fashion items, and more. You can browse our full catalog on our website.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">How can I track my order?</div>
              <div class="faq-answer">Once your order is shipped, you'll receive a tracking number via email. You can use this number to track your package on our website or the courier's website.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">What is your return policy?</div>
              <div class="faq-answer">We offer a 30-day return policy for most items. If you're not satisfied with your purchase, you can return it for a full refund or exchange within 30 days of delivery.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">Do you offer international shipping?</div>
              <div class="faq-answer">Yes, we offer international shipping to many countries. Shipping costs and delivery times vary depending on the destination. You can check shipping options during checkout.</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">How can I contact customer support?</div>
              <div class="faq-answer">You can contact our customer support team through email, phone, or the contact form on our website. We aim to respond to all inquiries within 24 hours.</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
@endsection