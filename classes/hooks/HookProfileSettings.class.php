<?php

class PluginGeo_HookProfileSettings extends Hook {
    
    /**
     * Регистрируем хуки
     */
    public function RegisterHook() {
        /**
         * Хук на отображение админки
         */
        $this->AddHook('template_profile_settings_end', 'SettingsGeo');
    }

    public function SettingsGeo($aParams) { 

        return smarty_insert_block([
            'block' => 'geo',
            'params' => [
                'plugin' => 'geo',
                'target' => $aParams['oUserProfile'],
                'target_type' => 'user_geo'
            ],
            
        ], $nll);
        
    }
}