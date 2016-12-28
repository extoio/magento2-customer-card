<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\View\JsLayout;

/**
 * Layout Processor interface.
 *
 * @api
 */
interface ProcessorInterface
{
    /**
     * Process js layout.
     *
     * @param array $layout
     * @return array
     */
    public function process(array $layout);
}
