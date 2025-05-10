<div
                      class="share-button-section1   align-items-center d-flex justify-content-start position-relative">
                      <div class="share-btn1" id="share">
                        <a class="secondary-share-btn">
                          <svg width="18" height="21" viewBox="0 0 18 21" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M17.2712 17.1491C17.2713 17.6417 17.1635 18.1283 16.9554 18.5749C16.7474 19.0214 16.4441 19.417 16.067 19.7338C15.6898 20.0506 15.2478 20.2811 14.7721 20.4089C14.2963 20.5367 13.7984 20.5589 13.3132 20.4738C12.828 20.3887 12.3673 20.1984 11.9635 19.9163C11.5596 19.6342 11.2224 19.2672 10.9756 18.8409C10.7287 18.4146 10.5782 17.9395 10.5345 17.4488C10.4908 16.9581 10.5551 16.4638 10.7228 16.0007L5.754 12.8085C5.27945 13.274 4.678 13.5889 4.02511 13.7139C3.37222 13.8389 2.69697 13.7683 2.08406 13.5109C1.47115 13.2536 0.947884 12.821 0.579906 12.2674C0.211928 11.7138 0.015625 11.0638 0.015625 10.3991C0.015625 9.73435 0.211928 9.08441 0.579906 8.53081C0.947884 7.97721 1.47115 7.5446 2.08406 7.28726C2.69697 7.02992 3.37222 6.9593 4.02511 7.08427C4.678 7.20924 5.27945 7.52423 5.754 7.98972L10.7228 4.80222C10.4382 4.02039 10.4517 3.16113 10.7607 2.38864C11.0697 1.61614 11.6525 0.98458 12.3977 0.614623C13.1429 0.244665 13.9983 0.162256 14.8005 0.383141C15.6026 0.604026 16.2952 1.11272 16.746 1.81202C17.1968 2.51131 17.3741 3.35218 17.2441 4.17396C17.114 4.99573 16.6858 5.74078 16.0411 6.26674C15.3965 6.7927 14.5806 7.06271 13.7495 7.02515C12.9183 6.98759 12.1302 6.64512 11.5356 6.06316L6.56681 9.25535C6.83535 9.99742 6.83535 10.8101 6.56681 11.5522L11.5356 14.7444C12.01 14.2801 12.6107 13.966 13.2627 13.8415C13.9147 13.7169 14.589 13.7873 15.2011 14.044C15.8133 14.3006 16.3362 14.7321 16.7044 15.2844C17.0726 15.8367 17.2697 16.4853 17.2712 17.1491Z"
                              fill="#FAFAFA" />
                          </svg>
                        </a>
                      </div>
                      <div class="share-overlay1 align-items-center gap-2" id="share-overlay1">
                        <div id="close" class="secondary-share-btn">
                          <i class="fa-solid fa-xmark"></i>
                        </div>
                        <div class="share-container">
                          <a href="#" id="copy-link-box" data-slug="<?= $url ?>" ><i class="fa-regular fa-copy"></i></a>
                          <a href="#" id="twitter-box" data-slug="<?= $url ?>" ><i class="fa-brands fa-x-twitter"></i></a>
                          <a href="#" id="whatsapp-box" data-slug="<?= $url ?>" ><i class="fa-brands fa-whatsapp"></i></a>
                          <a href="#" id="facebook-box" data-slug="<?= $url ?>" ><i class="fa-brands fa-facebook"></i></a>
                        </div>
                      </div>
                    </div>

                       
<?php
$this->registerJsVar('inner_url', $url);
    $script = <<< JS
    $(document).ready(function () {

      $(document).on("click", "#whatsapp-box", function(event) {
    event.preventDefault();
   
    const url = window.location.href; 
    const Inner_url = $(this).attr('data-slug'); 
  
    const totalUrl = url + "/" + Inner_url;
    
    const text = "Check this out!"; 
    window.open('https://wa.me/?text=' + encodeURIComponent(text) + '%20' + encodeURIComponent(totalUrl), '_blank');
  });


  $(document).on("click", "#twitter-box", function(event) {
    event.preventDefault();

    const url = window.location.href; 
    const Inner_url = $(this).attr('data-slug'); 
    const totalUrl = url + "/" + Inner_url;
   
    const text = "Check this out!"; 
    window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(totalUrl), '_blank');
  });



  $(document).on("click", "#facebook-box", function(event) {
    event.preventDefault();
    const url = window.location.href; 
    const Inner_url = $(this).attr('data-slug'); 
    const totalUrl = url + "/" + Inner_url;
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(totalUrl), '_blank');
  });

  $(document).on("click", "#copy-link-box", function(event) {
    event.preventDefault();
    const url = window.location.href; 
    const Inner_url = $(this).attr('data-slug'); 
    const totalUrl = url + "/" + Inner_url;
    navigator.clipboard.writeText(totalUrl).then(() => {
      alert('Link copied to clipboard!'); 
    });
  });
  

    });
JS;
$this->registerJs($script);
?>
