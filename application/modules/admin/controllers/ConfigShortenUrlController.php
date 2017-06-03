<?php
/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 2:29 PM
 */
class Admin_ConfigShortenUrlController extends Application_Controller_BackEnd_Admin
{
    public function indexAction()
    {
        $short_url = $this->getRequest()->getParam('s');
        $full_url = $this->getRequest()->getParam('f');

        $this->loadGird(
            Admin_Model_ConfigShortenUrl::getInstance()->searchQuery($short_url, $full_url)
        );

        $this->view->assign('short_url', $short_url);
        $this->view->assign('full_url', $full_url);
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('i');
        if ($id) {
            $data = Admin_Model_ConfigShortenUrl::getInstance()->getById($id);
            if ($data) {
                $this->view->assign('dataInfo', $data->current());
            }
        }
    }

    public function submitEditAction()
    {
        $id = $this->getRequest()->getParam('id');
        $short_url = $this->getRequest()->getParam('short_url');
        $full_url = $this->getRequest()->getParam('full_url');

        $message = null;
        $validation = true;

        $validationShortUrl = Admin_Model_ConfigShortenUrl::getInstance()->searchByShortUrl($short_url);
        if (!$validationShortUrl || ($id && $validationShortUrl && $validationShortUrl->{DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_ID}==$id)) {
            $validationFullUrl = Admin_Model_ConfigShortenUrl::getInstance()->searchByFullUrl($full_url);
            if (!$validationFullUrl || ($id && $validationFullUrl && $validationFullUrl->{DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_ID}==$id)) {
                $validationShortUrlAndFullUrl = Admin_Model_ConfigShortenUrl::getInstance()->searchByShortUrlAndFullUrl($short_url, $full_url);
                if ((!$id && $validationShortUrlAndFullUrl) || ($id && $validationShortUrlAndFullUrl && $validationShortUrlAndFullUrl->{DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_ID}!=$id)) {
                    $validation = false;
                    $message = Application_Constant_Module_Admin_ConfigShortenUrl_SubmitEdit::MSG_URL_DUPLICATED;
                }
            } else {
                $validation = false;
                $message = Application_Constant_Module_Admin_ConfigShortenUrl_SubmitEdit::MSG_URL_DUPLICATED;
            }
        } else {
            $validation = false;
            $message = Application_Constant_Module_Admin_ConfigShortenUrl_SubmitEdit::MSG_URL_DUPLICATED;
        }

        if ($validation) {
            if ($id) {
                $message = Admin_Model_ConfigShortenUrl::getInstance()->update($id, $short_url, $full_url);
            } else {
                $message = Admin_Model_ConfigShortenUrl::getInstance()->insert($short_url, $full_url);
            }
        }

        if ($message) {
            $this->alertSubmitError($message);
        } else {
            $this->redirectSubmit('config-shorten-url/');
        }
        $this->noRender();
    }

    public function deleteByIdAction()
    {
        $id = $this->getRequest()->getParam('i');
        if ($id) {
            Admin_Model_ConfigShortenUrl::getInstance()->deleteById($id);
            $this->gotoUrl('config-shorten-url/');
        }
        $this->noRender();
    }
}