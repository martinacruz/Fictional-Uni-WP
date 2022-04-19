<!-- When we create an archive theme for our customs post types we need to name it 'archive-CUSTOME_POST_TYPE_NAME'.php -->
<!-- If one is not found WP will use the defualt 'archive.php' file to display -->

<?php 
get_header(); ?>

<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri("/images/ocean.jpg") ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"> All Events</h1>
        <div class="page-banner__intro">
          <p>See what is going on in our world.</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">
      <?php 
      //this while loop: WHILE we have posts in our db (have_posts()) grab each individual post(the_post())
      while(have_posts()){
        the_post(); ?>
              <div class="event-summary">
              <a class="event-summary__date t-center" href="<?php the_permalink() ?>">
          <span class="event-summary__month"><?php 
          $eventDate = new DateTime(get_field('event_date'));
          echo $eventDate -> format('M');
          ?></span>
          <span class="event-summary__day"><?php 
          $eventDate = new DateTime(get_field('event_date'));
          echo $eventDate -> format('d');
          ?></span>
        </a>

        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
          <p><?php echo wp_trim_words(get_the_content(), 18) ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
        </div>
      </div>

      <?php }
        echo paginate_links();
      ?>

      <hr class="section-break">

      <p>Check out our past event <a href="<?php echo site_url('/past-events')?>">Here</a></p>

      
    </div>

<?php get_footer();
?>