<?php

class PluginGeo_HookAdmin extends Hook {
    
    /**
     * Регистрируем хуки
     */
    public function RegisterHook() {
        /**
         * Хук на отображение админки
         */
        $this->AddHook('init_action_admin', 'InitActionAdmin');
    }

    public function InitActionAdmin($aParams) { 
        

        $oSection = Engine::GetEntity('PluginAdmin_Ui_MenuSection')
                ->SetCaption('Геолокация')
                ->SetName('geo')
                ->SetUrl('plugin/geo')
                ->setIcon('th-list');
        
        $oSection
                ->AddItem(Engine::GetEntity('PluginAdmin_Ui_MenuItem')
                ->SetCaption('Страны')
                ->SetUrl('/admin/plugin/geo/countries'));

        $oMenu = $this->PluginAdmin_Ui_GetMenuMain();
        $oMenu->AddSection($oSection);
        
        
    }
}