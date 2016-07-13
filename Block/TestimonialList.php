<?php
namespace Test\Testimonials\Block;

use Test\Testimonials\Api\Data\TestimonialInterface;
use Test\Testimonials\Model\ResourceModel\Testimonial\Collection as TestimonialCollection;

class TestimonialList extends \Magento\Framework\View\Element\Template

{
    /**
     * @var \Test\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory
     */
    protected $_testimonialCollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Test\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory $testimonialCollectionFactory,
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
       \Test\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory $testimonialCollectionFactory,
       array $data = []
   ) {
       parent::__construct($context, $data);
        $this->_testimonialCollectionFactory = $testimonialCollectionFactory;
   }

    /**
     * @return \Test\Testimonials\Model\ResourceModel\Testimonial\Collection
     */
    public function getTestimonials()
    {
        if (!$this->hasData('testimonialCollection')) {
            /** @var \Test\Testimonials\Model\ResourceModel\Testimonial\Collection $testimonialCollection  */
            $testimonialCollection = $this->_testimonialCollectionFactory
                ->create()
                ->addFilter('is_active', 1)
                ->addOrder(
                    TestimonialInterface::CREATION_TIME,
                    TestimonialCollection::SORT_ORDER_DESC
                );
            $this->setData('testimonials', $testimonialCollection);
        }
        return $this->getData('testimonials');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */

    public function getIdentities()
    {
        return [\Test\Testimonials\Model\Testimonial::CACHE_TAG . '_' . 'list'];
    }

    /**
     * @param \Test\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory $testimonialCollectionFactory
     * @return TestimonialList
     */
    public function setTestimonialCollectionFactory($testimonialCollectionFactory)
    {
        $this->_testimonialCollectionFactory = $testimonialCollectionFactory;
        return $this;
    }
}
