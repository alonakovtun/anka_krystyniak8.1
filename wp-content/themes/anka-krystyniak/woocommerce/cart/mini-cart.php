<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;

global $woocommerce;

do_action('woocommerce_before_mini_cart'); ?>

<div class="site-cart">
    <div class="site-cart__header">
        <a id="cart-popup-toggle" class="cart-close-btn"><? _e('Close', 'anka-krystyniak'); ?></a>
    </div>

    <?php if (!WC()->cart->is_empty()) : ?>

        <ul class="site-cart__products-list <?php echo esc_attr($args['list_class']); ?>">
            <?php
            do_action('woocommerce_before_mini_cart_contents');

            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
                    <li class="site-cart__product-item">
                        <a href="<?= esc_url($product_permalink); ?>">
                            <div class="product-item-description">
                                <p class="price"><?= $product_price; ?></p>
                                <p class="title"><?= $product_name; ?></p>
                            </div>
                            <?= $thumbnail; ?>
                            <div class="product-item-controls">
                                <p class="product-qty"><? _e('Quantity', 'anka-krystyniak'); ?>: <?= $cart_item['quantity']; ?></p>
                                <div class="qty-buttons">
                                    <button data-cart_item_qty="<?= $cart_item['quantity']; ?>" data-cart_item_key="<?= $cart_item_key; ?>" class="cart-item-qty-btn minus-btn">-</button>
                                    <button data-cart_item_qty="<?= $cart_item['quantity']; ?>" data-cart_item_key="<?= $cart_item_key; ?>" class="cart-item-qty-btn plus-btn">+</button>
                                </div>
                            </div>
                        </a>
                        <?php
                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_attr__('Remove this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($cart_item_key),
                                esc_attr($_product->get_sku()),
                                __('Remove', 'anka-krystyniak')
                            ),
                            $cart_item_key
                        );
                        ?>
                    </li>
            <?php
                }
            }

            do_action('woocommerce_mini_cart_contents');
            ?>
        </ul>

        <a class="site-cart__checkout-btn" href="<?= wc_get_checkout_url(); ?>">
            <p class="total-row">
                <?php
                /**
                 * Hook: woocommerce_widget_shopping_cart_total.
                 *
                 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
                 */
                do_action('woocommerce_widget_shopping_cart_total');
                ?>
            </p>

            <p class="checkout-text-row">
                <? _e('Go to checkout', 'anka-krystyniak'); ?>
            </p>
        </a>

    <?php endif; ?>

    <?php do_action('woocommerce_after_mini_cart'); ?>

</div>