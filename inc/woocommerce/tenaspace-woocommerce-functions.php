<?php

function tenaspace_is_product_archive()
{
	return(is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) ? true : false;
}

?>