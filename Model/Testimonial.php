<?php namespace Test\Testimonials\Model;

use Test\Testimonials\Api\Data\TestimonialInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Testimonial  extends \Magento\Framework\Model\AbstractModel implements TestimonialInterface, IdentityInterface
{
    /**
     * Testimonial's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     *  cache tag
     */
    const CACHE_TAG = 'testimonial';

    /**
     * @var string
     */
    protected $_cacheTag = 'testimonial';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'testimonial';

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Registry $registry,
        UploaderPool $uploaderPool,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [])
    {
        $this->uploaderPool = $uploaderPool;
        $this->_urlBuilder  = $urlBuilder;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */

    protected function _construct()
    {
        $this->_init('Test\Testimonials\Model\ResourceModel\Testimonial');
    }

    /**
     * Prevent testimonials recursion
     *
     * @return AbstractModel
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $needle = 'testimonials_id="' . $this->getId() . '"';
        if (false == strstr($this->getContent(), $needle)) {
            return parent::beforeSave();
        }
        throw new \Magento\Framework\Exception\LocalizedException(
            __('Make sure that testimonial content does not reference the testimonial itself.')
        );
    }

    /**
     * Prepare testimonial's statuses.
     * Available event testimonial_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::TESTIMONIALS_ID);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->getData(TestimonialInterface::AVATAR);
    }

    /**
     * @return bool|string
     * @throws LocalizedException
     */
    public function getAvatarUrl()
    {
        $url = false;
        $avatar = $this->getAvatar();
        if ($avatar) {
            if (is_string($avatar)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$avatar;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the avatar url.')
                );
            }
        }
        return $url;
    }

    /**
     * Return the desired URL of a Testimonial
     *  eg: /testimonials/view/index/id/1/
     * @TODO Move to a TestimonialUrl model, and make use of the
     * @TODO rewrite system, using url_key to build url.
     * @TODO desired url: /testimonials/my-test-testimonials-testimonial-title
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_urlBuilder->getUrl();
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }
    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive()
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setId($id)
    {
        return $this->setData(self::TESTIMONIALS_ID, $id);
    }

    /**
     * Set  title
     *
     * @param string $title
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * set avatar
     *
     * @param $avatar
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setAvatar($avatar)
    {
        return $this->setData(TestimonialInterface::AVATAR, $avatar);
    }

    /**
     * Set  content
     *
     * @param string $content
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set  creation time
     *
     * @param string $creation_time
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setCreationTime($creation_time)
    {
        return $this->setData(self::CREATION_TIME, $creation_time);
    }

    /**
     * Set  is active
     *
     * @param int|bool $is_active
     * @return \Test\Testimonials\Api\Data\TestimonialInterface
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }

}
