$('.oneToTw').mouseover(function(){
        $('.oneToTwEl').addClass('__select');
    });

    $('.oneToTw').mouseout(function(){
        $('.oneToTwEl').removeClass('__select');
    });
    $('.thrtToTf').mouseover(function(){
        $('.thrtToTfEl').addClass('__select');
    });

    $('.thrtToTf').mouseout(function(){
        $('.thrtToTfEl').removeClass('__select');
    });

    $('.twfToTs').mouseover(function(){
        $('.twfToTsEl').addClass('__select');
    });

    $('.twfToTs').mouseout(function(){
        $('.twfToTsEl').removeClass('__select');
    });

    $('.oneToEt').mouseover(function(){
        $('.oneToEtEl').addClass('__select');
    });

    $('.oneToEt').mouseout(function(){
        $('.oneToEtEl').removeClass('__select');
    });

    $('.nineteenTtsix').mouseover(function(){
        $('.nineteenTtsixEl').addClass('__select');
    });

    $('.nineteenTtsix').mouseout(function(){
        $('.nineteenTtsixEl').removeClass('__select');
    });

    $('.even').mouseover(function(){
        $('.evenEl').addClass('__select');
    });

    $('.even').mouseout(function(){
        $('.evenEl').removeClass('__select');
    });

    $('.odd').mouseover(function(){
        $('.oddEl').addClass('__select');
    });

    $('.odd').mouseout(function(){
        $('.oddEl').removeClass('__select');
    });

    $('.red').mouseover(function(){
        $('.redEl').addClass('__select');
    });

    $('.red').mouseout(function(){
        $('.redEl').removeClass('__select');
    });

    $('.black').mouseover(function(){
        $('.blackEl').addClass('__select');
    });

    $('.black').mouseout(function(){
        $('.blackEl').removeClass('__select');
    });

    $('.twByOne1').mouseover(function(){
        $(this).parents('tr').find('td').addClass('__select');
        $(this).parents('tr').find('.zero').removeClass('__select');
        $(this).removeClass('__select');
    });

    $('.twByOne1').mouseout(function(){
        $(this).parents('tr').find('td').removeClass('__select');
    });

    $('.twByOne2').mouseover(function(){
        $(this).parents('tr').find('td').addClass('__select');
        $(this).removeClass('__select');
    });

    $('.twByOne2').mouseout(function(){
        $(this).parents('tr').find('td').removeClass('__select');
    });

    $('.twByOne3').mouseover(function(){
        $(this).parents('tr').find('td').addClass('__select');
        $(this).removeClass('__select');
    });

    $('.twByOne3').mouseout(function(){
        $(this).parents('tr').find('td').removeClass('__select');
    });



    //Click
    $('td').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
        }
        $(this).addClass('selected');
    });


    $('.oneToTw').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $('.oneToTwEl').addClass('selected one');
        $(this).find('input[type=hidden]').attr('name','btn122');
        bonus(12);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });
    $('.thrtToTf').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $('.thrtToTfEl').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btn1324');
        bonus(12);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });


    $('.twfToTs').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $('.twfToTsEl').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btn2536');
        bonus(12);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });

    $('.oneToEt').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $('.oneToEtEl').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btn118');
        bonus(18);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });

    $('.nineteenTtsix').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected')
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $(this).find('input[type=hidden]').attr('name','btn119');
        $('.nineteenTtsixEl').addClass('selected');
        bonus(18);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });

 
    $('.even').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $(this).find('input[type=hidden]').attr('name','btneven');
        $('.evenEl').addClass('selected');
        bonus(18);
        calcul(($('.bon').val()),$('input[name=invest]').val())
   
    });

    $('.odd').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $('.oddEl').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btnodd');
        bonus(18);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });

    $('.red').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $('.redEl').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btnred');
        bonus(18);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });

    $('.black').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $('.blackEl').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btnblack');
        bonus(18);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });

    $('.twByOne1').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $(this).parents('tr').find('td').addClass('selected');
        $(this).parents('tr').find('.zero').removeClass('selected');
        $(this).find('input[type=hidden]').attr('name','btn211');
        bonus(12);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });


    $('.twByOne2').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $(this).parents('tr').find('td').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btn212');
        bonus(12);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });


    $('.twByOne3').click(function(){
        if ($('td').hasClass('selected')) {
            $('td').removeClass('selected');
            $('td').find('input[type=hidden]').removeAttr('name');
        }
        $(this).parents('tr').find('td').addClass('selected');
        $(this).find('input[type=hidden]').attr('name','btn213');
        bonus(12);
        calcul(($('.bon').val()),$('input[name=invest]').val())
    });

    $('td').click(function(){
        $('input[name=choose]').val('1');
        if ($(this).text() == 0) {
            $('td').find('input[type=hidden]').removeAttr('name');
            $('input[name=choose]').val('');
            $('.bon').val(0);
            calcul(($('.bon').val()),$('input[name=invest]').val())
        }
        var vall = $(this).text();
        if (vall > 0 && vall < 37) {
            $('input[name=numbers]').val(vall);
            bonus(1);
            calcul(($('.bon').val()),$('input[name=invest]').val())
        }else{
            $('input[name=numbers]').val(' ');
            $(this).removeClass('selected');
        }
    });

$('input[name=invest]').on('input',function(){
    calcul(($('.bon').val()),$(this).val())
});

function calcul(perc,inv){
    var winAmo = perc * inv;
    $('.winAmo').val(winAmo.toFixed(2));
}