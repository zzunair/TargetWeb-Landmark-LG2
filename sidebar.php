<?php
/**
 * Blog sidebar.
 *
 * @package Greenline
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) return;
?>
<aside class="gl-sidebar">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
