<?php

/**
 * Template part for displaying PayU mini widget
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package anka-krystyniak
 */

global $product;

$current_lang = apply_filters('wpml_current_language', NULL);
$current_currency = get_woocommerce_currency();
$product_price = $product->get_price_html();
?>
<? if($current_currency == 'PLN'): ?>
<div class="ak-product__payu-info-box">
    <img class="logo" src="<?= get_template_directory_uri(); ?>/assets/img/payu-raty-icon.png" alt="PayU raty logo">

    <p>
        <span id="installment-mini-prod-details"></span>
        <span class="rrso">RRSO 0%</span>
    </p>
</div>

<script type="text/javascript">
    var payuInfoBoxEl = document.querySelector('.ak-product__payu-info-box');
    var rawPrice = '<?= $product_price; ?>';
    var transformedPrice = Number(rawPrice.match(/\d/g).join(""));

    if (transformedPrice && transformedPrice >= 300 && transformedPrice <= 50000) {
        var options = {
            lang: "<?= strtolower($current_lang); ?>",
            currencySign: "<?= $current_currency; ?>",
            creditAmount: transformedPrice,
            posId: '295639',
            key: 'a0',
            showLongDescription: true
        };
        OpenPayU.Installments.miniInstallment('#installment-mini-prod-details', options)
            .then(function(result) {
                const payuInfoBoxEl = document.querySelector('.ak-product__payu-info-box');

                payuInfoBoxEl.classList.add('visible');
            })
            .catch(function(e) {
                console.error(e.toString());
            });
    } else {
        payuInfoBoxEl.remove();
    }
</script>
<? endif; ?>