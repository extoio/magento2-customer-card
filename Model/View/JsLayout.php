<?php
/**
 * Copyright © 2016 Exto. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\CustomerCard\Model\View;

use Exto\CustomerCard\Model\View\JsLayout\ProcessorInterface;

/**
 * Js Layout.
 */
class JsLayout implements JsLayoutInterface
{
    /**
     * @var array
     */
    private $layout;

    /**
     * @var ProcessorInterface[]
     */
    private $processors;

    /**
     * @param array $layout
     * @param ProcessorInterface[] $processors
     */
    public function __construct(
        $layout = [],
        $processors = []
    ) {
        $this->layout = $layout;
        $this->processors = $processors;
    }

    /**
     * {@inheritdoc}
     */
    public function getLayout()
    {
        $layout = $this->layout;

        foreach ($this->processors as $processor) {
            $layout = $processor->process($layout);
        }

        return $layout;
    }
}
