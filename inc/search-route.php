<?php
//create a custom json object in order to improve site speed by only receiving needed json information to function the search feature

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
    //wp method to create custom endpoint
    
  register_rest_route('university/v1', 'search', array(
      //type of request 'GET'
    'methods' => WP_REST_SERVER::READABLE,
    //callback function to use
    'callback' => 'universitySearchResults'
  ));
}

function universitySearchResults($data) {
    //grab everything associated with professors
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'professor', 'page', 'program', 'campus', 'event'),
        's' => sanitize_text_field($data['term'])
    ));
    //create an array to push selected information
    $results = array(
        //created individual arrays for each section we will be displaying
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()
    );
    //loop through all JSON information associated with professors
    while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        //create conditionals to check post type of retrived data and push into correct array.
        if (get_post_type() == 'post' OR get_post_type() == 'page') {
            //push created json object and info into 'professorResults' array
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'professor') {
            //push created json object and info into 'professorResults' array
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'program') {
            //push created json object and info into 'professorResults' array
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'event') {
            //push created json object and info into 'professorResults' array
            array_push($results['events'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'campus') {
            //push created json object and info into 'professorResults' array
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }
        
    }
    //return results
  return $results;
}