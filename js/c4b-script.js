jQuery(document).ready(function($){
    let config = $('.filter').data('config')
    let currentQueryVars = c4b_localize_data.query_vars

    let paged = config.paged
    let maxPages = config.max_pages

    if(paged == maxPages){
        $(config.loadmore_selector).hide()
    }

    if(!config.wrapper){
        config.wrapper = '.posts-wrap'
    }

    jQuery('body').on('submit', '.form', function(e){
        e.preventDefault()

        let fd = new FormData($(this)[0])
        fd.append('action', 'c4b_filtering')
        fd.append('query_vars', c4b_localize_data.query_vars)
        fd.append('config', JSON.stringify(config))
    
        jQuery.ajax({
            url: c4b_localize_data.url,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(res){
                $(config.wrapper).html(res.html)

                currentQueryVars = res.query_vars

                paged = config.paged

                if(config.loadmore_selector !== ''){
                    if(res.paged == res.max_pages){
                        $(config.loadmore_selector).hide()
                    }else{
                        $(config.loadmore_selector).css('display','inline')
                    }
                }
            }
        })

        return false
    })

    let values = {}
    let taxonomies = config.taxonomies.split(',')

    taxonomies.forEach(function(item){
        values[item] = []
    })

    $('.filtering-form__checkbox').click(function(){
        $('.filtering-form__checkbox').each(function(){
            let currentTax = $(this).prop('name').replace(/\[|\]/g,'')
            if($(this).prop('checked') && $.inArray($(this).val(), values[currentTax]) == -1){
                values[currentTax].push($(this).val())
            }
            if(!$(this).prop('checked') && $.inArray($(this).val(), values[currentTax]) > -1){
                let i = values[currentTax].indexOf($(this).val())
                if(i >= 0){
                    values[currentTax].splice(i,1)
                }
            }
        })

        let currentURL = window.location.protocol + '//' + window.location.host + window.location.pathname

        let isEmpty = true
        for(let key in values){
            if(values[key].length > 0){
                isEmpty = false
                break
            }
        }
        if(!isEmpty){
            let dataParams = {}
            for(let key in values){
                if(values[key].length > 0){
                    dataParams[key + '[]'] = values[key].join(',')
                }
            }
            currentURL = currentURL + '?' + new URLSearchParams(dataParams).toString()
        }

        window.history.pushState({ path: currentURL }, '', currentURL)
    })

    if($('#loadmore') !== undefined){
        if(config.loadmore_selector !== ''){
            let $loadmoreBtn = $(config.loadmore_selector)

            $loadmoreBtn.click(function(event){
                event.preventDefault()
        
                $.ajax({
                    url : c4b_localize_data.url,
                    type : 'POST',
                    data : {
                        paged: paged,
                        action: 'loadmore',
                        query_vars: currentQueryVars//c4b_localize_data.query_vars
                    },
                    beforeSend : function(xhr){
                        $loadmoreBtn.text('Loading...')
                    },
                    success : function(data){
                        paged++
                        $(config.wrapper).append(data.html)

                        //currentQueryVars = data.query_vars

                        $loadmoreBtn.text('Load more')
        
                        if(paged == data.max_pages){
                            $loadmoreBtn.hide()
                        }
                    }
                })
            })
        } else {
            $(window).scroll(function(){
                let bottomOffset = 2000
        
                if($(document).scrollTop() > ($(document).height() - bottomOffset) && !$('body').hasClass('loading')){
                    $.ajax({
                        type : 'POST',
                        url : c4b_localize_data.url,
                        data : {
                            paged : paged,
                            action : 'loadmore',
                            query_vars: currentQueryVars//c4b_localize_data.query_vars
                        },
                        beforeSend : function(xhr){
                            $('body').addClass('loading');
                        },
                        success : function(data){
                            if(data){
                                paged++
                                $(config.wrapper).append(data.html)
                                $('body').removeClass('loading')
                            }
                        }
                    })
                }
            })
        }
    }
})