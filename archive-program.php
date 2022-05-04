<!-- When we create an archive theme for our customs post types we need to name it 'archive-CUSTOME_POST_TYPE_NAME'.php -->
<!-- If one is not found WP will use the defualt 'archive.php' file to display -->

<?php 
get_header();
pageBanner(array(
  'title' => 'All Programs',
  'subtitle' => 'Have a look around. There is something for everyone.'
));
 ?>


    <div class="container container--narrow page-section">

        <ul class="link-list min-list">

      <?php 
      //this while loop: WHILE we have posts in our db (have_posts()) grab each individual post(the_post())
      while(have_posts()){
        the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
      <?php }
        echo paginate_links();
      ?>
        </ul>
      
    </div>

<?php get_footer();
?>