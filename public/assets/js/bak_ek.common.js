
document.addEventListener('DOMContentLoaded', function() {
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
  document.getElementById('addNewRowButton').addEventListener('click', function () {
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
  // end


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
    // const toText = document.createElement('span');
    // toText.className = 'totext';
    // toText.textContent = 'To';
    // const quantityuptoInput_2 = document.createElement('input');
    // quantityuptoInput_2.type = 'text';
    // quantityuptoInput_2.className = 'smallInput_n w_40';
    // quantityuptoInput_2.placeholder = '0';
    quantityuptoCell.appendChild(quantityuptoInput);
    // quantityuptoCell.appendChild(toText);
    // quantityuptoCell.appendChild(quantityuptoInput_2);

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
      console.log('hiiii')
      button.closest('#shippingRateTable tr').remove();
    });
  });
  // end

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
    closeIcon.innerHTML = "x";
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
  // Function to show yesblock and hide noblock
  function showYesBlock() {
    yesBlock.style.display = 'block';
    noBlock.style.display = 'none';
  }
  // Function to show noblock and hide yesblock
  function showNoBlock() {
    yesBlock.style.display = 'none';
    noBlock.style.display = 'block';
  }
  // Initially, show/hide blocks based on default checked state
  if (noRadio.checked) {
    showNoBlock();
  } else if (yesRadio.checked) {
    showYesBlock();
  }
  // Event listeners for radio buttons
  yesRadio.addEventListener('change', showYesBlock);
  noRadio.addEventListener('change', showNoBlock);
  // ####### end radio check ######

  // ########## Create Product Feature List ############
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
  //########## End Product Feature List ############

});

