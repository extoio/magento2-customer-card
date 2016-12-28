/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'uiComponent'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            modules: {
                card: '${ $.card }'
            }
        },

        /**
         * Get card data.
         *
         * @return {Object}
         */
        getCardData: function (path) {
            return this.card().getCardData(path);
        }
    });
});
