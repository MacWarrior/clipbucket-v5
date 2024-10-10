<?php
/*
	Plugin Name: Oxygenz - Plugin example
	Description: An example plugin showing all anchors
	Author: Oxygenz
    Author Website: https://clipbucket.oxygenz.fr
    Version: 1.0.1
	ClipBucket Version: 5.5.1
	Website: https://github.com/MacWarrior/clipbucket-v5/
*/

class oxygenz_example {
    /**
     * @throws Exception
     */
    function __construct(){
        $this->register_anchors();
    }
    private function register_anchors(){
        // This function is used to call a specitic function at a specific place
        // In this case, we will display a message at each anchor place
        register_anchor_function('show_anchor', '*', self::class);
    }

    // Functions called from register_anchor_function has to be static to be callable
    public static function show_anchor(){
        global $current_anchor;
        echo '<div>Anchor : '.$current_anchor.'</div>';
    }

}

new oxygenz_example();
