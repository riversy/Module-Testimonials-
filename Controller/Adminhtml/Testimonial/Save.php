<?php

namespace Test\Testimonials\Controller\Adminhtml\Testimonial;

use Magento\Backend\App\Action\Context;
use Test\Testimonials\Model\Testimonial;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Test\Testimonials\Model\UploaderPool;

class Save extends \Test\Testimonials\Controller\Adminhtml\Testimonial
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        UploaderPool $uploaderPool
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->uploaderPool = $uploaderPool;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('testimonials_id');

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Testimonial::STATUS_ENABLED;
            }
            if (empty($data['testimonials_id'])) {
                $data['testimonials_id'] = null;
            }
            $avatar = $this->getUploader('image')->uploadFileAndGetName('avatar', $data);
            $data['avatar'] = $avatar;
            /** @var \Test\Testimonials\Model\Testimonial $model */
            $model = $this->_objectManager->create('Test\Testimonials\Model\Testimonial')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This testimonial no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the testimonial.'));
                $this->dataPersistor->clear('testimonial');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['testimonials_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the testimonial.'));
            }

            $this->dataPersistor->set('testimonial', $data);
            return $resultRedirect->setPath('*/*/edit', ['testimonials_id' => $this->getRequest()->getParam('testimonials_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);

    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Test_Testimonials::save');
    }
}