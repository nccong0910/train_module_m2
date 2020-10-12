<?php

namespace Tutorial\Devtrain\Model;

class Blog extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Tutorial\Devtrain\Model\ResourceModel\Blog');
    }
}