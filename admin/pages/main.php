<div class="wrap">
  <h1>Guido Stepper</h1>

  <div class="welcome-panel">
    <div class="welcome-panel-content">
      <h2>Welcome!</h2>
      <p class="about-description">This is the main page for the plugin.</p>

      <div class="welcome-panel-column-container">
        <div class="welcome-panel-column">
          <h3>Next Steps</h3>
          <ul>
            <li>1) Create some input forms;</li>
            <li>2) Create some slides;</li>
            <li>3) Apply the plugin shortcode at one page;</li>
            <li>4) Manage registrations.</li>
          </ul>
        </div>
        <div class="welcome-panel-column" style="width: 64%;">
          <a href="<?php echo admin_url('edit.php?post_type=gs_inputs'); ?>" class="button button-primary button-hero load-customize hide-if-no-customize">Input Forms</a>
          <a href="<?php echo admin_url('edit.php?post_type=gs_slides'); ?>" class="button button-primary button-hero load-customize hide-if-no-customize">Slides</a>
          <a href="<?php echo admin_url('edit.php?post_type=gs_registrations'); ?>" class="button button-primary button-hero load-customize hide-if-no-customize">Registrations</a>
        </div>
      </div>
    </div>
  </div>


  <?php
    $slides = new WP_Query(['post_type' => 'gs_slides']);
  ?>

  <h1>Shortcodes</h1>

  <p>Here will display all shortcodes available for each slide:</p>

  <?php foreach($slides->posts as $slide): ?>
    <h2><?php echo $slide->post_title; ?></h2>
    <textarea style="width: 100%; height: 40px; line-height: 30px; resize: none;" onClick="this.select()">[stepper name="<?php echo $slide->post_title; ?>" to="example@email.com" submit_button_background="#222" submit_button_color="#FFF" 1st_slide_submit="Send Data" 2nd_slide_submit="Submit Data"]</textarea>
  <?php endforeach; ?>

</div>