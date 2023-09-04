jQuery(document).ready(function($){
    let config = $('.filter').data('config')

    if( ! config.wrapper ){
        config.wrapper = '.posts-wrap'
    }

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
                $(config.wrapper).html(res)
            }
        })

        return false
    })

    // Adding / Removing get parameters from url

    let checkbox_values = []
    $('.filtering-form__checkbox').click(function(){
        $('.filtering-form__checkbox').each(function(){
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
            currentURL = currentURL + '?' + config.taxonomy + '%5B%5D=' + checkbox_values.join(',')
        }

        window.history.pushState({ path: currentURL }, '', currentURL)
    })

    // Infinite scroll

    if( $( '#loadmore' ) !== undefined ){
        let paged = config.paged,
        maxPages = config.max_pages

        if( config.load_type == 'button' ){
            let $loadmoreBtn = $( '#loadmore a' )

            $loadmoreBtn.click( function( event ){
                event.preventDefault()
        
                $.ajax({
                    url : c4b_localize_data.url,
                    type : 'POST',
                    data : {
                        paged: paged,
                        action: 'loadmore',
                        query_vars: c4b_localize_data.query_vars
                    },
                    beforeSend : function( xhr ){
                        $loadmoreBtn.text( 'Loading...' )
                    },
                    success : function( data ){
                        paged++
                        $(config.wrapper).append( data )
                        $loadmoreBtn.text( 'Load more' )
        
                        if( paged == maxPages ){
                            $loadmoreBtn.remove()
                        }
                    }
                })
            })
        } else {
            $(window).scroll(function(){
                let bottomOffset = 2000
        
                if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && !$('body').hasClass('loading') ){
                    $.ajax({
                        type : 'POST',
                        url : c4b_localize_data.url,
                        data : {
                            paged : paged,
                            action : 'loadmore',
                            query_vars: c4b_localize_data.query_vars
                        },
                        beforeSend : function( xhr ){
                            $('body').addClass('loading');
                        },
                        success : function(data){
                            if(data){
                                paged++
                                $(config.wrapper).append( data )
                                $('body').removeClass('loading')
                            }
                        }
                    })
                }
            })
        }
    }
})