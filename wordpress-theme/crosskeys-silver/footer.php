<?php
/**
 * footer.php — Crosskeys Silver Band Theme
 */
?>
  <!-- ── Footer ── -->
  <footer id="main-footer">
    <div class="container" style="padding: 0 0 30px 0;">
      <div class="footer-grid">

        <div class="footer-info">
          <h4 class="brand-font">Crosskeys<br><span class="accent-text">Silver Band</span></h4>
          <p>A community brass band in South Wales, rehearsing Tuesdays at Pandy Park.</p>
          <div class="social-links">
            <a href="https://www.facebook.com/CrosskeysSilverBand" target="_blank" rel="noopener"
               class="social-btn" aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.youtube.com/CrossKeysSilverBand" target="_blank" rel="noopener"
               class="social-btn" aria-label="YouTube">
              <i class="fab fa-youtube"></i>
            </a>
            <a href="mailto:secretary@crosskeysband.co.uk" class="social-btn" aria-label="Email">
              <i class="fas fa-envelope"></i>
            </a>
          </div>
        </div>

        <div class="footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>">Our Story</a></li>
            <li><a href="<?php echo esc_url( home_url( '/#conductor' ) ); ?>">Musical Director</a></li>
            <li><a href="<?php echo esc_url( home_url( '/#vacancies' ) ); ?>">Vacancies</a></li>
            <li><a href="<?php echo esc_url( home_url( '/#rehearsals' ) ); ?>">Rehearsals</a></li>
          </ul>
        </div>

        <div class="footer-links">
          <h4>Information</h4>
          <ul>
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'policies' ) ) ); ?>">Policies &amp; Governance</a></li>
            <li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Bookings &amp; Contact</a></li>
          </ul>
        </div>

      </div>

      <div class="footer-bottom">
        <p>&copy; <?php echo date( 'Y' ); ?> Crosskeys Silver Band. All rights reserved. Registered Charity in England &amp; Wales (<a href="https://register-of-charities.charitycommission.gov.uk/en/charity-search/-/charity-details/5014261?_uk_gov_ccew_onereg_charitydetails_web_portlet_CharityDetailsPortlet_organisationNumber=5014261" target="_blank" rel="noopener" style="color:inherit; text-decoration:underline;">1139417</a>).</p>
      </div>
    </div>
  </footer>

<?php wp_footer(); ?>
</body>
</html>
