<?php
/**
 * 
 * @author Oleg Demidov
 *
 */

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginGeo extends Plugin
{
    


    public function Init()
    {
//        $this->Component_Add('geo:geo');
//        $this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__) . 'assets/js/init.js');
        $this->Lang_AddLangJs([
            'plugin.geo.no_results_text',
            'plugin.media.media.remove'
        ]);
    }

    public function Activate()
    {
        
        
        return true;
    }

    public function Deactivate()
    {
        
        return true;
    }
    
    public function Remove()
    {
        
        return true;
    }
}