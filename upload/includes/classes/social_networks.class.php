<?php
class SocialNetworks{
    private static $social_networks;
    private $tablename;
    private $tablename_icons;

    /**
     * @throws Exception
     */
    public function __construct(){
        $this->tablename = 'social_networks';
        $this->tablename_icons = 'fontawesome_icons';
    }

    public static function getInstance(): self
    {
        if( empty(self::$social_networks) ){
            self::$social_networks = new self();
        }
        return self::$social_networks;
    }

    private function getTableName(): string
    {
        return $this->tablename;
    }

    private function getTableNameIcons(): string
    {
        return $this->tablename_icons;
    }

    /**
     * @throws Exception
     */
    public function getAllIcons(): array
    {
        $sql = 'SELECT id_fontawesome_icon, icon FROM '.$this->tablename_icons;
        return Clipbucket_db::getInstance()->_select($sql);
    }
}