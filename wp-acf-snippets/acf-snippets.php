
## Basic Fields

<!-- ### Display A Field -->


<p><?php the_field('field_name'); ?></p>


### Retrieving A Field As A Variable

 
<?php $variable = get_field('field_name'); ?> 


### Get A Field By Name


/**
 * Get A Field By Name
 */
 
<?php if ( get_field('field_name') ) : ?>
  <?php echo get_field('field_name'); ?>
<?php endif; ?>


### Get And Format A Date Field


/**
 * Get And Format A Date Field
 */
 
<?php if ( get_field('field_name') ) : $date = DateTime::createFromFormat('Ymd', get_field('field_name')); ?>
  <?php echo $date->format('d-m-Y'); ?>
<?php endif; ?>


### Field Conditional Also Used for True or False Fields


/**
 * Field Conditional / Also Used for True/False Fields
 */
 
<?php if ( get_field('field_name') ) : ?>
  // some code
<?php endif; ?>


### Get A Field By Name Within Repeater (Flexible)


/**
 * Get A Field By Name Within Repeater/Flexible
 */
 
<?php if ( get_sub_field('field_name') ) : ?>
  <?php echo get_sub_field('field_name'); ?>
<?php endif; ?>


### Using Conditional Statements


 /**
  * Using Conditional Statements
  * get_field returns false if (value == “” || value == null || value == false)
  */
<?php
  if( get_field('field_name') ) {
	    echo '<p>' . get_field('field_name') . '</p>';
  }
?>


## Color Picker Field

### Display a color picker field value


/**
 * Display a color picker field value
 */
$color = get_field('color_picker_field_name');
if ($color) {
    echo '<div style="background-color:' . $color . ';">Some content</div>';
}


## Image Fields

### Image Field With A Return Value Of "Image URL"


/**
 * Image Field With A Return Value Of "Image URL"
 */
<?php if ( get_field('field_name') ) : ?>
    <img src="<?php the_field('field_name'); ?>" alt="<?php the_field(''); ?>">
<?php endif; ?>


## Image Field With A Return Value Of "Image ID"


/**
 * Image Field With A Return Value Of "Image ID"
 */
<?php
  if ( get_field('field_name') ) {
    $attachment_id = get_field('field_name');
    $size = "full"; // (thumbnail, medium, large, full or custom size)
    wp_get_attachment_image( $attachment_id, $size );
  }
?>


## Image Field With A Return Value Of "Image Object"


/**
 * Image Field With A Return Value Of "Image Object"
 */
<?php if ( get_field('field_name') ) : $image = get_field('field_name'); ?>

  <!-- Full size image -->
  <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>

  <!-- Thumbnail image -->
  <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>"/>

<?php endif; ?>


## Gallery Field

### Loop through a gallery field and display images


/**
 * Loop through a gallery field and display images
 */
 <?php
$images = get_field('gallery_field_name');
if ($images) {
    echo '<div class="gallery">';
    foreach ($images as $image) {
        echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';
    }
    echo '</div>';
}
?>

## File Fields

### File Field With A Return Value Of "File URL"


/**
 * File Field With A Return Value Of "File URL"
 */
<?php if ( get_field('field_name') ) : ?>
  <a href="<?php the_field('field_name'); ?>" >Download File</a>
<?php endif; ?>


### File Field With A Return Value Of "File ID"


/**
 * File Field With A Return Value Of "File ID"
 */
<?php
  if ( get_field('field_name') ) :
    $attachment_id = get_field('field_name');
    $url = wp_get_attachment_url( $attachment_id );
    $title = get_the_title( $attachment_id );
?>
  <a href="<?php echo $url; ?>" ><?php echo $title; ?></a>
<?php endif; ?>


### File Field With A Return Value Of "File Object"


/**
 * File Field With A Return Value Of "File Object"
 */
<?php if ( get_field('field_name') ) : $file = get_field('field_name'); ?>
  <a href="<?php echo $file['url']; ?>"><?php echo $file['title']; ?></a>
<?php endif; ?>


### Flexible Content Basic Field Returns 1 Row Deep


/**
 * Flexible Content Basic Field Returns 1 Row Deep
 */
<?php if ( have_rows( 'field_name' ) ) : ?>
    <?php while ( have_rows('field_name' ) ) : the_row();
        if ( get_row_layout() == 'layout_field' ) : ?>
            <div class="class">
                <?php the_sub_field( 'field_name' ); ?>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>


### Flexible Content Nested Field Returns


/**
 * Flexible Content Nested Field Returns
 */
<?php if( have_rows('field_name') ): ?>
    <?php while ( have_rows('field_name') ) : the_row(); ?>
        <?php if( get_row_layout() == 'layout_field' ): ?>
            <?php if( have_rows('layout_rows') ): ?>
                <ul>
                    <?php while ( have_rows('layout_rows') ) : the_row(); $image = get_sub_field('sub_field'); ?>
                        <li><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>


### Flexible Content Basic Field Returns 1 Row Deep


/**
 * Flexible Content Basic Field Returns 1 Row Deep
 */
<?php if ( have_rows( 'field_name' ) ) : ?>
    <?php while ( have_rows('field_name' ) ) : the_row();
        if ( get_row_layout() == 'layout_field' ) : ?>
            <div class="class">
                <?php the_sub_field( 'field_name' ); ?>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>


## Embed Field

### Display an embed field


/**
 * Display an embed field (e.g. video or audio)
 */
<?php 
$embed = get_field('embed_field_name');
if ($embed) {
    echo $embed;
}
?>

## Relationship Field

### Get A Relationship Field And Loop Over All Returned Posts


/**
 * Get A Relationship Field And Loop Over All Returned Posts
 */
<?php $posts = get_field('field_name'); ?>
<?php if ( $posts ): ?>
  <ul>
    <?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
      <li>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </li>
    <?php endforeach; wp_reset_postdata(); ?>
  </ul>
<?php endif; ?>


## Location Fields

### Get The Street Address From A Location Field


/**
 * Get The Street Address From A Location Field
 */
<?php if ( get_field('field_name') ) :
  $location = get_field('field_name'); ?>
  <?php echo $location['address']; ?>
<?php endif; ?>


### Get A Location Field And Convert It To A Static Google Map


/**
 * Get A Location Field And Convert It To A Static Google Map
 */
<?php if ( get_field('field_name') ) :
  $location = get_field('field_name');
  $coordinates = isset( $location['coordinates'] ) ? $location['coordinates'] : $location ; ?>
  <img src="http://maps.google.com/maps/api/staticmap?markers=<?php echo $coordinates; ?>&size=500x300&sensor=false" alt="">
<?php endif; ?>


### Get A Location Field And Convert It To An Interactive Google Map


/**
 * Get a location field and convert it to an interactive Google Map. 
 * Also adds a marker to the location. The CSS is used to prevent rendering 
 * issues with map controls caused by most responsive CSS grids.
 */
<?php if ( get_field('field_name') ) :
  $location = get_field('field_name');
  $coordinates = isset( $location['coordinates'] ) ? $location['coordinates'] : $location ; ?>

  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script>
    google.maps.event.addDomListener(window, 'load', function() {
      var map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 16,
        center: new google.maps.LatLng(<?php echo $coordinates; ?>),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
      });

      new google.maps.Marker({
          position: new google.maps.LatLng(<?php echo $coordinates; ?>),
          map: map
      });
    });
  </script>

  <style>
  #map-canvas img {
    max-width: inherit;
  }
  </style>

  <div id="map-canvas" style="width:500px;height:300px;"></div>

<?php endif; ?>


## Gravity Form Field

### Display A Gravity Form


/**
 * Display a Gravity form
 * The parameters for gravity_form() are outlined in the Gravity Forms documentation
 */
<?php if ( get_field('field_name') ) :
  $location = get_field('field_name');
  $coordinates = isset( $location['coordinates'] ) ? $location['coordinates'] : $location ; ?>
  <img src="http://maps.google.com/maps/api/staticmap?markers=<?php echo $coordinates; ?>&size=500x300&sensor=false" alt="">
<?php endif; ?>


## Repeater Field

### Get And Loop Over A Repeater Field


/**
 * Get And Loop Over A Repeater Field
 */
<?php if ( have_rows('field_name') ) : ?>

  <?php while( have_rows('field_name') ) : the_row(); ?>

    <?php the_sub_field('sub_field_name'); ?>

  <?php endwhile; ?>

<?php endif; ?>


### Get and loop over a repeater field with subfields


/**
 * Get and loop over a repeater field with subfields
 */
<?php 
if (have_rows('repeater_field_name')) {
    while (have_rows('repeater_field_name')) {
        the_row();
        $subfield_1 = get_sub_field('subfield_1');
        $subfield_2 = get_sub_field('subfield_2');
        // Output or use subfields as needed
    }
}
?>

### Loop Over A Repeater Filed And Seperate Results Into Rows


/**
 * Loop Over A Рepeater Filed And Seperate Results Into Rows. 
 * The second tabstop is the row length.
 */
<?php if ( get_field('field_name') ) : ?>

  <div class="items">
    <?php foreach ( array_chunk(get_field('field_name'), 2) as $row): ?>

      <div class="row">
        <?php foreach ($row as $item): ?>

          <div class="item">
            <?php echo $item['field_name']; ?>$5
          </div>

        <?php endforeach; ?>
      </div>

    <?php endforeach; ?>
  </div>

<?php endif; ?>


## Taxonomy Fields

### Get taxonomy field as a list of terms


/**
 * Get taxonomy field as a list of terms
 */
<?php 
$taxonomy_terms = get_field('taxonomy_field_name');
if ($taxonomy_terms) {
    echo '<ul>';
    foreach ($taxonomy_terms as $term) {
        echo '<li><a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';
    }
    echo '</ul>';
}
?>


### Get taxonomy field as a comma-separated list of terms


/**
 * Get taxonomy field as a comma-separated list of terms
 */
<?php 
$taxonomy_terms = get_field('taxonomy_field_name');
if ($taxonomy_terms) {
    $term_names = array();
    foreach ($taxonomy_terms as $term) {
        $term_names[] = $term->name;
    }
    echo implode(', ', $term_names);
}
?>


## Queries

### Query A Post Type On A Field Value And Loop Over Posts


/**
 * Query A Post Type On A Field Value And Loop Over Posts
 */
<?php

$args = array(
  'numberposts' => 10,
  'post_type' => 'post',
  'meta_key' => 'field_name',
  'meta_value' => 'field_value'
);

$query = new WP_Query( $args );

?>

<?php if( $query->have_posts() ) : ?>
  <ul>
  <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <li>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </li>
  <?php endwhile; ?>
  </ul>
<?php endif; ?>

<?php wp_reset_query(); ?>


## WYSIWYG Editor Field

### Display the content of a WYSIWYG editor field


/**
 * Display the content of a WYSIWYG editor field
 */
<?php 
$wysiwyg_content = get_field('wysiwyg_field_name');
if ($wysiwyg_content) {
    echo $wysiwyg_content;
}
?>

### Get and format a date field with a custom format


/**
 * Get and format a date field with a custom format
 */
<?php 
$date_field = get_field('date_field_name', false, false);
if ($date_field) {
    $date = new DateTime($date_field);
    echo $date->format('F j, Y');
}
?>


## Misc

### var_dump The Field Contents Wrapped In 'pre' tags


<pre>
    <?php var_dump(get_field('field_name')); die(); ?>
</pre>


