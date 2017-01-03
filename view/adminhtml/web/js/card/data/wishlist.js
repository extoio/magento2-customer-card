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
         * Get wishlist items.
         *
         * @return {Array}
         */
        getWishlistItems: function (){
            return this.getCardData('data.wishlist.items') || [];
        },

        /**
         * Has wishlist items.
         *
         * @return {boolean}
         */
        hasWishlistItems: function () {
            return this.getWishlistItems().length > 0;
        }
    });
});
