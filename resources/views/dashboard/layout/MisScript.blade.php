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
