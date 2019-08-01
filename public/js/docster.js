$(function(){
    // begin::jQuery extend for PUT and DELETE
    jQuery.each( [ "put", "delete" ], function( i, method ) {
        jQuery[ method ] = function( url, data, callback, type ) {
            if ( jQuery.isFunction( data ) ) {
                type = type || callback;
                callback = data;
                data = undefined;
            }

            if(data == null){
                data = {
                    _method: method.toUpperCase()
                };
            } else {
                data._method = method.toUpperCase();
            }

            return jQuery.ajax({
                url: url,
                type: method,
                dataType: type,
                data: data,
                success: callback
            });
        };
    });

    // end::jQuery extend for PUT and DELETE
    // begin::ajax token support
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // end::ajax token support
    // begin::redirects
    $("[data-action='redirect']").click(function(){
        var element = $(this);
        window.location = element.data("href");
    });

    // end::redirects
    // begin::destroying, updating, creating on the fly
    $("[data-action='destroy']").click(function(){
        var model = $(this).data('target');
        var id = $(this).data('id');

        if(model != null && id != null){
            $.delete(`/${model}/${id}`);
            $(`[data-id=${id}][data-model=${model}],#${id}[data-model=${model}]`).remove();
        }
    });
    // end::destroying, updating, creating on the fly
});