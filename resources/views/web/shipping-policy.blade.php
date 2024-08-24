@extends('web.layout.app')
@section('content')
<div class="ekcontent">
    <nav class="secondaryNav">
        <div class="section_list refund">
            <a class="section_link active" href="#Introduction">Overview</a>
            <a class="section_link" href="#termsSection1">General Shipping Guidelines</a>
            <a class="section_link" href="#termsSection2">Shipping Policy for Dropship Orders</a>
            <a class="section_link" href="#termsSection3">Shipping Policy for Bulk Orders</a>
            <a class="section_link" href="#termsSection4">Shipping Policy for Resell Orders</a>
            <a class="section_link" href="#termsSection5">Additional Notes</a>
            <a class="section_link" href="#termsSection6">Contact Information</a>
        </div>
    </nav>
    
    <div class="secondaryContainer">
        <div class="staticContent active" id="Introduction">
            <h1 class="fs-26 bold text-center mb-5">eKomn Shipping Policy</h1>
            <h3 class="staticContent_h">OVERVIEW</h3>
            <p>
                This Shipping Policy applies to all orders placed through eKomn, a B2B eCommerce platform connecting online sellers with registered and verified suppliers in India. The policy outlines the shipping process and timelines based on three order types: Dropship, Bulk Orders, and Resell Orders.
            </p>
        </div>

        <div class="staticContent" id="termsSection1">
            <h3 class="staticContent_h">General Shipping Guidelines</h3>
            <ul class="termsPolicyList">
                <li><span class="fw-bold">Order Fulfillment:</span> All products on eKomn are supplied by registered and verified suppliers. The shipping process starts once the supplier confirms the availability and readiness of the goods for dispatch.</li>
                <li><span class="fw-bold">Shipping Partners:</span> We collaborate with reputable shipping and logistics companies to ensure timely delivery across India.</li>
                <li><span class="fw-bold">Tracking Information:</span> Once the order is shipped, you will receive an email with the tracking details. You can track your order status through the eKomn platform or directly via the shipping partner’s website.</li>
            </ul>
        </div>

        <div class="staticContent" id="termsSection2">
            <h3 class="staticContent_h">Shipping Policy for Dropship Orders</h3>
            <ul class="termsPolicyList">
                <li><span class="fw-bold">Processing Time:</span>
                    <ul>
                        <li>Orders will be processed within 24-48 hours after payment confirmation.</li>
                        <li>The supplier is responsible for packing and preparing the product for shipment.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Shipping Timeline:</span>
                    <ul>
                        <li>Delivery Timelines, Metro cities: 4-6 business days within India.</li>
                        <li>Delivery Timelines, Non-Metro cities: 4-8 business days within India.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Shipping Charges:</span>
                    <ul>
                        <li>The cost of shipping will be calculated based on the weight, dimensions, and destination of the order.</li>
                        <li>Shipping charges are added at the time of order processing. User can review product shipping charges on the product page.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Shipping Confirmation:</span> Online Sellers will be notified once the product is shipped. Tracking details can be accessed on the eKomn platform.</li>
                <li><span class="fw-bold">Returns and Refunds:</span> For Return and refunds, please refer to eKomn's Return & Refund policy.</li>
            </ul>
        </div>

        <div class="staticContent" id="termsSection3">
            <h3 class="staticContent_h">Shipping Policy for Bulk Orders</h3>
            <ul class="termsPolicyList">
                <li><span class="fw-bold">Processing Time:</span>
                    <ul>
                        <li>Processing time may vary depending on the order size and product availability.</li>
                        <li>Typically, bulk orders are processed within 3-7 business days.</li>
                        <li>Suppliers will confirm the availability and estimated dispatch time once the order is placed.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Shipping Timeline:</span>
                    <ul>
                        <li>Delivery Timelines, Metro cities: 4-6 business days within India.</li>
                        <li>Delivery Timelines, Non-Metro cities: 4-8 business days within India.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Shipping Charges:</span> Shipping costs for bulk orders are based on the order volume, weight, and destination.</li>
                <li><span class="fw-bold">Delivery and Inspection:</span>
                    <ul>
                        <li>Upon delivery, the buyer is responsible for inspecting the goods.</li>
                        <li>Any discrepancies or damages should be reported immediately to eKomn.</li>
                        <li>The delivery receipt must be signed by the buyer or an authorized representative at the time of delivery.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Returns and Exchanges:</span>
                    <ul>
                        <li>Bulk orders are generally non-returnable unless there is a defect or discrepancy in the delivered goods.</li>
                        <li>Any issues with the order must be reported within 48 hours of delivery for a return or exchange to be considered.</li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="staticContent" id="termsSection4">
            <h3 class="staticContent_h">Shipping Policy for Resell Orders</h3>
            <ul class="termsPolicyList">
                <li><span class="fw-bold">Processing Time:</span>
                    <ul>
                        <li>Orders are processed within 3-5 business days after payment confirmation and finalization of any customization requirements.</li>
                        <li>The supplier will handle any requested branding or packaging modifications.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Shipping Timeline:</span>
                    <ul>
                        <li>Delivery Timelines, Metro cities: 4-6 business days within India.</li>
                        <li>Delivery Timelines, Non-Metro cities: 4-8 business days within India.</li>
                    </ul>
                </li>
                <li><span class="fw-bold">Shipping Charges:</span> Shipping costs are calculated based on order specifics, including customization, volume, and destination. Any additional charges for custom packaging or branding will be included in the final shipping cost.</li>
                <li><span class="fw-bold">Shipping Confirmation:</span> Online Sellers will be notified once the product is shipped. Tracking details can be accessed on the eKomn platform.</li>
                <li><span class="fw-bold">Returns and Exchanges:</span>
                    <ul>
                        <li>Due to the customized nature of resell orders, returns and exchanges are generally not accepted unless there is a defect in the goods.</li>
                        <li>Any issues with the order must be reported within 24 hours of delivery.</li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="staticContent" id="termsSection5">
            <h3 class="staticContent_h">Additional Notes</h3>
            <ul class="termsPolicyList">
                <li><span class="fw-bold">Delivery Delays:</span> While we aim to ensure timely deliveries, unforeseen circumstances such as weather conditions, logistical challenges, or transportation strikes may cause delays. eKomn will notify you promptly of any significant delays.</li>
                <li><span class="fw-bold">Customs and other Taxes:</span> For orders crossing state borders, any applicable taxes, duties, or other charges are the buyer's responsibility.</li>
            </ul>
        </div>

        <div class="staticContent" id="termsSection6">
            <h3 class="staticContent_h">Contact Information</h3>
            <p>
                For any questions or concerns regarding your shipment, please contact us through our customer support section.<br>
                Support Hours: [Mon-Sat - 10:00 AM to 07:00 PM]
            </p>
            <p>This Shipping Policy is subject to change. Please review it periodically for any updates.</p>
        </div>
        <div class="bottom_scroll_spac"></div>
    </div>  
</div>
@endsection

@section('scripts')
@endsection
