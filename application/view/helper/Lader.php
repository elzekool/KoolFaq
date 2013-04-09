<?php
/**
 * Lader Helper
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace View\Helper;

/**
 * Lader Helper
 * 
 * Wordt gebruikt voor het laden van diverse tools zoals bijvoorbeeld
 * de wysiwyg editor
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class Lader extends \Helper
{
    /**
     * Laad Select2
     * 
     * @return \View\Helper\Lader self
     */
    public function select2() {
        $assets = $this->getView()->helper('Assets');
        $assets->script('external/select2/select2.min.js');
        $assets->css('external/select2/select2.css');
        return $this;
    }
            
    /**
     * Laad jQuery UI
     * 
     * @return \View\Helper\Lader self
     */
    public function jqueryui() {
        $assets = $this->getView()->helper('Assets');
        $assets->script('external/jquery-ui/js/jquery-ui-1.9.2.custom.min.js');
        $assets->css('external/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.min.css');
        
        return $this;
    }
    
    /**
     * Laad Datepicker
     * 
     * @return \View\Helper\Lader self
     */
    public function datepicker() {
        $assets = $this->getView()->helper('Assets');
        $assets->script('external/datepicker/js/bootstrap-datepicker.js');
        $assets->css('external/datepicker/css/datepicker.css');        
        return $this;
    }
    
    /**
     * Laad WYSIWYG editor. Vervangt alle textarea's met classe wysiwyg
     * voor een editor
     * 
     * @return \View\Helper\Lader self
     */
    public function wysiwyg() {        
        $assets = $this->getView()->helper('Assets');   
        $assets->script(r()->getBase() . __min('js/wysiwyg.js'));
        
        return $this;
    }
    
    /**
     * Laad File Uploader, een HTML5/AJAX file uploader
     * 
     * @return \View\Helper\Lader self
     */
    public function file_uploader() {
        $assets = $this->getView()->helper('Assets');
        $assets->script(r()->getBase() . __min('external/file-uploader/js/header.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/util.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/button.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/handler.base.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/handler.form.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/handler.xhr.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/uploader.basic.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/dnd.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/uploader.js'));
        $assets->script(r()->getBase() . __min('external/file-uploader/js/jquery-plugin.js'));
        $assets->css('external/file-uploader/fineuploader.css');
        return $this;
    }
    
    /**
     * jQuery fancybox2 laden
     * 
     * @return \View\Helper\Lader self
     */
    public function fancybox() {
        $assets = $this->getView()->helper('Assets');
        $assets->script(r()->getBase() . '/external/fancybox/lib/jquery.mousewheel-3.0.6.pack.js');        
        $assets->script(r()->getBase() . '/external/fancybox/source/jquery.fancybox.pack.js');        
        $assets->css('external/fancybox/source/jquery.fancybox.css');
        return $this;
    }
    
    
}