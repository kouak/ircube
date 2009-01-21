<?php 
class FckHelper extends AppHelper  
{  
    var $helpers = array('Javascript');  

    function load( $template = 'default', $height = '300', $width = '650', $toolbar = 'Default' )  
    {  
        $jsDS = '/'; //because \' only suxx in javascript  
        $js = $this->webroot . 'js' . $jsDS . 'fck' . $jsDS;  
        $skinDir = $js . 'editor' . $jsDS . 'skins' . $jsDS;  
        $templateDir = $skinDir . (is_dir( $skinDir . $template ) ? $template : 'default') . $jsDS;  

        $code  = "fckLoader = function ( ID ) {";  
        $code .= " var bFCKeditor = new FCKeditor( ID );";  
        $code .= " bFCKeditor.BasePath = '" . $js . "';";  
        $code .= " bFCKeditor.ToolbarSet = '" . $toolbar . "';";  
        $code .= " bFCKeditor.SkinPath = '" . $templateDir . "';";  
        $code .= " bFCKeditor.Height = " . $height . ";";  
        $code .= " bFCKeditor.Width = " . $width . ";";  
        $code .= " bFCKeditor.ReplaceTextarea();";  
        $code .= " }";  

        $this->Javascript->link('fck/fckeditor.js', true); // add it to the header  
        return $this->Javascript->codeBlock($code);  
    }  
      
    function editor( $fieldName )  
    {  
        $seperator = (strstr($fieldName, '.') ? '.' : '/');  
        $id = Inflector::camelize( str_replace($seperator, '_', $fieldName) );  
        $code = "fckLoader('" . $id . "');";  
          
        return $this->Javascript->codeBlock($code);  
    }  
}
?>