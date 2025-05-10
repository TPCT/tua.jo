

  function ajaxRequest(type,url,data,processData,contentType)
  {
      var results;
      $.ajax
        ({
            type: type,
            url: url,
            dataType: 'json',
            data: data,
            async:false, //stop untill the ajax request done
            processData: processData,
            contentType: contentType,
            success: function (data)
            {
              results = data;
              
            },
            error:function(data)
            {
              results = data;
            }
        });
      // console.log(results);
      return results;
  }

  $(document).on("click", "#whatsapp", function(event) {
    event.preventDefault();
    const url = window.location.href; 
    const text = "Check this out!"; 
    window.open('https://wa.me/?text=' + encodeURIComponent(text) + '%20' + encodeURIComponent(url), '_blank');
  });


  $(document).on("click", "#twitter", function(event) {
    event.preventDefault();
    const url = window.location.href; 
    const text = "Check this out!"; 
    window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(url), '_blank');
  });

  $(document).on("click", "#linkedin", function(event) {
    event.preventDefault();
    const url = window.location.href; 
    window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(url), '_blank');
  });

  $(document).on("click", "#facebook", function(event) {
    event.preventDefault();
    const url = window.location.href; 
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank');
  });

  $(document).on("click", "#copy-link", function(event) {
    event.preventDefault();
    const url = window.location.href; 
    navigator.clipboard.writeText(url).then(() => {
      alert('Link copied to clipboard!'); 
    });
  });
  

  $(document).on("click",".by-ajax a",function(event)
  {
      event.preventDefault();
      var section = $(this).parents(".by-ajax").attr("data-section");
      var container = $(this).parents(".by-ajax").attr("data-container");
      let href = $(this).attr("href");
      let page = href.split('?')[1];


      let newUrl =  window.location.href.split('?')[0];

          newUrl = newUrl + "?" + page;
          encodeURIComponent(newUrl);
          $(section).load(newUrl + " " + container, function() {
              $('html, body').animate({
                  scrollTop: $(".ajax-scroll-filter").offset().top
              }, 500); // 500ms for smooth scrolling
          });

          history.pushState(null, "", newUrl);


      $(section).load(window.location.href + "?" + page + " " + container, function() {
        $('html, body').animate({
            scrollTop: $(".ajax-scroll-filter").offset().top
        }, 500); // 500ms for smooth scrolling
    });
  });

  $(document).on("submit", ".module-search-post", function(e){
      e.preventDefault();

      let formFields = $(this).find(':input, select.select2, select');
      var fieldWithValue = "";
      formFields.each(function() {
          if($(this).attr('name') != "_csrf" && $(this).val() && !$(this).attr("disabled") && $(this).attr('data-url-name') != undefined )
          {
            let value = $(this).val();
            let filteredValue = value.replace(/[^a-zA-Z0-9\u0600-\u06FF\s_-]/g, '');
            console.log(value, filteredValue);
            fieldWithValue += $(this).attr('data-url-name') + '/' + filteredValue + "/";
          }
      });

      fieldWithValue = fieldWithValue.slice(0, -1);
      
      let lang = $("html").attr("lang");
      let model = $(this).attr("data-model");
      let url = window.location.protocol +"//"+ window.location.hostname+"/"+lang+"/"+model;
      url += fieldWithValue? '/search/'+fieldWithValue : '';
      window.location.href = url;
  });


//   document.addEventListener("DOMContentLoaded", function () {
//     document.querySelectorAll('.custom-file-upload').forEach(container => {
   
//         const fileNameDisplay = container.querySelector('.file-name-display');

//         if (fileInput && fileNameDisplay) {

//         }
//     });
// });

const fileInput = document.querySelector('.custom-file-input');
const result = document.querySelector('.file-name-display');

if(fileInput)
{
  fileInput.addEventListener('change', function () {

    const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : '';
    result.textContent  = fileName || "No file chosen";
  });
}


$(document).ready(function () {

  $("#overlay").fadeOut();

  $(document).ajaxStart(function() {
      $("#overlay").fadeIn();
  }).ajaxComplete(function() {
      $("#overlay").fadeOut();
  });

  $(document).on("change",".select-module-post",function(){
      $(".module-search-post-ajax").submit();
  });

  $(document).on("submit",".module-search-post-ajax",function(e)
  {
      $(this).find("[type='submit']").attr("disabled","disabled");
      e.preventDefault();
      let section = $(this).attr('data-section');
      let container = $(this).attr('data-contanier');
      let url = $(this).attr('action');
      let form = $(this)[0];
      let formData = new FormData(form);
      let response = ajaxRequest("post", url, formData, false,false);
      response = response.responseText;
      let sectionContent = $(response).find(container);
      $(section).html(sectionContent);
      $(form).find("[type='submit']").removeAttr("disabled");

  });

  $(document).on("click",".reset-fields",function(e)
  {
    e.preventDefault();
    let form = $(this).parents("form");
    $(form).find("input").val(null);
    $(form).find("select").val(null);
    $(form).submit();
  });
  
});

$(document).on("change",".input-submit",function(){

  $(this).closest('form').submit();
});

$(document).ready(function() {
  $('#cv').change(function(e) {
    var fileName = e.target.files[0]?.name || 'No file selected';
    $('.file-name-display').text(fileName);
  });
});

        /**  newslatter */
        $(document).on("click","#newsletter-submit-btn",function(event){
          event.preventDefault();
          event.stopImmediatePropagation();
          $("#newsletter-form").submit();
      });
      $(document).on("submit","#newsletter-form",function (event) 
      {
          /* stop the form from submitting the normal way and refreshing the page */
          event.preventDefault();
          event.stopImmediatePropagation();
          
          $("#newsletter-form .alert").remove(); /* remove the error text */

          /* get the form data */
          /* there are many ways to get this data using jQuery (you can use the class or id also) */
          var formData = {
              "email": $("input[name=email]").val(),
              "_csrf": $("input[name=_csrf]").val()
          };

          $("#newsletter-submit-btn").attr("disabled", "disabled");
          $("#newsletter-submit-btn").addClass("loading-pointer");
          var text = $("#newsletter-submit-btn").html();
          /**  $("#newsletter-submit-btn").html("<img width='32' height='32' src='/images/ajax-loader.gif'>"); */


          /* process the form */
          $.ajax({
              type: "POST", /* define the type of HTTP verb we want to use (POST for our form) */
              url: $(this).attr("action"), /* the url where we want to POST */
              data: formData, /*  our data object */
              dataType: "json", /* what type of data do we expect back from the server */
              encode: true
          })
          /* using the done promise callback */
          .done(function (data) {

              console.log(data);
          
              $("#newsletter-submit-btn").removeAttr("disabled");
              $("#newsletter-submit-btn").removeClass("loading-pointer");

              $("#newsletter-submit-btn").html(text);

              if (!data.success) 
              {
                  /* handle errors for **/
                  if (data.errors) 
                  {
                      $.each(data.errors, function (key, value) 
                      {
                          $('#newsletter-form').append('<div class="alert alert-danger mt-3">' + value + '</div>');
                      });

                  }

              } 
              else 
              {
                  /* ALL GOOD! just show the success message! */
                  $("#newsletter-form").append('<div class="alert alert-success mt-3">' + data.message + '</div>');
                  $('#newsletter-email').val('');
              }
          });
          

      });


$('.repeater').repeater({
  // (Optional)
  // start with an empty list of repeaters. Set your first (and only)
  // "data-repeater-item" with style="display:none;" and pass the
  // following configuration flag
  initEmpty: false,
  // (Optional)
  // "defaultValues" sets the values of added items.  The keys of
  // defaultValues refer to the value of the input's name attribute.
  // If a default value is not specified for an input, then it will
  // have its value cleared.
  defaultValues: {
      'text-input': ''
  },
  // (Optional)
  // "show" is called just after an item is added.  The item is hidden
  // at this point.  If a show callback is not given the item will
  // have $(this).show() called on it.
  show: function () {
      $(this).slideDown();
  },
  // (Optional)
  // "hide" is called when a user clicks on a data-repeater-delete
  // element.  The item is still visible.  "hide" is passed a function
  // as its first argument which will properly remove the item.
  // "hide" allows for a confirmation step, to send a delete request
  // to the server, etc.  If a hide callback is not given the item
  // will be deleted.
  hide: function (deleteElement) {
      if(confirm('Are you sure you want to delete this element?')) {
          $(this).slideUp(deleteElement);
      }
  },
  // (Optional)
  // Removes the delete button from the first list item,
  // defaults to false.
  isFirstItemUndeletable: true
})




