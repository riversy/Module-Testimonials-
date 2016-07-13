<?php
namespace Test\Testimonials\Block\Adminhtml\Testimonial\Edit;

use Magento\Backend\Block\Widget\Context;
use Test\Testimonials\Api\TestimonialRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var TestimonialRepositoryInterface
     */
    protected $testimonialRepository;

    /**
     * @param Context $context
     * @param TestimonialRepositoryInterface $testimonialRepository
     */
    public function __construct(
        Context $context,
        TestimonialRepositoryInterface $testimonialRepository
    ) {
        $this->context = $context;
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Return  testimonial ID
     *
     * @return int|null
     */
    public function getTestimonialId()
    {
        try {
            return $this->testimonialRepository->getById(
                $this->context->getRequest()->getParam('testimonials_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
