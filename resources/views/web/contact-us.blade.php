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
                  <a href="mailto:info@ekomn.com">info@ekomn.com</a>
                </div>
                <div class="infoCenter">
                  <i class="fas fa-map-marker-alt icon"></i>
                  <h4 class="fs-16 bold">Office Address</h4>
                  <p>Ocus Quantum, Ocus Quantum Internal Rd,<br> Sector 51, Gurugram, Samaspur,<br> Haryana 122003</p>
                </div>
                <div class="infoCenter">
                  <i class="fas fa-phone-alt icon"></i>
                  <h4 class="fs-16 bold">Call Us</h4>
                  <a href="tel:++919810164845">+91 9810164845</a>
                </div>
                {{--<div class="socialLinks bigSize">
                  <a href=""><i class="fab fa-youtube"></i></a>
                  <a href=""><i class="fab fa-linkedin-in"></i></a>
                  <a href=""><i class="fab fa-pinterest-p"></i></a>
                  <a href=""><i class="fab fa-whatsapp"></i></a>
                  <a href=""><i class="fab fa-facebook-f"></i></a>
                  <a href=""><i class="fab fa-twitter"></i></a>
                </div>--}}
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-7">
            <div class="contactForm">
              <h2>Get in Touch</h2>
              
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" id="firstname" class="form-control" placeholder="*First Name">
                      <div id="firstnameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" id="lastname" class="form-control" placeholder="Last Name">
                      <div id="lastnameErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" id="email" class="form-control" placeholder="*Email Address">
                      <div id="emailErr" class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" id="contact" class="form-control" placeholder="*Contact Number">
                      <div id="contactErr" class="invalid-feedback"></div>
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
                        <div id="queryErr" class="text-danger"></div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                  <label class="fs-16 bold">Message</label>
                  <textarea class="form-control resizer_none" id="message" rows="4" placeholder="Type your message"></textarea>
                  <div id="messageErr" class="invalid-feedback"></div>
                </div>
                <div class="d-flex justify-content-end">
                  <button type="" id="btnSubmit" class="btn btnekomn btnround py-2 px-4">Send Message</button>
                </div>
              
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
            <div class="faq-item">
              <div class="faq-question">What is your return policy?</div>
              <div class="faq-answer">A return has to be reported back within 48 hours from delivery with all necessary details. Please refer to our <a href="{{route('return.policy')}}">Return & Refund Policy</a> page</div>
            </div>
            <div class="faq-item">
              <div class="faq-question">Do you offer international shipping?</div>
              <div class="faq-answer">At the moment we do not support International shipping however, our international buyers can still use our platform. Please submit your interest through contact us form and we shall get back earliest.</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    const mobileRegex = /^[6-9]\d{9}$/;
    $('#btnSubmit').click(function(){
      var formData = new FormData();
      var isValid = true;
      var firstname = $('#firstname').val();
      var lastname = $('#lastname').val();
      var email = $('#email').val();
      var contact = $('#contact').val();
      var message = $('#message').val();
      var query = $('input[name="query"]:checked').val();

      if(firstname == ''){
        $('#firstname').addClass('is-invalid');
        $('#firstnameErr').text('First Name is required');
        isValid = false;
      }else{
        $('#firstname').removeClass('is-invalid');
        $('#firstnameErr').text('');
      }

      if(lastname == ''){
        $('#lastname').addClass('is-invalid');
        $('#lastnameErr').text('Last Name is required');
        isValid = false;
      }else{
        $('#lastname').removeClass('is-invalid');
        $('#lastnameErr').text('');
      }

      if(email == ''){
        $('#email').addClass('is-invalid');
        $('#emailErr').text('Email is required');
        isValid = false;
      }else{
        $('#email').removeClass('is-invalid');
        $('#emailErr').text('');
      }

      if(contact == ''){
        $('#contact').addClass('is-invalid');
        $('#contactErr').text('Contact Number is required');
        isValid = false;
      }else if(contact.length < 10){
        $('#contact').addClass('is-invalid');
        $('#contactErr').text('Contact Number must be 10 digits');
        isValid = false;
      }else if(!mobileRegex.test(contact)){
        $('#contact').addClass('is-invalid');
        $('#contactErr').text('Invalid Contact Number');
        isValid = false;
      }else{
        $('#contact').removeClass('is-invalid');
        $('#contactErr').text('');
      }

      if(query == undefined){
        $('#queryErr').text('Please select a subject');
        isValid = false;
      }else{
        $('#queryErr').text('');
      }
      if(message == ''){
        $('#message').addClass('is-invalid');
        $('#messageErr').text('Message is required');
        isValid = false;
      }else if(message.length < 10){
        $('#message').addClass('is-invalid');
        $('#messageErr').text('Message must be at least 10 characters');
        isValid = false;
      }else{
        $('#message').removeClass('is-invalid');
        $('#messageErr').text('');
      }



      formData.append('first_name', firstname);
      formData.append('last_name', lastname);
      formData.append('email', email);
      formData.append('phone', contact);
      formData.append('subject', query);
      formData.append('message', message);

      if(isValid){
        ApiRequest('contact-us-post', 'POST', formData)
        .then(response => {
          if (response.data.statusCode == 200) {
              Swal.fire({
                  title: "Success!",
                  text: response.data.message,
                  icon: "success",
                  didOpen: () => {
                      const titleElement = Swal.getTitle();
                      titleElement.style.color = 'green';
                      titleElement.style.fontSize = '20px';

                      const confirmButton = Swal.getConfirmButton();
                      confirmButton.style.backgroundColor = '#feca40';
                      confirmButton.style.color = 'white';
                  }
              }).then(function() {
                  window.location.reload();
              });
          } else {
              Swal.fire({
                  title: "Error!",
                  text: response.data.message,
                  icon: "error",
                  didOpen: () => {
                      const titleElement = Swal.getTitle();
                      titleElement.style.color = 'red';
                      titleElement.style.fontSize = '20px';

                      const confirmButton = Swal.getConfirmButton();
                      confirmButton.style.backgroundColor = '#feca40';
                      confirmButton.style.color = 'white';
                  }
              });
          }
        })
      }
    })
  });
</script>
@endsection