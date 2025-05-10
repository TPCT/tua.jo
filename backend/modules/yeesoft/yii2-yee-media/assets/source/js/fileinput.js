function mediaTinyMCE(callback, value, meta) {
    var inputId = tinymce.activeEditor.settings.id,
        modal = $('[data-btn-id="' + inputId + '-btn"]'),
        iframe = $('<iframe src="' + modal.attr("data-frame-src")
        + '?mode=modal" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="media-frame"></iframe>');

    iframe.on("load", function () {
        var modal = $(this).parents('[role="dialog"]'),
            input = $("#" + modal.attr("data-input-id"));

        $(this).contents().find(".dashboard").on("click", "#insert-btn", function (e) {
            e.preventDefault();

            var data = getFormData($(this).parents("#control-form"));

            input.trigger("fileInsert", [data]);

            callback(data.url, {alt: data.alt});

            let theModal = bootstrap.Modal.getInstance(modal);
            theModal.hide();
        });
    });

    modal.find(".modal-body").html(iframe);

    let theModal = new bootstrap.Modal($('[data-btn-id="' + inputId + '-btn"]'), {});
    theModal.show();
}

function getFormData(form) {
    var formArray = form.serializeArray(),
        modelMap = {
            'Media[alt]': 'alt',
            'Media[description]': 'description',
            url: 'url',
            id: 'id'
        },
        data = [];

    for (var i = 0; formArray.length > i; i++) {
        if (modelMap[formArray[i].name]) {
            data[modelMap[formArray[i].name]] = formArray[i].value;
        }
    }

    return data;
}

function getFormDataMulitple(form) {
    let imagesInput = $(form).find("#images-input");
    let data =[];
    data["url"] = imagesInput.attr("data-url");
    data["value"] = imagesInput.val();
    

    // var formArray = form.serializeArray();
    //     data = [];

    // for (var i = 0; formArray.length > i; i++) {
    //     if (formArray[i].name == "images") {
    //         console.log(formArray[i]);
    //         data[formArray[i].name] = formArray[i].value;
    //     }
    // }

    return data;
}

$(document).ready(function () {

    function frameHandler(e) {
        var modal = $(this).parents('[role="dialog"]'),
            imageContainer = $(modal.attr("data-image-container")),
            pasteData = modal.attr("data-paste-data"),
            input = $("#" + modal.attr("data-input-id"));
            
        $(this).contents().find(".dashboard").on("click", "#insert-btn", function (e) {
            e.preventDefault();
            
            var data = getFormData($(this).parents("#control-form"));

            input.trigger("fileInsert", [data]);

            if (imageContainer) {
                imageContainer.html('<img src="' + data.url + '" alt="' + data.alt + '">');
            }

            input.val(data[pasteData]);
        
            let theModal = bootstrap.Modal.getInstance(modal);
            theModal.hide();
        });
    }

    function frameHandlerMultiple(e) {
        var modal = $(this).parents('[role="dialog"]'),
            imageContainer = $(modal.attr("data-image-container")),
            pasteData = modal.attr("data-paste-data"),
            input = $("#" + modal.attr("data-input-id"));
            
        $(this).contents().find(".dashboard").on("click", "#insert-btn", function (e) {
            e.preventDefault();

            var data = getFormDataMulitple($(this).parents("#control-form"));
            let images = data.url.split("###");
            images.pop(); //remove last item which is empty value

            input.trigger("fileInsert", [data.images]);

            if (imageContainer) {
                imageContainer.html('');
                $(images).each(function( index, item ) {
                    console.log(item);
                    imageContainer.append('<img src="' + item + '" alt="' + item + '">');
                    //imageContainer.html('<img src="' + item + '" alt="' + item + '">');
                });
                

            }

            input.val(data.value);
            input.attr("data-url",data.url);
        
            let theModal = bootstrap.Modal.getInstance(modal);
            theModal.hide();
        });
    }

    $('[role="media-launch"]').on("click", function (e) {
        e.preventDefault();

        var modal = $('[data-btn-id="' + $(this).attr("id") + '"]'),
        iframe = $('<iframe src="' + modal.attr("data-frame-src")
        + '?mode=modal" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="media-frame"></iframe>');

        iframe.on("load", frameHandler);
        modal.find(".modal-body").html(iframe);
        
        let theModal = new bootstrap.Modal($('[data-btn-id="' + $(this).attr("id") + '"]'), {});
        theModal.show();
    });

    $('[role="media-launch-multiple"]').on("click", function (e) {
        e.preventDefault();

        var modal = $('[data-btn-id="' + $(this).attr("id") + '"]'),
        iframe = $('<iframe src="' + modal.attr("data-frame-src")
        + '?mode=modal&&multiple=1" id="' + modal.attr("data-frame-id") + '" frameborder="0" role="media-frame"></iframe>');

        iframe.on("load", frameHandlerMultiple);
        modal.find(".modal-body").html(iframe);

        let theModal = new bootstrap.Modal($('[data-btn-id="' + $(this).attr("id") + '"]'), {});
        theModal.show();

    });

    $('[role="clear-input"]').on("click", function (e) {
        e.preventDefault();

        $("#" + $(this).attr("data-clear-element-id")).val("");
        $($(this).attr("data-image-container")).empty();
    });
});