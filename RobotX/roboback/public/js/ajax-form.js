(function() {

    var defaults = {

    };

    $.fn.ajaxform = function(options) {

//            console.log("OPTIONS ");

        $(this).on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var form = $(this);
            var method = $(this).attr('method');

            console.log("DATA " + data);
            console.log("OPTIONS " + JSON.stringify(options));

            $.ajax({
                type: method,
                url: url,
                data: data,
                beforeSend: function() {
                    form.find('.has-error').removeClass('has-error');
                    form.find('.help-block').remove();
                },
                success: function(response) {
                   console.log('succes ' + JSON.stringify(response));
                    if (response === "EMPTY INPUT")
                    {
                        $("#form-errors").html('<div class="alert alert-warning">No input</div>');
                    }
                    else if (response === 'DUPLICATE ENTRY')
                    {
                        $("#form-errors").html('<div class="alert alert-warning">Item(s) already selected</div>');
                    }
                    else if (response.startsWith("Exception"))
                    {
                        $("#form-errors").html('<div class="alert alert-danger">' + response + '</div>');
                    }
                    else
                    {
                        $("#form-errors").html('<div class="alert alert-success">This database has been saved!</div>');
                        if (!!options) {
                            $( location ).attr( 'href', options.index );
                        }
                    }
                    // location.reload();
                },
                error :function( jqXhr ) {
                    console.log('error ' + JSON.stringify(jqXhr));
                    if( jqXhr.status === 401 ) //redirect if not authenticated user.
                        $( location ).prop( 'pathname', 'auth/login' );
                    if( jqXhr.status === 422 ) {
                        $errors = jqXhr.responseJSON;

                        errorsHtml = '<div class="alert alert-danger">Some errors occured.';

                        console.log($errors);

                        $.each( $errors, function( key, value ) {
                            var input = form.find('input[name="'+ key +'"]');
                            var group = input.closest('.form-group');
                            group.addClass('has-error');
                            // input.after('<div class="help-block">' + value[0] + '</div>');
                            errorsHtml += '<div class="help-block">' + value[0] + '</div>';
                        });
                        errorsHtml += '</div>';

                        $( '#form-errors' ).html( errorsHtml );
                    } else {
                        alert('An unknown error occured.');
                    }
                }
            });
        });
    }
})(jQuery);