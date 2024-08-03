
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

// end

  // form footer button
  const footers = document.querySelectorAll('.saveform_footer');
  footers.forEach(function (footer) {
    const buttons = footer.querySelectorAll('button');
    if (buttons.length === 1) {
      footer.classList.add('single-button');
    }
  });
  // end

  
  // add product tab next & previous
  const next_Tab = document.querySelectorAll('.next_Tab');
  const previous_Tab = document.querySelectorAll('.previous_Tab');
  next_Tab.forEach(button => {
    button.addEventListener('click', function () {
      const currentTab = document.querySelector('.tab-pane.active');
      const nextTab = currentTab.nextElementSibling;
      if (nextTab && nextTab.classList.contains('tab-pane')) {
        const currentTabId = currentTab.getAttribute('id');
        const nextTabId = nextTab.getAttribute('id');
        document.querySelector(`[data-bs-target="#${currentTabId}"]`).classList.remove('active');
        document.querySelector(`[data-bs-target="#${nextTabId}"]`).classList.add('active');
        currentTab.classList.remove('show', 'active');
        nextTab.classList.add('show', 'active');
      }
    });
  });
  previous_Tab.forEach(button => {
    button.addEventListener('click', function () {
      const currentTab = document.querySelector('.tab-pane.active');
      const prevTab = currentTab.previousElementSibling;
      if (prevTab && prevTab.classList.contains('tab-pane')) {
        const currentTabId = currentTab.getAttribute('id');
        const prevTabId = prevTab.getAttribute('id');
        document.querySelector(`[data-bs-target="#${currentTabId}"]`).classList.remove('active');
        document.querySelector(`[data-bs-target="#${prevTabId}"]`).classList.add('active');
        currentTab.classList.remove('show', 'active');
        prevTab.classList.add('show', 'active');
      }
    });
  });
  // end

  // Add or Remove Bulk Rate Row
 /* document.getElementById('addNewRowButton').addEventListener('click', function () {
    const tableBody = document.querySelector('#bulkRateTable tbody');
    const newRow = document.createElement('tr');
    const quantityCell = document.createElement('td');
    const quantityInput = document.createElement('input');
    quantityInput.type = 'text';
    quantityInput.className = 'smallInput_n';
    quantityInput.placeholder = 'Qty. Upto';
    quantityCell.appendChild(quantityInput);
  
    const priceCell = document.createElement('td');
    const priceInput = document.createElement('input');
    priceInput.type = 'text';
    priceInput.className = 'smallInput_n';
    priceInput.placeholder = 'Rs. 0.00';
    priceCell.appendChild(priceInput);
  
    const deleteButton = document.createElement('button');
    deleteButton.className = 'deleteRow deleteBulkRow';
    deleteButton.innerHTML = '<i class="far fa-trash-alt"></i>';
    priceCell.appendChild(deleteButton);
  
    newRow.appendChild(quantityCell);
    newRow.appendChild(priceCell);
    tableBody.appendChild(newRow);
    deleteButton.addEventListener('click', function () {
      newRow.remove();
    });
  });
  document.querySelectorAll('.deleteBulkRow').forEach(button => {
    button.addEventListener('click', function () {
      button.closest('#bulkRateTable tr').remove();
    });
  });
  // end*/

/*
  // Add or Remove Shipping Rate Row
  const addShippingDetails = document.getElementById('addShippingRow')
  addShippingDetails.addEventListener('click', function () {
    const shippingTableBody = document.querySelector('#shippingRateTable tbody');
    const newShipingRow = document.createElement('tr');
    const quantityuptoCell = document.createElement('td');
    const quantityuptoInput = document.createElement('input');
    quantityuptoInput.type = 'text';
    quantityuptoInput.className = 'smallInput_n';
    quantityuptoInput.placeholder = 'Qty. Upto';
    quantityuptoCell.appendChild(quantityuptoInput);

    const localPrice = document.createElement('td');
    const localPriceInput = document.createElement('input');
    localPriceInput.type = 'text';
    localPriceInput.className = 'smallInput_n';
    localPriceInput.placeholder = 'Rs. 0.00';
    localPrice.appendChild(localPriceInput);

    const regionalPrice = document.createElement('td');
    const regionalPriceInput = document.createElement('input');
    regionalPriceInput.type = 'text';
    regionalPriceInput.className = 'smallInput_n';
    regionalPriceInput.placeholder = 'Rs. 0.00';
    regionalPrice.appendChild(regionalPriceInput);

    const nationalPrice = document.createElement('td');
    const nationalPriceInput = document.createElement('input');
    nationalPriceInput.type = 'text';
    nationalPriceInput.className = 'smallInput_n';
    nationalPriceInput.placeholder = 'Rs. 0.00';
    nationalPrice.appendChild(nationalPriceInput);

    const deletShippingRow = document.createElement('td');
    const deletShippingBtn = document.createElement('button');
    deletShippingBtn.type = 'button';
    deletShippingBtn.className = 'deleteRow deleteShippingRow';
    deletShippingBtn.innerHTML = '<i class="far fa-trash-alt"></i>';
    deletShippingRow.appendChild(deletShippingBtn);

    newShipingRow.appendChild(quantityuptoCell);
    newShipingRow.appendChild(localPrice);
    newShipingRow.appendChild(regionalPrice);
    newShipingRow.appendChild(nationalPrice);
    newShipingRow.appendChild(deletShippingRow);
    shippingTableBody.appendChild(newShipingRow);

    deletShippingRow.addEventListener('click', function () {
      newShipingRow.remove();
    });
  });
  document.querySelectorAll('.deleteShippingRow').forEach(button => {
    button.addEventListener('click', function () {
      button.closest('#shippingRateTable tr').remove();
    });
  });
  // end
*/
  // add product keywords
  const tagContainer = document.querySelector(".tag-container");
  const input = document.querySelector("#tag-input");
  function createTag(label) {
    const div = document.createElement("div");
    div.setAttribute("class", "tag");
    const span = document.createElement("span");
    span.innerHTML = label.trim();
    div.appendChild(span);
    const closeIcon = document.createElement("span");
    closeIcon.innerHTML = "";
    closeIcon.setAttribute("class", "remove-tag");
    closeIcon.onclick = function () {
      tagContainer.removeChild(div);
    };
    div.appendChild(closeIcon);
    return div;
  }
  function addTag() {
    const inputValue = input.value.trim().replace(/,$/, '');
    if(inputValue !== "") {
      const tag = createTag(inputValue);
      tagContainer.insertBefore(tag, input.parentElement);
      input.value = "";
    }
  }
  input.addEventListener("keyup", function (e) {
    if (e.key === "Enter" || e.key === ",") {
      addTag();
    }
  });
  input.addEventListener("blur", function () {
    addTag();
  });
  // end

  // ######### Radio Check to Show/Hide #######
  const yesRadio = document.getElementById('yes');
  const noRadio = document.getElementById('no');
  const yesBlock = document.querySelector('.yesblock');
  const noBlock = document.querySelector('.noblock');
  function showYesBlock() {
    yesBlock.style.display = 'block';
    noBlock.style.display = 'none';
  }
  function showNoBlock() {
    yesBlock.style.display = 'none';
    noBlock.style.display = 'block';
  }
  if (noRadio.checked) {
    showNoBlock();
  } else if (yesRadio.checked) {
    showYesBlock();
  }
  yesRadio.addEventListener('change', showYesBlock);
  noRadio.addEventListener('change', showNoBlock);
  // ####### end radio check ######
  

  // ########## Create Product Feature List ############
  /*
  document.getElementById('add-feature').addEventListener('click', function() {
    const textarea = document.getElementById('product-description');
    const featureList = document.getElementById('features-list');
    const errorMessage = document.getElementById('error-message');
    if (textarea.value.trim() === '') {
      errorMessage.classList.remove('hide');
      return;
    } else {
      errorMessage.classList.add('hide');
    }
    const newFeature = document.createElement('li');
    newFeature.innerHTML = `
      <div class="featurescontent">
        ${textarea.value.replace(/\n/g, '<br>')}
        <div class="f_btn f_btn_rightSide">
          <button class="btn btn-link btn-sm me-1 p-1 edit-feature" type="button"><i class="fas fa-pencil-alt"></i></button>
          <button class="btn btn-link btn-sm text-danger p-1 delete-feature" type="button"><i class="fas fa-trash"></i></button>
        </div>
      </div>
    `;
    featureList.appendChild(newFeature);
    textarea.value = '';
    if (featureList.children.length >= 7) {
      document.getElementById('add-feature').disabled = true;
    }
    newFeature.querySelector('.delete-feature').addEventListener('click', function() {
      newFeature.remove();
      if (featureList.children.length < 7) {
        document.getElementById('add-feature').disabled = false;
      }
    });
    newFeature.querySelector('.edit-feature').addEventListener('click', function() {
      const content = newFeature.querySelector('.featurescontent').innerHTML
        .split('<div')[0].trim().replace(/<br>/g, '\n');
      textarea.value = content;
      newFeature.remove();
      if (featureList.children.length < 7) {
        document.getElementById('add-feature').disabled = false;
      }
    });
  });
  */
  //########## End Product Feature List ############

});


  // ########## Header Search ############
  const searchInput = document.querySelector('.serchinput');
  const searchCard = document.querySelector('.header_search_card');
  if (searchInput && searchCard) {
    searchInput.addEventListener('input', function() {
      searchCard.style.display = 'block';
    });
    document.addEventListener('click', function(event) {
      if (!searchCard.contains(event.target) && !searchInput.contains(event.target)) {
        searchCard.style.display = 'none';
      }
    });
  }
  // ## end header search ##



  // ############# Mobile Drawer ##########
  const barclick = document.getElementById('barIcon');
  const filtershow = document.querySelector('.mobileMenu');
  const closeDrawer = document.querySelector('.closeDrawer');
  const bodyOverlay = document.querySelector('.bodyOverlay');
  if (barclick && filtershow && closeDrawer && bodyOverlay) {
    barclick.addEventListener('click', function() {
      filtershow.classList.add('active');
      bodyOverlay.classList.add('active');
    });
    closeDrawer.addEventListener('click', function() {
      filtershow.classList.remove('active');
      bodyOverlay.classList.remove('active');
    });
    bodyOverlay.addEventListener('click', function() {
      filtershow.classList.remove('active');
      bodyOverlay.classList.remove('active');
    });
  }
  // ## end mobile drawer ##



  // ############## Index Page Mein Category ##############
  var menuItems = document.querySelectorAll('.primary_category_menu > li');
  menuItems.forEach(function(item) {
    item.addEventListener('mouseenter', function() {
      var submenu = item.querySelector('.category_sub_list');
      var rect = submenu.getBoundingClientRect();
      if (rect.right > window.innerWidth) {
        submenu.classList.add('open-right');
      } else {
        submenu.classList.remove('open-right');
      }
    });
  });
  // ## end Index Page Mein Category ##



  // ######## Select All Product #########
  const selectAllCheckbox = document.getElementById('selectAllCheckbox');
  if (selectAllCheckbox) {
    const checkboxes = document.querySelectorAll('.allproductbox .form-check-input');
    selectAllCheckbox.addEventListener('click', () => {
      checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
      });
    });
  }
  // ## end select all ##



  // ########### Scroll to Stick header on web ##########
  if (window.innerWidth > 1024) {
    window.addEventListener('scroll', function() {
      const header = document.getElementById("main_header");
      const bottomHeader = document.querySelector('.bottom_header');
      if (header && bottomHeader) {
        const sticky = header.offsetTop;
        if (window.pageYOffset > sticky) {
          header.classList.add("headerFixed");
          bottomHeader.style.marginTop = '60px';
        } else {
          header.classList.remove("headerFixed");
          bottomHeader.style.marginTop = '0px';
        }
      }
    });
  }
  // ## end stick header ##



  // ######## Show and Less Items #######
  const items = document.querySelectorAll('#itemList li');
  const toggleButton = document.getElementById('toggleButton');
  if(toggleButton){
    let showingAll = false;
    toggleButton.addEventListener('click', () => {
      showingAll = !showingAll;
      items.forEach((item, index) => item.classList.toggle('show', showingAll || index < 8));
      toggleButton.innerHTML = showingAll ? '<u>Less</u>' : 'More';
    });
    items.forEach((item, index) => item.classList.toggle('show', index < 8));
  }
  // ## end Show and Less Items ##

  

  // ####### Stick Filter bar ########
  if(window.innerWidth > 1025) {
    const stickyElement = document.getElementById('productFilters');
    const footerElement = document.querySelector('footer');
    if(stickyElement && footerElement) {
      const stickyOffset = stickyElement.offsetTop - 76;
      window.addEventListener('scroll', () => {
        const footerOffset = footerElement.offsetTop;
        const scrollPosition = window.pageYOffset + window.innerHeight;
        const stickyHeight = stickyElement.offsetHeight;
        if (window.pageYOffset >= stickyOffset) {
          if (scrollPosition >= footerOffset) {
            stickyElement.style.position = 'absolute';
            stickyElement.style.top = (footerOffset - stickyHeight - 16) + 'px';
          } else {
            stickyElement.style.position = 'fixed';
            stickyElement.style.top = '76px';
          }
        } else {
          stickyElement.style.position = 'static';
        }
      });
    }
  }
  // ## end Stick Filter bar ##



  // ########## Image Carousel Setup ##########
  const mainImg = document.getElementById('main-img');
  const smallImgs = document.querySelectorAll('.smImg');
  const carousel = document.querySelector('.small-card');
  const prevButton = document.querySelector('.prev');
  const nextButton = document.querySelector('.next');
  if(mainImg && smallImgs.length && carousel && prevButton && nextButton) {
    const imgWidth = 84;
    const imgMargin = 10;
    const visibleImgs = 5;
    let scrollPosition = 0;
    const maxScroll = (smallImgs.length - visibleImgs) * (imgWidth + imgMargin);
    const updateButtonStates = () => {
      prevButton.style.display = scrollPosition > 0 ? 'block' : 'none';
      nextButton.style.display = scrollPosition < maxScroll ? 'block' : 'none';
    };
    smallImgs.forEach(img => {
      img.addEventListener('mouseover', () => {
        mainImg.src = img.getAttribute('data-src');
        smallImgs.forEach(i => i.classList.remove('active'));
        img.classList.add('active');
      });
      img.addEventListener('click', () => {
        mainImg.src = img.getAttribute('data-src');
        smallImgs.forEach(i => i.classList.remove('active'));
        img.classList.add('active');
      });
    });
    prevButton.addEventListener('click', () => {
      if(scrollPosition > 0) {
        scrollPosition -= (imgWidth + imgMargin);
        carousel.style.transform = `translateX(-${scrollPosition}px)`;
        updateButtonStates();
      }
    });
    nextButton.addEventListener('click', () => {
      if (scrollPosition < maxScroll) {
        scrollPosition += (imgWidth + imgMargin);
        carousel.style.transform = `translateX(-${scrollPosition}px)`;
        updateButtonStates();
      }
    });
    updateButtonStates();
  }
  // ## End Image Carousel ##



  // ########## Testimonial text truncat ##########
  var paragraphs = document.querySelectorAll(".authorContentPara");
  if (paragraphs.length > 0) {
    paragraphs.forEach(function(paragraph) {
      var text = paragraph.textContent || paragraph.innerText;
      if (text.length > 150) {
        var truncatedText = text.slice(0, 150) + "...";
        paragraph.textContent = truncatedText;
      }
    });
  }
  // ## end testimonial text truncat ##



  // dashboard side-bar menu
  function setActive(elements, currentElement) {
    elements.forEach(function(element) {
      element.classList.remove('active');
    });
    currentElement.classList.add('active');
  }
  var links = document.querySelectorAll('.sidebar-menu .nav-link');
  var subLinks = document.querySelectorAll('.sidenav-second-level .nav-link');
  var menutoggle = document.querySelector('.menutoggle');
  var ek_nav = document.querySelector('.ek_nav');
  links.forEach(function(link) {
    link.addEventListener('click', function(event) {
      // event.preventDefault();
      setActive(links, this);
    });
  });
  subLinks.forEach(function(subLink) {
    subLink.addEventListener('click', function(event) {
      // event.preventDefault();
      setActive(links, this.closest('.sidenav-second-level').previousElementSibling);
      setActive(subLinks, this);
    });
  });
  if(menutoggle && ek_nav) {
      menutoggle.addEventListener('click', function() {
        ek_nav.classList.toggle('active');
      });
      document.addEventListener('click', function(event) {
        if (!ek_nav.contains(event.target) && !menutoggle.contains(event.target)) {
          ek_nav.classList.remove('active');
        }
    });
  }
  // end side-bar menu
  

  // ######### file upload #########
  const fileInput = document.getElementById('fileInput');
  if(fileInput) {
    fileInput.addEventListener('change', function(event) {
      const fileName = event.target.files[0]?.name || 'No file chosen';
      const fileNameDisplay = document.getElementById('fileName');
      if(fileNameDisplay) {
        fileNameDisplay.textContent = fileName;
      }
    });
  }
  // ## end file upload ##

  // registration
  var sections = document.querySelectorAll('.sup_section');
  var nextButtons = document.querySelectorAll('.sup_next');
  var sup_formSubmit = document.querySelector('.sup_formSubmit');
  var register = document.querySelector('.register');
  var t_u_s = document.querySelector('.t_u_s');
  nextButtons.forEach(function(button, index) {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      sections.forEach(function(section) {
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
    sup_formSubmit.addEventListener('click', function(event) {
      event.preventDefault();
      sections.forEach(function(section) {
        section.style.display = 'none';
      });
      register.style.display = 'none';
      t_u_s.style.display = 'block';
    });
  }
  // end



  // ######## footer button if button is single ########
  const footers = document.querySelectorAll('.saveform_footer');
  footers.forEach(function (footer) {
    const buttons = footer.querySelectorAll('button');
    if (buttons.length === 1) {
      footer.classList.add('single-button');
    }
  });
  // ## end footer button if button is single ##


  
  // add product tab next & previous
  const next_Tab = document.querySelectorAll('.next_Tab');
  const previous_Tab = document.querySelectorAll('.previous_Tab');
  next_Tab.forEach(button => {
    button.addEventListener('click', function () {
      const currentTab = document.querySelector('.tab-pane.active');
      const nextTab = currentTab.nextElementSibling;
      if (nextTab && nextTab.classList.contains('tab-pane')) {
        const currentTabId = currentTab.getAttribute('id');
        const nextTabId = nextTab.getAttribute('id');
        document.querySelector(`[data-bs-target="#${currentTabId}"]`).classList.remove('active');
        document.querySelector(`[data-bs-target="#${nextTabId}"]`).classList.add('active');
        currentTab.classList.remove('show', 'active');
        nextTab.classList.add('show', 'active');
      }
    });
  });
  previous_Tab.forEach(button => {
    button.addEventListener('click', function () {
      const currentTab = document.querySelector('.tab-pane.active');
      const prevTab = currentTab.previousElementSibling;
      if (prevTab && prevTab.classList.contains('tab-pane')) {
        const currentTabId = currentTab.getAttribute('id');
        const prevTabId = prevTab.getAttribute('id');
        document.querySelector(`[data-bs-target="#${currentTabId}"]`).classList.remove('active');
        document.querySelector(`[data-bs-target="#${prevTabId}"]`).classList.add('active');
        currentTab.classList.remove('show', 'active');
        prevTab.classList.add('show', 'active');
      }
    });
  });
  // end



  // ######## Add or Remove Bulk Rate Row #############
  const addNewRowButton = document.getElementById('addNewRowButton');
  const bulkRateTable = document.querySelector('#bulkRateTable');
  if(addNewRowButton && bulkRateTable) {
    addNewRowButton.addEventListener('click', function () {
      const tableBody = bulkRateTable.querySelector('tbody');
      const newRow = document.createElement('tr');
      const quantityCell = document.createElement('td');
      const quantityInput = document.createElement('input');
      quantityInput.type = 'text';
      quantityInput.className = 'smallInput_n';
      quantityInput.placeholder = 'Qty. Upto';
      quantityCell.appendChild(quantityInput);
      const priceCell = document.createElement('td');
      const priceInput = document.createElement('input');
      priceInput.type = 'text';
      priceInput.className = 'smallInput_n';
      priceInput.placeholder = 'Rs. 0.00';
      priceCell.appendChild(priceInput);
      const deleteButton = document.createElement('button');
      deleteButton.className = 'deleteRow deleteBulkRow';
      deleteButton.innerHTML = '<i class="far fa-trash-alt"></i>';
      priceCell.appendChild(deleteButton);
      newRow.appendChild(quantityCell);
      newRow.appendChild(priceCell);
      tableBody.appendChild(newRow);
      deleteButton.addEventListener('click', function () {
        newRow.remove();
      });
    });
    document.querySelectorAll('.deleteBulkRow').forEach(button => {
      button.addEventListener('click', function () {
        button.closest('tr').remove();
      });
    });
  }
  // ## end dd or Remove Bulk Rate Row ##



  // ######## Add or Remove Shipping Rate Row ########
  const addShippingDetails = document.getElementById('addShippingRow')
  if(addShippingDetails){
    addShippingDetails.addEventListener('click', function () {
      const shippingTableBody = document.querySelector('#shippingRateTable tbody');
      const newShipingRow = document.createElement('tr');
      const quantityuptoCell = document.createElement('td');
      const quantityuptoInput = document.createElement('input');
      quantityuptoInput.type = 'text';
      quantityuptoInput.className = 'smallInput_n';
      quantityuptoInput.placeholder = 'Qty. Upto';
      quantityuptoCell.appendChild(quantityuptoInput);

      const localPrice = document.createElement('td');
      const localPriceInput = document.createElement('input');
      localPriceInput.type = 'text';
      localPriceInput.className = 'smallInput_n';
      localPriceInput.placeholder = 'Rs. 0.00';
      localPrice.appendChild(localPriceInput);

      const regionalPrice = document.createElement('td');
      const regionalPriceInput = document.createElement('input');
      regionalPriceInput.type = 'text';
      regionalPriceInput.className = 'smallInput_n';
      regionalPriceInput.placeholder = 'Rs. 0.00';
      regionalPrice.appendChild(regionalPriceInput);

      const nationalPrice = document.createElement('td');
      const nationalPriceInput = document.createElement('input');
      nationalPriceInput.type = 'text';
      nationalPriceInput.className = 'smallInput_n';
      nationalPriceInput.placeholder = 'Rs. 0.00';
      nationalPrice.appendChild(nationalPriceInput);

      const deletShippingRow = document.createElement('td');
      const deletShippingBtn = document.createElement('button');
      deletShippingBtn.type = 'button';
      deletShippingBtn.className = 'deleteRow deleteShippingRow';
      deletShippingBtn.innerHTML = '<i class="far fa-trash-alt"></i>';
      deletShippingRow.appendChild(deletShippingBtn);

      newShipingRow.appendChild(quantityuptoCell);
      newShipingRow.appendChild(localPrice);
      newShipingRow.appendChild(regionalPrice);
      newShipingRow.appendChild(nationalPrice);
      newShipingRow.appendChild(deletShippingRow);
      shippingTableBody.appendChild(newShipingRow);

      deletShippingRow.addEventListener('click', function () {
        newShipingRow.remove();
      });
    });
    document.querySelectorAll('.deleteShippingRow').forEach(button => {
      button.addEventListener('click', function () {
        button.closest('#shippingRateTable tr').remove();
      });
    });
  }
  // ## end Add or Remove Shipping Rate Row ##



  // ######### add product keywords #########
  const tagContainer = document.querySelector(".tag-container");
  const input = document.querySelector("#tag-input");
  if(tagContainer && input) {
    function createTag(label) {
      const div = document.createElement("div");
      div.setAttribute("class", "tag");
      const span = document.createElement("span");
      span.innerHTML = label.trim();
      div.appendChild(span);
      const closeIcon = document.createElement("span");
      closeIcon.innerHTML = "x";
      closeIcon.setAttribute("class", "remove-tag");
      closeIcon.onclick = function () {
        tagContainer.removeChild(div);
      };
      div.appendChild(closeIcon);
      return div;
    }
    function addTag() {
      const inputValue = input.value.trim();
      if (inputValue !== "") {
        const values = inputValue.split(",").filter(value => value.trim() !== "");
        values.forEach(value => {
          const tag = createTag(value.trim());
          tagContainer.insertBefore(tag, input.parentElement);
        });
        input.value = "";
      }
    }
    input.addEventListener("keyup", function (e) {
      if (e.key === "Enter" || e.key === ",") {
        addTag();
      }
    });
    input.addEventListener("blur", function () {
      addTag();
    });
    input.addEventListener("input", function () {
      if (input.value.includes(",")) {
        addTag();
      }
    });
  }
  // ## end add product keywords ##


  
  // ######### Sub header link active ########
  document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll('.b_h_list > li > a');
    links.forEach(link => {
      link.addEventListener('click', function(event) {
        // event.preventDefault();
        links.forEach(link => link.classList.remove('active'));
        this.classList.add('active');
      });
    });
  });
  // ## end Sub header link active ##

  

  // ######### Radio Check to Show/Hide #######
  const yesRadio = document.getElementById('yes');
  const noRadio = document.getElementById('no');
  const yesBlock = document.querySelector('.yesblock');
  const noBlock = document.querySelector('.noblock');
  function updateBlocks() {
    if (yesRadio && noRadio && yesBlock && noBlock) {
      yesBlock.style.display = yesRadio.checked ? 'block' : 'none';
      noBlock.style.display = noRadio.checked ? 'block' : 'none';
    }
  }
  if (yesRadio && noRadio) {
    yesRadio.addEventListener('change', updateBlocks);
    noRadio.addEventListener('change', updateBlocks);
    updateBlocks(); // Initialize display based on initial radio button state
  }
  // ## end radio check ##

  

  // ########## Create Product Feature List ############
  const addFeatureButton = document.getElementById('add-feature');
  const textarea = document.getElementById('product-description');
  const featureList = document.getElementById('features-list');
  const errorMessage = document.getElementById('error-message');
  if(addFeatureButton && textarea && featureList && errorMessage) {
    addFeatureButton.addEventListener('click', function() {
      if (textarea.value.trim() === '') {
        errorMessage.classList.remove('hide');
        return;
      } else {
        errorMessage.classList.add('hide');
      }
      const newFeature = document.createElement('li');
      newFeature.innerHTML = `
        <div class="featurescontent">
          ${textarea.value.replace(/\n/g, '<br>')}
          <div class="f_btn f_btn_rightSide">
            <button class="btn btn-link btn-sm me-1 p-1 edit-feature" type="button"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-link btn-sm text-danger p-1 delete-feature" type="button"><i class="fas fa-trash"></i></button>
          </div>
        </div>
      `;
      featureList.appendChild(newFeature);
      textarea.value = '';
      if (featureList.children.length >= 7) {
        addFeatureButton.disabled = true;
      }
      newFeature.querySelector('.delete-feature').addEventListener('click', function() {
        newFeature.remove();
        if (featureList.children.length < 7) {
          addFeatureButton.disabled = false;
        }
      });
      newFeature.querySelector('.edit-feature').addEventListener('click', function() {
        const content = newFeature.querySelector('.featurescontent').innerHTML
          .split('<div')[0].trim().replace(/<br>/g, '\n');
        textarea.value = content;
        newFeature.remove();
        if (featureList.children.length < 7) {
          addFeatureButton.disabled = false;
        }
      });
    });
  }
  // ## End Product Feature List ##




