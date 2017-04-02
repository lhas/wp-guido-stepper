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
          <a href="#" class="button button-primary button-hero load-customize hide-if-no-customize">Input Forms</a>
          <a href="#" class="button button-primary button-hero load-customize hide-if-no-customize">Slides</a>
          <a href="#" class="button button-primary button-hero load-customize hide-if-no-customize">Registrations</a>
        </div>
      </div>
    </div>
  </div>


  <?php
    $slides = new WP_Query(['post_type' => 'gs_slides']);
    $slide = @$slides->posts[0];
  ?>

  <?php if(!empty($slide)) : ?>
  <?php
    $slide_meta = get_post_meta($slide->ID, '');
    $slide_slides = [];

    foreach($slide_meta as $k => $v) {
      if(preg_match('/slide\_/', $k)) {
        $images_id = explode(',', $v[0]);
        $images = [];

        foreach($images_id as $image_id) {
          $image = wp_get_attachment_url($image_id);
          $images[] = $image;
        }

        $slide_slides[] = [
          'headline' => $k,
          'images' => $images,
        ];
      }
    }
  ?>
  <h1>Demo</h1>

  <div class="guido-stepper">
    <?php foreach($slide_slides as $slide_slide) : ?>
    <div class="guido-stepper-slide">
      <h2><?php echo $slide_slide['headline']; ?></h2>

      <?php foreach($slide_slide['images'] as $image) : ?>
      <a href="#" class="guido-stepper-slide-item" style="width: 100px; height: 100px; display: inline-block;">
        <img src="<?php echo $image; ?>" style="width: 100%;" />
      </a>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <div class="guido-stepper-slide form-slide">
      <h2>Form Slide</h2>

      <?php
        $inputs = new WP_Query([
          'post_type' => 'gs_inputs',
          'limit' => 9999,
        ]);

        foreach($inputs->posts as $input) :
      ?>
        <div class="form-slide-input">
          <label><?php echo $input->post_title; ?></label>
          <input type="<?php echo get_post_meta($input->ID, 'type'); ?>" placeholder="<?php echo $input->post_title; ?>" />
        </div> <!-- .form-slide-input -->
      <?php endforeach; ?>

      <button type="button" class="guido-stepper-submit-button">Submit</button>
    </div>
    <div class="guido-stepper-slide thank-you-slide">
      <h2>Thank you</h2>
    </div>
  </div> <!-- .guido-stepper -->
  <?php endif; ?>

</div>