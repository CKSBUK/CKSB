<?php
/**
 * index.php — Crosskeys Silver Band Theme
 *
 * This is the fallback template WordPress uses if no more-specific template
 * exists (e.g. for blog posts, 404s, search results, etc.).
 * For the site's main content this is handled by front-page.php.
 */

get_header();
?>

<main style="padding-top: 120px; min-height: 60vh;">
  <div class="container">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article>
          <h1 class="section-title"><?php the_title(); ?></h1>
          <div class="conductor-bio-text" style="margin-top: 2rem;">
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <div class="text-center" style="padding: 4rem 0;">
        <h2 class="section-title">Page Not Found</h2>
        <p class="section-subtitle">Sorry, the page you were looking for doesn't exist.</p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary" style="margin-top: 1.5rem;">
          Back to Home
        </a>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
