<?php
require('ToDuo.php');

if ( $_GET['key'] == "peteralmeida" ) {
    if ( isset( $_GET['get_week'] ) ) {
        $calendario = new ToDuo( 2016 );
        $calendario->set_event(20160102, 'eventog fdg fdg');
        $calendario->set_event(20160104, 'egdfgf ghgfh gfh fgo');
        $calendario->set_event(20160105, 'evehgf hgfh gfh gfhgf hgfh gfh nto');
        $calendario = $calendario->get_week( $_GET['get_week'] );
        echo json_encode( $calendario );
    }
}
?>
