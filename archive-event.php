<!-- When we create an archive theme for our customs post types we need to name it 'archive-CUSTOME_POST_TYPE_NAME'.php -->
<!-- If one is not found WP will use the defualt 'archive.php' file to display -->

<?php 
get_header();
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world.'
)); ?>


    <div class="container container--narrow page-section">
      <?php 
      //this while loop: WHILE we have posts in our db (have_posts()) grab each individual post(the_post())
      while(have_posts()){
        the_post();
        get_template_part('template-parts/content-event');


       }
        echo paginate_links();
      ?>

      <hr class="section-break">

      <p>Check out our past event <a href="<?php echo site_url('/past-events')?>">Here</a></p>

      
    </div>

<?php get_footer();
?>