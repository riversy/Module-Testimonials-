<?php
namespace Test\Testimonials\Api\Data;


interface TestimonialInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TESTIMONIALS_ID      = 'testimonials_id';
    const TITLE                = 'title';
    const CONTENT              = 'content';
    const CREATION_TIME        = 'creation_time';
    const IS_ACTIVE            = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */

    public function getContent();

    /**
     * Get creation time
     *
     * @return string|null
     */

    public function getCreationTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */

    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */

    public function setTitle($title);

    /**
     * Set content
     *
     * @param string $content
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setContent($content);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setIsActive($isActive);
}
