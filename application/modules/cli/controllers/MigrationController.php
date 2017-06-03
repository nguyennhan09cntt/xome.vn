<?php
class Cli_MigrationController extends Application_Controller_Cli
{
    /**
     * @var string
     */
    private $_path;

    /**
     * @var string
     */
    private $_path_script;

    /**
     * @var string
     */
    private $_vPathDbTable;

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    private $_db;

    public function init()
    {
        $this->_path = SYS_PATH . '/scripts/builds/migrations';
        $this->_path_script = $this->_path . '/scripts';
        $this->_vPathDbTable = APPLICATION_PATH . '/libs';
        $this->_db = Zend_Registry::get('db_master');
    }

    /**
     * Usage: php cli.php -m cli -c migration
     */
    public function indexAction()
    {
        $config = Zend_Registry::get('config');
        $generate = $this->getRequest()->getParam('g', 0);

        $migration = $this->_runMigration();
        $this->_runRoutine();
        if ($config->env->name != 'live') {
            $this->_cleanCache();
            if ($migration || $generate==1) {
                $pathDbTable = APPLICATION_PATH . '/libs/DbTable';
                if (!is_dir($pathDbTable)) {
                    mkdir($pathDbTable);
                }
                $this->_cleanUpDbTable($pathDbTable);
                $this->_generateDbTable($pathDbTable, $this->_db, 'DbTable');

                #DbLink News
                /*
                $pathDbTable = APPLICATION_PATH . '/libs/DbLink';
                if (!is_dir($pathDbTable)) {
                    mkdir($pathDbTable);
                }
                $pathDbTable = $pathDbTable . '/News';
                if (!is_dir($pathDbTable)) {
                    mkdir($pathDbTable);
                }
                $dbNews = new Application_Db_DbLink_News();
                $this->_cleanUpDbTable($pathDbTable);
                $this->_generateDbTable($pathDbTable, $dbNews->getDbTable(), 'DbLink_News');
                */
                #DbLink News
            }
        }
    }

    private function _cleanCache()
    {
        Application_Cache::getInstance()->clean();
    }

    private function _runRoutine()
    {
        $routinePath = $this->_path . '/routines';
        $dir = scandir($routinePath);
        if ($dir) {
            foreach ($dir as $file) {
                if (!in_array($file, array('.','..'))) {
                    $query = file_get_contents($routinePath . '/'. $file);
                    if ($query) {
                        try {
                            echo '>>>>>Running:' . PHP_EOL . $file . PHP_EOL . PHP_EOL;
                            $this->_db->query($query);
                        } catch (Exception $e) {
                            echo 'Caught exception: ' . $e->getMessage() . PHP_EOL . PHP_EOL;
                            echo 'Can not execute [' . $file . ']. Routine was stopped.';

                            $this->_showLine('*');
                            die();
                        }
                    }
                }
            }
        }
    }

    /**
     * Run migration script
     * @return int
     */
    private function _runMigration()
    {
        require_once $this->_path . '/List.php';
        $arrDataMigration = array();
        $arrMigration = array();
        $arrData = Cli_Model_SchemaUpdated::getInstance()->search(array());
        $migration = MigrationList::getList();

        if ($arrData) {
            foreach ($arrData as $data) {
                $arrDataMigration[] = trim($data['migration']);
            }
        }
        if ($migration) {
            foreach ($migration as $script) {
                if (!in_array($script, $arrDataMigration)) {
                    $arrMigration[] = trim($script);
                }
            }
        }
        $migrationScript = 0;
        if ($arrMigration) {
            echo 'Starting migration:' . PHP_EOL;

            foreach ($arrMigration as $script) {
                $file = $this->_path_script . '/' . $script;

                $this->_showLine('=');
                echo $script . ' :' . PHP_EOL;

                if (!file_exists($file)) {
                    echo 'File does not exist in [' . $file . ']' . PHP_EOL;
                    $this->_db->rollBack();
                    die();
                } else {
                    $content = trim(file_get_contents($file));
                    if ($content) {
                        $arrStatementUp = explode(';', $content);
                        $arrStatementDown = array();

                        $this->_db->beginTransaction();
                        try {
                            foreach ($arrStatementUp as $statement) {
                                $statement = trim($statement);
                                if ($statement) {
                                    $statementDown = $this->_prepareDownStatement($statement);
                                    if ($statementDown) {
                                        $arrStatementDown[] = $statementDown;
                                    }
                                    echo '>>>>>Running:' . PHP_EOL . $statement . PHP_EOL . PHP_EOL;
                                    $this->_db->query($statement);
                                }
                            }
                            $params = array(
                                'schema_updated_file' => trim($script)
                            );
                            Cli_Model_SchemaUpdated::getInstance()->insert($params);

                            $this->_db->commit();

                            echo 'Done.' . PHP_EOL;
                            $migrationScript++;
                        } catch (Exception $e) {
                            $this->_db->rollBack();

                            if ($arrStatementDown) {
                                $this->_db->query(implode(' ; ', $arrStatementDown));
                            }

                            echo 'Caught exception: ' . $e->getMessage() . PHP_EOL . PHP_EOL;
                            echo 'Can not execute [' . $script . ']. Migration was stopped.';

                            $this->_showLine('*');
                            die();
                        }
                    }
                }
                $this->_showLine('=');
            }
            echo PHP_EOL . 'Migration is done.' . PHP_EOL;
        } else {
            echo 'No migration need to be deployed.' . PHP_EOL;
        }
        return $migrationScript;
    }

    /**
     * Clean up db table classes
     * @param string $pathDbTable
     */
    private function _cleanUpDbTable($pathDbTable)
    {
        $arrDir = scandir($pathDbTable);
        foreach ($arrDir as $dir) {
            if (in_array($dir, array('.', '..'))) {
                continue;
            }
            Application_Function_Folder::removePath($pathDbTable.'/'.$dir);
        }
    }

    /**
     * Generate db table
     * @param string $pathDbTable
     * @param Zend_Db_Adapter_Abstract $db
     * @param string $type
     */
    private function _generateDbTable($pathDbTable, $db, $type)
    {
        $arrTable = $db->fetchAll('Show tables');
        foreach ($arrTable as $item) {
            foreach ($item as $tableName) {

                $className = $this->_generateClassName($tableName);
                $generatePath = $this->_generatePathByClassName($pathDbTable, $className);

                $this->view->assign('timeStamp', date('Y-m-d H:i:s'));
                $this->view->assign('className', $className);
                $this->view->assign('tableName', $tableName);
                $this->view->assign('type', $type);
                $this->view->assign(
                    'arrColumn',
                    $db->fetchAll('DESCRIBE '.$tableName)
                );

                $pathClass = $pathDbTable.'/'.$generatePath;
                file_put_contents(
                    $pathClass,
                    $this->view->render('migration/DbTable.phtml')
                );

                echo 'Generating DbTable for ['.$tableName.'] table...' . PHP_EOL;
                echo $pathClass;
                echo PHP_EOL . PHP_EOL ;
            }
        }
    }

    /**
     * Generate name of DbTable classes
     * @param string $tableName
     * @return null|string
     */
    private function _generateClassName($tableName)
    {
        $classPath = null;
        $info = explode('_', $tableName);
        foreach ($info as $folder) {
            $folder = ucwords(trim($folder));
            if ($folder) {
                $classPath = $classPath ? ($classPath.'_'.$folder) : $folder;
            }
        }
        return $classPath;
    }

    /**
     * Generate path of DbTable classes
     * @param string $pathDbTable
     * @param string $path
     * @param string $separated
     * @return string
     */
    private function _generatePathByClassName($pathDbTable, $path, $separated='_')
    {
        $generatePath = str_replace($separated, '/', $path).'.php';
        Application_Function_Folder::createFolderFollowPath($pathDbTable, $generatePath);
        return $generatePath;
    }

    /**
     * Show new line in command
     * @param string $p_symbol
     */
    private function _showLine($p_symbol)
    {
        echo PHP_EOL;
        for ($i = 0; $i < 80; $i++) {
            echo $p_symbol;
        }
        echo PHP_EOL;
    }

    /**
     * Generate down statement
     * @param $p_strQuery
     * @return null|string
     */
    private function _prepareDownStatement($p_strQuery)
    {
        $strResult = null;
        $arrSyntax = array('create table', 'create index', 'rename table');
        $syntaxSupported = null;
        foreach ($arrSyntax as $syntax) {
            if (strstr(strtolower(trim($p_strQuery)), $syntax)) {
                $syntaxSupported = $syntax;
                break;
            }
        }
        if ($syntaxSupported) {
            switch ($syntaxSupported) {
                case 'create table':
                    $arrInfo = explode('(', $p_strQuery);
                    $tableName = trim(str_replace($syntaxSupported, '', strtolower(trim($arrInfo[0]))));
                    $strResult = 'DROP TABLE ' . $tableName;
                    break;
                case 'create index':
                    $arrInfo = explode('(', $p_strQuery);
                    $strResult = trim(str_replace('create', 'drop', strtolower(trim($arrInfo[0]))));
                    break;
                case 'rename table':
                    $p_strQuery = strtolower(trim($p_strQuery));
                    $arrInfo = explode(' to ', $p_strQuery);
                    $newTable = trim(str_replace(';', '', $arrInfo[1]));
                    $oldTable = trim(str_replace('rename table', '', $arrInfo[0]));
                    $strResult = 'RENAME TABLE ' . $newTable . ' TO ' . $oldTable;
                    break;
                default:
                    break;
            }
        }
        return $strResult;
    }

}