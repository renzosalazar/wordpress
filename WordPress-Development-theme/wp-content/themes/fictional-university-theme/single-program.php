<?php 


get_header();

while (have_posts()){
    the_post();
    pageBanner();

} 
wp_reset_postdata();
?>


<div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs </a> <span class="metabox__main"><?php the_title() ?> </span></p>

    </div>
    <div class="generic-content"><?php the_field('main_body_content') ?></div>


    <?php
    //post_per_page - kung ilan lilitaw dun sa fron-end
    //post_type - kung anong post type
    // orderby - post_date - the date that the post was created or published
    // ^       - value [post_date] is the default value
    //^ value [title] - will be alphabetically
    //^ orderby->rand - post will be random
    //^ orderby->meta_value_num - it need the meta_key 1st - then the value means that the orderby will be base on any value of Post Type.
    // meta_key-event_date - the ACF variabe
    // 'posts_per_page' => -1, -1 meaning the WP will give all the posts
    // order -> DESC - post will be descending 
    // order -> ASC - post will be Ascending 

    // meta_query - array-> 
    //  ^key - the ACF
    //  ^compare - the condition
    //  ^value  - here is date $today

    $relatedProfessor = new WP_Query(array(
        'posts_per_page'   => -1,
        'post_type'        => 'professor',
        'orderby'          => 'title',
        'order'            => 'ASC',
        'meta_query' => array(
            array(
                'key'      => 'related_programs',
                'compare'  => 'LIKE',
                'value'    =>  '"'. get_the_ID() .'"'
            )
        )

    ));



            if( $relatedProfessor->have_posts()) { 


                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium" >' . get_the_title() . ' Professor </h2>';

                echo '<ul class="professor-cards">';

                while( $relatedProfessor->have_posts()){
                    $relatedProfessor->the_post(); 

    ?>

    <!--
the_post_thumbnail_url($size) - si-net natin ung size sa functions.php
-->
    <li class="professor-card__list-item">
        <a class="professor-card" href="<?php the_permalink() ?>">
            <img src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="" class="professor-card__image">
            <span class="professor-card__name"><?php the_title(); ?></span>
        </a>
    </li>




    <?php }  /* End while $relatedProfessor */
                wp_reset_postdata();

                echo '</ul>';

            }
    ?>

    <!--related Professor-->

    <?php


    //post_per_page - kung ilan lilitaw dun sa fron-end
    //post_type - kung anong post type
    // orderby - post_date - the date that the post was created or published
    // ^       - value [post_date] is the default value
    //^ value [title] - will be alphabetically
    //^ orderby->rand - post will be random
    //^ orderby->meta_value_num - it need the meta_key 1st - then the value means that the orderby will be base on any value of Post Type.
    // meta_key-event_date - the ACF variabe
    // 'posts_per_page' => -1, -1 meaning the WP will give all the posts
    // order -> DESC - post will be descending 
    // order -> ASC - post will be Ascending 

    // meta_query - array->  is a FILTER
    //  ^key - the ACF
    //  ^compare - the condition
    //  ^value  - here is date $today
    // ung Compare and Value - is un ung condition
    // here greater than equal the value of the date today
    // the type is numeric - meaning numbers
    // 1st filter - we are only looking for the date - 
    // 2nd filter - we are looking for related programs set by user on the dashboard, so that is from the current ID of the page

    $today = date('Ymd');
    $eventPostType = new WP_Query(array(
        'posts_per_page'   => 2,
        'post_type'        => 'event',
        'meta_key'         => 'event_date',
        'orderby'          => 'meta_value_num',
        'order'            => 'ASC',
        'meta_query' => array(
            array(
                'key'      => 'event_date',
                'compare'  => '>=',
                'value'    =>   $today,
                'type'     => 'numeric'
            ),
            array(
                'key'      => 'related_programs',
                'compare'  => 'LIKE',
                'value'    =>  '"'. get_the_ID()  .'"'
            )
        )

    ));

    /* IF CONDITION */
    /* para hindi mag appear ung UPCOMING EVENTS na title tag
    tapos sa loob nun ung content na relation nun sa event?? gets moba ? ano kaya pa?
    */

    if($eventPostType->have_posts()) { 


        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium" > Upcoming ' . get_the_title() . ' Events </h2>';


        while($eventPostType->have_posts()){
            $eventPostType->the_post(); 


            get_template_part('template-parts/content', 'event');

        }  /*Event post type Loop*/
    }  
    wp_reset_postdata();
    /*Event post type IF*/ 


    $relatedCampus = get_field('related_campuses');

    if($relatedCampus){
        
        echo '<hr class="section-break" >';
        echo '<h2 class="headline headline--medium" >' . get_the_title() . ' is Available at these Campuses: </h2>';
        
        echo '<ul class="min-list link-list"> ';
        foreach($relatedCampus as $campus ){  ?>
        <li>
            <a href="<?php echo get_the_permalink($campus)?>"> <?php echo get_the_title($campus) ?></a>
        </li>
    <?php
        }
        echo "</ul>";
    }

    ?>
</div>



<!--/*wp_reset_postdata();*/-->


<?php 
get_footer();
?>