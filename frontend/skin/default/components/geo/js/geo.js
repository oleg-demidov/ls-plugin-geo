/**
 * Geo
 *
 * @module ls/uploader
 *
 * @license   GNU General Public License, version 2
 * @copyright 2013 OOO "ЛС-СОФТ" {@link http://livestreetcms.com}
 * @author    Denis Shakhov <denis.shakhov@gmail.com>
 */

(function($) {
    "use strict";

    $.widget( "livestreet.geo", $.livestreet.lsComponent, {
        /**
         * Дефолтные опции
         */
        options: {
            // Ссылки
            urls: {
                load: aRouter['geo'] + 'ajax-load'
            },

            // Селекторы
            selectors: {
                country:  '[data-country]',
                region: '[data-region]',
                city: '[data-city]'
            },
            
            i18n: {
            },

            // Доп-ые параметры передаваемые в аякс запросах
            params: {}
            
            

        },

        /**
         * Конструктор
         *
         * @constructor
         * @private
         */
        _create: function () {
            this._super(); 

            this.elements.country.on('change', this.changeCountry.bind(this));
            this.elements.region.on('change', this.changeRegion.bind(this));
        },
        
        changeCountry: function()
        {
            this._load('load', {type: 'region', country_id: this.elements.country.val()}, function(response){
                this.setOptions(this.elements.region, response.result);
            }.bind(this));
            
        },
        
        changeRegion: function()
        {
            this._load('load', {type: 'city', region_id: this.elements.region.val()}, function(response){
                this.setOptions(this.elements.city, response.result);
            }.bind(this));
            
        },
        
        setOptions: function($select, data)
        {
            $select.empty().removeAttr('disabled');
            data.forEach(function(item){
                $select.append('<option value=' + item.value + '>' + item.text + '</option>');
            })
            
        }
        
    });
})(jQuery);