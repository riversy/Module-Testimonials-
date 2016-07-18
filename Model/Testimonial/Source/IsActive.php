<?php
namespace Test\Testimonials\Model\Testimonial\Source;

use \Test\Testimonials\Model\Testimonial;

class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Test\Testimonials\Model\Testimonial
     */
    protected $testimonial;

    /**
     * Constructor
     *
     * @param \Test\Testimonials\Model\Testimonial $testimonial
     */
    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->testimonial->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
