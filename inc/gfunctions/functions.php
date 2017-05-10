<?
// Functions for GMWP+

function add_support_caps() {
    // gets the GMWP+ user's Support role
    $role = get_role( 'subscriber' );
    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'view_ticket' );
    $role->add_cap( 'create_ticket' );
    $role->add_cap( 'close_ticket' );
    $role->add_cap( 'reply_ticket' );
    $role->add_cap( 'attach_files' ); 
}
add_action( 'admin_init', 'add_support_caps');
// F1
