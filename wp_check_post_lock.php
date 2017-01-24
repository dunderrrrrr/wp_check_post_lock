
// add function (content-single.php)

function wp_check_post_lock( $post_id ) {
    if ( !$post = get_post( $post_id ) )
        return false;

    if ( !$lock = get_post_meta( $post->ID, '_edit_lock', true ) )
        return false;

    $lock = explode( ':', $lock );
    $time = $lock[0];
    $user = isset( $lock[1] ) ? $lock[1] : get_post_meta( $post->ID, '_edit_last', true );

    $time_window = apply_filters( 'wp_check_post_lock_window', 150 );
    if ( $time && $time > time() - $time_window && $user != get_current_user_id() )
        return $user;
    return false;
}


// place in body (content-single.php)

if (!(wp_check_post_lock())) {
        echo "This post is currently being edited.";
} else {
       // echo "not locked";
}