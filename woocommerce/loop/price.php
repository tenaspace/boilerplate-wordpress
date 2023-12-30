<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use TailwindMerge\TailwindMerge;

$tw = TailwindMerge::instance();

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<span class="<?php echo $tw->merge(['price', 'flex flex-col-reverse mt-1 [&_bdi]:text-[20px] [&_bdi]:leading-[1.75] [&_bdi]:font-semibold [&_ins]:no-underline [&_del]:text-ts-gray [&_del]:-mt-1 [&_del_bdi]:text-[14px] [&_del_bdi]:leading-normal [&_del_bdi]:font-normal']); ?>"><?php echo $price_html; ?></span>
<?php endif; ?>
