<?php
/*
Plugin Name: Simple Error Handler
Plugin URI: http://devondev.com/blog/simple-error-handler/
Description: Allows administrators and developers to get a stack trace when PHP errors occur
Version: 1.1
Author: Peter Wooster
Author URI: http://www.devondev.com/
*/

/*  Copyright (C) 2011 Devondev Inc.  (http://devondev.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/* =========================================================================
 * Error trap
 * - catches the PHP errors, 
 * - throws an exception and catches it
 * - displays the stack trace
 * =========================================================================*/

/**
 * throws an exception 
 */
function seh_throw() {
    throw new Exception("Error trapped");
}

/**
 * trap a PHP error, throw an exception, catches it and displays the stack trace
 * @param type $errno the PHP error number
 * @param type $errstr the PHP error text
 * @return boolean true if processing is to continue, false to die
 */
function seh_trap($errno, $errstr){
    global $seh_trapped;

    if($seh_trapped)return true;
    $seh_trapped = true;
    $ename = seh_error_code_as_string($errno);
    echo "<br/><br/>Error trapped: $ename($errno), $errstr<br/>";
    try {
        seh_throw();
    } catch (Exception $e) {
        $tr = $e->getTrace();
        for($i = 2; $i < count($tr); $i++) {
            $sf = $tr[$i];
            echo $sf['file'].'['.$sf['line'].']<br/>';
        }
    }
    return true;
}

/**
 * set the error trap up to catch the requested errors
 */
function seh_set_handler() {
    global $seh_trapped;
    $seh_trapped = false;
    $enabled = true;
    $level = intval(get_option('seh_level', seh_notice_level()));
    // echo "level=$level<br/>";
    if($enabled) {
        set_error_handler('seh_trap', $level);
    }
}
seh_set_handler();



/* =========================================================================
 * Build settings used by administrators either as a separate page or as a 
 * section in the general settings page.
 * 
 * This code uses the new settings api
 * thanks to http://ottopress.com/2009/wordpress-settings-api-tutorial/ for the helpful tutorial
 * =========================================================================*/

/**
 * set up actions to link into the admin settings 
 */
$seh_options_location = 'seh_options'; // on a separate page

add_action('admin_init', 'seh_admin_init');
add_action('admin_menu', 'seh_add_option_page');
    
/**
 * run when admin initializes
 * register our settings as part of the sac_options_group
 * add the section seh_options:seh_options_main
 * add the fields to that section
 */

function seh_admin_init() {
    register_setting('seh_options_group', 'seh_level','seh_validate_level');
    add_settings_section  ('seh_options_main', '', 'seh_main_section_text', 'seh_options');
    add_settings_field('seh_level_text', 'Error level', 'seh_level', 'seh_options', 'seh_options_main');
}

/**
 * action to add the custom options page, for users with manage_options capabilities 
 */
function seh_add_option_page() {
    add_options_page('Simple Error Handler', 'Simple Error Handler',
            'manage_options', 'seh_options', 'seh_options_page');
}

/**
 * display the custom options page
 */
function seh_options_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Simple Error Handler Settings</h2>
        <form action="options.php" method="post">
            <?php settings_fields('seh_options_group');?>
            <?php do_settings_sections('seh_options')?>
            <p class="submit"> <input name="submit" class="button-primary" type="submit" value="Save changes"/></p>
        </form>
    </div>
    <?php
}

/**
 * display the section title, empty if separate page
 */
function seh_main_section_text() {
    echo "";
}

/**
 * display the form field for the level
 */
function seh_level() {
    $value=seh_level_as_string(get_option('seh_level', seh_notice_level()));
    echo '<input id="seh_level" name="seh_level" value="'.$value.'"><br/>';
    echo 'the value may be "all"", "notice" or a number as described in PHP predefined constants<br/>';
    echo 'any value except a number or "all" defaults to handle notice and deprecation warnings';
}

function seh_validate_level($level){
    $level = trim($level);
    if (is_numeric($level))return intval($level);
    else if($level == 'all')return 32767;
    else if($level == 'none')return 0;
    else return seh_notice_level();
}

function seh_notice_level() {
    return E_NOTICE | E_DEPRECATED | E_USER_DEPRECATED |E_USER_NOTICE;
}

function seh_level_as_string($level) {
    if($level == 32767)return'all';
    else if($level == 0)return 'none';
    else if($level == (E_NOTICE | E_DEPRECATED | E_USER_DEPRECATED |E_USER_NOTICE))return 'notice';
    else return $level;
}

function seh_error_code_as_string($code) {
    $errors = array(
        1 => 'ERROR', 
        2 => 'WARNING',
        4 =>  'PARSE',
        8 =>  'NOTICE',
        16 =>  'CORE ERROR',
        32 =>  'CORE WARNING',
        64 => 'COMPILE ERROR',
        128 => 'COMPILE WARNING',
        256 => 'USER ERROR',
        512 => 'USER WARNING',
        1024 => 'USER NOTICE',
        2048 => 'STRICT',
        4096 => 'RECOVERABLE ERROR',
        8192 => 'DEPRECATED',
        16384 => 'USER DEPRECATED',
    );
    if(isset($errors[$code]))return $errors[$code];
    else return 'UNKNOWN ERROR';
}

/* =========================================================================
 * end of program, php close tag intentionally omitted
 * ========================================================================= */
