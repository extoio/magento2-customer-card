/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    '../data'
], function (CardData) {
    'use strict';

    return CardData.extend({
        /**
         * Format customer name.
         *
         * @return {String}
         */
        formatCustomerName: function (){
            return this.getCardData('data.customer.name') + ' <' + this.getCardData('data.customer.email') + '>';
        },

        /**
         * Get customer url.
         *
         * @return {String}
         */
        getCustomerUrl: function () {
            return this.getCardData('data.customer.url');
        }
    });
});
