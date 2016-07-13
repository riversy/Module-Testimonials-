<?php
namespace Test\Testimonials\Block\Widget;

use Test\Testimonials\Api\Data\TestimonialInterface;
use Test\Testimonials\Model\ResourceModel\Testimonial\Collection as TestimonialCollection;

class Testimonial extends  \Test\Testimonials\Block\TestimonialList  implements \Magento\Widget\Block\BlockInterface
{
   const DEFAULT_COUNT = 3;

   const DEFAULT_SORT_ORDER = 'DESC';
    /**
     * Get testimonials count parameter
     *
     * @return mixed
     */
    public function getTestimonialsCount()
    {
        if (!$this->hasData('testimonials_count')) {
            return self::DEFAULT_COUNT;
        }
        return $this->getData('testimonials_count');
    }

    /**
     * Get sortOrder parameter
     * @return mixed
     */
    public function getSortOrder()
    {
        if (!$this->hasData('sort_order')) {
            return self::DEFAULT_SORT_ORDER();
        }
        return $this->getData('sort_order');
    }

    /**
     * @return \Test\Testimonials\Model\ResourceModel\Testimonial\Collection
     */
    public function getTestimonials()
    {
        if (!$this->hasData('testimonial')) {
            /** @var \Test\Testimonials\Model\ResourceModel\Testimonial\Collection $testimonialCollection  */
            $testimonialCollection = $this->_testimonialCollectionFactory
                ->create();
            $testimonialCollection->getSelect()->limit($this->getTestimonialsCount());
            $testimonialCollection
                ->addFilter('is_active', 1)
                ->addOrder(
                    TestimonialInterface::CREATION_TIME,
                    $this->getSortOrder()

                );

            $this->setData('testimonial', $testimonialCollection);
        }
        return $this->getData('testimonial');
    }

    /**
     *
     */
    protected function _construct( )
    {
        parent::_construct( );
        $this->setTemplate('widget/testimonial.phtml');

     }

}