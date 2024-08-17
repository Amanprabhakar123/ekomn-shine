<footer class="ekfooter">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <div class="eKomonsummary">
          <a href="#"><img src="{{asset('assets/images/Logo.svg')}}" class="footerlogo" alt="Logo" height="50" /></a>
          <p class="m-0">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus pariatur cupiditate, voluptatibus praesentium ducimus eius! Nostrum, facere, laudantium vero ab officia animi sapiente voluptatum architecto esse corrupti numquam consequatur quibusdam?
          </p>
        </div>
      </div>
      <div class="col col-md-2">
        <div>
          <h4 class="footer-heading">About Us</h4>
          <ul class="eKomUsefulLink">
            <li><a href="">Company Info</a></li>
            <li><a href="">Shipping Policy</a></li>
            <li><a href="">Return</a></li>
            <li><a href="">Refund Policy</a></li>
            <li><a href="">Company Info</a></li>
          </ul>
        </div>
      </div>
      <div class="col col-md-2">
        <div>
          <h4 class="footer-heading">Useful Links</h4>
          <ul class="eKomUsefulLink">
            <li><a href="">FAQs</a></li>
            <li><a href="">Blogs</a></li>
          </ul>
        </div>
      </div>
      <div class="col-sm-4 col-md-2">
        <div>
          <h4 class="footer-heading">Support</h4>
          <ul class="eKomUsefulLink">
            <li><a href="">Get in Touch</a></li>
            <li><a href="">Help Center</a></li>
          </ul>
        </div>
      </div>
      <div class="col-sm-12 col-md-12">
        <div class="copyright_section">
          <div class="copyrightText">
            &copy; 2024 ekomn.com, All Rights Reserved. <a href="" target="_blank">Terms of Use</a> and <a href="" target="_blank">Privacy Policy</a>
          </div>
          <div class="socialLinks">
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
  </div>
  <div class="bodyOverlay"></div>
</footer>
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
</script>
@yield('scripts')