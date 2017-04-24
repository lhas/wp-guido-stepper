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
          'url' => wp_get_attachment_image_src($image_id, 'thumbnail'),
          'title' => get_the_title($image_id),
        ];
      }

      $index = preg_replace('/\D/', '', $k);
      $slide_slides[] = [
        'background' => get_post_meta($slide->ID, 'background_' . $index, true),
        'headline' => get_post_meta($slide->ID, 'title_' . $index, true),
        'subtitle' => get_post_meta($slide->ID, 'subtitle_' . $index, true),
        'images' => $images,
      ];
    }
  }
?>

<div class="guido-stepper-container">
  <div class="guido-stepper">
    <?php foreach($slide_slides as $slide_slide) : ?>
    <div class="guido-stepper-slide" style="background: <?php echo $slide_slide['background']; ?>;">
      <h2 class="guido-stepper-headline"><?php echo $slide_slide['headline']; ?></h2>
      <h3 class="guido-stepper-subtitle"><?php echo $slide_slide['subtitle']; ?></h3>

      <?php foreach($slide_slide['images'] as $image) : ?>
      <a href="#" class="guido-stepper-slide-item" data-headline="<?php echo $slide_slide['headline']; ?>" data-value="<?php echo $image['title']; ?>">
        <img src="<?php echo $image['url'][0]; ?>" />
        <span class="guido-stepper-slide-item-title"><?php echo $image['title']; ?></span>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

    <!-- 1st SLIDE -->
    <div class="guido-stepper-slide form-slide">
      <h2 class="guido-stepper-headline"><?php echo get_post_meta($slide->ID, '1st_form_headline', true); ?></h2>
      <h3 class="guido-stepper-subtitle"><?php echo get_post_meta($slide->ID, '1st_form_subtitle', true); ?></h3>

      <form class="guido-stepper-form" data-step="1st" data-slide="<?php echo $slide->post_title; ?>">
        <input type="hidden" name="to" value="<?php echo get_post_meta($slide->ID, 'to', true); ?>" />
        <?php
          $inputs = new WP_Query([
            'post_type' => 'gs_inputs',
            'limit' => 9999,
          ]);

          foreach($inputs->posts as $index => $input) :
          if(get_post_meta($input->ID, 'belongs_to', true) === '1st_slide') :
        ?>
          <div class="form-slide-input <?php echo ($index % 2 === 0) ? 'even' : 'odd'; ?>">
            <label><?php echo $input->post_title; ?> *</label>
            <input type="<?php echo get_post_meta($input->ID, 'type', true); ?>" required name="<?php echo $input->ID; ?>" />
          </div> <!-- .form-slide-input -->
        <?php endif; endforeach; ?>

        <button type="submit" class="guido-stepper-submit-button"><?php echo get_post_meta($slide->ID, '1st_form_submit', true); ?></button>
      </form>

      <img src="<?php echo plugin_dir_url(__FILE__) . '/../../img/loading.svg'; ?>" class="gs-loading" alt="">
    </div> <!-- .form-slide -->

    <!-- 2nd SLIDE -->
    <div class="guido-stepper-slide form-slide">
      <h2 class="guido-stepper-headline"><?php echo get_post_meta($slide->ID, '2nd_form_headline', true); ?></h2>
      <h3 class="guido-stepper-subtitle"><?php echo get_post_meta($slide->ID, '2nd_form_subtitle', true); ?></h3>

      <form class="guido-stepper-form" data-step="2nd" data-slide="<?php echo $slide->post_title; ?>">
        <?php
          $inputs = new WP_Query([
            'post_type' => 'gs_inputs',
            'limit' => 9999,
          ]);

          foreach($inputs->posts as $input) :
          if(get_post_meta($input->ID, 'belongs_to', true) === '2nd_slide') :
        ?>
          <div class="form-slide-input">
            <label><?php echo $input->post_title; ?> *</label>
            <input type="<?php echo get_post_meta($input->ID, 'type', true); ?>" required name="<?php echo $input->ID; ?>" />
          </div> <!-- .form-slide-input -->
        <?php endif; endforeach; ?>

        <button type="submit" class="guido-stepper-submit-button"><?php echo get_post_meta($slide->ID, '2nd_form_submit', true); ?></button>
      </form>

      <img src="<?php echo plugin_dir_url(__FILE__) . '/../../img/loading.svg'; ?>" class="gs-loading" alt="">
    </div> <!-- .form-slide -->


    <div class="guido-stepper-slide thank-you-slide">
      <h2>Thank you</h2>
    </div>
  </div> <!-- .guido-stepper -->
</div> <!-- .guido-stepper-container -->

<style type="text/css">
.guido-stepper-submit-button {
  color: <?php echo $atts['submit_button_color']; ?> !important;
  background: <?php echo $atts['submit_button_background']; ?> !important;
}
</style>