// 

( function() {
    tinymce.PluginManager.add( 'spb_banner_button', function( editor, url ) {

        // Add a button that opens a window
        editor.addButton( 'spb_banner', {

            text: '',
            icon: "spb_banner",
            onclick: function() {
                      // Insert content when the window form is submitted
                        editor.insertContent( '[tonjoo_spb]' );
            }

        } );

    } );

} )();