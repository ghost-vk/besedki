<?php
global $home_page_id;
$wa_group = get_field('wa_group', $home_page_id);
$wa_target = $wa_group['link']['target'] ? $wa_group['link']['target'] : 'self';
?>
<div class="rounded bg-light p-3 mb-3">
	<h4 class="text-center mb-3">Изменить заказ</h4>
	<p class="text-muted">
        Чтобы изменить заказ, перейдите на <a href="<?php echo home_url('/reservation'); ?>">страницу
        бронирования</a>, выберите беседку, дату и время. В заказе окажется выбранная вами бронь, а эта
        уже будет удалена.
    </p>
</div>
<div class="rounded bg-light p-3">
	<h4 class="text-center mb-3">Поддержка</h4>
	<p class="text-muted">Если у вас есть вопросы, вы можете написать нам на почту или на What's App:<br /><br />
		<a class="text-decoration-none" href="mailto:support@besedki-krasnodar.ru">
            <i class="far fa-envelope"></i> support@besedki-krasnodar.ru
        </a>
        <br />
		<a class="text-decoration-none" href="<?php echo $wa_group['link']['url']; ?>"
           target="<?php echo $wa_target?>">
            <i class="fab fa-whatsapp"></i> What's App
        </a>
	</p>
</div>