/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'ko',
    'uiComponent'
], function (ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            modules: {
                modal: '${ $.modal }',
                card: '${ $.card }'
            }
        },

        /**
         * Open card.
         */
        open: function (customerId) {
            this.modal().openModal();
            this.card().setParams({
                customer_id: customerId
            });
        }
    });
});
