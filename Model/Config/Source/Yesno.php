<?php
namespace Test\Testimonials\Model\Config\Source;

class Yesno implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 'DESC', 'label' => __('Descending')], ['value' => 'ASC', 'label' => __('Ascending')]];
    }


}
