$(function(){
    $('.test-data').find('div:first').show();

    /* PAGINATION */

    $('.pagination a').on('click', function(){
        if($(this).attr('class') == 'nav-active') return false;
        
        var link = $(this).attr('href'); // посилання на текст вкладинки для показу
        var prevActive = $('.pagination > a.nav-active').attr('href'); // посилання на текст активної вкладинки

        $('.pagination > a.nav-active').removeClass('nav-active'); // видалення активного посилання

        $(this).addClass('nav-active') // додаємо класс активної вкладки

        $(prevActive).fadeOut(0, function(){
            $(link).fadeIn(0);
        });
        
        return false;
    });

    /* TRANSITIONS */

    $('.transition a').on('click', function(){
        //if($(this).attr('class') == 'transition-active') return false;
        
        var link = $(this).attr('href'); // посилання на текст вкладинки для показу
        var prevActive = $('.transition > a.transition-active').attr('href'); // посилання на текст активної вкладинки

        $('.transition > a.transition-active').removeClass('transition-active'); // видалення активного посилання

        $(this).addClass('transition-active') // додаємо класс активної вкладки

        /*$(prevActive).fadeOut(0, function(){
            $(link).fadeIn(0);
        });*/
        
        return false;
    });

    /*  ********** */

    $('#btn').click(function(){
        var test = +$('#test-id').text();
        var res = {'test':test};

        $('.question').each(function(){
            var id = $(this).data('id');
            res[id] = $('input[name=question-'+ id +']:checked').val();
        });
        
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: res,
            success: function(html){
                $('.content').html(html);
            },
            error: function(){
                alert('error');
            }
        });

    });

});