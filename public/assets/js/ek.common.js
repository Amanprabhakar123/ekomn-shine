
document.addEventListener('DOMContentLoaded', function () {
  // dashboard side-bar menu
  function setActive(elements, currentElement) {
    elements.forEach(function (element) {
      element.classList.remove('active');
    });
    currentElement.classList.add('active');
  }
  var links = document.querySelectorAll('.sidebar-menu .nav-link');
  var subLinks = document.querySelectorAll('.sidenav-second-level .nav-link');
  var menutoggle = document.querySelector('.menutoggle');
  var ek_nav = document.querySelector('.ek_nav');
  links.forEach(function (link) {
    link.addEventListener('click', function (event) {
      // event.preventDefault();
      setActive(links, this);
    });
  });
  subLinks.forEach(function (subLink) {
    subLink.addEventListener('click', function (event) {
      // event.preventDefault();
      setActive(links, this.closest('.sidenav-second-level').previousElementSibling);
      setActive(subLinks, this);
    });
  });
  if (menutoggle && ek_nav) {
    menutoggle.addEventListener('click', function () {
      ek_nav.classList.toggle('active');
    });
    document.addEventListener('click', function (event) {
      if (!ek_nav.contains(event.target) && !menutoggle.contains(event.target)) {
        ek_nav.classList.remove('active');
      }
    });
  }
  // end side-bar menu


  // registration
  var sections = document.querySelectorAll('.sup_section');
  var nextButtons = document.querySelectorAll('.sup_next');
  var sup_formSubmit = document.querySelector('.sup_formSubmit');
  var register = document.querySelector('.register');
  var t_u_s = document.querySelector('.t_u_s');
  nextButtons.forEach(function (button, index) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      sections.forEach(function (section) {
        section.style.display = 'none';
      });
      if (sections[index + 1]) {
        sections[index + 1].style.display = 'block';
        setTimeout(() => {
          sections[index + 1].classList.add(`show_section_${index + 2}`);
        }, 10);
      }
    });
  });
  if (sup_formSubmit) {
    sup_formSubmit.addEventListener('click', function (event) {
      event.preventDefault();
      sections.forEach(function (section) {
        section.style.display = 'none';
      });
      register.style.display = 'none';
      t_u_s.style.display = 'block';
    });
  }
});
// end


