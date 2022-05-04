<!-- When we create an archive theme for our customs post types we need to name it 'archive-CUSTOME_POST_TYPE_NAME'.php -->
<!-- If one is not found WP will use the defualt 'archive.php' file to display -->

<?php 
get_header();
pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'Recap of our past events.'
));
 ?>



    <div class="container container--narrow page-section">
      <?php 


        $today = date('Ymd');
    //make homepage events section dynamic
    //create a new class for events
    //in the array pass the argument 'posts_per_page' and limit to 2
    //  and 'post_type' to pull posts from events.
    $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1),
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key' => 'event_date',
            'compare' => '<',
            'value' => $today,
            'type' => 'numeric'
          )
        )
      ));

      //this while loop: WHILE we have posts in our db (have_posts()) grab each individual post(the_post())
      while($pastEvents -> have_posts()){
        $pastEvents -> the_post(); ?>
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
        echo paginate_links(array(
            'total' => $pastEvents -> max_num_pages
        ))

      ?>

      
    </div>

<?php get_footer();
?>