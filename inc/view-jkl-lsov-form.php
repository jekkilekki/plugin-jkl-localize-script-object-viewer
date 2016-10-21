<?php
/**
 * 
 */
if( isset( $_POST[ 'jkl-lsov-submit' ] ) && 
    isset( $_POST[ 'jkl_lsov_input' ] ) && 
    wp_verify_nonce( $_POST[ 'jkl_lsov_form'], 'jkl_lsov' ) 
) {
    wp_localize_script( 'jkl-lsov-functions', 'Inputdata', $_POST[ 'jkl_lsov_input' ] );
}
?>
        
        <form id="jkl-lsov-form" action="" method="POST">
            
            <?php
            // Add a nonce (number once) to be sure submissions come from THIS form
            wp_nonce_field( 'jkl_lsov', 'jkl_lsov_form' );
            ?>
            
            <h4><?php _e( 'Localize Script Object Viewer', 'jkl-localize-script-object-viewer' ); ?></h4>
            
            <h5>Input</h5>
            <textarea name="jkl-lsov-input" id="jkl-lsov-textarea" style="overflow: hidden; font-family: monospace" onkeyup="textAreaAdjust(this)" placeholder="Enter your PHP data or array to transform into JSON with wp_localize_script():"></textarea>
            <input name="action" type="hidden" value="jkl_lsov">
            
            <div class="controls">
                    <input id="jkl-lsov-submit" class="button" type="button" onClick="convert2json();" value="<?php _e( 'Convert', 'jkl-unit-converter' ); ?>">
            </div>
            
            <div class="jkl-lsov-result">
                <h5>Result</h5>
                <pre id="jkl-lsov-jsobj">
                    <?php // results are populated by our JavaScript function ?>
                </pre>
            </div>
            
        </form><!-- END #conversion-form -->
        