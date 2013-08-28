<!--Стили приведены в качестве примера.
ВАЖНО!!! Изначально кнопка скрыта - display: none
-->
 <style>
 .get-size-btn {
    position: absolute;
    top: 161px;
    left: 130px;
    display: none;    
 }
 </style>

<!--Кнопка-->
<input class="get-size-btn" type="image" src="http://www.astrafit.com.ua/static/img/widget_ru.png" name="image" width="125" height="50" onclick="PopupWindowCenter('http://www.astrafit.com.ua/register/index?code=<?php echo $p['code'][0]?>', 'PopupWindowCenter',1250,620); return false;">
<!--Кнопка end-->

<script>
    //В приведенном примере переменная $code - содержит уникальный код изделия (это НЕ id)
    //Скрипт отправляет уникальный код изделия на сервер AstraFit, где происходит его проверка на предмет готовности
    //(наличие всех размеров изделия, фотографии, описание прочие необходимые данные).
    //Если изделие готово, скрипт возвращает код 1 и на странице изделия появляется кнопка (см. jsonpCallback),
    //В противном случае кнопка остается скрытой (потому важно, чтобы кнопка была изначально скрыта). 
    $.ajax({
      dataType: 'jsonp',
      data: 'code=<?php echo $code; ?>',
      url: 'http://www.astrafit.com.ua/api/getStatus',
      jsonpCallback: 'jsonpCallback',
      success: jsonpCallback,
      error: function(e) {
         console.log(e.message);
      }      
    });

    //СallBack функция
    //код 1 - изделие готово. Кнопка появляется
    //Любой другой код скроет кнопку.
    function jsonpCallback(response) {
        console.log('response.state: ' + response.state);
        if(response.state==1) {
            $('.get-size-btn').fadeIn('slow');
        } else {
            $('.get-size-btn').hide();
        }
    }

    //Открывает поп-ап окно и позиционирует его по центру экрана
    function PopupWindowCenter(URL, title,w,h)
    {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2)-50;
        var newWin = window.open (URL, title, 'toolbar=no, location=no,directories=no, menubar=no, status=no, scrollbars=yes, resizable=0,copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    }    
</script>