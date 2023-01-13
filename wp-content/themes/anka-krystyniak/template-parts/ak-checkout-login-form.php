<?php

/**
 * Template part for displaying checkout login form
 *
 * @package anka-krystyniak
 */

?>

<div class="ak-checkout-login-form">
    <div class="form-wraper col-1">
        <h2 class="form-title"><?php esc_html_e('I already have an account', 'anka-krystyniak'); ?></h2>

        <? get_template_part('template-parts/ak-login-form'); ?>
    </div>

    <div class="form-wraper col-2 ak-form">
        <h2 class="form-title"><?php esc_html_e('As a guest', 'anka-krystyniak'); ?></h2>

        <button id="continue-to-checkout-btn" type="submit" class="button"><?php esc_html_e('Continue', 'anka-krystyniak'); ?></button>
    </div>
</div>