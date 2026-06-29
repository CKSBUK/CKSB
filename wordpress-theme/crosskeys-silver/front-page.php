<?php
/**
 * front-page.php — Crosskeys Silver Band Theme
 *
 * WordPress loads this template for the static front page.
 * (Settings → Reading → "A static page" → Front page)
 *
 * Content sources:
 *   Hero text        → Appearance → Customize → Band Content → Hero
 *   Our Story text   → Pages → "About"     (slug: about)
 *   Conductor bio    → Pages → "Conductor" (slug: conductor)
 *                       • Page Title    = conductor's name (e.g. Dave Collins)
 *                       • Page Excerpt  = role/title (e.g. Musical Director)
 *                       • Page Content  = bio paragraphs
 *   Stats (1901 etc) → Appearance → Customize → Band Content → Our Story — Stats
 *   Rehearsal info   → Appearance → Customize → Band Content → Rehearsals
 *   Vacancies        → wp-admin → Vacancies (Custom Post Type)
 */

get_header();

// ── Customizer values ──────────────────────────────────────────────────────────
$hero_pre   = get_theme_mod( 'crosskeys_hero_pre',   'Established 1901' );
$hero_title = get_theme_mod( 'crosskeys_hero_title', 'Making Music in South Wales for over a Century' );
$hero_desc  = get_theme_mod( 'crosskeys_hero_desc',  'Crosskeys Silver Band is a historic, community-focused brass band dedicated to musical excellence, performance, and preserving our Welsh brass heritage.' );

$stat1_num   = get_theme_mod( 'crosskeys_about_stat1_num',   '1901' );
$stat1_label = get_theme_mod( 'crosskeys_about_stat1_label', 'Founded' );
$stat2_num   = get_theme_mod( 'crosskeys_about_stat2_num',   '25+' );
$stat2_label = get_theme_mod( 'crosskeys_about_stat2_label', 'Active Players' );
$stat3_num   = get_theme_mod( 'crosskeys_about_stat3_num',   '100%' );
$stat3_label = get_theme_mod( 'crosskeys_about_stat3_label', 'Community Focused' );
$stat4_num   = get_theme_mod( 'crosskeys_about_stat4_num',   '120+' );
$stat4_label = get_theme_mod( 'crosskeys_about_stat4_label', 'Years of Music' );

$rehearsal_day     = get_theme_mod( 'crosskeys_rehearsal_day',     'Tuesday' );
$rehearsal_time    = get_theme_mod( 'crosskeys_rehearsal_time',    '19:30 – 21:30' );
$rehearsal_venue   = get_theme_mod( 'crosskeys_rehearsal_venue',   'Pandy Park (Crosskeys RFC)' );
$rehearsal_address = get_theme_mod( 'crosskeys_rehearsal_address', "Woodward Ave, Crosskeys,\nNewport, NP11 7PU" );
$rehearsal_note    = get_theme_mod( 'crosskeys_rehearsal_note',    'Our rehearsals take place in the dedicated bandroom at Pandy Park. Ample free parking is available on-site.' );
$rehearsal_address_html = nl2br( esc_html( $rehearsal_address ) );

// ── Page-driven content ────────────────────────────────────────────────────────
// About / Our Story — body text from Pages → About (slug: about)
$about_page_obj = crosskeys_get_page( 'about' );
$about_content  = $about_page_obj
    ? apply_filters( 'the_content', $about_page_obj->post_content )
    : '';

if ( ! $about_content ) {
    // Fallback shown when the 'about' page hasn't been created/published yet
    $about_content = '<p>Founded in 1901 in the heart of the Western Valley of Monmouthshire, Crosskeys Silver Band has been a vital musical pillar of our local community for more than 125 years. Rooted in the rich industrial history of South Wales, the band initially brought together local coal miners and workers, establishing a tradition of camaraderie and artistic expression that continues to this day.</p>
<p>Today, we are a modern, forward-looking contesting band. We perform a wide range of repertoire, from traditional brass band marches and classical arrangements to contemporary concert items and film scores. We take pride in representing our region at Welsh contesting finals and community events alike.</p>
<p>Whether performing at local bandstands, concert halls, or competing on stage, Crosskeys Silver Band remains committed to delivering premium musical experiences and mentoring the next generation of brass instrumentalists.</p>';
}


// Conductor — from Pages → Conductor (slug: conductor)
//   Title   = conductor name
//   Excerpt = role / job title
//   Content = bio paragraphs
$conductor_page    = crosskeys_get_page( 'conductor' );
$conductor_name    = $conductor_page ? esc_html( $conductor_page->post_title )   : 'Dave Collins';
$conductor_role    = $conductor_page ? esc_html( $conductor_page->post_excerpt ) : 'Musical Director';
$conductor_content = $conductor_page
    ? apply_filters( 'the_content', $conductor_page->post_content )
    : '<p>Dave Collins is a first-class honors graduate in Music from Grey College, University of Durham, and holds a Masters in Musical Composition with distinction from Salford University. He is an accomplished conductor, orchestrator, and composer whose brass band works are performed globally by elite ensembles such as the Cory Band, the GUS Band, and the Carlton Main Colliery Band.</p>
<p>During his studies, Dave specialized in acoustical and electronic composition and trained under renowned brass figures including Ray Farr (Conducting and Arranging), Bennet Zon (Orchestration), and Huw Thomas (Conducting and Trumpet Performance). Outside of directing the Crosskeys Silver Band, he works in professional orchestral management.</p>
<p>Dave brings a rich combination of artistic caliber and structured training, maintaining the band\'s historic standards of excellence while introducing exciting and challenging repertoire to our rehearsal room.</p>';
?>

<?php if ( current_user_can( 'manage_options' ) ) :
  $debug_about     = crosskeys_get_page( 'about' );
  $debug_conductor = crosskeys_get_page( 'conductor' );
  $icon_ok  = '✅';
  $icon_err = '❌';
?>
<div style="position:fixed; bottom:1rem; right:1rem; z-index:9999; background:#121214; border:1px solid rgba(255,215,0,0.3); border-radius:8px; padding:1rem 1.5rem; font-family:monospace; font-size:0.8rem; color:#a1a1a6; max-width:340px;">
  <strong style="color:#ffd700; display:block; margin-bottom:0.5rem;">🛠 Admin — Page Source Debug</strong>
  <div><?php echo $debug_about ? $icon_ok . ' <strong style="color:#f5f5f7">About</strong> found (ID: ' . $debug_about->ID . ')' : $icon_err . ' <strong style="color:#ff4757">About</strong> NOT found — check slug is exactly <code>about</code> and status is Published'; ?></div>
  <div style="margin-top:0.4rem"><?php echo $debug_conductor ? $icon_ok . ' <strong style="color:#f5f5f7">Conductor</strong> found (ID: ' . $debug_conductor->ID . ')' : $icon_err . ' <strong style="color:#ff4757">Conductor</strong> NOT found — check slug is exactly <code>conductor</code> and status is Published'; ?></div>
  <div style="margin-top:0.6rem; font-size:0.75rem; color:#666;">Visible to admins only. Dismiss once working.</div>
</div>
<?php endif; ?>

<!-- ════════════════════════════════════
     HERO SECTION
     ════════════════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-bg" style="background-image: linear-gradient(to bottom, rgba(10,10,11,0.55), var(--bg-primary)), url('<?php echo esc_url( get_template_directory_uri() ); ?>/images/hero-bg.jpg');"></div>
  <div class="hero-logo-glow"></div>

  <div class="hero-content">
    <span class="hero-pre reveal"><?php echo esc_html( $hero_pre ); ?></span>
    <h1 class="hero-title reveal"><?php echo esc_html( $hero_title ); ?></h1>
    <p class="hero-desc reveal"><?php echo esc_html( $hero_desc ); ?></p>
    <div class="hero-btns reveal">
      <a href="#rehearsals" class="btn btn-primary" id="hero-btn-rehearsals">Join A Rehearsal</a>
      <a href="#contact"    class="btn btn-outline"  id="hero-btn-contact">Book the Band</a>
    </div>
  </div>
</section>


<!-- ════════════════════════════════════
     ABOUT / OUR STORY
     Content from: Pages → About
     ════════════════════════════════════ -->
<section class="container" id="about">
  <div class="about-grid">

    <div class="about-text reveal">
      <h2 class="section-title">Our Story</h2>
      <p class="section-subtitle" style="margin-left:0; text-align:left;">From local roots to the national stage.</p>
      <?php echo $about_content; ?>
    </div>

    <div class="about-highlights reveal">
      <div class="highlight-box">
        <span class="highlight-number"><?php echo esc_html( $stat1_num ); ?></span>
        <span class="highlight-label"><?php echo esc_html( $stat1_label ); ?></span>
      </div>
      <div class="highlight-box">
        <span class="highlight-number"><?php echo esc_html( $stat2_num ); ?></span>
        <span class="highlight-label"><?php echo esc_html( $stat2_label ); ?></span>
      </div>
      <div class="highlight-box">
        <span class="highlight-number"><?php echo esc_html( $stat3_num ); ?></span>
        <span class="highlight-label"><?php echo esc_html( $stat3_label ); ?></span>
      </div>
      <div class="highlight-box">
        <span class="highlight-number"><?php echo esc_html( $stat4_num ); ?></span>
        <span class="highlight-label"><?php echo esc_html( $stat4_label ); ?></span>
      </div>
    </div>

  </div>
</section>


<!-- ════════════════════════════════════
     CONDUCTOR
     Content from: Pages → Conductor
       Title   = name
       Excerpt = role
       Content = bio
     ════════════════════════════════════ -->
<section class="conductor-bg" id="conductor">
  <div class="container">
    <div class="conductor-grid">

      <div class="conductor-img-container reveal">
        <div class="conductor-deco-border"></div>
        <div class="conductor-frame">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/conductor.jpg"
               alt="<?php echo $conductor_name; ?> — <?php echo $conductor_role; ?> of Crosskeys Silver Band">
        </div>
      </div>

      <div class="conductor-bio reveal">
        <h2 class="section-title" style="margin-left:0; text-align:left;">The Conductor</h2>
        <span class="conductor-role"><?php echo $conductor_name; ?> — <?php echo $conductor_role; ?></span>
        <div class="conductor-bio-text">
          <?php echo $conductor_content; ?>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ════════════════════════════════════
     EVENTS
     Managed via: wp-admin → Events
     ════════════════════════════════════ -->
<?php
$events = crosskeys_get_events();
if ( ! empty( $events ) ) :
?>
<section class="container" id="events" style="margin-bottom: 2rem;">
  <div class="text-center reveal">
    <h2 class="section-title">Upcoming Events</h2>
    <p class="section-subtitle">Catch us performing at these upcoming concerts and contests.</p>
  </div>

  <div class="events-grid reveal" id="events-list">
    <?php
      foreach ( $events as $e ) :
        $date_formatted = ! empty( $e['date'] ) ? date( 'j M Y', strtotime( $e['date'] ) ) : '';
        $time_str       = esc_html( $e['time'] );
        $venue_str      = esc_html( $e['venue'] );
        $desc_str       = esc_html( $e['description'] );
        $title_str      = esc_html( $e['title'] );
        $link           = esc_url( $e['ticket_link'] );
    ?>
      <div class="glass-card event-card">
        <div class="event-date-block">
          <span class="event-month"><?php echo date('M', strtotime($e['date'])); ?></span>
          <span class="event-day"><?php echo date('d', strtotime($e['date'])); ?></span>
          <span class="event-year"><?php echo date('Y', strtotime($e['date'])); ?></span>
        </div>
        <div class="event-content">
          <h3 class="event-title"><?php echo $title_str; ?></h3>
          <div class="event-meta">
            <?php if ($time_str) : ?><span class="event-time"><i class="far fa-clock"></i> <?php echo $time_str; ?></span><?php endif; ?>
            <?php if ($venue_str) : ?><span class="event-venue"><i class="fas fa-map-marker-alt"></i> <?php echo $venue_str; ?></span><?php endif; ?>
          </div>
          <?php if ($desc_str) : ?><p class="event-desc"><?php echo nl2br($desc_str); ?></p><?php endif; ?>
        </div>
        <?php if ($link) : ?>
        <div class="event-action">
          <a href="<?php echo $link; ?>" class="btn btn-outline btn-sm" target="_blank" rel="noopener">More Info / Tickets</a>
        </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>


<!-- ════════════════════════════════════
     VACANCIES
     Managed via: wp-admin → Vacancies
     ════════════════════════════════════ -->
<section class="container" id="vacancies">
  <div class="text-center reveal">
    <h2 class="section-title">Join The Band</h2>
    <p class="section-subtitle">We are always happy to hear from friendly, committed musicians. Explore our current player vacancies below.</p>
  </div>

  <div class="vacancies-grid" id="vacancies-list">
    <?php
    $vacancies = crosskeys_get_vacancies();

    if ( ! empty( $vacancies ) ) :
      foreach ( $vacancies as $v ) :
        $date_formatted = ! empty( $v['date_added'] )
          ? date( 'j M Y', strtotime( $v['date_added'] ) )
          : '';
        $instrument = esc_html( $v['instrument'] );
        $section    = esc_html( $v['section'] ?: 'General' );
        $desc       = esc_html( $v['description'] );
        $date_str   = esc_html( $date_formatted );
    ?>
      <div class="glass-card vacancy-card reveal">
        <div class="vacancy-header">
          <h3 class="vacancy-instrument"><?php echo $instrument; ?></h3>
          <span class="vacancy-badge"><?php echo $section; ?></span>
        </div>
        <p class="vacancy-desc"><?php echo $desc; ?></p>
        <div class="vacancy-footer">
          <span>Added: <?php echo $date_str; ?></span>
          <a href="#contact"
             class="btn btn-outline btn-sm apply-btn"
             data-instrument="<?php echo $instrument; ?>">Apply Now</a>
        </div>
      </div>
    <?php
      endforeach;
    else :
    ?>
      <div class="glass-card no-vacancies-card reveal active">
        <div class="no-vacancies-icon">📯</div>
        <h3>No Current Vacancies</h3>
        <p class="section-subtitle" style="margin-bottom:1.5rem; max-width:100%;">
          We don't have any specific player vacancies at the moment. However, we are a friendly and welcoming band, and we always love to meet new players.
        </p>
        <p class="section-subtitle" style="margin-bottom:2rem; max-width:100%;">
          If you play a brass or percussion instrument and want to join us for a rehearsal, please contact us or drop by!
        </p>
        <a href="#contact" class="btn btn-primary">Get In Touch</a>
      </div>
    <?php endif; ?>
  </div>
</section>


<!-- ════════════════════════════════════
     REHEARSALS & MAP
     Settings: Appearance → Customize → Rehearsals
     ════════════════════════════════════ -->
<section class="rehearsal-bg" id="rehearsals">
  <div class="container rehearsal-grid">

    <div class="rehearsal-info reveal">
      <h2 class="section-title" style="margin-left:0; text-align:left;">Rehearsals</h2>
      <p class="section-subtitle" style="margin-left:0; text-align:left;">Come along to hear us play or join in.</p>

      <div class="rehearsal-time-card">
        <h3>Rehearsal Times</h3>
        <div class="time-item">
          <span class="time-day"><?php echo esc_html( $rehearsal_day ); ?></span>
          <span class="time-hours"><?php echo esc_html( $rehearsal_time ); ?></span>
        </div>
      </div>

      <div class="rehearsal-location-card">
        <h3>Location</h3>
        <p style="color:var(--text-secondary); margin-bottom:1rem;">
          <strong><?php echo esc_html( $rehearsal_venue ); ?></strong><br>
          <?php echo $rehearsal_address_html; ?>
        </p>
        <p style="font-size:0.95rem; color:var(--text-secondary);">
          <?php echo esc_html( $rehearsal_note ); ?>
        </p>
      </div>
    </div>

    <div class="map-wrapper reveal">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2477.139326256424!2d-3.1297874!3d51.6206569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486e1fea07e3df35%3A0xa706ca215bfa90cd!2sCross+Keys+Silver+Band!5e0!3m2!1sen!2suk!4v1719600000000!5m2!1sen!2suk"
        width="600" height="450"
        allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Google Maps Location of Crosskeys Silver Bandroom">
      </iframe>
    </div>

  </div>
</section>


<!-- ════════════════════════════════════
     CONTACT
     ════════════════════════════════════ -->
<section class="container" id="contact">
  <div class="contact-grid">

    <div class="contact-details reveal">
      <div>
        <h2 class="section-title" style="margin-left:0; text-align:left;">Get In Touch</h2>
        <p class="section-subtitle" style="margin-left:0; text-align:left;">We would love to hear from you, whether you want to book the band, enquire about joining, or ask a question.</p>
      </div>

      <div class="contact-item">
        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
        <div class="contact-item-content">
          <h4>Email Us</h4>
          <p><a href="mailto:secretary@crosskeysband.co.uk">secretary@crosskeysband.co.uk</a></p>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-icon"><i class="fas fa-location-dot"></i></div>
        <div class="contact-item-content">
          <h4>Find Us</h4>
          <p>Pandy Park, Woodward Ave, Crosskeys, NP11 7PU</p>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-icon"><i class="fab fa-facebook-f"></i></div>
        <div class="contact-item-content">
          <h4>Facebook Page</h4>
          <p><a href="https://www.facebook.com/CrosskeysSilverBand" target="_blank" rel="noopener">facebook.com/CrosskeysSilverBand</a></p>
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-icon"><i class="fab fa-youtube"></i></div>
        <div class="contact-item-content">
          <h4>YouTube Channel</h4>
          <p><a href="https://www.youtube.com/CrossKeysSilverBand" target="_blank" rel="noopener">youtube.com/CrossKeysSilverBand</a></p>
        </div>
      </div>
    </div>

    <div class="glass-card contact-form reveal">
      <?php
      if ( function_exists( 'wpcf7' ) ) :
        echo do_shortcode( '[contact-form-7 id="crosskeys-contact" title="Crosskeys Contact Form"]' );
      else :
      ?>
        <form id="contact-form" action="mailto:secretary@crosskeysband.co.uk" method="post" enctype="text/plain">
          <div class="form-group">
            <label for="name">Your Name *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="e.g. John Evans" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="e.g. john@example.com" required>
          </div>
          <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" class="form-control" placeholder="e.g. Booking Enquiry">
          </div>
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" class="form-control" placeholder="Your message here..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;" id="contact-submit-btn">Send Message</button>
          <p style="font-size:0.8rem; color:var(--text-secondary); margin-top:0.8rem; text-align:center;">
            Install <strong>Contact Form 7</strong> + <strong>WP Mail SMTP</strong> for reliable email delivery.
          </p>
        </form>
      <?php endif; ?>
    </div>

  </div>
</section>

<?php get_footer(); ?>
