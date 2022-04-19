<?php
get_header();

while(have_posts()) {
    the_post(); ?>

<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri("/images/ocean.jpg") ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title()?></h1>
        <div class="page-banner__intro">
          <p>DONT FORGET TO REPLACE ME LATER</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">

        <?php 

        $parentPage = wp_get_post_parent_id(get_the_ID());
        // if statement to checkl if current page is a child page. 
        // in order to only show breadcrums on child pages and not parents
        if($parentPage) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($parentPage) ;?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentPage)?></a> <span class="metabox__main"><?php echo the_title(); ?></span>
        </p>
      </div>
        <?php }

    ?>



    <?php
    $testArray = get_pages(array(
        'child_of' => get_the_ID()
    ));
    
    if ($parentPage or $testArray) { ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($parentPage) ?>"><?php echo get_the_title($parentPage) ?></a></h2>
        <ul class="min-list">
          <?php 
            //list childen pages dynamicly
            // wp_list_pages() will <li>'s for every page available NOT specific to parent's children
            //we must use an associate array and pass it as the argument

            //if true (not 0 = not a parent) make variable childs parents id
            if($parentPage){
                $findChildrenOf = $parentPage;
            //if false (id = 0, is a parent) make variable the cirrent page id
            } else {
                $findChildrenOf = get_the_ID();

            }
            //break down: if we are on a child page => display all the children of its parent
            //if we are on the parent page display all of ITS OWN child pages
            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'
            ));
          ?>
        </ul>
      </div>
      <?php } ?>

      <div class="generic-content">
        <p><?php the_content() ?></p>
      </div>
    </div>


<?php }
get_footer();
?>
