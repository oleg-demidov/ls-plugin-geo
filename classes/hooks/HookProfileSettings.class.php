<?php

class PluginGeo_HookProfileSettings extends Hook {
    
    /**
     * Регистрируем хуки
     */
    public function RegisterHook() {
        /**
         * Хук на отображение админки
         */
//        $this->AddHook('template_profile_settings_end', 'ShowProperiesUser');
    }

    public function ShowProperiesUser($aParams) { 
        
        $this->Viewer_Assign('properties', $aParams['oUser']->property->getPropertyList());
        return $this->Viewer_Fetch('component@property:property.input-block');
        
    }
}