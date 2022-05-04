<?php

function pageBanner($args = NULL) {
  
    if (!$args['title']) {
      $args['title'] = get_the_title();
    }
   
    if (!$args['subtitle']) {
      $args['subtitle'] = get_field('page_banner_subtitle');
    }
   
    if (!$args['photo']) {
      if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
        $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      } else {
        $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    }

//this is the function being called in 'add_action''
//this function works similar to a HTML <head> tag where all >link> and <script>
function university_files() {
    //this function calls the defualt css files 'style.css'
    //if we wanted to load a js file 'university_main_styles' would be 'script'
    //we can list multiple files to load back calling the fucntion multi times
    wp_enqueue_script('main-university-js', get_theme_file_uri("/build/index.js"), array("jquery"), 1.0, true);
    wp_enqueue_style('google-fonts', "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('font-awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
};

// this function takes two arguments
// arg 1 os what type of action is being given
//'wp_enqueue_scripts'= want to load css or JS files
//arg 2 is a callback function of that is to be run
add_action('wp_enqueue_scripts', 'university_files');


function university_features() {
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocation1', 'Footer Location 1');
    // register_nav_menu('footerLocation2', 'Footer Location 2');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) {
    if(!is_admin() AND is_post_type_archive('program') AND is_main_query()) {
        $query -> set('orderby', 'title');
        $query -> set('order', 'ASC');
        $query -> set('post_per_page', -1);
    }


    if(!is_admin() AND is_post_type_archive('event') AND $query -> is_main_query()) {
        $today = date('Ymd');
        $query -> set('meta_key', 'event_date');
        $query -> set('orderby', 'meta_value_num');
        $query -> set('order', 'ASC');
        $query -> set('meta_query', array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            )
          ));
    };
}


add_action('pre_get_posts', 'university_adjust_queries');