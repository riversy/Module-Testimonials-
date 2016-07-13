<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action\Context;
use Test\Testimonials\Api\TestimonialRepositoryInterface as TestimonialRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Test\Testimonials\Api\Data\TestimonialInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var TestimonialRepository  */
    protected $testimonialRepository;

    /** @var JsonFactory  */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param TestimonialRepository $testimonialRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        TestimonialRepository $testimonialRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->testimonialRepository = $testimonialRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $testimonialId) {
                    /** @var \Test\Testimonials\Model\Testimonial $testimonial */
                    $testimonial = $this->testimonialRepository->getById($testimonialId);
                    try {
                        $testimonial->setData(array_merge($testimonial->getData(), $postItems[$testimonialId]));
                        $this->testimonialRepository->save($testimonial);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithTestimonialId(
                            $testimonial,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add testimonial title to error message
     *
     * @param TestimonialInterface $block
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithTestimonialId(TestimonialInterface $testimonial, $errorText)
    {
        return '[Testimonial ID: ' . $testimonial->getId() . '] ' . $errorText;
    }
}
