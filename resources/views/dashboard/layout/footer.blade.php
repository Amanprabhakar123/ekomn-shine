<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/js/ek.common.js"></script>
    <script>
      document.getElementById("panupload").addEventListener("change", function () {
        var fileName = this.files[0].name;
        document.getElementById("panfilename").innerHTML = fileName;
      });
      document.getElementById("gstupload").addEventListener("change", function () {
        var fileName = this.files[0].name;
        document.getElementById("gstfilename").innerHTML = fileName;
      });
    </script>
    <script>
      function handleFileSelect(inputElement, imageElement, defaultHtml) {
        const inputFile = document.querySelector(inputElement);
        const pictureImage = document.querySelector(imageElement);
        pictureImage.innerHTML = defaultHtml;
    
        inputFile.addEventListener("change", function (e) {
          const inputTarget = e.target;
          const file = inputTarget.files[0];
    
          if (file) {
            const reader = new FileReader();
    
            reader.addEventListener("load", function (e) {
              const readerTarget = e.target;
    
              const img = document.createElement("img");
              img.src = readerTarget.result;
              img.classList.add("picture__img");
    
              pictureImage.innerHTML = "";
              pictureImage.appendChild(img);
            });
    
            reader.readAsDataURL(file);
          } else {
            pictureImage.innerHTML = defaultHtml;
          }
        });
      }
    
      handleFileSelect("#picture__input_cheque", ".picture__image_cheque", ` <div class="uploadText">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <h4>Upload Cheque</h4>
                  <p class="m-0">Upload a copy of cancelled cheque for above bank account</p>
                </div>`);
      handleFileSelect("#picture__input_signature", ".picture__image_signature", `<div class="uploadText">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <h4>Upload Signature</h4>
                  <p class="m-0">Sign on a blank page, take a picture and upload a high resolution copy here</p>
                </div>`);
    </script>
    
    @yield('scripts')

  </body>
</html>