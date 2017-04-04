# Guido Stepper

## Overview

This plugin helps to create rich interfaces where site admin can create dynamically.

The site admin create:
1. Some input forms to display at the end;
2. Some slides to display at front page;

Then, after visitors interact with the slides, the side admin will have access to visitors information in WordPress (on Registrations page) or in e-mail.

## How to install

1. Download this project.
2. Extract it at `wp-content/plugins/wp-guido-stepper`.
3. Activate it in WordPress.

You should have access to plugin menu after activate it.

## Dependencies

1. [Slick Carousel](http://kenwheeler.github.io/slick/)

## Shortcodes

After create one slide, you can output it in frontpase using this shortcode:

`[stepper name="Slide name here"]`

This will display the Stepper in front page.

## FAQ

1. What is the e-mail who receives all the visitor information?

Is the e-mail filled in "Settings -> General -> Email Address".

2. Can i apply multiples shortcodes in same page?

Yes, you can. You should be able to use multiples shortcodes in the same page.

3. Why we have "Inputs"?

This way, the site admin can create infinites input fields to display for visitors. Inputs created dynamically increases the customization use in plugin.

4. How to set the image legend?

The plugin uses the image title as legend, so before you add the image as attachment to the slide, you should change the title as you desire.

5. Why we have "Registrations"?

To store all information submitted by visitors in Wordpress backend too (not only in e-mail).

6. What is the method to send the e-mail?

The plugin uses the [wp_mail()](https://developer.wordpress.org/reference/functions/wp_mail/) function to do the job.
