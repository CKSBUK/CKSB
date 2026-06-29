<?php
/**
 * header.php — Crosskeys Silver Band Theme
 * Outputs the <head>, Google Fonts preconnect, and the fixed navigation header.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Preconnect for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

  <!-- Google Fonts — loaded directly, not via wp_enqueue -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap">

  <!-- Font Awesome 6 — loaded directly so no plugin/CSP can block it -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Header & Navigation -->
<header id="main-header">
  <div class="nav-container">

    <!-- Logo -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-wrapper" id="nav-logo-link">
      <?php
      if ( has_custom_logo() ) {
          $logo_id  = get_theme_mod( 'custom_logo' );
          $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
          echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . ' Logo" class="logo-img">';
      } else {
          echo '<img src="' . esc_url( get_template_directory_uri() . '/images/logo.png' ) . '" alt="Crosskeys Silver Band Logo" class="logo-img">';
      }
      ?>
      <span class="logo-text brand-font">Crosskeys<span class="logo-sub accent-text">Silver Band</span></span>
    </a>

    <!-- Mobile hamburger -->
    <button class="nav-toggle" aria-label="Toggle Navigation" id="mobile-menu-btn">
      <span class="hamburger"></span>
    </button>

    <!-- Navigation links -->
    <nav class="nav-links" id="navigation-bar" role="navigation" aria-label="Primary Navigation">
      <?php
        $nav_events = function_exists('crosskeys_get_events') ? crosskeys_get_events() : [];
        if ( is_front_page() ) :
      ?>
        <a href="#about"      class="nav-item">About Us</a>
        <a href="#conductor"  class="nav-item">Musical Director</a>
        <?php if ( ! empty( $nav_events ) ) : ?><a href="#events" class="nav-item">Events</a><?php endif; ?>
        <a href="#vacancies"  class="nav-item">Vacancies</a>
        <a href="#rehearsals" class="nav-item">Rehearsals</a>
        <a href="#contact"    class="nav-item">Contact</a>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'policies' ) ) ); ?>" class="nav-item">Policies</a>
      <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"      class="nav-item">About Us</a>
        <a href="<?php echo esc_url( home_url( '/#conductor' ) ); ?>"  class="nav-item">Musical Director</a>
        <?php if ( ! empty( $nav_events ) ) : ?><a href="<?php echo esc_url( home_url( '/#events' ) ); ?>" class="nav-item">Events</a><?php endif; ?>
        <a href="<?php echo esc_url( home_url( '/#vacancies' ) ); ?>"  class="nav-item">Vacancies</a>
        <a href="<?php echo esc_url( home_url( '/#rehearsals' ) ); ?>" class="nav-item">Rehearsals</a>
        <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"    class="nav-item">Contact</a>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'policies' ) ) ); ?>"
           class="nav-item<?php echo ( is_page( 'policies' ) ? ' active' : '' ); ?>">Policies</a>
      <?php endif; ?>
    </nav>

  </div>
</header>
