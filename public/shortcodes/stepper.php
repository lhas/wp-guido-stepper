<?php
  $slide = get_page_by_title($slide_name, OBJECT, 'gs_slides');

  $slide_meta = get_post_meta($slide->ID, '');
  $slide_slides = [];

  foreach($slide_meta as $k => $v) {
    if(preg_match('/slide\_/', $k)) {
      $images_id = explode(',', $v[0]);
      $images = [];

      foreach($images_id as $image_id) {
        $images[] = [
          'url' => wp_get_attachment_url($image_id),
          'title' => get_the_title($image_id),
        ];
      }

      $index = preg_replace('/\D/', '', $k);
      $slide_slides[] = [
        'headline' => get_post_meta($slide->ID, 'title_' . $index, true),
        'images' => $images,
      ];
    }
  }
?>

<div class="guido-stepper-container">
  <div class="guido-stepper">
    <?php foreach($slide_slides as $slide_slide) : ?>
    <div class="guido-stepper-slide">
      <h2 class="guido-stepper-headline"><?php echo $slide_slide['headline']; ?></h2>

      <?php foreach($slide_slide['images'] as $image) : ?>
      <a href="#" class="guido-stepper-slide-item" data-headline="<?php echo $slide_slide['headline']; ?>" data-value="<?php echo $image['title']; ?>">
        <img src="<?php echo $image['url']; ?>" />
        <span class="guido-stepper-slide-item-title"><?php echo $image['title']; ?></span>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <div class="guido-stepper-slide form-slide">
      <h2 class="guido-stepper-headline">Form Slide</h2>

      <form class="guido-stepper-form" data-slide="<?php echo $slide->post_title; ?>">
        <?php
          $inputs = new WP_Query([
            'post_type' => 'gs_inputs',
            'limit' => 9999,
          ]);

          foreach($inputs->posts as $input) :
        ?>
          <div class="form-slide-input">
            <label><?php echo $input->post_title; ?></label>
            <input type="<?php echo get_post_meta($input->ID, 'type', true); ?>" required name="<?php echo $input->ID; ?>" placeholder="<?php echo $input->post_title; ?>" />
          </div> <!-- .form-slide-input -->
        <?php endforeach; ?>

        <button type="submit" class="guido-stepper-submit-button">Submit</button>
      </form>

      <img src="<?php echo plugin_dir_url(__FILE__) . '/../../img/loading.svg'; ?>" class="gs-loading" alt="">
    </div> <!-- .form-slide -->
    <div class="guido-stepper-slide thank-you-slide">
      <h2>Thank you</h2>
    </div>
  </div> <!-- .guido-stepper -->
</div> <!-- .guido-stepper-container -->