<?php
/**
 * page-policies.php — Policies & Governance Page
 *
 * WordPress loads this template when the page slug is "policies".
 * Upload your PDF files to the WordPress Media Library and update the
 * links below with the URLs you get from Media → Library → attachment URL.
 *
 * Alternatively, use the ACF or custom fields plugin to manage the PDF URLs
 * from the admin and replace the hard-coded URLs here with get_field() calls.
 */

get_header();
?>

<!-- Policies Hero -->
<section class="policies-hero">
  <div class="container" style="padding:0;">
    <h1 class="accent-text" style="font-size:3rem; margin-bottom:1rem;">Policies &amp; Governance</h1>
    <p class="section-subtitle" style="margin-bottom:0;">
      As a registered charity and community group, Crosskeys Silver Band is committed to transparency, safety, and proper governance.
      You can view and download our official policy documents below.
    </p>
  </div>
</section>

<!-- Policy Cards Grid -->
<main class="container" style="padding-top:40px; padding-bottom:80px;">

  <!-- Admin notice (only visible to admins) -->
  <?php if ( current_user_can( 'manage_options' ) ) : ?>
  <div class="glass-card" style="margin-bottom:3rem; border-color:rgba(255,215,0,0.2); background:rgba(255,215,0,0.02);">
    <h3 style="color:var(--color-gold); margin-bottom:0.5rem; display:flex; align-items:center; gap:8px;">
      <i class="fas fa-info-circle"></i> Admin Notice
    </h3>
    <p style="font-size:0.95rem; color:var(--text-secondary);">
      To update a policy PDF, go to <strong>Media → Add New</strong> in the WordPress admin, upload the PDF,
      then copy its URL and paste it into the relevant "View Policy PDF" link in
      <strong>Appearance → Theme File Editor → page-policies.php</strong>.
    </p>
  </div>
  <?php endif; ?>

  <div class="policies-grid">

    <!-- Safeguarding Policy -->
    <div class="glass-card policy-card reveal active">
      <div class="policy-icon"><i class="fas fa-user-shield"></i></div>
      <h3 class="policy-title">Safeguarding Policy</h3>
      <p class="policy-desc">Our commitment to ensuring a safe environment for all members, especially children, young people, and vulnerable adults who participate in our rehearsals and events.</p>
      <div class="policy-meta"><span><strong>File:</strong> safeguarding.pdf</span></div>
      <a href="<?php echo esc_url( get_template_directory_uri() ); ?>/policies/safeguarding.pdf"
         target="_blank" class="btn btn-primary" id="btn-safeguarding">View Policy PDF</a>
    </div>

    <!-- GDPR / Data Protection -->
    <div class="glass-card policy-card reveal active">
      <div class="policy-icon"><i class="fas fa-shield-halved"></i></div>
      <h3 class="policy-title">Data Protection (GDPR)</h3>
      <p class="policy-desc">Details how Crosskeys Silver Band collects, stores, and manages personal data of members, supporters, and clients in compliance with data privacy regulations.</p>
      <div class="policy-meta"><span><strong>File:</strong> gdpr.pdf</span></div>
      <a href="<?php echo esc_url( get_template_directory_uri() ); ?>/policies/gdpr.pdf"
         target="_blank" class="btn btn-primary" id="btn-gdpr">View Policy PDF</a>
    </div>

    <!-- Band Constitution -->
    <div class="glass-card policy-card reveal active">
      <div class="policy-icon"><i class="fas fa-gavel"></i></div>
      <h3 class="policy-title">Band Constitution</h3>
      <p class="policy-desc">The governing document outlining the objectives of Crosskeys Silver Band, the rules of membership, and the structure and operation of the band's elected committee.</p>
      <div class="policy-meta"><span><strong>File:</strong> constitution.pdf</span></div>
      <a href="<?php echo esc_url( get_template_directory_uri() ); ?>/policies/constitution.pdf"
         target="_blank" class="btn btn-primary" id="btn-constitution">View Policy PDF</a>
    </div>

    <!-- Code of Conduct -->
    <div class="glass-card policy-card reveal active">
      <div class="policy-icon"><i class="fas fa-file-signature"></i></div>
      <h3 class="policy-title">Code of Conduct</h3>
      <p class="policy-desc">Outlines the standards of behavior, respect, and attendance expected of all band members during rehearsals, contests, concerts, and public engagements.</p>
      <div class="policy-meta"><span><strong>File:</strong> code-of-conduct.pdf</span></div>
      <a href="<?php echo esc_url( get_template_directory_uri() ); ?>/policies/code-of-conduct.pdf"
         target="_blank" class="btn btn-primary" id="btn-conduct">View Policy PDF</a>
    </div>

    <!-- Health & Safety -->
    <div class="glass-card policy-card reveal active">
      <div class="policy-icon"><i class="fas fa-kit-medical"></i></div>
      <h3 class="policy-title">Health &amp; Safety</h3>
      <p class="policy-desc">Outlines safety precautions and risk assessment guidelines for our rehearsal facilities at Pandy Park and at our outdoor concert bookings.</p>
      <div class="policy-meta"><span><strong>File:</strong> health-safety.pdf</span></div>
      <a href="<?php echo esc_url( get_template_directory_uri() ); ?>/policies/health-safety.pdf"
         target="_blank" class="btn btn-primary" id="btn-health-safety">View Policy PDF</a>
    </div>

    <!-- Equality & Diversity -->
    <div class="glass-card policy-card reveal active">
      <div class="policy-icon"><i class="fas fa-users-rectangle"></i></div>
      <h3 class="policy-title">Equality &amp; Diversity</h3>
      <p class="policy-desc">Our policy promoting equal opportunities, inclusivity, and welcoming players of all backgrounds, abilities, and identities to make music together.</p>
      <div class="policy-meta"><span><strong>File:</strong> equality-diversity.pdf</span></div>
      <a href="<?php echo esc_url( get_template_directory_uri() ); ?>/policies/equality-diversity.pdf"
         target="_blank" class="btn btn-primary" id="btn-equality">View Policy PDF</a>
    </div>

  </div>
</main>

<?php get_footer(); ?>
