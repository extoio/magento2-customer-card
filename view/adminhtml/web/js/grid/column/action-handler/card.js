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
                modal: '${ $.modal }',
                card: '${ $.card }'
            }
        },

        /**
         * Apply action
         *
         * @param {String} action
         * @param {String} recordId
         * @param {Object} data
         */
        apply: function (action, recordId, data) {
            this.card().setParams({
                customer_id: recordId
            });
            this.modal().openModal();
        }
    });
});
