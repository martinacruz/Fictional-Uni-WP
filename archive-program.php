<!-- When we create an archive theme for our customs post types we need to name it 'archive-CUSTOME_POST_TYPE_NAME'.php -->
<!-- If one is not found WP will use the defualt 'archive.php' file to display -->

<?php 
get_header(); ?>

<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri("/images/ocean.jpg") ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"> All Programs</h1>
        <div class="page-banner__intro">
          <p>Have a look around. There is something for everyone.</p>
        </div>
      </div>
    </div>

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