<?php
namespace Test\Testimonials\Model;

use Test\Testimonials\Api\Data;
use Test\Testimonials\Api\TestimonialRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\Testimonials\Model\ResourceModel\Testimonial as ResourceTestimonial;
use Test\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory as TestimonialCollectionFactory;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    /**
     * @var ResourceTestimonial
     */
    protected $resource;

    /**
     * @var TestimonialFactory
     */
    protected $testimonialFactory;

    /**
     * @var TestimonialCollectionFactory
     */
    protected $testimonialCollectionFactory;

    /**
     * @var \Test\Testimonials\Api\Data\TestimonialInterfaceFactory
     */
    protected $dataTestimonialFactory;


    /**
     * @param ResourceTestimonial $resource
     * @param TestimonialFactory $testimonialFactory
     * @param Data\TestimonialInterfaceFactory $dataTestimonialFactory
     * @param TestimonialCollectionFactory $TestimonialCollectionFactory
     * @param Data\TestimonialSearchResultsInterfaceFactory $searchResultsFactory
     *
     */
    public function __construct(
        ResourceTestimonial $resource,
        TestimonialFactory $testimonialFactory,
        \Test\Testimonials\Api\Data\TestimonialInterfaceFactory $dataTestimonialFactory,
        TestimonialCollectionFactory $testimonialCollectionFactory

    ) {
        $this->resource = $resource;
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->dataTestimonialFactory = $dataTestimonialFactory;

    }

    /**
     * Save Testimonial data
     *
     * @param \Test\Testimonials\Api\Data\TestimonialInterface $testimonial
     * @return Testimonial
     * @throws CouldNotSaveException
     */
    public function save(Data\TestimonialInterface $testimonial)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $testimonial->setStoreId($storeId);
        try {
            $this->resource->save($testimonial);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $testimonial;
    }

    /**
     * Load Testimonial data by given Testimonial Identity
     *
     * @param string $testimonialId
     * @return Testimonial
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($testimonialId)
    {
        $testimonial = $this->testimonialFactory->create();
        $this->resource->load($testimonial, $testimonialId);
        if (!$testimonial->getId()) {
            throw new NoSuchEntityException(__('Testimonial with id "%1" does not exist.', $testimonialId));
        }
        return $testimonial;
    }

    /**
     * Delete Testimonial
     *
     * @param \Test\Testimonials\Api\Data\TestimonialInterface $testimonial
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\TestimonialInterface $testimonial)
    {
        try {

            $this->resource->delete($testimonial);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete testimonial by given testimonial Identity
     *
     * @param string $testimonialId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($testimonialId)
    {
        return $this->delete($this->getById($testimonialId));
    }
}