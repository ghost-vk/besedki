<?php
global $home_page_id;
$insta_group = get_field('insta_group', $home_page_id);
$telegram_group = get_field('telegram_group', $home_page_id);
$wa_group = get_field('wa_group', $home_page_id);
$vk_group = get_field('vk_group', $home_page_id);
$youtube_group = get_field('youtube_group', $home_page_id);
?>

<?php if ( $insta_group['is_on'] === true ) : ?>
	<?php $target = $insta_group['link']['target'] ? $insta_group['link']['target'] : 'self'; ?>
	<a href="<?= $insta_group['link']['url'] ?>" target="<?= $target; ?>">
		<svg class="instagram" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M21.9941 14.6635C17.9544 14.6635 14.6578 17.9603 14.6578 22C14.6578 26.0397 17.9544 29.3365 21.9941 29.3365C26.0337 29.3365 29.3304 26.0397 29.3304 22C29.3304 17.9603 26.0337 14.6635 21.9941 14.6635ZM43.9975 22C43.9975 18.9619 44.0251 15.9514 43.8545 12.9189C43.6838 9.39648 42.8803 6.27037 40.3046 3.69463C37.7234 1.11339 34.6029 0.315349 31.0806 0.144734C28.0426 -0.0258816 25.0321 0.00163705 21.9996 0.00163705C18.9616 0.00163705 15.9511 -0.0258816 12.9186 0.144734C9.39631 0.315349 6.27026 1.11889 3.69456 3.69463C1.11337 6.27588 0.315343 9.39648 0.144731 12.9189C-0.0258811 15.9569 0.00163702 18.9675 0.00163702 22C0.00163702 25.0325 -0.0258811 28.0486 0.144731 31.0811C0.315343 34.6035 1.11887 37.7296 3.69456 40.3054C6.27576 42.8866 9.39631 43.6847 12.9186 43.8553C15.9566 44.0259 18.9671 43.9984 21.9996 43.9984C25.0376 43.9984 28.0481 44.0259 31.0806 43.8553C34.6029 43.6847 37.7289 42.8811 40.3046 40.3054C42.8858 37.7241 43.6838 34.6035 43.8545 31.0811C44.0306 28.0486 43.9975 25.0381 43.9975 22ZM21.9941 33.2881C15.7475 33.2881 10.7062 28.2467 10.7062 22C10.7062 15.7533 15.7475 10.7119 21.9941 10.7119C28.2407 10.7119 33.282 15.7533 33.282 22C33.282 28.2467 28.2407 33.2881 21.9941 33.2881ZM33.7443 12.8858C32.2859 12.8858 31.1081 11.708 31.1081 10.2496C31.1081 8.79107 32.2859 7.61328 33.7443 7.61328C35.2028 7.61328 36.3805 8.79107 36.3805 10.2496C36.381 10.5959 36.3131 10.9389 36.1808 11.2589C36.0484 11.579 35.8543 11.8698 35.6094 12.1147C35.3645 12.3596 35.0737 12.5537 34.7537 12.6861C34.4336 12.8184 34.0906 12.8863 33.7443 12.8858Z" fill="#B3B3B3"/>
		</svg>
	</a>
<?php endif; ?>

<?php if ( $telegram_group['is_on'] === true ) : ?>
	<?php $target = $telegram_group['link']['target'] ? $telegram_group['link']['target'] : 'self'; ?>
	<a href="<?= $telegram_group['link']['url'] ?>" target="<?= $target; ?>">
		<svg class="telegram" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.47715 0 0 4.47715 0 10V34C0 39.5228 4.47715 44 10 44H34C39.5228 44 44 39.5228 44 34V10C44 4.47715 39.5228 0 34 0H10ZM29.9429 32.0573L33.7736 13.9715C33.7736 13.9714 33.7737 13.9714 33.7737 13.9715C33.7737 13.9715 33.7738 13.9715 33.7738 13.9715C34.1135 12.3769 33.2015 11.7535 32.1589 12.1447L9.63943 20.8306C8.1035 21.4324 8.12617 22.2948 9.3783 22.686L10.7236 23.1077C13.5227 23.985 16.5658 23.589 19.0472 22.0247L28.5095 16.0597C29.1378 15.6394 29.7108 15.8727 29.2402 16.292L19.629 24.9868C18.8548 25.6871 18.3815 26.6596 18.3081 27.7009L18.0979 30.6808C18.0464 31.4096 18.6597 31.9733 19.176 31.4564C20.8024 29.8899 23.3214 29.7247 25.1385 31.0652L27.8294 33.0503C28.9002 33.6512 29.6537 33.3335 29.9429 32.0573Z" fill="#B3B3B3"/>
		</svg>
	</a>
<?php endif; ?>

<?php if ( $wa_group['is_on'] === true ) : ?>
	<?php $target = $wa_group['link']['target'] ? $wa_group['link']['target'] : 'self'; ?>
    <a href="<?= $wa_group['link']['url'] ?>" target="<?= $target; ?>">
        <svg class="vkontakte" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.47715 0 0 4.47715 0 10V34C0 39.5228 4.47715 44 10 44H34C39.5228 44 44 39.5228 44 34V10C44 4.47715 39.5228 0 34 0H10ZM16.3298 10.7385C18.2607 9.56016 20.4613 8.93901 22.7026 8.93969L22.7004 8.9375C26.0273 8.93808 29.2177 10.3072 31.5698 12.7438C33.9219 15.1803 35.2429 18.4846 35.2424 21.9298C35.2418 25.375 33.9197 28.6788 31.5668 31.1145C29.2139 33.5502 26.0231 34.9183 22.6962 34.9177H22.6899C20.4437 34.9178 18.2388 34.2925 16.3062 33.1072L15.849 32.8266L11.1015 34.1155L12.3693 29.324L12.0709 28.8331C10.8801 26.8667 10.2197 24.606 10.1585 22.2858C10.0973 19.9657 10.6374 17.6709 11.7227 15.6402C12.808 13.6095 14.3988 11.9169 16.3298 10.7385ZM28.9923 28.7087C29.4301 28.3891 29.7994 27.9793 30.0768 27.5048C30.3236 26.9215 30.4002 26.2761 30.2969 25.6483C30.2239 25.5211 30.0532 25.4357 29.8012 25.3095C29.7319 25.2749 29.6564 25.2371 29.5752 25.1946C29.1984 24.9973 27.3422 24.0526 26.9971 23.9233C26.6521 23.794 26.4024 23.7282 26.1505 24.1184C25.8986 24.5085 25.1769 25.3875 24.9567 25.6483C24.7366 25.9091 24.5165 25.9442 24.1397 25.7469C23.0276 25.2886 22.0012 24.6329 21.1066 23.8093C20.2822 23.02 19.5753 22.1085 19.0091 21.1045C18.7911 20.7144 18.9858 20.504 19.1763 20.3089C19.2844 20.197 19.4071 20.0422 19.5313 19.8856C19.6017 19.7969 19.6725 19.7075 19.7414 19.625C19.8964 19.4278 20.0232 19.2085 20.1182 18.9741C20.1682 18.8663 20.1915 18.7474 20.186 18.628C20.1804 18.5086 20.1462 18.3925 20.0864 18.2902C20.0312 18.1744 19.743 17.4496 19.4516 16.7165C19.2522 16.215 19.0513 15.7095 18.9223 15.3925C18.6528 14.718 18.38 14.7205 18.1594 14.7226C18.1306 14.7228 18.1026 14.7231 18.0757 14.7218C17.8556 14.7087 17.6037 14.7087 17.354 14.7087H17.3539C17.1629 14.714 16.9749 14.7601 16.8019 14.8443C16.6289 14.9284 16.4745 15.0486 16.3485 15.1975C15.9222 15.6153 15.5846 16.1205 15.3572 16.6809C15.1298 17.2413 15.0176 17.8446 15.0278 18.4524C15.1509 19.9248 15.6864 21.3281 16.5687 22.4898C18.1859 24.9994 20.4055 27.0305 23.0095 28.3837C23.7111 28.6973 24.4282 28.9724 25.1578 29.2079C25.9272 29.4495 26.7403 29.502 27.5326 29.3613C28.0575 29.2504 28.5544 29.0282 28.9923 28.7087Z" fill="#B3B3B3"/>
        </svg>
    </a>
<?php endif; ?>

<?php if ( $vk_group['is_on'] === true ) : ?>
	<?php $target = $vk_group['link']['target'] ? $vk_group['link']['target'] : 'self'; ?>
	<a href="<?= $vk_group['link']['url'] ?>" target="<?= $target; ?>">
		<svg class="wa" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.47715 0 0 4.47715 0 10V34C0 39.5228 4.47715 44 10 44H34C39.5228 44 44 39.5228 44 34V10C44 4.47715 39.5228 0 34 0H10ZM36.301 29.8009C36.3315 29.8521 36.3644 29.916 36.3996 29.993C36.4349 30.0698 36.4703 30.2058 36.5062 30.4002C36.5412 30.5951 36.5391 30.7694 36.4985 30.923C36.4578 31.0765 36.3318 31.2176 36.1196 31.3457C35.9078 31.4736 35.6092 31.538 35.2254 31.538L31.3459 31.5994C31.103 31.6506 30.8202 31.625 30.4974 31.5226C30.1741 31.4201 29.9114 31.3074 29.709 31.1843L29.406 30.9999C29.103 30.7844 28.7495 30.4568 28.3452 30.016C27.9411 29.5755 27.5952 29.1787 27.3072 28.8249C27.0191 28.4716 26.711 28.1742 26.3826 27.9334C26.0539 27.6924 25.7686 27.613 25.5261 27.695C25.4958 27.7055 25.4556 27.7229 25.4053 27.7487C25.3546 27.7744 25.2683 27.8488 25.1472 27.9717C25.0263 28.0944 24.9177 28.2457 24.8215 28.4249C24.7252 28.6044 24.6391 28.8708 24.5636 29.2242C24.488 29.5777 24.4549 29.9748 24.4653 30.4153C24.4653 30.5688 24.4476 30.7099 24.4122 30.838C24.3771 30.9658 24.3392 31.0609 24.2986 31.122L24.2383 31.1991C24.0563 31.3936 23.7885 31.5064 23.4351 31.5373H21.6922C20.9748 31.578 20.2373 31.4937 19.4795 31.2834C18.7217 31.0734 18.0575 30.8019 17.4865 30.4691C16.9157 30.1358 16.3954 29.7977 15.9255 29.4543C15.4557 29.111 15.0996 28.8164 14.8571 28.5705L14.4782 28.2016C14.3772 28.0992 14.2382 27.9457 14.0613 27.7405C13.8846 27.5356 13.5234 27.0694 12.9778 26.3417C12.4322 25.6144 11.8967 24.8406 11.3713 24.0207C10.8461 23.2014 10.2272 22.1201 9.51493 20.7777C8.80268 19.4353 8.14346 18.0417 7.53727 16.5967C7.4766 16.4329 7.44629 16.2945 7.44629 16.1818C7.44629 16.069 7.46158 15.9871 7.49189 15.9358L7.55256 15.8437C7.70416 15.6489 7.99207 15.5514 8.41641 15.5514L12.5689 15.5208C12.6903 15.5413 12.8063 15.5744 12.9175 15.6207C13.0285 15.667 13.1095 15.7104 13.1599 15.7513L13.2358 15.7976C13.3974 15.9103 13.5187 16.0741 13.5994 16.2893C13.8014 16.8017 14.0337 17.3321 14.2966 17.8804C14.5593 18.4286 14.7663 18.8462 14.9179 19.1331L15.1603 19.579C15.4533 20.1938 15.7362 20.7266 16.0089 21.1774C16.2818 21.6283 16.5268 21.9792 16.7441 22.2304C16.9613 22.4815 17.171 22.6786 17.3729 22.8222C17.575 22.9657 17.7466 23.0375 17.8882 23.0375C18.0296 23.0375 18.1661 23.0115 18.2975 22.9605C18.3175 22.9504 18.3428 22.9246 18.3731 22.8837C18.4035 22.8427 18.464 22.73 18.5551 22.5456C18.6459 22.3612 18.7141 22.1204 18.7597 21.8232C18.8053 21.526 18.8531 21.1111 18.9037 20.5781C18.9541 20.0453 18.9541 19.4048 18.9037 18.6567C18.8836 18.247 18.838 17.873 18.7673 17.5349C18.6966 17.1968 18.6259 16.9609 18.5551 16.8278L18.464 16.6431C18.2114 16.2948 17.7822 16.0744 17.1759 15.9823C17.0446 15.962 17.07 15.839 17.2519 15.6134C17.4235 15.4189 17.6155 15.2651 17.8277 15.1525C18.3632 14.8861 19.5706 14.763 21.4498 14.7834C22.2784 14.7938 22.9603 14.8603 23.4959 14.9832C23.6976 15.0345 23.8672 15.1037 24.0036 15.1908C24.1397 15.278 24.2434 15.4008 24.3142 15.5597C24.3847 15.7186 24.4381 15.8826 24.473 16.0516C24.5082 16.2207 24.526 16.4538 24.526 16.751C24.526 17.0482 24.5213 17.3301 24.511 17.5965C24.5006 17.8627 24.4882 18.224 24.473 18.68C24.4579 19.136 24.4504 19.5587 24.4504 19.9481C24.4504 20.0609 24.4457 20.2759 24.4352 20.5937C24.425 20.9113 24.4228 21.1575 24.4275 21.3316C24.4326 21.5059 24.4504 21.7131 24.4806 21.9541C24.5109 22.1949 24.5689 22.3948 24.655 22.5536C24.7407 22.7125 24.8544 22.838 24.9958 22.9302C25.0769 22.9507 25.1626 22.9711 25.2537 22.9918C25.3445 23.0124 25.4757 22.956 25.6475 22.8226C25.8196 22.6893 26.0112 22.5127 26.2235 22.2924C26.4355 22.0722 26.6982 21.7288 27.0114 21.2627C27.3249 20.7964 27.6682 20.2457 28.0421 19.6102C28.6484 18.5446 29.1887 17.3918 29.6639 16.1518C29.7042 16.0494 29.7547 15.9595 29.8151 15.8829C29.8757 15.806 29.9313 15.7522 29.9819 15.7216L30.0422 15.6754L30.1181 15.6369L30.3152 15.5906C30.4467 15.5598 30.5477 15.5575 30.6184 15.5829L34.983 15.5523C35.3771 15.5011 35.7003 15.5138 35.9532 15.5906C36.2055 15.6676 36.3621 15.752 36.4228 15.8443L36.513 15.9976C36.7455 16.6535 35.9877 18.1596 34.2397 20.5166C33.9973 20.8446 33.6691 21.2799 33.2547 21.8231C32.4669 22.848 32.0118 23.5188 31.8907 23.8365C31.7193 24.2569 31.7895 24.6718 32.1033 25.0817C32.2747 25.2969 32.6841 25.7172 33.3307 26.3423H33.3459L33.3612 26.3578L33.3763 26.3729L33.4063 26.4036C34.8309 27.746 35.796 28.8784 36.301 29.8009Z" fill="#B3B3B3"/>
        </svg>
	</a>
<?php endif; ?>

<?php if ( $youtube_group['is_on'] === true ) : ?>
	<?php $target = $youtube_group['link']['target'] ? $youtube_group['link']['target'] : 'self'; ?>
	<a href="<?= $youtube_group['link']['url'] ?>" target="<?= $target; ?>">
		<svg class="youtube" width="59" height="44" viewBox="0 0 59 44" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M57.442 6.78654C57.1012 5.47911 56.4516 4.28827 55.5562 3.32932C54.6608 2.37036 53.5498 1.6758 52.3309 1.31288C47.7553 6.27641e-05 29.3613 6.30815e-05 29.3613 6.30815e-05C29.3613 6.30815e-05 11.0021 -0.0314291 6.37888 1.31288C5.1619 1.67739 4.05312 2.37269 3.1597 3.33155C2.26628 4.29041 1.61845 5.48042 1.27881 6.78654C0.409908 11.8139 -0.0180389 16.9175 0.000582415 22.0305C-0.00789587 27.119 0.419984 32.1974 1.27881 37.2017C1.61955 38.5085 2.26758 39.6994 3.16068 40.66C4.05379 41.6206 5.16199 42.3187 6.37888 42.6872C10.9545 44 29.3613 44 29.3613 44C29.3613 44 47.7095 44 52.3309 42.6872C53.5497 42.3203 54.6601 41.6229 55.5552 40.6622C56.4503 39.7015 57.1001 38.5098 57.442 37.2017C58.2837 32.2004 58.6945 27.1145 58.6652 22.0305C58.6945 16.9131 58.2929 11.8193 57.442 6.78654ZM23.4855 31.4525V12.5673L38.7967 22.0305L23.4855 31.4525Z" fill="#B3B3B3"/>
		</svg>
	</a>
<?php endif; ?>