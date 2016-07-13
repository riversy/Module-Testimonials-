<?php
namespace Test\Testimonials\Model\Template;

class FilterProvider
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;


    protected $_testimonialFilter;

    /**
     * @var array
     */
    protected $_instanceList;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     *
     * @param string $testimonialFilter
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,

        $testimonialFilter = 'Test\Testimonials\Model\Template\Filter'
    ) {
        $this->_objectManager = $objectManager;

        $this->_testimonialFilter = $testimonialFilter;
    }

    /**
     * @param string $instanceName
     * @return \Magento\Framework\Filter\Template
     * @throws \Exception
     */
    protected function _getFilterInstance($instanceName)
    {
        if (!isset($this->_instanceList[$instanceName])) {
            $instance = $this->_objectManager->get($instanceName);

            if (!$instance instanceof \Magento\Framework\Filter\Template) {
                throw new \Exception('Template filter ' . $instanceName . ' does not implement required interface');
            }
            $this->_instanceList[$instanceName] = $instance;
        }

        return $this->_instanceList[$instanceName];
    }

    /**
     * @return \Magento\Framework\Filter\Template
     */
    public function getTestimonialFilter()
    {
        return $this->_getFilterInstance($this->_testimonialFilter);
    }


}
