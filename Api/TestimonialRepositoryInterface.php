<?php
namespace Test\Testimonials\Api;


interface TestimonialRepositoryInterface
{
    /**
     * Save testimonial.
     *
     * @param \Test\Testimonials\Api\Data\TestimonialInterface $testimonial
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\TestimonialInterface $testimonial);

    /**
     * Retrieve testimonial.
     *
     * @param int $testimonialId
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($testimonialId);
    /**
     * Delete testimonial.
     *
     * @param \Test\Testimonials\Api\Data\TestimonialInterface $testimonial
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\TestimonialInterface $testimonial);

    /**
     * Delete testimonial by ID.
     *
     * @param int $testimonialId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($testimonialId);}
