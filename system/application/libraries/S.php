<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Wrapper of a smarty class, setting up all the necessary options to have it up and running.
 * @author Radim Res
 */
require 'Smarty-3.0.7/libs/Smarty.class.php';

/**
 * Wrapper of a smarty class, setting up all the necessary options to have it up and running.
 */

class S extends Smarty {

    /**
     * Class Constructor
     * @access Public
     * @param  void
     * @return void
     */
    public function S() {
        parent::__construct();
        // CI is loaded in modules, because of decrease session load
        // recursion in session array -> Radim Res 26.5.2011
        // $this->CI           = & get_instance();
        $config             = & get_config();
        $this->template_dir = !empty($config['smarty_template_dir']) ? $config['smarty_template_dir'] : '';
        $this->compile_dir  = !empty($config['smarty_compile_dir'])  ? $config['smarty_compile_dir']  : '';
        $this->cache_dir = !empty($config['smarty_cache_dir'])  ? $config['smarty_cache_dir']  : '';        
//        $this->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
    }

    /**
     * display template with header and footer
     * @access Public
     * @param  string $sFile
     * @param  array $aJavascriptFiles
     * @param  array $aCssFiles
     * @return void
     */
    function displayWithHeader( $sFile, $aJavascriptFiles = false, $aCssFiles = false ) {

        $this->assign( 'aCssFiles', $aCssFiles );
        $this->assign( 'aJavascriptFiles', $aJavascriptFiles );
        $this->assign( 'showMenu', true);
        $this->display('block/dsp_header.php');
        $this->display($sFile);
        $this->display('block/dsp_footer.php');
    }
    
    /**
     * display template with header and footer but without menu
     * @access Public
     * @param  string $sFile
     * @param  array $aJavascriptFiles
     * @param  array $aCssFiles
     * @return void
     */
    function displayWithHeaderNoMenu( $sFile, $aJavascriptFiles = false, $aCssFiles = false ) {

        $this->assign( 'aCssFiles', $aCssFiles );
        $this->assign( 'aJavascriptFiles', $aJavascriptFiles );
        $this->display('block/dsp_header.php');
        $this->display($sFile);
        $this->display('block/dsp_footer.php');
    }
}
