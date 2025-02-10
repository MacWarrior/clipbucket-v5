<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00262 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('countries') . ' DROP COLUMN `name`;', [
            'table'  => 'countries',
            'column' => 'name'
        ]);

        $sql = 'DELETE FROM ' . tbl('countries') . ' WHERE iso2 = \'AN\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso2 = \'RS\', name_en = \'Serbia\', iso3 = \'SRV\', numcode = \'688\' WHERE iso2 = \'CS\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'ATA\', numcode = \'10\' WHERE iso2 = \'AQ\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'BVT\', numcode = \'74\' WHERE iso2 = \'BV\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'IOT\', numcode = \'86\' WHERE iso2 = \'IO\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'CXR\', numcode = \'162\' WHERE iso2 = \'CX\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'CCK\', numcode = \'166\' WHERE iso2 = \'CC\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'ATF\', numcode = \'260\' WHERE iso2 = \'TF\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'HMD\', numcode = \'334\' WHERE iso2 = \'HM\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'MYT\', numcode = \'175\' WHERE iso2 = \'YT\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'PSE\', numcode = \'275\' WHERE iso2 = \'PS\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'SGS\', numcode = \'239\' WHERE iso2 = \'GS\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'TLS\', numcode = \'626\' WHERE iso2 = \'TL\';';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('countries') . ' SET iso3 = \'UMI\', numcode = \'581\' WHERE iso2 = \'UM\';';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'BQ\',\'Bonaire, Sint Eustatius and Saba\',\'BES\',535);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'CW\',\'Curaçao\',\'CUW\',531);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'GG\',\'Guernsey\',\'GGY\',831);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'IM\',\'Isle of Man\',\'IMN\',833);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'JE\',\'Jersey\',\'JEY\',832);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'ME\',\'Montenegro\',\'MNE\',499);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'BL\',\'Saint Barthélemy\',\'BLM\',652);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'MF\',\'Saint Martin (French part)\',\'MAF\',663);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'SX\',\'Sint Maarten (Dutch part)\',\'SXM\',534);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'SS\',\'South Sudan\',\'SSD\',728);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('countries') . ' (iso2, name_en, iso3, numcode) VALUES (\'AX\',\'Åland Islands\',\'ALA\',248);';
        self::query($sql);
    }
}
