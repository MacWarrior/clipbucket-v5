<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('request_has_been_canceled', [
            'fr' => 'Votre demande d\'ami a été annulée',
            'en' => 'Your request has been canceled'
        ]);

        self::generateTranslation('confirm_unfriend', [
            'fr' => 'Voulez-vous vraiment supprimer %s de votre liste des contacts ?',
            'en' => 'Are you sure you want to unfriend %s ?'
        ]);

        $sql = 'DELETE FROM ' . tbl('subscriptions') . ' WHERE `subscribed_to` NOT REGEXP \'^[0-9]+$\' OR `subscribed_to` IS NULL OR `subscribed_to` NOT IN (SELECT `userid` FROM ' . tbl('users') . ') OR `userid` NOT IN (SELECT `userid` FROM ' . tbl('users') . ')';
        self::query($sql);

        self::alterTable('ALTER TABLE ' . tbl('subscriptions') . ' CHANGE `subscribed_to` `subscribed_to` BIGINT NOT NULL;',
            [
                'table'  => 'subscriptions',
                'column' => 'subscribed_to'
            ]
        );
        self::alterTable('ALTER TABLE `{tbl_prefix}subscriptions`
            ADD CONSTRAINT `subscriptions_subscribed_to_fk` FOREIGN KEY (`subscribed_to`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'subscriptions',
            'column' => 'subscribed_to'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'subscriptions_subscribed_to_fk'
            ]
        ]);
        self::alterTable('ALTER TABLE ' . tbl('subscriptions') . ' CHANGE `userid` `userid` BIGINT NOT NULL;',
            [
                'table'  => 'subscriptions',
                'column' => 'userid'
            ]
        );
        self::alterTable('ALTER TABLE `{tbl_prefix}subscriptions`
            ADD CONSTRAINT `subscriptions_userid_fk` FOREIGN KEY (`userid`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'subscriptions',
            'column' => 'userid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'subscriptions_userid_fk'
            ]
        ]);

        //maj compteurs
        $sql = 'UPDATE ' . tbl('users') . ' U
        INNER JOIN (
        SELECT `userid`, COUNT(*) AS `total_subscriptions` FROM ' . tbl('subscriptions') . ' GROUP BY `userid`) sub on U.userid = sub.userid
        SET U.`total_subscriptions` = sub.total_subscriptions';
        self::query($sql);
        $sql = 'UPDATE ' . tbl('users') . ' U
        INNER JOIN (
        SELECT `subscribed_to`, COUNT(*) AS `total_subscribers` FROM ' . tbl('subscriptions') . ' GROUP BY `subscribed_to`) sub on U.userid = sub.subscribed_to
        SET U.`subscribers` = sub.total_subscribers';
        self::query($sql);
    }
}
