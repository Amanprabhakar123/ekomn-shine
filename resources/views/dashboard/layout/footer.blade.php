<script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/ek.common.js')}}"></script>
    @yield('scripts')
<script>
    $(document).ready(function() {
        if ($('.dashboard-header').length > 0) {
            $('.dashboard-header ul').prepend('<li><a class="dropdown-item" href="{{ url('/') }}">Go To Website</a></li>');
        }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function exportMisReport(type) {
        // Make an API request to export the MIS report in CSV format based on the provided type
        ApiRequest(`mis-export-csv/${type}`, 'GET')
            .then(response => {
                // Check if the response status code indicates success
                if (response.data.statusCode == 200) {
                    // Display a success message using SweetAlert2
                    Swal.fire({
                        title: "Good job!", // Title of the alert
                        text: response.data.message, // Message text from the response
                        icon: "success", // Icon indicating success
                        didOpen: () => {
                            // Apply custom styles to the SweetAlert2 elements when it opens
                            const title = Swal.getTitle(); // Get the title element of the alert
                            title.style.color = 'red'; // Set the title color to red
                            title.style.fontSize = '20px'; // Set the title font size to 20px

                            const content = Swal
                                .getHtmlContainer(); // Get the HTML container of the alert content
                            // Optionally, you could style the content here

                            const confirmButton = Swal
                                .getConfirmButton(); // Get the confirm button of the alert
                            confirmButton.style.backgroundColor =
                                '#feca40'; // Set the button background color
                            confirmButton.style.color = 'white'; // Set the button text color to white
                        }
                    }).then(() => {
                        // Redirect to the inventory page after the alert is closed
                        window.location.href = "{{ route('mis.setting.inventory') }}";
                    });
                }
            })
            .catch(error => {
                // Log any errors encountered during the API request
                console.error('Error updating stock:', error);
            });
    }
</script>
<script>
    document.getElementById('newshine-link').addEventListener('click', async function(event) {
        event.preventDefault(); // Prevent the default link behavior
    
        const { value: accept } = await Swal.fire({
            title: "Must Read...!",
            html: `
                <div>
                    <h4 style="margin: 0;"><b>eKomn Shine - Usage guidelines and Terms<b></h4>
                    <p class="pt-3">eKomn shine is a product feedback/review program that you can use to get professional reviews for your product and showcase them on selected platforms. It is a voluntary program primarily designed to assist online sellers to support each other as a community. The objective is to create better opportunities to grow their online selling business across various platforms. We urge you to review below guidelines and terms before you start using this module.</p>
                    <ul>
                        <li>Term 1: Shine is a product review module and you are requested to participate mutually and reciprocate for every product feedback request that you raise for your products.</li>
                        <li>Term 2: You are not required to make any payment for this service. For each request raised, an equal value request shall be assigned to you that you must complete.</li>
                        <li>Term 3: Your product review request shall be processed only when you complete your own assigned requests.</li>
                        <li>Term 4: Each assigned Shine request must be processed within <b>48</b> hours else your own request will be disqualified and you will be asked to reinitiate it again.</li>
                        <li>Term 5: For beginners, the product value of each Shine request is restricted between <b>200 to 500</b>. As you use the service, you will auto qualify for higher value product orders.</li>
                        <li>Term 6: Usually, a Shine product review takes <b>15-20</b> days before a product review is visible on the selected platform. You are advised to regularly visit Shine module and take action on all notifications related to your Own as well as Assigned requests.</li>
                        <li>Term 7: You are advised to opt for products that you dispatch from your own store and not done through a platform warehouse. This will help you manage the shipment of actual products for each Shine request optimally.</li>
                    </ul>
                    <p>Please read the Guidelines and Terms carefully before proceeding.</p>
                </div>
            `,
            input: "checkbox",
            inputValue: 0,
            inputPlaceholder: "I agree with the Guidelines and Terms",
            confirmButtonText: "I Agree !  &nbsp;<i class='fa fa-arrow-right'></i>",
            inputValidator: (result) => {
                return !result && "You need to agree with Guidelines and Terms";
            },
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Close",
            customClass: {
                title: 'swal2-title-red', 
                confirmButton: 'swal2-confirm-btn',
                cancelButton: 'swal2-cancel-btn'
            },
            didOpen: () => {
                const title = Swal.getTitle();
                title.style.fontSize = '25px';
                const confirmButton = Swal.getConfirmButton();
                confirmButton.style.backgroundColor = '#FFB20C';
                confirmButton.style.color = 'white';
            }
        });
        
        if (accept) {
          Swal.fire({
            title: "Thanks for reading the shine guidelines. We wish you great business growth !!",
            icon: "success",
            confirmButtonColor: "#FFB20C", // Directly sets the button color
          }).then(() => {
            // Redirect to the new page
            window.location.href = "{{ route('new-shine') }}";
          });
        }
    });
    </script>
  </body>
</html>