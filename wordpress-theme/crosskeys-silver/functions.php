<?php
/**
 * Crosskeys Silver Band — functions.php
 * Registers theme supports, enqueues assets, and registers the Vacancy CPT.
 */

// ── 1. Theme Setup ──────────────────────────────────────────────────────────
function crosskeys_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'menus' );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'crosskeys-silver' ),
    ] );
}
add_action( 'after_setup_theme', 'crosskeys_setup' );

// ── 2. Enqueue Styles & Scripts ──────────────────────────────────────────────
function crosskeys_enqueue_assets() {
    // Main stylesheet (also contains theme declaration)
    wp_enqueue_style(
        'crosskeys-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );

    // FontAwesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        [],
        '6.4.0'
    );

    // Main JS
    wp_enqueue_script(
        'crosskeys-main',
        get_template_directory_uri() . '/js/main.js',
        [],
        '1.0.0',
        true // load in footer
    );

    // Pass the AJAX URL and nonce to JS (for CF7, future use, etc.)
    wp_localize_script( 'crosskeys-main', 'crosskeys_ajax', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'crosskeys_nonce' ),
        'home_url' => home_url( '/' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'crosskeys_enqueue_assets' );

// ── 3. Vacancy Custom Post Type ──────────────────────────────────────────────
function crosskeys_register_vacancy_cpt() {
    $labels = [
        'name'                  => _x( 'Vacancies', 'Post type general name', 'crosskeys-silver' ),
        'singular_name'         => _x( 'Vacancy', 'Post type singular name', 'crosskeys-silver' ),
        'menu_name'             => _x( 'Vacancies', 'Admin Menu text', 'crosskeys-silver' ),
        'name_admin_bar'        => _x( 'Vacancy', 'Add New on Toolbar', 'crosskeys-silver' ),
        'add_new'               => __( 'Add New', 'crosskeys-silver' ),
        'add_new_item'          => __( 'Add New Vacancy', 'crosskeys-silver' ),
        'new_item'              => __( 'New Vacancy', 'crosskeys-silver' ),
        'edit_item'             => __( 'Edit Vacancy', 'crosskeys-silver' ),
        'view_item'             => __( 'View Vacancy', 'crosskeys-silver' ),
        'all_items'             => __( 'All Vacancies', 'crosskeys-silver' ),
        'search_items'          => __( 'Search Vacancies', 'crosskeys-silver' ),
        'not_found'             => __( 'No vacancies found.', 'crosskeys-silver' ),
        'not_found_in_trash'    => __( 'No vacancies found in Trash.', 'crosskeys-silver' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-businessman',
        'supports'           => [ 'title' ], // Title = Instrument name
        'show_in_rest'       => true,
    ];

    register_post_type( 'vacancy', $args );
}
add_action( 'init', 'crosskeys_register_vacancy_cpt' );

// ── 4. Vacancy Custom Meta Box (Section, Description, Date Added) ────────────
function crosskeys_vacancy_meta_boxes() {
    add_meta_box(
        'vacancy_details',
        __( 'Vacancy Details', 'crosskeys-silver' ),
        'crosskeys_vacancy_meta_box_html',
        'vacancy',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'crosskeys_vacancy_meta_boxes' );

function crosskeys_vacancy_meta_box_html( $post ) {
    wp_nonce_field( 'crosskeys_save_vacancy', 'crosskeys_vacancy_nonce' );

    $section     = get_post_meta( $post->ID, '_vacancy_section', true );
    $description = get_post_meta( $post->ID, '_vacancy_description', true );
    $date_added  = get_post_meta( $post->ID, '_vacancy_date_added', true );

    if ( empty( $date_added ) ) {
        $date_added = date( 'Y-m-d' );
    }

    $sections = [
        'Cornets',
        'Horns',
        'Baritones & Euphoniums',
        'Trombones',
        'Basses',
        'Percussion',
        'Musical Director',
        'General',
    ];
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="vacancy_section"><?php _e( 'Section', 'crosskeys-silver' ); ?> *</label>
            </th>
            <td>
                <select id="vacancy_section" name="vacancy_section" style="width:100%; max-width:400px;">
                    <?php foreach ( $sections as $sec ) : ?>
                        <option value="<?php echo esc_attr( $sec ); ?>" <?php selected( $section, $sec ); ?>>
                            <?php echo esc_html( $sec ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="vacancy_date_added"><?php _e( 'Date Added', 'crosskeys-silver' ); ?></label>
            </th>
            <td>
                <input type="date" id="vacancy_date_added" name="vacancy_date_added"
                       value="<?php echo esc_attr( $date_added ); ?>" style="width:100%; max-width:400px;" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="vacancy_description"><?php _e( 'Description / Requirements', 'crosskeys-silver' ); ?> *</label>
            </th>
            <td>
                <textarea id="vacancy_description" name="vacancy_description"
                          rows="5" style="width:100%; max-width:600px;"><?php echo esc_textarea( $description ); ?></textarea>
                <p class="description"><?php _e( 'Describe the vacancy, what you are looking for, experience required, etc.', 'crosskeys-silver' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function crosskeys_save_vacancy_meta( $post_id ) {
    // Security checks
    if ( ! isset( $_POST['crosskeys_vacancy_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['crosskeys_vacancy_nonce'], 'crosskeys_save_vacancy' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['vacancy_section'] ) ) {
        update_post_meta( $post_id, '_vacancy_section', sanitize_text_field( $_POST['vacancy_section'] ) );
    }
    if ( isset( $_POST['vacancy_date_added'] ) ) {
        update_post_meta( $post_id, '_vacancy_date_added', sanitize_text_field( $_POST['vacancy_date_added'] ) );
    }
    if ( isset( $_POST['vacancy_description'] ) ) {
        update_post_meta( $post_id, '_vacancy_description', sanitize_textarea_field( $_POST['vacancy_description'] ) );
    }
}
add_action( 'save_post_vacancy', 'crosskeys_save_vacancy_meta' );

// ── 5. Admin Column: show Section in Vacancies list table ────────────────────
function crosskeys_vacancy_columns( $columns ) {
    $new = [];
    foreach ( $columns as $key => $value ) {
        $new[ $key ] = $value;
        if ( $key === 'title' ) {
            $new['section']    = __( 'Section', 'crosskeys-silver' );
            $new['date_added'] = __( 'Date Added', 'crosskeys-silver' );
        }
    }
    return $new;
}
add_filter( 'manage_vacancy_posts_columns', 'crosskeys_vacancy_columns' );

function crosskeys_vacancy_column_content( $column, $post_id ) {
    if ( $column === 'section' ) {
        echo esc_html( get_post_meta( $post_id, '_vacancy_section', true ) ?: '—' );
    }
    if ( $column === 'date_added' ) {
        $d = get_post_meta( $post_id, '_vacancy_date_added', true );
        echo $d ? esc_html( date( 'j M Y', strtotime( $d ) ) ) : '—';
    }
}
add_action( 'manage_vacancy_posts_custom_column', 'crosskeys_vacancy_column_content', 10, 2 );

// ── 6. Helper: get vacancies as array (for template use) ─────────────────────
function crosskeys_get_vacancies() {
    $query = new WP_Query( [
        'post_type'      => 'vacancy',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => '_vacancy_date_added',
        'order'          => 'DESC',
    ] );

    $vacancies = [];
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $vacancies[] = [
                'instrument'  => get_the_title(),
                'section'     => get_post_meta( get_the_ID(), '_vacancy_section', true ),
                'description' => get_post_meta( get_the_ID(), '_vacancy_description', true ),
                'date_added'  => get_post_meta( get_the_ID(), '_vacancy_date_added', true ),
            ];
        }
        wp_reset_postdata();
    }
    return $vacancies;
}

// ── 7. Event Custom Post Type ──────────────────────────────────────────────────
function crosskeys_register_event_cpt() {
    $labels = [
        'name'                  => _x( 'Events', 'Post type general name', 'crosskeys-silver' ),
        'singular_name'         => _x( 'Event', 'Post type singular name', 'crosskeys-silver' ),
        'menu_name'             => _x( 'Events', 'Admin Menu text', 'crosskeys-silver' ),
        'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'crosskeys-silver' ),
        'add_new'               => __( 'Add New', 'crosskeys-silver' ),
        'add_new_item'          => __( 'Add New Event', 'crosskeys-silver' ),
        'new_item'              => __( 'New Event', 'crosskeys-silver' ),
        'edit_item'             => __( 'Edit Event', 'crosskeys-silver' ),
        'view_item'             => __( 'View Event', 'crosskeys-silver' ),
        'all_items'             => __( 'All Events', 'crosskeys-silver' ),
        'search_items'          => __( 'Search Events', 'crosskeys-silver' ),
        'not_found'             => __( 'No upcoming events found.', 'crosskeys-silver' ),
        'not_found_in_trash'    => __( 'No events found in Trash.', 'crosskeys-silver' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => [ 'title' ], // Title = Event Name
        'show_in_rest'       => true,
    ];

    register_post_type( 'event', $args );
}
add_action( 'init', 'crosskeys_register_event_cpt' );

function crosskeys_event_meta_boxes() {
    add_meta_box(
        'event_details',
        __( 'Event Details', 'crosskeys-silver' ),
        'crosskeys_event_meta_box_html',
        'event',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'crosskeys_event_meta_boxes' );

function crosskeys_event_meta_box_html( $post ) {
    wp_nonce_field( 'crosskeys_save_event', 'crosskeys_event_nonce' );

    $date  = get_post_meta( $post->ID, '_event_date', true );
    $time  = get_post_meta( $post->ID, '_event_time', true );
    $venue = get_post_meta( $post->ID, '_event_venue', true );
    $desc  = get_post_meta( $post->ID, '_event_description', true );
    $link  = get_post_meta( $post->ID, '_event_ticket_link', true );

    if ( empty( $date ) ) {
        $date = date( 'Y-m-d' );
    }
    ?>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="event_date"><?php _e( 'Date', 'crosskeys-silver' ); ?> *</label></th>
            <td><input type="date" id="event_date" name="event_date" value="<?php echo esc_attr( $date ); ?>" style="width:100%; max-width:200px;" required /></td>
        </tr>
        <tr>
            <th scope="row"><label for="event_time"><?php _e( 'Time', 'crosskeys-silver' ); ?></label></th>
            <td><input type="text" id="event_time" name="event_time" value="<?php echo esc_attr( $time ); ?>" style="width:100%; max-width:200px;" placeholder="e.g. 19:30" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="event_venue"><?php _e( 'Venue', 'crosskeys-silver' ); ?></label></th>
            <td><input type="text" id="event_venue" name="event_venue" value="<?php echo esc_attr( $venue ); ?>" style="width:100%; max-width:400px;" placeholder="e.g. The Congress Theatre, Cwmbran" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="event_description"><?php _e( 'Short Description', 'crosskeys-silver' ); ?></label></th>
            <td>
                <textarea id="event_description" name="event_description" rows="3" style="width:100%; max-width:600px;"><?php echo esc_textarea( $desc ); ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="event_ticket_link"><?php _e( 'Ticket / Info Link', 'crosskeys-silver' ); ?></label></th>
            <td><input type="url" id="event_ticket_link" name="event_ticket_link" value="<?php echo esc_attr( $link ); ?>" style="width:100%; max-width:600px;" placeholder="https://..." /></td>
        </tr>
    </table>
    <?php
}

function crosskeys_save_event_meta( $post_id ) {
    if ( ! isset( $_POST['crosskeys_event_nonce'] ) || ! wp_verify_nonce( $_POST['crosskeys_event_nonce'], 'crosskeys_save_event' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [ 'event_date', 'event_time', 'event_venue', 'event_description', 'event_ticket_link' ];
    foreach ( $fields as $f ) {
        if ( isset( $_POST[ $f ] ) ) {
            $val = $f === 'event_description' ? sanitize_textarea_field( $_POST[ $f ] ) : sanitize_text_field( $_POST[ $f ] );
            update_post_meta( $post_id, '_' . $f, $val );
        }
    }
}
add_action( 'save_post_event', 'crosskeys_save_event_meta' );

function crosskeys_get_events() {
    $query = new WP_Query( [
        'post_type'      => 'event',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => '_event_date',
        'order'          => 'ASC',
        'meta_query'     => [
            [
                'key'     => '_event_date',
                'value'   => date('Y-m-d'),
                'compare' => '>=', // Only show upcoming and today's events
                'type'    => 'DATE'
            ]
        ]
    ] );

    $events = [];
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $events[] = [
                'title'       => get_the_title(),
                'date'        => get_post_meta( get_the_ID(), '_event_date', true ),
                'time'        => get_post_meta( get_the_ID(), '_event_time', true ),
                'venue'       => get_post_meta( get_the_ID(), '_event_venue', true ),
                'description' => get_post_meta( get_the_ID(), '_event_description', true ),
                'ticket_link' => get_post_meta( get_the_ID(), '_event_ticket_link', true ),
            ];
        }
        wp_reset_postdata();
    }
    return $events;
}

// ── 8. Contact Form 7 — pre-populate subject from vacancy apply link ──────────
// The JS in main.js will handle this on the front-end just as before.

// ── 8. Disable WordPress admin bar on front-end for non-admins ───────────────
add_filter( 'show_admin_bar', function( $show ) {
    return current_user_can( 'manage_options' ) ? $show : false;
} );

// ── 9. Remove default WordPress <head> clutter ───────────────────────────────
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// ══════════════════════════════════════════════════════════════════════════════
// 10. WordPress Customizer — Settings only (short config values)
//
//   Long text content (Our Story, Conductor bio) is read from WordPress Pages:
//     • Pages → "About"     (slug: about)     — Our Story body text
//     • Pages → "Conductor" (slug: conductor) — bio; title = name, excerpt = role
//
//   Appearance → Customize → Band Content
//     ├── Hero Section       (pre-title, heading, description)
//     └── Rehearsals         (day, time, venue, address, note)
// ══════════════════════════════════════════════════════════════════════════════

// Enable Excerpt field on Pages (used for conductor role/title line)
add_action( 'init', function() {
    add_post_type_support( 'page', 'excerpt' );
} );

// Helper: fetch a published page by its slug (post_name).
// Uses get_posts() with an explicit 'name' argument which is more reliable
// than get_page_by_path() across different hosting environments.
function crosskeys_get_page( $slug ) {
    $results = get_posts( [
        'post_type'      => 'page',
        'name'           => sanitize_title( $slug ), // match by post_name / slug
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'no_found_rows'  => true,   // skip COUNT(*) query — faster
    ] );
    return ! empty( $results ) ? $results[0] : null;
}

// Helper: return the rendered (filtered) content of a page by slug, or '' if not found.
function crosskeys_page_content( $slug ) {
    $page = crosskeys_get_page( $slug );
    if ( ! $page ) return '';
    // apply_filters('the_content') runs shortcodes, blocks, autop, etc.
    return apply_filters( 'the_content', $page->post_content );
}


function crosskeys_customize_register( WP_Customize_Manager $wp_customize ) {

    // ── Top-level Panel ───────────────────────────────────────────────────────
    $wp_customize->add_panel( 'crosskeys_content', [
        'title'    => __( 'Band Content', 'crosskeys-silver' ),
        'priority' => 30,
    ] );

    // ── HERO ─────────────────────────────────────────────────────────────────
    $wp_customize->add_section( 'crosskeys_hero', [
        'title' => __( 'Hero Section', 'crosskeys-silver' ),
        'panel' => 'crosskeys_content',
    ] );

    crosskeys_text_setting( $wp_customize, 'hero_pre',    'crosskeys_hero',
        __( 'Pre-Title (small gold text above heading)', 'crosskeys-silver' ),
        'Established 1901' );

    crosskeys_text_setting( $wp_customize, 'hero_title',  'crosskeys_hero',
        __( 'Main Heading', 'crosskeys-silver' ),
        'Making Music in South Wales for over a Century' );

    crosskeys_textarea_setting( $wp_customize, 'hero_desc', 'crosskeys_hero',
        __( 'Sub-heading / Description', 'crosskeys-silver' ),
        'Crosskeys Silver Band is a historic, community-focused brass band dedicated to musical excellence, performance, and preserving our Welsh brass heritage.' );

    // ── OUR STORY — stats only (body text comes from Pages → About) ───────────
    $wp_customize->add_section( 'crosskeys_about', [
        'title'       => __( 'Our Story — Stats', 'crosskeys-silver' ),
        'description' => __( 'The four highlight numbers shown next to the Our Story text. Edit the body text itself at Pages → About.', 'crosskeys-silver' ),
        'panel'       => 'crosskeys_content',
    ] );

    crosskeys_text_setting( $wp_customize, 'about_stat1_num',   'crosskeys_about', __( 'Stat 1 — Number (e.g. 1901)', 'crosskeys-silver' ), '1901' );
    crosskeys_text_setting( $wp_customize, 'about_stat1_label', 'crosskeys_about', __( 'Stat 1 — Label', 'crosskeys-silver' ), 'Founded' );
    crosskeys_text_setting( $wp_customize, 'about_stat2_num',   'crosskeys_about', __( 'Stat 2 — Number', 'crosskeys-silver' ), '25+' );
    crosskeys_text_setting( $wp_customize, 'about_stat2_label', 'crosskeys_about', __( 'Stat 2 — Label', 'crosskeys-silver' ), 'Active Players' );
    crosskeys_text_setting( $wp_customize, 'about_stat3_num',   'crosskeys_about', __( 'Stat 3 — Number', 'crosskeys-silver' ), '100%' );
    crosskeys_text_setting( $wp_customize, 'about_stat3_label', 'crosskeys_about', __( 'Stat 3 — Label', 'crosskeys-silver' ), 'Community Focused' );
    crosskeys_text_setting( $wp_customize, 'about_stat4_num',   'crosskeys_about', __( 'Stat 4 — Number', 'crosskeys-silver' ), '120+' );
    crosskeys_text_setting( $wp_customize, 'about_stat4_label', 'crosskeys_about', __( 'Stat 4 — Label', 'crosskeys-silver' ), 'Years of Music' );

    // (Conductor bio is read from Pages → Conductor. No Customizer settings needed.)


    $wp_customize->add_section( 'crosskeys_rehearsals', [
        'title' => __( 'Rehearsals & Location', 'crosskeys-silver' ),
        'panel' => 'crosskeys_content',
    ] );

    crosskeys_text_setting( $wp_customize, 'rehearsal_day',     'crosskeys_rehearsals', __( 'Day', 'crosskeys-silver' ), 'Tuesday' );
    crosskeys_text_setting( $wp_customize, 'rehearsal_time',    'crosskeys_rehearsals', __( 'Time', 'crosskeys-silver' ), '19:30 - 21:30' );
    crosskeys_text_setting( $wp_customize, 'rehearsal_venue',   'crosskeys_rehearsals', __( 'Venue Name', 'crosskeys-silver' ), 'Pandy Park (Crosskeys RFC)' );
    crosskeys_textarea_setting( $wp_customize, 'rehearsal_address', 'crosskeys_rehearsals',
        __( 'Address', 'crosskeys-silver' ), "Woodward Ave, Crosskeys,\nNewport, NP11 7PU" );
    crosskeys_textarea_setting( $wp_customize, 'rehearsal_note', 'crosskeys_rehearsals',
        __( 'Additional Note', 'crosskeys-silver' ),
        'Our rehearsals take place in the dedicated bandroom at Pandy Park. Ample free parking is available on-site.' );
}
add_action( 'customize_register', 'crosskeys_customize_register' );

// ── Customizer helpers ────────────────────────────────────────────────────────
function crosskeys_text_setting( $wpc, $id, $section, $label, $default = '' ) {
    $wpc->add_setting( 'crosskeys_' . $id, [
        'default'           => $default,
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wpc->add_control( 'crosskeys_' . $id, [
        'label'   => $label,
        'section' => $section,
        'type'    => 'text',
    ] );
}

function crosskeys_textarea_setting( $wpc, $id, $section, $label, $default = '' ) {
    $wpc->add_setting( 'crosskeys_' . $id, [
        'default'           => $default,
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ] );
    $wpc->add_control( 'crosskeys_' . $id, [
        'label'   => $label,
        'section' => $section,
        'type'    => 'textarea',
    ] );
}
