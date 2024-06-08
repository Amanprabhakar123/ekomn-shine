
// document.addEventListener('DOMContentLoaded', function() {
//   // dashboard side-bar menu
//   function setActive(elements, currentElement) {
//     elements.forEach(function(element) {
//       element.classList.remove('active');
//     });
//     currentElement.classList.add('active');
//   }
//   var links = document.querySelectorAll('.sidebar-menu .nav-link');
//   var subLinks = document.querySelectorAll('.sidenav-second-level .nav-link');
//   var menutoggle = document.querySelector('.menutoggle');
//   var ek_nav = document.querySelector('.ek_nav');
//   links.forEach(function(link) {
//     link.addEventListener('click', function(event) {
//       event.preventDefault();
//       setActive(links, this);
//     });
//   });
//   subLinks.forEach(function(subLink) {
//     subLink.addEventListener('click', function(event) {
//       event.preventDefault();
//       setActive(links, this.closest('.sidenav-second-level').previousElementSibling);
//       setActive(subLinks, this);
//     });
//   });
//   if(menutoggle && ek_nav) {
//       menutoggle.addEventListener('click', function() {
//         ek_nav.classList.toggle('active');
//       });
//       document.addEventListener('click', function(event) {
//         if (!ek_nav.contains(event.target) && !menutoggle.contains(event.target)) {
//           ek_nav.classList.remove('active');
//         }
//     });
//   }
//   // end side-bar menu


//   // registration
//   var sections = document.querySelectorAll('.sup_section');
//   var nextButtons = document.querySelectorAll('.sup_next');
//   var sup_formSubmit = document.querySelector('.sup_formSubmit');
//   var register = document.querySelector('.register');
//   var t_u_s = document.querySelector('.t_u_s');
//   nextButtons.forEach(function(button, index) {
//     button.addEventListener('click', function(event) {
//       event.preventDefault();
//       sections.forEach(function(section) {
//         section.style.display = 'none';
//       });
//       if (sections[index + 1]) {
//         sections[index + 1].style.display = 'block';
//         setTimeout(() => {
//           sections[index + 1].classList.add(`show_section_${index + 2}`);
//         }, 10);
//       }
//     });
//   });
//   if (sup_formSubmit) {
//     sup_formSubmit.addEventListener('click', function(event) {
//       event.preventDefault();
//       sections.forEach(function(section) {
//         section.style.display = 'none';
//       });
//       register.style.display = 'none';
//       t_u_s.style.display = 'block';
//     });
//   }
// });


$(document).ready(function () {

  // Function to clear error messages for all fields
  function clearErrorMessages() {
    const fields = [
      'first_name', 'mobile', 'address', 'state', 'city', 'pin_code',
      'business_name', 'gst', 'pan', 'designation', 'email', 'password', 'confirm_password'
    ];
    fields.forEach(field => {
      $(`#${field}`).removeClass('is-invalid');
      $(`#${field}Err`).text('');
    });
  }

  // Call clearErrorMessages function when any input field is focused
  $('input').focus(function () {
    clearErrorMessages();
  });

  // Form submission handler for Step 1
  $('#formStep_1').submit(function (event) {
    event.preventDefault();

    // Clear previous error messages
    // clearErrorMessages();

    // Retrieve form values
    const formData_1 = {
      step_1: $('#step_1').val(),
      first_name: $('#first_name').val(),
      last_name: $('#last_name').val(), // This will be included but not validated
      mobile: $('#mobile').val(),
      designation: $('#designation').val(), // This will be included but not validated
      address: $('#address').val(),
      state: $('#state').val(),
      city: $('#city').val(),
      pin_code: $('#pin_code').val(),
      business_name: $('#business_name').val(),
      gst: $('#gst').val(),
      pan: $('#pan').val(),
    };

    // Validate form fields and show error messages
    let isValid = true;
    const requiredFields = ['first_name', 'mobile', 'address', 'state', 'city', 'pin_code', 'business_name', 'gst', 'pan'];
    requiredFields.forEach(field => {
      if (!formData_1[field]) {
        $(`#${field}`).addClass('is-invalid');
        $(`#${field}Err`).text(`Please enter your ${field.replace('_', ' ')}.`);
        isValid = false;
      }
    });

    // If form is not valid, exit function
    if (!isValid) return;

    // Submit form data via API
    ApiRequest('buyer/register', 'POST', formData_1)
      .then(response => {
        if (response.data.statusCode == 200) {
          alert('Step 1 form submitted successfully.');
          $('#hiddenField').val(response.data.id);
          $('.section_1').hide();
          $('.section_2').css('display', 'block');
          setTimeout(function () {
            $('.section_2').show().addClass('show_section_2');
          }, 10);

        }
        if (response.data.statusCode == 422) {
          const field = response.data.key;
          $(`#${field}`).addClass('is-invalid');
          $(`#${field}Err`).text(response.data.message);
        }
      })
      .catch(error => {
        console.error('Error222:', error);
      });
  });

  $('#formStep_2').submit(function (event) {
    event.preventDefault();

    var hiddenField = $('#hiddenField').val();
    var email = $("#email").val();
    var password = $("#password").val();
    var confirm_password = $("#confirm_password").val();
    const regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/;

    let isValid = true;
    // Clear previous errors
    $('#email').removeClass('is-invalid');
    $('#emailErr').text('');
    $('#password').removeClass('is-invalid');
    $('#passwordErr').text('');
    $('#confirm_password').removeClass('is-invalid');
    $('#confirm_passwordErr').text('');

    if (!email) {
      $('#email').addClass('is-invalid');
      $('#emailErr').text('Please enter your email.');
      isValid = false;
    }
    if (!password) {
      $('#password').addClass('is-invalid');
      $('#passwordErr').text('Please enter your password.');
      isValid = false;
    }
    if (!regex.test(password)) {
      $('#password').addClass('is-invalid');
      $('#passwordErr').text('Password must be at least 8 characters long, include letters, numbers, and special characters.');
      isValid = false;
    }
    if (!confirm_password) {
      $('#confirm_password').addClass('is-invalid');
      $('#confirm_passwordErr').text('Please enter your confirm password.');
      isValid = false;
    }
    if (password !== confirm_password) {
      $('#confirm_password').addClass('is-invalid');
      $('#confirm_passwordErr').text('Passwords do not match.');
      isValid = false;
    }

    if (isValid) {
      const formData_2 = {
        step_2: $('#step_2').val(),
        hiddenField: hiddenField,
        email: email,
        password: password,
        password_confirmation: confirm_password,
        product_channel: $('input[type="radio"][name="product_channel"]:checked').val()
      };
      ApiRequest('buyer/register', 'POST', formData_2)
        .then(response => {
          if (response.data.statusCode == 200) {
            alert('Step 2 form submitted successfully.');
            $('#exampleModal').attr('aria-hidden', 'false');
            $('#exampleModal').modal('show');
            $('#exampleModal').on('hidden.bs.modal', function () {
              $('#exampleModal').attr('aria-hidden', 'true');
            });

            $(document).ready(function() {
              if ($('.sup_formSubmit').length) {
                $('.sup_formSubmit').on('click', function(event) {
                  event.preventDefault();
                  
                  // Hide the register element
                  $('.register').hide();
                  
                  // Show the t_u_s element
                  setTimeout(function () {
                    $('.t_u_s').show();
                  }, 10);
                 
                });
              }
            });
            

          //  $('.register').css('display', 'none');
          //  $('.t_u_s').css('display', 'block');
           
//       t_u_s.style.display = 'block';
          } else {
            alert('Registration failed!');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

  });


});

