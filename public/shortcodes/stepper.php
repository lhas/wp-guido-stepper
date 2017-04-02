<?php
  $slide = get_page_by_title($slide_name, OBJECT, 'gs_slides');

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

      $index = preg_replace('/\D/', '', $k);
      $slide_slides[] = [
        'headline' => get_post_meta($slide->ID, 'title_' . $index, true),
        'images' => $images,
      ];
    }
  }
?>

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

    <form class="guido-stepper-form">
      <?php
        $inputs = new WP_Query([
          'post_type' => 'gs_inputs',
          'limit' => 9999,
        ]);

        foreach($inputs->posts as $input) :
      ?>
        <div class="form-slide-input">
          <label><?php echo $input->post_title; ?></label>
          <input type="<?php echo get_post_meta($input->ID, 'type', true); ?>" required name="<?php echo $input->post_title; ?>" placeholder="<?php echo $input->post_title; ?>" />
        </div> <!-- .form-slide-input -->
      <?php endforeach; ?>

      <button type="submit" class="guido-stepper-submit-button">Submit</button>
    </form>
  </div> <!-- .form-slide -->
  <div class="guido-stepper-slide thank-you-slide">
    <h2>Thank you</h2>
  </div>
</div> <!-- .guido-stepper -->