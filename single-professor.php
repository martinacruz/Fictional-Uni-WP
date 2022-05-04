<?php
get_header();
while(have_posts()) {
    the_post();
    pageBanner();
     ?> ?>

    <div class="container container--narrow page-section">

    <!-- <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event');?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> <span class="metabox__main"> <?php the_title() ?></span>
        </p>
      </div> -->

        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail('professorPortrait'); ?></div>
                <div class="two-thirds"><?php the_content(); ?></div>
            </div>
        </div>



        <?php 
        // adding relationship between events and programs
        $relatedPrograms = get_field('related_programs');

        if($relatedPrograms) {
          echo '<hr class="section-break">';
          echo '<ul class="link-list min-list">';
          echo '<h2 class="headline headline--medium">Subject(s) Tought</h2>';
          foreach($relatedPrograms as $program) { ?>
            <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program) ?></a></li>
          <?php }
          echo '</ul>';
  
          // print_r($relatedPrograms);
        }
          ?>

      
    </div>
<?php }
get_footer();
?>
