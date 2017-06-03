<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/30/15
 * Time: 10:36 AM
 */
class Admin_Model_Dao_ConfigShortenUrl extends DbTable_Config_Shorten_Url
{
    /**
     * Generate search query
     * @param string $short_url
     * @param string $full_url
     * @return Zend_Db_Table_Select
     */
    public function searchQuery($short_url, $full_url)
    {
        $select = $this->select();
        if ($short_url) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr('LOWER(' . DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_SHORT_URL . ')'),
                    $this->getAdapter()->quote('%' . strtolower($short_url) . '%')
                )
            );
        }
        if ($full_url) {
            $select->where(
                sprintf(
                    '%s like %s',
                    new Zend_Db_Expr('LOWER(' . DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_FULL_URL . ')'),
                    $this->getAdapter()->quote('%' . strtolower($full_url) . '%')
                )
            );
        }
        $select->order(DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_ID . ' desc');
        return $select;
    }

    /**
     * Generate search by short url
     * @param $short_url
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByShortUrl($short_url)
    {
        return $this->fetchRow(
            $this->select()->where(DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_SHORT_URL . '=?', $short_url)
        );
    }

    /**
     * Generate search by full url
     * @param $full_url
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByFullUrl($full_url)
    {
        return $this->fetchRow(
            $this->select()->where(DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_FULL_URL . '=?', $full_url)
        );
    }

    /**
     * Generate search by short url and full url
     * @param $short_url
     * @param $full_url
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function searchByShortUrlAndFullUrl($short_url, $full_url)
    {
        return $this->fetchRow(
            $this->select()
                ->where(DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_SHORT_URL . '=?', $short_url)
                ->where(DbTable_Config_Shorten_Url::COL_CONFIG_SHORTEN_URL_FULL_URL . '=?', $full_url)
        );
    }
}