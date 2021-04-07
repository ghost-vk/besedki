<?php global $home_page_id; ?>
<div class="callback" id="callbackForm">
    <?php
    $background_image = get_stylesheet_directory_uri() . '/img/picture/callback_bg.jpg';
    if ( is_mobile() ) {
        $background_image = get_stylesheet_directory_uri() . '/img/picture/callback_bg_mobile.jpg';
    }
    ?>
    <style>
        .callback {
            background: center / cover url("<?= $background_image ?>");
            background: linear-gradient(360deg, #FFFFFF 0%, rgba(255, 255, 255, 0) 100%), center / cover url("<?= $background_image ?>");
        }
    </style>
	<div class="container">
		<div class="callback__row">
			<div class="callback__input name">
				<input type="text" placeholder="Ваше имя" />
				<span class="callback__error inputError no-select">!Введите ваше имя</span>
			</div>
			<div class="callback__input phone">
				<input type="text" placeholder="Ваш номер телефона" />
				<span class="callback__error inputError no-select">!Введите номер телефона</span>
			</div>
			<div class="callback__btn">
				<button class="blueBtn">Перезвоните мне</button>
			</div>
			<div class="callback__check">
                <div class="callback__box">
                    <svg class="callback__v" id="callbackV" width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.0757 0.852963C11.8365 0.582541 11.4485 0.582541 11.2092 0.852963L3.86792 9.14865L1.04606 5.95996C0.806773 5.68954 0.418819 5.68956 0.179484 5.95996C-0.0598279 6.23035 -0.0598279 6.66874 0.179484 6.93916L3.43463 10.6174C3.67384 10.8878 4.06208 10.8876 4.3012 10.6174L12.0757 1.83219C12.3151 1.5618 12.315 1.12339 12.0757 0.852963Z" fill="#152352"/>
                    </svg>
                    <input type="checkbox" />
                    <span class="callback__error inputError no-select">!Это обязательно</span>
                </div>
				<p class="mainText-2">Подтверждаю правильность ввода данных и даю согласие на <a class="mainText-2" href="<?php echo home_url('/user-agreement'); ?>">обработку персональных данных</a>.</p>
			</div>
		</div>
	</div>
</div>

<!--  RESPONSE  -->
<div class="modal modal-response" id="callbackModal">
    <div class="modal__window lightBg no-opacity">
        <div class="modal__close">
            <div class="closeBtn"></div>
        </div>
        <div class="modal__body">
            <div class="modal__response">
                <p class="mainText-1 no-select"><?php the_field('notification_callback_success', $home_page_id); ?></p>
            </div>
        </div>
    </div>
</div>