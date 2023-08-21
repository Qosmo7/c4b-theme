jQuery(document).ready(function($){
    jQuery( 'body' ).on('submit', 'form', function(e){
        e.preventDefault()

        let fd = new FormData( $(this)[0] )
        fd.append( 'action', 'c4b_filtering' )

        let parsedQuery = JSON.parse(c4b_localize_data.query)
        if( parsedQuery.taxonomy !== undefined ){
            fd.append( 'taxonomy', parsedQuery.taxonomy )
            fd.append( 'term_name', parsedQuery.name )
        }
    
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
})