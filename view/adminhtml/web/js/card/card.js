/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'uiComponent',
    'mageUtils'
], function (Component, utils) {
    'use strict';

    return Component.extend({
        defaults: {
            tabs: [],
            cardData: {},
            params: {},
            isLoading: true,
            modules: {
                provider: '${ $.provider }'
            },
            imports: {
                cardData: '${ $.provider }:data'
            },
            links: {
                params: '${ $.provider }:params'
            },
            listens: {
                '${ $.provider }:reload': '_onBeforeReload',
                '${ $.provider }:reloaded': '_onDataReloaded'
            }
        },

        /**
         * @inheritdoc
         */
        initObservable: function () {
            this._super()
                .observe([
                    'cardData',
                    'params',
                    'isLoading'
                ]);

            return this;
        },

        /**
         * Set card params.
         */
        setParams: function (params) {
            this.params(params)
        },

        /**
         * Get tabs.
         *
         * @return {Array}
         */
        getTabs: function () {
            return this.tabs;
        },

        /**
         * Get card data.
         *
         * @return {Object}
         */
        getCardData: function (path) {
            return utils.nested(this.cardData(), path);
        },

        /**
         * On before reload.
         *
         * @private
         */
        _onBeforeReload: function () {
            this.isLoading(true);
        },

        /**
         * On data reloaded.
         *
         * @private
         */
        _onDataReloaded: function () {
            this.isLoading(false);
        }
    });
});
