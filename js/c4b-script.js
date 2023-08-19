jQuery(document).ready(function($){
    jQuery( 'body' ).on('submit', 'form', function(e){
        e.preventDefault()

        let fd = new FormData( $(this)[0] )
        fd.append( 'action', 'c4b_filtering' )
    
        jQuery.ajax({
            url: c4b_ajax.url,
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
})