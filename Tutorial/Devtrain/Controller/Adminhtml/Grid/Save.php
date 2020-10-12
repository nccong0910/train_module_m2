<?php

namespace Tutorial\Devtrain\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Auth\Session;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_adminSession;

    /**
     * @var \Tutorial\Devtrain\Model\BlogFactory
     */
    protected $blogFactory;

    /**
     * @param Action\Context                      $context
     * @param \Magento\Backend\Model\Auth\Session $adminSession
     * @param \Tutorial\Devtrain\Model\BlogFactory          $blogFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Tutorial\Devtrain\Model\BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->_adminSession = $adminSession;
        $this->blogFactory = $blogFactory;
    }

    /**
     * Save blog record action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $postObj = $this->getRequest()->getPostValue();
        $name = $postObj["title"];
        $date = date("Y-m-d h:i:s");
        $username = $this->_adminSession->getUser()->getFirstname();
        if ($username == $name) {
            $username = $this->_adminSession->getUser()->getFirstname();
        } else {
            $username = $name;
        }
        $description =$postObj["description"];

        $userDetail = ["title" => $username,"description" => $description, "create_at" => $date];
        $data = array_merge($postObj, $userDetail);

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->blogFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->_adminSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('blog/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        #image
        if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['name'];
            $this->imageUploader->moveFileFromTmp($data['image']);
        } elseif (isset($data['image'][0]['name']) && !isset($data['image'][0]['tmp_name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = '';
        }
        return $resultRedirect->setPath('*/*/');
    }
}