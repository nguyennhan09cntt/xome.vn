<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 11/10/15
 * Time: 9:26 AM
 */
class Model_Promotion extends Application_Singleton
{
    /**
     * @var Model_Dao_Promotion
     */
    private $_dao;

    protected function __construct()
    {
        $this->_dao = new Model_Dao_Promotion();
    }

    /**
     * Get promotion listing
     * @param int $page
     * @param int $limit
     * @param int $componentId
     * @return array
     */
    public function getListing($page, $limit, $componentId)
    {
        $page = intval($page);
        $limit = intval($limit);
        $componentId = intval($componentId);

        $isCache = $page <= Application_Constant_Cache::CACHE_PAGE;
        $result = array();
        $key = Application_Cache_Default::getInstance()->promotionListing($componentId);
        if ($isCache) {
            $result = Application_Cache_Default::getInstance()->load($key);
        }
        if (!$result) {
            $paramsPage = $isCache ? 0 : $page;
            $paramsLimit = $isCache ? Application_Constant_Cache::CACHE_PAGE * $limit : $limit;
            $data = $this->_dao->getListing($paramsPage, $paramsLimit, $componentId);
            if ($data) {
                $total = isset($data[Application_Constant_Global::KEY_TOTAL]) ? $data[Application_Constant_Global::KEY_TOTAL] : 0;
                if ($total) {
                    $data[Application_Constant_Global::KEY_DATA] = $data[Application_Constant_Global::KEY_DATA]->toArray();
                    if ($isCache) {
                        Application_Cache_Default::getInstance()->save($data, $key, Application_Constant_Cache::PROMOTION_LISTING_LIFE_TIME);
                    }
                    $result = $data;
                }
            }
        }
        if ($isCache && $result) {
            $offset = ($page-1) * $limit;
            $result[Application_Constant_Global::KEY_DATA] = array_slice(
                $result[Application_Constant_Global::KEY_DATA],
                $offset,
                $limit
            );
        }
        return $result;
    }

    /**
     * Get all promotion information by fk component
     * @param int $componentId
     * @return array|false|mixed|null
     */
    public function getByFkComponent($componentId)
    {
        $result = array();
        $key = Application_Cache_Default::getInstance()->promotionComponent($componentId);
        $result = Application_Cache::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->getByFkComponent($componentId);
            if ($data) {
                foreach ($data as $promotion) {
                    $result[$promotion->{DbTable_Promotion::COL_PROMOTION_ID}] = $promotion->toArray();
                }
            }
            Application_Cache::getInstance()->save(
                $result,
                $key,
                Application_Constant_Cache::PROMOTION_COMPONENT_ALL_INFO_LIFE_TIME
            );
        }
        return $result;
    }


    /**
     * Get by ID
     * @param int $id
     * @return array|false|mixed
     */
    public function getById($id)
    {
        $id = intval($id);
        $key = Application_Cache_Default::getInstance()->promotionDetail($id);
        $result = Application_Cache_Default::getInstance()->load($key);
        if (!$result) {
            $data = $this->_dao->find($id);
            if ($data) {
                $result = $data->current()->toArray();
                Application_Cache_Default::getInstance()->save($result, $key, Application_Constant_Cache::PROMOTION_DETAIL_LIFE_TIME);
            }
        }
        return $result;
    }

    /**
     * Generate promotion URL
     * @param int $id
     * @param string $title
     * @param int $componentId
     * @return string
     */
    public function generateUrl($id, $title, $componentId)
    {
        $id = intval($id);
        $title = Application_Function_String::getFormatUrl($title);
        $component = '';
        switch ($componentId) {
            case Application_Constant_Db_Config_Component::BUS :
                $component = Application_Constant_Identify::COMPONENT_BUS;
                break;
            case Application_Constant_Db_Config_Component::PLANE :
                $component = Application_Constant_Identify::COMPONENT_PLANE;
                break;
            case Application_Constant_Db_Config_Component::HOTEL :
                $component = Application_Constant_Identify::COMPONENT_HOTEL;
                break;
            default:
                break;
        }
        return sprintf('/%s/uu-dai/%s-%d.html', $component, $title, $id);
    }
}