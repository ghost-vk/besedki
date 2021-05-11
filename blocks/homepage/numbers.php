<div class="homeNumbers">
	<div class="homeNumbers__title titleAnimated" data-animation="right">
		<h3 class="title-1"><?php the_field('numbers_title'); ?></h3>
	</div>
	<?php $background_image = get_field('numbers_bg'); ?>
	<style>
        .homeNumbers__row {
            background: center / cover url("<?php echo $background_image ?>");
            background: linear-gradient(180deg, #eaf0eb 14.92%, rgba(234, 240, 235, 0) 39.4%),
            center / cover url("<?php echo $background_image ?>");
        }
	</style>
	<div class="homeNumbers__row">
		<?php for ($i = 1; $i < 5; $i += 1) : ?>
			<?php $data = get_field("numbers_$i"); ?>
			<div class="homeNumbers__item">
				<p class="homeNumbers__number no-select"><?= $data['num']; ?></p>
				<p class="homeNumbers__text no-select mainText-2"><?= $data['text']; ?></p>
			</div>
		<?php endfor; ?>
	</div>
</div>