$(document).ready(function ($) {


    /* DatePicker Issue Fixing for DynamicForm */
    window.initSelect2Loading = function(id, optVar){
        initS2Loading(id, optVar)
    };
    window.initSelect2DropStyle = function(id, kvClose, ev){
        initS2Loading(id, kvClose, ev)
    };
    $(".dynamicform_wrapper").on('afterInsert', function(e, item) {
        var datePickers = $(this).find('[data-krajee-kvdatepicker]');
        datePickers.each(function(index, el) {
            $(this).parent().removeData().kvDatepicker('initDPRemove');
            $(this).parent().kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
        });
    });
    /* DatePicker Issue Fixing for DynamicForm */

    $(".remove-filter_item_c").on("click", function (e, item) {
        // if (!confirm("Are you sure you want to delete this item?")) {
        //     return false;
        // }
        // var pk = $(this).attr('pk');
        var pk_parent_id = $(this).attr('pk_parent_id');
        var item = $('.filter_item_c[pk=' + pk_parent_id +']');
        // console.log(item);
        // $('<input />').attr('type', 'hidden')
        //     .attr('name', "deleteFilter[]")
        //     .attr('value', pk)
        //     .appendTo('#places-form');
        // $('<input />').attr('type', 'hidden')
        //     .attr('name', "deleteSubSector[]")
        //     .attr('value', pk_subsector)
        //     .appendTo('#places-form');
        item.remove();
        // return true;
    });

    $('#compare_user').on('click', function () {

        var favorite = [];
        $.each($("input[name='selection[]']:checked"), function(){
            favorite.push($(this).val());
        });

        if(favorite.length < 2) {
            alert('You should select at least 2 users ')
            return false;
        }
        $.redirect("/career/default/compare-user", {'users' : favorite.join('|')}, 'get');
        return false;
    });


    $("select.form-control").addClass("form-select");
    
    $(".for-img").each(function(){
        let img = $(this).val();
        if(img.length == 0){
            $(this).parent().prev().html('');
        }
        else{
            $(this).parent().prev().html('<img src="' + img + '" />');
        }
    });

    $(document).on("click",".language-pills a",function(){
        $(".for-img").each(function(){
            let img = $(this).val();
            if(img.length == 0){
                $(this).parent().prev().html('');
            }
            else{
                $(this).parent().prev().html('<img src="' + img + '" />');
            }
        });
    });

    $(document).on("change",".for-img",function(){
        let img = $(this).val();
        if(img.length == 0){
            $(this).parent().prev().html('');
        }
        else{
            $(this).parent().prev().html('<img src="' + img + '" />');
        }
    });

    $(document).on("click",".submit-modal-form",function(){
        console.log("aa");
        $(this).parents(".modal-footer").prev().find(".modal-form").submit();
    });

    $(document).on("submit",".modal-form",function(e)
    {
        $(this).find("[type='submit']").attr("disabled","disabled");
        e.preventDefault();
        e.stopPropagation();
        let url = $(this).attr('action');
        var form = $(this)[0];
        var formData = new FormData(form);

        $.ajax
        ({
            type: 'POST',
            url: url,
            method: 'post',
            data: formData,
            dataType:'json',
            contentType: false,
            processData: false,
            success: function (data) 
            {
                console.log(data);
                if(data.success == "success")
                {
                    form.reset();
                    swal
                    ({
                        title: data.message,
                        icon: "success",
                        buttons: false,
                        timer: 1500,
                    });
                    $("#close-modal").click();
                    $(form).find("[type='submit']").removeAttr("disabled");
                    location.reload();

                }
                else
                {
                    console.log(data.errors);
                    $.each(data.errors, function (key, value) 
                    {
                        console.log(key);
                        console.log(value);
                        $('[name="' + data.model+"[" + key +"]"+ '"]').removeClass("is-valid");
                        $('[name="' + data.model+"[" + key +"]"+ '"]').parent().removeClass("has-success");
                        
                        $('[name="' + data.model+"[" + key +"]"+ '"]').addClass("is-invalid");
                        $('[name="' + data.model+"[" + key +"]"+ '"]').parent().addClass("has-error");

                        $('[name="' + data.model+"[" + key +"]"+ '"]').next().html(value);

                    });
                    $(form).find("[type='submit']").removeAttr("disabled");
                }
                
            }
        });

    });





    
    $(document).on("submit",".ajax-form",function(e)
    {
        e.preventDefault();
        let section = $(this).attr('data-section');
        let contanier = $(this).attr("data-contanier");
        let url = $(this).attr('action');
        var form = $(this)[0];
        var formData = new FormData(form);
        $.ajax
        ({
            type: 'POST',
            url: url,
            method: 'post',
            data: formData,
            dataType:'json',
            contentType: false,
            processData: false,
            success: function (data) 
            {
                console.log(data);
                if(data.success == "success")
                {
                    console.log(data.message);
                    form.reset();
                    swal
                    ({
                        title: data.message,
                        icon: "success",
                        buttons: false,
                        timer: 1500,
                    });

                    $('.btn-close').trigger('click');
                    $(section).load(location.href + " " + contanier, function() {
                        $(".sortable").sortable({
                            update: function(event, ui) {
                    
                                let newWeight = ui.item.index() + 1; 
                                let form = ui.item.attr("data-form");
                    
                                $(form).find(".weight").val(newWeight);
                                $(form).submit();
                    
                            },
                        });

                    });



                    
                }
                else
                {
                    console.log(data);
                    console.log(data.errors);
                    $.each(data.errors, function (key, value) 
                    {
                        console.log(key);
                        console.log(value);
                        $('[name="' + data.model+"[" + key +"]"+ '"]').removeClass("is-valid");
                        $('[name="' + data.model+"[" + key +"]"+ '"]').parent().removeClass("has-success");
                        
                        $('[name="' + data.model+"[" + key +"]"+ '"]').addClass("is-invalid");
                        $('[name="' + data.model+"[" + key +"]"+ '"]').parent().addClass("has-error");

                        $('[name="' + data.model+"[" + key +"]"+ '"]').next().html(value);

                    });
                }
            },
            fail: function (data) 
            {
                console.log(data);
                console.log(data.errors);
                $.each(data.errors, function (key, value) 
                {
                    console.log(key);
                    console.log(value);
                    $('[name="' + data.model+"[" + key +"]"+ '"]').removeClass("is-valid");
                    $('[name="' + data.model+"[" + key +"]"+ '"]').parent().removeClass("has-success");
                    
                    $('[name="' + data.model+"[" + key +"]"+ '"]').addClass("is-invalid");
                    $('[name="' + data.model+"[" + key +"]"+ '"]').parent().addClass("has-error");

                    $('[name="' + data.model+"[" + key +"]"+ '"]').next().html(value);

                });

            }
        });
        
       
    });


    $(document).on("click",".delete-ajax",function(e){

        e.preventDefault();
        let url = $(this).attr('href');
        let section = $(this).attr('data-section');
        let contanier = $(this).attr("data-contanier");


        swal({
			  title: "Are You Sure You Want To Delete this Item?",
			  icon: "warning",
			  buttons:  ["Cancel", "Ok"],
			  dangerMode: true,
			})
			.then((willDelete) => 
			{
			  if (willDelete) 
			  {
                $.ajax
                ({
                    type: 'POST',
                    url: url,
                    method: 'post',
                    data: [],
                    dataType:'json',
                    contentType: false,
                    processData: false,
                    success: function (data) 
                    {
                        console.log(data);
                        if(data.success == "success")
                        {
                            console.log(data.message);
                            swal
                            ({
                                title: data.message,
                                icon: "success",
                                buttons: false,
                                timer: 1500,
                            });
        
                
                            $(section).load(location.href + " " + contanier, function() {
                                $(".sortable").sortable({
                                    update: function(event, ui) {
                                        let newWeight = ui.item.index() + 1; 
                                        let form = ui.item.attr("data-form");
                            
                                        $(form).find(".weight").val(newWeight);
                                        $(form).submit();

                                    },
                                });
                            });
                    
                        }
                        else
                        {
                            console.log(data);
                            console.log(data.errors);
                            
                        }
                    },
                    fail: function (data) 
                    {
                        console.log(data);
                        console.log(data.errors);
                        
        
                    }
                });
			  }
			  else 
			  {
				swal("Your Item is safe",{
                    buttons: false,
                    timer: 1000,
                });
			  }

			});



        

    });



});

