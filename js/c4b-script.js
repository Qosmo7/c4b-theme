jQuery(document).ready(function($){
    jQuery( 'body' ).on('submit', '.form', function(e){
        e.preventDefault()

        let fd = new FormData( $(this)[0] )
        fd.append( 'action', 'c4b_filtering' )
        fd.append( 'query_vars', c4b_localize_data.query_vars )
    
        jQuery.ajax({
            url: c4b_localize_data.url,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(res){
                $('.posts-wrap').html(res)
            }
        })

        return false
    })

    let checkbox_values = []
    let tax_name = $('input[name="tax_name"]').val()
    $('.difficulty-form__checkbox').click(function(){
        $('.difficulty-form__checkbox').each(function(){
            if( $(this).prop('checked') && $.inArray( $(this).val(), checkbox_values ) == -1 ){
                checkbox_values.push( $(this).val() )
            }
            if( ! $(this).prop('checked') && $.inArray( $(this).val(), checkbox_values ) > -1 ){
                let i = checkbox_values.indexOf( $(this).val() )
                if( i >= 0 ){
                    checkbox_values.splice(i,1)
                }
            }
        })

        let currentURL = window.location.protocol + '//' + window.location.host + window.location.pathname

        if( checkbox_values.length > 0 ){
            currentURL = currentURL + '?' + tax_name + '%5B%5D=' + checkbox_values.join(',')
        }

        window.history.pushState({ path: currentURL }, '', currentURL)
    })
})