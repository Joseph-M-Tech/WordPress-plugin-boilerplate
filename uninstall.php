<?/**
 * Summary.
 *
 * Description. Trigger this file to Uninstall BoilerPlate plugin and clear DB data.
 * @package plugin-boilerplate
 * @since 1.0.0
 */

//  exit direct access 
if( ! defined( 'WP_UNINSTALL_PLUGIN')) {
    die;
}
//clear the books in the database
// Method 1 (for one option) 

$books = get_posts( array( 'post_type' => 'book', 'numberposts' => -1) );
foreach( $books as $book ) {
    wp_delete_post($book->ID, true);
}

// Method 2 for multiple options/ access DB via SQL (be careful):
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book' ");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );//delete metadata
$wpdb->query("DELETE FROM wp_term_relationships WHERE post_id NOT IN (SELECT id FROM wp_posts)" );//del term relationships
