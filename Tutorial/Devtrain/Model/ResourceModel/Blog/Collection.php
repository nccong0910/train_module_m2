<?php

namespace Tutorial\Devtrain\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(   'Tutorial\Devtrain\Model\Blog',
                        'Tutorial\Devtrain\Model\ResourceModel\Blog');
    }
}