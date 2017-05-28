<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package travelogue
 */

        global $travelogue_redux_options;
        ?>

        <!-- Back to top button -->
        <?php if (isset($travelogue_redux_options['back_to_top']) && $travelogue_redux_options['back_to_top'] == 1) { ?>
             <a href="#0" class="back-to-top"><?php echo esc_attr__('Top','travelogue'); ?></a>
        <?php } ?> 

        </div>

        <?php wp_footer(); ?>
    </body>
</html>