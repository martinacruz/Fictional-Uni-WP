<?php
get_header();
while(have_posts()) {
    the_post(); ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php $pageBannerImg = get_field('page_banner_background_image'); echo $pageBannerImg['url']; ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title()?></h1>
        <div class="page-banner__intro">
          <p><?php the_field('page_banner_subtitle') ?></p>
        </div>
      </div>
    </div>

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
