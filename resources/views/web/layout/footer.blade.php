<footer class="ekfooter">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <div class="eKomonsummary">
          <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo_b.png') }}" alt="Logo" class="footerlogo" /></a>
          <p class="m-0">
          eKomn is engaged into B2B ecommerce product sourcing and ecommerce related services to micro and small enterprises through our innovative Technology platform. With our technology led innovative features and services, we aim to empower all existing and new entrepreneurs in online ecommerce space to manage their ecommerce/online business efficiently and grow profitably. Our mission is to democratize product sourcing and online ecommerce services ushering in greater employment and wealth generation. 
          </p>
        </div>
      </div>
      <div class="col col-md-3">
        <div>
          <h4 class="footer-heading">About Us</h4>
          <ul class="eKomUsefulLink">
            <li><a href="{{route('aboutus')}}">Company Info</a></li>
            <li><a href="{{route('shipping.policy')}}">Shipping Policy</a></li>
            <li><a href="{{route('return.policy')}}">Return & Refund Policy</a></li>
          </ul>
        </div>
      </div>
      <!-- <div class="col col-md-2">
        <div>
          <h4 class="footer-heading">Useful Links</h4>
          <ul class="eKomUsefulLink">
            <li><a href="">FAQs</a></li>
            <li><a href="">Blogs</a></li>
          </ul>
        </div>
      </div> -->
      <div class="col-sm-4 col-md-3">
        <div>
          <h4 class="footer-heading">Support</h4>
          <ul class="eKomUsefulLink">
            <li><a href="{{route('contactus')}}">Contact Us</a></li>
            <!-- <li><a href="">Help Center</a></li> -->
          </ul>
        </div>
      </div>
      <div class="col-sm-12 col-md-12">
        <div class="copyright_section">
          <div class="copyrightText">
            &copy; 2024 ekomn.com, All Rights Reserved. <a href="{{route('terms.and.conditions')}}" target="_blank">Terms of Use</a> and <a href="{{route('privacy.policy')}}" target="_blank">Privacy Policy</a>
          </div>
          {{--<div class="socialLinks">
            <a href=""><i class="fab fa-youtube"></i></a>
            <a href=""><i class="fab fa-linkedin-in"></i></a>
            <a href=""><i class="fab fa-pinterest-p"></i></a>
            <a href=""><i class="fab fa-whatsapp"></i></a>
            <a href=""><i class="fab fa-facebook-f"></i></a>
            <a href=""><i class="fab fa-twitter"></i></a>
          </div>
          --}}
        </div>
      </div>
    </div>
  </div>
  <div class="bodyOverlay"></div>
</footer>
</div>
</div>
<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/ek.common.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/request.js')}}"></script>

<script>
  // document.addEventListener("DOMContentLoaded", () => {
  //     const searchQuery = document.getElementById("serchinput");

  //     searchQuery.addEventListener("input", async (e) => {
  //         const query = e.target.value;
  //         if (query.length < 2) return;

  //         const response = await fetch(`/search?query=${query}`);
  //         const suggestions = await response.json();

  //         // Display suggestions (implement your own logic here)
  //         console.log(suggestions);
  //     });
  // });

// ########## Header Search ############
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.querySelector('.serchinput');
  const searchList = document.querySelector('.searchList');
  const searchCard = document.querySelector('.header_search_card');
  const searchBtnInput = document.getElementById('searchBtnInput');

  if (searchInput && searchList) {
    searchInput.addEventListener('keyup', async (e) => {
      const query = e.target.value;
      if (query.length < 2) {
        searchCard.style.display = 'none';
        return;
      }

      try {
        // Clear previous suggestions
        searchList.innerHTML = '';

        // Fetch new suggestions
        const response = await fetch(`{{route("search")}}?query=${query}`);
        const suggestions = await response.json();

        // Display suggestions
        if (suggestions.length > 0) {
          searchCard.style.display = 'block';
          suggestions.forEach((suggestion) => {
            const li = document.createElement('li');
            li.innerHTML = `<a href="${suggestion.url}">${suggestion.text}</a>`;
            searchList.appendChild(li);
          });
        } else {
          searchCard.style.display = 'none';
        }
      } catch (error) {
        console.error('Error fetching suggestions:', error);
      }
    });



searchBtnInput.addEventListener('click', function() {
    searchCard.style.display = 'none';
    const query = searchInput.value.trim();
    // Clear previous suggestions
    searchList.innerHTML = '';

    // Construct the URL with the correct query parameter
    const url =  `{{ url('/')}}/search?q=title&term=`+query;
    window.location.href = url;
    
});

// http://localhost:8083/search?q=keyword&term='Fashion Section Shoes
// http://localhost:8083/search?q=title&term=fashion section shoes (black,10)
searchInput.addEventListener('keydown', function(event) {
  if (event.key === 'Enter') {
    event.preventDefault();
    searchCard.style.display = 'none';
    const query = searchInput.value.trim();
    // Clear previous suggestions
    searchList.innerHTML = '';

    // Construct the URL with the correct query parameter
    const url =  `{{ url('/')}}/search?q=title&term=`+query;
    window.location.href = url;
  }
});

  }
});
  // ## end header search ##


   // Perform an AJAX GET request to fetch category data
   $.ajax({
                    url: '{{ route('categories.list') }}', // URL endpoint for fetching categories
                    type: 'GET', // HTTP method for the request
                    dataType: 'json', // Expected data type of the response
                    success: function(res) {
                        // jQuery object for the primary category menu
                        $menu = $("#primary_category");
                        $mobileMenu = $("#mob_cat_list");

                        // Clear any existing content in the menu
                        $menu.empty();
                        var url = "{{ route('product.category', ['slug' => 'SLUG']) }}";
                        // Check if the response status code is 200 (OK)
                        if (res.data.statusCode == 200) {
                            // Extract the category data from the response
                            let data = res.data.data;

                            // Clear existing content (redundant with the above empty())
                            $menu.empty();
                            $mobileMenu.empty();

                            // Iterate through each main category in the data
                            $.each(data, function(index, category) {
                                // HTML structure for the main category
                                var mainCategoryHtml = '<li class="primary_category_list">';
                                mainCategoryHtml += '<a href="' + url.replace('SLUG', category
                                        .parent_slug) +
                                    '" class="main_category">' + category.parent_name + '</a>';
                                mainCategoryHtml += '<div class="category_sub_list">';

                                // Iterate through each sub-parent of the main category
                                $.each(category.sub_parents, function(index, subParent) {
                                    // HTML structure for each sub-parent
                                    var subParentHtml = '<div class="inner_category">';
                                    subParentHtml += '<h4> <a href="'+url.replace('SLUG', subParent.sub_parent_slug)+'" class="underline">' + subParent.sub_parent_name +
                                        '</a></h4>';
                                    subParentHtml += '<ul class="web_sub_category">';

                                    // Iterate through each child category of the sub-parent
                                    $.each(subParent.children, function(index, child) {
                                        // HTML structure for each child category
                                        subParentHtml += '<li><a href="' + url
                                            .replace('SLUG', child
                                                .child_slug) + '">' + child
                                            .child_name +
                                            '</a></li>';
                                    });



                                    // Close the list and sub-parent HTML structure
                                    subParentHtml += '</ul></div>';
                                    mainCategoryHtml += subParentHtml;
                                });

                                // Close the sub-list and main category HTML structure
                                mainCategoryHtml += '</div></li>';

                                // Append the constructed HTML to the menu
                                $menu.append(mainCategoryHtml);

                                // Begin HTML structure for mobile menu
                                var mobileCategory = '<li class="nav-item">';
                                mobileCategory += `<a class="nav-link collapsed nav-link-arrow" data-bs-toggle="collapse" href="#${category.parent_slug}"
                                                    data-bs-parent="#mob_cat_list" id="components">
                                                    <span class="nav-link-text">${category.parent_name}</span>
                                                    <span class="menu_arrowIcon"><i class="fas fa-angle-right"></i></span>
                                                    </a>`;

                                // Loop through sub-parent categories and build HTML for each
                                $.each(category.sub_parents, function(index, subParent) {
                                    // Begin HTML structure for sub-parent category
                                    var mobilesubParentHtml =
                                        `<ul class="sidenav-second-level collapse" id="${category.parent_slug}" data-bs-parent="#mob_cat_list">`;

                                    // Loop through child categories of the sub-parent
                                    $.each(subParent.children, function(index, child) {
                                        // Add child category links dynamically using its slug and name
                                        mobilesubParentHtml +=
                                            '<li><a class="nav-link" href="' + url
                                            .replace('SLUG', child.child_slug) +
                                            '">' + child.child_name + '</a></li>';
                                    });

                                    // Close the sub-parent's child category list
                                    mobilesubParentHtml += '</ul>';

                                    // Append the sub-parent HTML to the main category structure
                                    mobileCategory += mobilesubParentHtml;
                                });

                                // Append the completed category structure to the mobile menu
                                $mobileMenu.append(mobileCategory);


                            });
                        }
                    }
                })

                .fail(function() {
                    // Log error message to console if AJAX request fails
                    console.log("error");
                });
</script>
@yield('scripts')