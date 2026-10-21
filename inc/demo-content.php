<?php
/**
 * Setup page under Appearance ▸ TargetWeb - Landmark Setup.
 *
 * Content blocks (categories, services, features, testimonials, FAQs) now
 * ship with real defaults baked into the Customizer settings themselves, so
 * the homepage is fully populated the moment the theme is activated —
 * there's nothing to "import." This page just: (1) makes sure the homepage
 * is set as the site's front page, and (2) offers a one-click reset back to
 * the original demo defaults, in case someone edits their way into a mess.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Exact-title lookup, used instead of the deprecated get_page_by_title().
 */
function greenline_find_post_by_title( $title, $post_type = 'page' ) {
	$q = new WP_Query( array(
		'post_type'      => $post_type,
		'title'          => $title,
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'no_found_rows'  => true,
	) );
	return $q->have_posts() ? $q->posts[0] : null;
}

function greenline_setup_admin_menu() {
	add_theme_page(
		__( 'TargetWeb - Landmark Setup', 'greenline' ),
		__( 'TargetWeb - Landmark Setup', 'greenline' ),
		'manage_options',
		'greenline-setup',
		'greenline_setup_page'
	);
}
add_action( 'admin_menu', 'greenline_setup_admin_menu' );

function greenline_ensure_homepage() {
	$home = greenline_find_post_by_title( 'Home', 'page' );
	if ( ! $home ) {
		$home_id = wp_insert_post( array(
			'post_type'     => 'page',
			'post_title'    => 'Home',
			'post_status'   => 'publish',
			'page_template' => 'front-page.php',
		) );
	} else {
		$home_id = $home->ID;
	}
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}
	return $home_id;
}

function greenline_setup_page() {
	$front_page_set = 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' );
	?>
	<div class="wrap">
		<h1><?php _e( 'TargetWeb - Landmark — Theme Setup', 'greenline' ); ?></h1>
		<p><?php _e( 'The homepage ships fully populated with demo content — categories, services, why-choose-us tiles, testimonials, and FAQs are all real, editable rows already. Go to Appearance ▸ Customize ▸ "⚙ TargetWeb - Landmark Theme Options" to add your own photos and edit any text, or use the tools below.', 'greenline' ); ?></p>

		<?php if ( $front_page_set ) : ?>
			<div class="notice notice-success inline"><p><?php _e( 'Your homepage is set correctly.', 'greenline' ); ?></p></div>
		<?php endif; ?>

		<form method="post" style="margin-bottom:28px;">
			<?php wp_nonce_field( 'greenline_setup_homepage', 'greenline_setup_nonce' ); ?>
			<button type="submit" name="greenline_setup_homepage" class="button button-primary">
				<?php echo $front_page_set ? __( 'Re-confirm Homepage', 'greenline' ) : __( 'Set Up Homepage', 'greenline' ); ?>
			</button>
		</form>

		<hr>
		<h2><?php _e( 'Demo pages, blog posts & menus', 'greenline' ); ?></h2>
		<p class="description"><?php _e( 'Creates About Us / Careers / Community / Blog pages, 3 sample blog posts, and populates the Primary Menu plus all 3 footer menus with working links — safe to run more than once, it will not create duplicates.', 'greenline' ); ?></p>
		<form method="post" style="margin-bottom:28px;">
			<?php wp_nonce_field( 'greenline_setup_menus', 'greenline_menus_nonce' ); ?>
			<button type="submit" name="greenline_setup_menus" class="button button-primary">
				<?php _e( 'Create Demo Pages & Menus', 'greenline' ); ?>
			</button>
		</form>

		<hr>
		<h2><?php _e( 'Reset ALL theme text/settings to demo defaults', 'greenline' ); ?></h2>
		<p class="description"><?php _e( 'If you activated an earlier version of this theme, a few fields may have been saved blank before defaults were fixed. This clears every text, color, and image setting (not menus or pages) and restores the full demo. Equipment Categories / Services / Why Choose Us / Testimonials / FAQs are reset by the button above, separately.', 'greenline' ); ?></p>
		<form method="post" style="margin-bottom:28px;">
			<?php wp_nonce_field( 'greenline_reset_all', 'greenline_reset_all_nonce' ); ?>
			<button type="submit" name="greenline_reset_all" class="button" onclick="return confirm('<?php echo esc_js( __( 'Reset every theme text, color, and image setting to the demo defaults? This cannot be undone.', 'greenline' ) ); ?>');">
				<?php _e( 'Reset All Theme Settings', 'greenline' ); ?>
			</button>
		</form>

		<hr>
		<h2><?php _e( 'Reset content blocks to demo defaults', 'greenline' ); ?></h2>
		<p class="description"><?php _e( 'This clears any edits made to Categories, Services, Why Choose Us, Testimonials, or FAQs in the Customizer and restores the original sample rows shown in the theme preview. Colors, hero text, financing numbers, contact info, and footer are not affected.', 'greenline' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'greenline_reset_blocks', 'greenline_reset_nonce' ); ?>
			<button type="submit" name="greenline_reset_blocks" class="button" onclick="return confirm('<?php echo esc_js( __( 'Reset all content blocks to demo defaults? This cannot be undone.', 'greenline' ) ); ?>');">
				<?php _e( 'Reset Content Blocks', 'greenline' ); ?>
			</button>
		</form>
	</div>
	<?php
}

function greenline_handle_setup_actions() {
	if ( ! current_user_can( 'manage_options' ) ) return;

	if ( isset( $_POST['greenline_setup_homepage'] ) && isset( $_POST['greenline_setup_nonce'] ) && wp_verify_nonce( $_POST['greenline_setup_nonce'], 'greenline_setup_homepage' ) ) {
		greenline_ensure_homepage();
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Homepage set.', 'greenline' ) . '</p></div>';
		} );
	}

	if ( isset( $_POST['greenline_setup_menus'] ) && isset( $_POST['greenline_menus_nonce'] ) && wp_verify_nonce( $_POST['greenline_menus_nonce'], 'greenline_setup_menus' ) ) {
		greenline_create_demo_pages_and_posts();
		greenline_create_demo_menus();
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Demo pages, posts, and menus created.', 'greenline' ) . '</p></div>';
		} );
	}

	if ( isset( $_POST['greenline_reset_all'] ) && isset( $_POST['greenline_reset_all_nonce'] ) && wp_verify_nonce( $_POST['greenline_reset_all_nonce'], 'greenline_reset_all' ) ) {
		foreach ( array_keys( greenline_text_defaults() ) as $key ) {
			remove_theme_mod( $key );
		}
		remove_theme_mod( 'gl_section_order' );
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'All theme text, color, and image settings reset to demo defaults.', 'greenline' ) . '</p></div>';
		} );
	}

	if ( isset( $_POST['greenline_reset_blocks'] ) && isset( $_POST['greenline_reset_nonce'] ) && wp_verify_nonce( $_POST['greenline_reset_nonce'], 'greenline_reset_blocks' ) ) {
		remove_theme_mod( 'gl_categories_repeater' );
		remove_theme_mod( 'gl_services_repeater' );
		remove_theme_mod( 'gl_features_repeater' );
		remove_theme_mod( 'gl_testimonials_repeater' );
		remove_theme_mod( 'gl_faqs_repeater' );
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Content blocks reset to demo defaults.', 'greenline' ) . '</p></div>';
		} );
	}
}
add_action( 'admin_init', 'greenline_handle_setup_actions' );

/**
 * On first activation, set the homepage automatically so the site is
 * usable immediately without a visit to the setup page.
 */
function greenline_on_activation() {
	greenline_ensure_homepage();
	greenline_create_demo_pages_and_posts();
	greenline_create_demo_menus();
}
add_action( 'after_switch_theme', 'greenline_on_activation' );

/**
 * Creates a small set of realistic placeholder pages + blog posts so the
 * whole site — not just the homepage — has something to look at. Safe to
 * re-run: looks up by title first and reuses whatever already exists.
 */
function greenline_create_demo_pages_and_posts() {
	$pages = array(
		'About Us' => "<!-- wp:paragraph -->\n<p>Greenline Power Equipment has served this community since 1998. What started as a two-bay repair shop is now a full-service dealership — but the goal hasn't changed: get you the right machine, keep it running, and tell you the truth about what it actually needs.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Our sales floor and service bays are staffed by people who've spent years with this equipment, not a script. If a $40 part fixes it, that's what we'll recommend — not a new unit.</p>\n<!-- /wp:paragraph -->",
		'Careers'   => "<!-- wp:paragraph -->\n<p>We're always glad to talk to experienced technicians, parts specialists, and sales people who care about doing right by customers. Send your resume to the email address in our Contact section and tell us a bit about your background.</p>\n<!-- /wp:paragraph -->",
		'Community' => "<!-- wp:paragraph -->\n<p>We sponsor local youth sports leagues, host a free equipment-safety clinic each spring, and donate serviced trade-in mowers to neighbors in need each fall. If you know someone who could use one, reach out — we keep a short waiting list.</p>\n<!-- /wp:paragraph -->",
		'Blog'      => '',
	);

	$ids = array();
	foreach ( $pages as $title => $content ) {
		$existing = greenline_find_post_by_title( $title, 'page' );
		if ( $existing ) {
			$ids[ $title ] = $existing->ID;
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => 'publish',
		) );
		if ( ! is_wp_error( $id ) ) $ids[ $title ] = $id;
	}

	// Use the "Blog" page as the site's posts index (yields a working /blog/ URL).
	if ( isset( $ids['Blog'] ) && ! get_option( 'page_for_posts' ) ) {
		update_option( 'page_for_posts', $ids['Blog'] );
	}

	$posts = array(
		array(
			'title'   => '5 Signs Your Mower Needs a Tune-Up Before Spring',
			'content' => "<!-- wp:paragraph -->\n<p>Hard starts, uneven cuts, and a rough idle are the most common warning signs we see every March. Catching them early usually means a $60 tune-up instead of a $400 repair once the season is in full swing.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:list -->\n<ul><li>Engine cranks 3+ times before starting</li><li>Visible grass buildup under the deck</li><li>Vibration that wasn't there last season</li><li>Uneven cut height across the lawn</li><li>Old or discolored fuel left in the tank over winter</li></ul>\n<!-- /wp:list -->",
		),
		array(
			'title'   => 'Zero-Turn vs. Riding Mower: Which Is Right for You?',
			'content' => "<!-- wp:paragraph -->\n<p>If your property has more than half an acre of open lawn with a few obstacles — trees, beds, a shed — a zero-turn will usually cut your mowing time significantly. Riding mowers still make sense on hillier terrain or tighter, more technical layouts. We're happy to talk through your specific yard before you buy.</p>\n<!-- /wp:paragraph -->",
		),
		array(
			'title'   => 'Winterizing Your Equipment the Right Way',
			'content' => "<!-- wp:paragraph -->\n<p>Stabilized fuel, a fresh oil change, and a dry storage spot will do more for your equipment's lifespan than almost anything else you can do. Here's the short checklist our techs run through on every winterization ticket.</p>\n<!-- /wp:paragraph -->",
		),
	);
	foreach ( $posts as $p ) {
		if ( greenline_find_post_by_title( $p['title'], 'post' ) ) continue;
		wp_insert_post( array(
			'post_type'    => 'post',
			'post_title'   => $p['title'],
			'post_content' => $p['content'],
			'post_status'  => 'publish',
		) );
	}

	return $ids;
}

/**
 * Creates the Primary + 3 footer menus with real demo items and assigns
 * them to their theme locations. Skips creating a menu that already
 * exists (by name) so re-activating the theme never duplicates content;
 * it will still assign an existing menu to its location if that's empty.
 */
function greenline_create_demo_menus() {
	$page_ids = array();
	foreach ( array( 'About Us', 'Careers', 'Community', 'Blog' ) as $title ) {
		$p = greenline_find_post_by_title( $title, 'page' );
		if ( $p ) $page_ids[ $title ] = $p->ID;
	}
	$home = trailingslashit( home_url( '/' ) );

	$menus = array(
		'primary' => array(
			'name'  => 'Primary Menu',
			'items' => array(
				array( 'title' => 'Home',      'url' => $home ),
				array( 'title' => 'Inventory', 'url' => $home . '#equipment' ),
				array( 'title' => 'Service',   'url' => $home . '#quote' ),
				array( 'title' => 'Financing', 'url' => $home . '#quote' ),
				array( 'title' => 'About',     'page' => 'About Us' ),
				array( 'title' => 'Contact',   'url' => $home . '#contact' ),
			),
		),
		'footer-shop' => array(
			'name'  => 'Footer — Shop',
			'items' => array(
				array( 'title' => 'Zero-Turn Mowers', 'url' => $home . '#equipment' ),
				array( 'title' => 'Riding Mowers',    'url' => $home . '#equipment' ),
				array( 'title' => 'Chainsaws',        'url' => $home . '#equipment' ),
				array( 'title' => 'Generators',       'url' => $home . '#equipment' ),
				array( 'title' => 'Utility Vehicles', 'url' => $home . '#equipment' ),
			),
		),
		'footer-services' => array(
			'name'  => 'Footer — Services',
			'items' => array(
				array( 'title' => 'Equipment Sales',    'url' => $home . '#quote' ),
				array( 'title' => 'Service & Repair',   'url' => $home . '#quote' ),
				array( 'title' => 'Parts Department',   'url' => $home . '#quote' ),
				array( 'title' => 'Financing',          'url' => $home . '#quote' ),
				array( 'title' => 'Pickup & Delivery',  'url' => $home . '#quote' ),
			),
		),
		'footer-company' => array(
			'name'  => 'Footer — Company',
			'items' => array(
				array( 'title' => 'About',     'page' => 'About Us' ),
				array( 'title' => 'Careers',   'page' => 'Careers' ),
				array( 'title' => 'Community', 'page' => 'Community' ),
				array( 'title' => 'Contact',   'url' => $home . '#contact' ),
				array( 'title' => 'Blog',      'page' => 'Blog' ),
			),
		),
	);

	$locations = get_theme_mod( 'nav_menu_locations', array() );

	foreach ( $menus as $location => $data ) {
		$menu = wp_get_nav_menu_object( $data['name'] );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $data['name'] );
			foreach ( $data['items'] as $item ) {
				if ( isset( $item['page'] ) && isset( $page_ids[ $item['page'] ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'     => $item['title'],
						'menu-item-object-id' => $page_ids[ $item['page'] ],
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				} else {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'  => $item['title'],
						'menu-item-url'    => $item['url'],
						'menu-item-status' => 'publish',
					) );
				}
			}
		} else {
			$menu_id = $menu->term_id;
		}

		if ( empty( $locations[ $location ] ) ) {
			$locations[ $location ] = $menu_id;
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}
