@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <nav class="secondaryNav">
      <div class="section_list refund">
        <a class="section_link active" href="#Introduction">Dropship/Sample</a>
        <a class="section_link" href="#privacySection1">Bulk Order</a>
        <a class="section_link" href="#privacySection2">Resell Orders</a>
        <a class="section_link" href="#privacySection3">Other Terms</a>
        <a class="section_link" href="#privacySection4">Cancellations Policy</a>
      </div>
    </nav>
    <div class="secondaryContainer refund">
      <div class="staticContent active" id="Introduction">
        <h1 class="fs-26 bold text-center mb-5">Product Return/Refund Policy & cancellations</h1>
        <h3 class="staticContent_h">Dropship/Sample</h3>
        <h6 class="fs-15">Eligibility Criteria</h6>
        <ol class="termsPolicyList">
          <li>Any product with a wholesale price greater than INR 75/- is eligible for Product Returns.</li>
          <li>Product return request must be submitted within 2 days from Order delivery date.</li>
          <li>Undelivered orders due to non availability or incorrect address will be refunded with adjusted RTO cost.</li>
          <li>Package opening video and images are mandatory for returns due to damaged product or Wrong/missing product related complaints.</li>
          <li>To be eligible for a return, your item must be unused and in original packing as received along with a receipt or proof of purchase.</li>
          <li>No Return/Refund for product samples.</li>
        </ol>
      </div>
      <div class="staticContent" id="privacySection1">
        <h3 class="staticContent_h">Bulk Order</h3>
        <h6 class="fs-15">Eligibility Criteria</h6>
        <ol class="termsPolicyList">
          <li>Product return request must be submitted within 2 days from Order delivery date.</li>
          <li>Undelivered orders due to non availability or incorrect address will be refunded with adjusted RTO cost.</li>
          <li>Package opening video and images are mandatory for returns due to damaged product, Wrong/missing product or incorrect quantity related complaints.</li>
          <li>To be eligible for a return, your item must be unused and in original packing as received along with a receipt or proof of purchase.</li>
        </ol>
      </div>
      <div class="staticContent" id="privacySection2">
        <h3 class="staticContent_h">Resell Orders</h3>
        <h6 class="fs-15">Eligibility Criteria</h6>
        <ol class="termsPolicyList">
          <li>Product return request must be submitted within 2 days from Order delivery date.</li>
          <li>Undelivered orders due to non availability or incorrect address will be refunded with adjusted RTO cost.</li>
          <li> Package opening video and images are mandatory for returns due to damaged product, Wrong/missing product or incorrect quantity related complaints.</li>
          <li>To be eligible for a return, your item must be unused and in original packing as received along with a receipt or proof of purchase.</li>
        </ol>
      </div> 
      <div class="staticContent" id="privacySection3">
        <h3 class="staticContent_h">Other Terms</h3>
        <ol class="termsPolicyList">
          <li>eKomn is committed to protect the interests of our partners however, it is advised to review a return/refund prior to submission to ensure details are correct and accurate.</li>
          <li>We will initiate a return pick-up only in case of damaged product, wrong product delivered, or any other valid reason. For cases such as "I ordered by mistake", "I no longer need this product" or etc., you will be responsible for sending the products back safely to successfully receive a refund.</li>
          <li>To be eligible for a return, your item must be unused and in original packing as received along with a receipt or proof of purchase.</li>
          <li>If reverse pickup has been arranged for defective/damaged or wrong products, after receiving the products back refund/replacement can be initiated.</li>
          <li>If Product is not working, contact us with the testing proof of the product received from us, without testing proof no return or refund claims will be entertained.</li>
          <li>For Bulk and Resell orders, If Product is in stock, we dispatch the product within 48 hours of your order otherwise we will inform you by mail about availability of the product within 2-3 days.</li>
          <li>If order is failed or cancelled and money gets deducted from your account, then your paid amount will be automatically refunded back to your card or account whichever is applicable.</li>
          <li>Shipping charges are extra that depend on weight and quantity of product and comes automatically when you purchase a product.</li>
          <li>If product is defective, damaged or broken, contact us within 2 Days of delivery otherwise no return or refund claims will be entertained.</li>
          <li>We ship through reputed courier companies including Bluedart, Fedex, Delhivery, Ecom Express, India Post, Xpress Bees and others to ensure safe and fast delivery.</li>
          <li>Delivery can take 2-5 working days for metro cities and 4-7 working days for rest of the India.</li>
          <li>Any delay caused by courier company or India post is not our responsibility.</li>
          <li>If order is prepaid and customer did not accept, receive or collect the courier or return the courier then shipping charges and return charges will be deducted from the prepaid amount and rest will be refunded back after evaluating the issue.</li>
        </ol>
        <p>
          In Defected/Damaged products BB have to create an opening box video and photographs to claim the refund.
        </p>
        <p>
          Incorrect or partially quantity delivered: BB have to create an opening video and raise a ticket on return & refund window, and supplier will refund for the rest quantities.
        </p>
        <p>
          If wrong products delivered: In that case supplier has to refund fully amount of the order to BB after investigation and BB has to return the box with original label at his own cost/shipping charge to claim the full refund.
        </p>
      </div>
      <div class="staticContent" id="privacySection4">
        <h3 class="staticContent_h">Cancellations Policy</h3>
        <ol class="termsPolicyList">
          <li>Only orders that are pending or in the middle of processing can be cancelled. Your order won't ever be cancelled if it is already shipped out. If you decide to cancel your order before the product is shipped, we will refund your payment in full amount within 10 to 15 working days. Shipping and return fees will be deducted from the prepaid amount if the customer did not accept, receive, or pick up the order after delivery or return the package to the courier. If the order fails or is canceled and the money gets deducted from your account, then your paid amount will be automatically refunded back to your card or bank account.</li>
          <li>Cancellations will not be processed for orders bought with coupon discounts. These are limited-time coupons and are solely aimed to liquify genuine inventory at cost price; therefore, cancellations will not be processed.</li>
          <li>If order is cancelled by our end for any reason, we will refund the full amount back to your account or card whichever is applicable with in 10 working days.</li>
        </ol>
      </div>
      <div class="bottom_scroll_spac"></div>
    </div>  
  </div>
@endsection
@section('scripts')
@endsection