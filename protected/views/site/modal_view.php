<div id="Modal_invite" class="forma_modal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="document.getElementById('wrapper_hide').style.display='block';"></button>
    </div>
    <div class="modal-body">
        <div class="modal_blue_wrapper">
            <div class="modal_top_blue_line"></div>
            <div class="modal_middle_blue_line">
                <p class="modal_slogan">Присоедининяйтесь к нам</p>
                <p class="modal_phone">+3(050)611-94-63</p>
                <form>
                    <fieldset>
                        <input name="name" onblur="if(this.value == '') {this.value = 'Ваше имя'; this.style.color = '#777';}" onfocus="if(this.value == 'Ваше имя') {this.value = ''; this.style.color = '#000';}" style="color: #777;" type="text" value="Ваше имя">
                        <input name="company" onblur="if(this.value == '') {this.value = 'Название компании'; this.style.color = '#777';}" onfocus="if(this.value == 'Название компании') {this.value = ''; this.style.color = '#000';}" style="color: #777;" type="text" value="Название компании">
                        <input name="link" onblur="if(this.value == '') {this.value = 'Ссылка на сайт магазина'; this.style.color = '#777';}" onfocus="if(this.value == 'Ссылка на сайт магазина') {this.value = ''; this.style.color = '#000';}" style="color: #777;" type="text" value="Ссылка на сайт магазина">
                        <input name="phone" onblur="if(this.value == '') {this.value = 'Телефон для обратной связи'; this.style.color = '#777';}" onfocus="if(this.value == 'Телефон для обратной связи') {this.value = ''; this.style.color = '#000';}" style="color: #777;" type="text" value="Телефон для обратной связи">
                        <input name="mail" onblur="if(this.value == '') {this.value = 'Ваш e-mail'; this.style.color = '#777';}" onfocus="if(this.value == 'Ваш e-mail') {this.value = ''; this.style.color = '#000';}" style="color: #777;" type="text" value="Ваш e-mail">
                        <textarea rows="5"></textarea>
                        <a href="#" type="submit" class="green_repeat_btn send_modal">Присоединиться</a>
                    </fieldset>
                </form>
            </div>
            <div class="modal_bottom_blue_line"></div>
        </div>
    </div>
</div>