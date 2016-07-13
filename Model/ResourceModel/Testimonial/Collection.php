<?php
namespace Test\Testimonials\Model\ResourceModel\Testimonial;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'testimonials_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Test\Testimonials\Model\Testimonial', 'Test\Testimonials\Model\ResourceModel\Testimonial');
    }

}
