<?php
require('ToDuo.php');

if ( $_GET['key'] == "peteralmeida" ) {
    if ( isset( $_GET['get_week'] ) ) {
        $calendario = new ToDuo( 2016 );
        $calendario->set_event(20160102, 'This is my first event');
        $calendario->set_event(20160102, 'This is another first event');
        $calendario->set_event(20160103, 'This is my second event');
        $calendario->set_event(20160103, 'This is my third event');
        $calendario = $calendario->get_week( $_GET['get_week'] );
        echo json_encode( $calendario );
    }
}
?>
