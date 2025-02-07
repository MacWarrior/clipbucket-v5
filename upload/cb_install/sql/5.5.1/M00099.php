<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00099 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('automate_launch_mode', 'user_activity');
        self::generateConfig('timezone', '');

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `frequency` varchar(30)', [
            'table' => 'tools'
        ], [
            'table'  => 'tools',
            'column' => 'frequency'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `previous_calculated_datetime` datetime', [
            'table' => 'tools'
        ], [
            'table'  => 'tools',
            'column' => 'previous_calculated_datetime'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `is_automatable` BOOL DEFAULT TRUE', [
            'table' => 'tools'
        ], [
            'table'  => 'tools',
            'column' => 'is_automatable'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `is_disabled` BOOL DEFAULT FALSE', [
            'table' => 'tools'
        ], [
            'table'  => 'tools',
            'column' => 'is_disabled'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD CONSTRAINT `chk_frequency_previous_calculated_datetime_required` 
                CHECK (
                    frequency IS NULL OR TRIM(frequency) = \'\' OR previous_calculated_datetime IS NOT NULL
                );', [
            'table'   => 'tools',
            'columns' => ['frequency', 'previous_calculated_datetime']
        ],[
            'constraint' => [
                'type' => 'CONSTRAINT',
                'name' => 'chk_frequency_previous_calculated_datetime_required'
            ]
        ]);

        self::query( /** @lang MySQL */'UPDATE `{tbl_prefix}tools` SET is_disabled = TRUE');
        self::query( /** @lang MySQL */'UPDATE `{tbl_prefix}tools` SET `frequency` = \'0 0 * * 7\', `previous_calculated_datetime` = CURRENT_TIMESTAMP,  is_disabled = FALSE WHERE code = \'clean_orphan_files\' ');
        self::query( /** @lang MySQL */'UPDATE `{tbl_prefix}tools` SET `frequency` = \'0 1 * * 7\', `previous_calculated_datetime` = CURRENT_TIMESTAMP,  is_disabled = FALSE WHERE code = \'repair_video_duration\' ');
        self::query( /** @lang MySQL */'UPDATE `{tbl_prefix}tools` SET `frequency` = \'0 2 * * 7\', `previous_calculated_datetime` = CURRENT_TIMESTAMP,  is_disabled = FALSE WHERE code = \'clean_orpha\' ');
        self::query( /** @lang MySQL */'UPDATE `{tbl_prefix}tools` SET `frequency` = \'0 3 * * 7\', `previous_calculated_datetime` = CURRENT_TIMESTAMP,  is_disabled = FALSE WHERE code = \'clean_session_table\' ');
        self::query( /** @lang MySQL */'UPDATE `{tbl_prefix}tools` SET `frequency` = \'0 4 * * 7\', `previous_calculated_datetime` = CURRENT_TIMESTAMP,  is_disabled = FALSE WHERE code = \'correct_video_categorie\' ');

        $sql = /** @lang MySQL */'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `code`, `frequency`, `previous_calculated_datetime`, `is_automatable`, `is_disabled`) 
                VALUES (\'automate_label\', \'automate_description\', \'AdminTool::checkAndStartToolsByFrequency\', \'automate\', NULL, NULL, 0, 0)';
        self::query($sql);


        self::query( /** @lang MySQL */'CREATE TABLE IF NOT EXISTS `{tbl_prefix}timezones` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `timezone` VARCHAR(255) NOT NULL UNIQUE
            );');

        self::query( /** @lang MySQL */'INSERT IGNORE INTO `{tbl_prefix}timezones` (`timezone`) VALUES
            (\'Africa/Abidjan\'),
            (\'Africa/Accra\'),
            (\'Africa/Addis_Ababa\'),
            (\'Africa/Algiers\'),
            (\'Africa/Asmara\'),
            (\'Africa/Asmera\'),
            (\'Africa/Bamako\'),
            (\'Africa/Bangui\'),
            (\'Africa/Banjul\'),
            (\'Africa/Bissau\'),
            (\'Africa/Blantyre\'),
            (\'Africa/Brazzaville\'),
            (\'Africa/Bujumbura\'),
            (\'Africa/Cairo\'),
            (\'Africa/Casablanca\'),
            (\'Africa/Ceuta\'),
            (\'Africa/Conakry\'),
            (\'Africa/Dakar\'),
            (\'Africa/Dar_es_Salaam\'),
            (\'Africa/Djibouti\'),
            (\'Africa/Douala\'),
            (\'Africa/El_Aaiun\'),
            (\'Africa/Freetown\'),
            (\'Africa/Gaborone\'),
            (\'Africa/Harare\'),
            (\'Africa/Johannesburg\'),
            (\'Africa/Juba\'),
            (\'Africa/Kampala\'),
            (\'Africa/Khartoum\'),
            (\'Africa/Kigali\'),
            (\'Africa/Kinshasa\'),
            (\'Africa/Lagos\'),
            (\'Africa/Libreville\'),
            (\'Africa/Lome\'),
            (\'Africa/Luanda\'),
            (\'Africa/Lubumbashi\'),
            (\'Africa/Lusaka\'),
            (\'Africa/Malabo\'),
            (\'Africa/Maputo\'),
            (\'Africa/Maseru\'),
            (\'Africa/Mbabane\'),
            (\'Africa/Mogadishu\'),
            (\'Africa/Monrovia\'),
            (\'Africa/Nairobi\'),
            (\'Africa/Ndjamena\'),
            (\'Africa/Niamey\'),
            (\'Africa/Nouakchott\'),
            (\'Africa/Ouagadougou\'),
            (\'Africa/Porto-Novo\'),
            (\'Africa/Sao_Tome\'),
            (\'Africa/Timbuktu\'),
            (\'Africa/Tripoli\'),
            (\'Africa/Tunis\'),
            (\'Africa/Windhoek\'),
            (\'America/Adak\'),
            (\'America/Anchorage\'),
            (\'America/Anguilla\'),
            (\'America/Antigua\'),
            (\'America/Araguaina\'),
            (\'America/Argentina/Buenos_Aires\'),
            (\'America/Argentina/Catamarca\'),
            (\'America/Argentina/ComodRivadavia\'),
            (\'America/Argentina/Cordoba\'),
            (\'America/Argentina/Jujuy\'),
            (\'America/Argentina/La_Rioja\'),
            (\'America/Argentina/Mendoza\'),
            (\'America/Argentina/Rio_Gallegos\'),
            (\'America/Argentina/Salta\'),
            (\'America/Argentina/San_Juan\'),
            (\'America/Argentina/San_Luis\'),
            (\'America/Argentina/Tucuman\'),
            (\'America/Argentina/Ushuaia\'),
            (\'America/Aruba\'),
            (\'America/Asuncion\'),
            (\'America/Atikokan\'),
            (\'America/Atka\'),
            (\'America/Bahia\'),
            (\'America/Bahia_Banderas\'),
            (\'America/Barbados\'),
            (\'America/Belem\'),
            (\'America/Belize\'),
            (\'America/Blanc-Sablon\'),
            (\'America/Boa_Vista\'),
            (\'America/Bogota\'),
            (\'America/Boise\'),
            (\'America/Buenos_Aires\'),
            (\'America/Cambridge_Bay\'),
            (\'America/Campo_Grande\'),
            (\'America/Cancun\'),
            (\'America/Caracas\'),
            (\'America/Catamarca\'),
            (\'America/Cayenne\'),
            (\'America/Cayman\'),
            (\'America/Chicago\'),
            (\'America/Chihuahua\'),
            (\'America/Ciudad_Juarez\'),
            (\'America/Coral_Harbour\'),
            (\'America/Cordoba\'),
            (\'America/Costa_Rica\'),
            (\'America/Creston\'),
            (\'America/Cuiaba\'),
            (\'America/Curacao\'),
            (\'America/Danmarkshavn\'),
            (\'America/Dawson\'),
            (\'America/Dawson_Creek\'),
            (\'America/Denver\'),
            (\'America/Detroit\'),
            (\'America/Dominica\'),
            (\'America/Edmonton\'),
            (\'America/Eirunepe\'),
            (\'America/El_Salvador\'),
            (\'America/Ensenada\'),
            (\'America/Fort_Nelson\'),
            (\'America/Fort_Wayne\'),
            (\'America/Fortaleza\'),
            (\'America/Glace_Bay\'),
            (\'America/Godthab\'),
            (\'America/Goose_Bay\'),
            (\'America/Grand_Turk\'),
            (\'America/Grenada\'),
            (\'America/Guadeloupe\'),
            (\'America/Guatemala\'),
            (\'America/Guayaquil\'),
            (\'America/Guyana\'),
            (\'America/Halifax\'),
            (\'America/Havana\'),
            (\'America/Hermosillo\'),
            (\'America/Indiana/Indianapolis\'),
            (\'America/Indiana/Knox\'),
            (\'America/Indiana/Marengo\'),
            (\'America/Indiana/Petersburg\'),
            (\'America/Indiana/Tell_City\'),
            (\'America/Indiana/Vevay\'),
            (\'America/Indiana/Vincennes\'),
            (\'America/Indiana/Winamac\'),
            (\'America/Indianapolis\'),
            (\'America/Inuvik\'),
            (\'America/Iqaluit\'),
            (\'America/Jamaica\'),
            (\'America/Jujuy\'),
            (\'America/Juneau\'),
            (\'America/Kentucky/Louisville\'),
            (\'America/Kentucky/Monticello\'),
            (\'America/Knox_IN\'),
            (\'America/Kralendijk\'),
            (\'America/La_Paz\'),
            (\'America/Lima\'),
            (\'America/Los_Angeles\'),
            (\'America/Louisville\'),
            (\'America/Lower_Princes\'),
            (\'America/Maceio\'),
            (\'America/Managua\'),
            (\'America/Manaus\'),
            (\'America/Marigot\'),
            (\'America/Martinique\'),
            (\'America/Matamoros\'),
            (\'America/Mazatlan\'),
            (\'America/Mendoza\'),
            (\'America/Menominee\'),
            (\'America/Merida\'),
            (\'America/Metlakatla\'),
            (\'America/Mexico_City\'),
            (\'America/Miquelon\'),
            (\'America/Moncton\'),
            (\'America/Monterrey\'),
            (\'America/Montevideo\'),
            (\'America/Montreal\'),
            (\'America/Montserrat\'),
            (\'America/Nassau\'),
            (\'America/New_York\'),
            (\'America/Nipigon\'),
            (\'America/Nome\'),
            (\'America/Noronha\'),
            (\'America/North_Dakota/Beulah\'),
            (\'America/North_Dakota/Center\'),
            (\'America/North_Dakota/New_Salem\'),
            (\'America/Nuuk\'),
            (\'America/Ojinaga\'),
            (\'America/Panama\'),
            (\'America/Pangnirtung\'),
            (\'America/Paramaribo\'),
            (\'America/Phoenix\'),
            (\'America/Port-au-Prince\'),
            (\'America/Port_of_Spain\'),
            (\'America/Porto_Acre\'),
            (\'America/Porto_Velho\'),
            (\'America/Puerto_Rico\'),
            (\'America/Punta_Arenas\'),
            (\'America/Rainy_River\'),
            (\'America/Rankin_Inlet\'),
            (\'America/Recife\'),
            (\'America/Regina\'),
            (\'America/Resolute\'),
            (\'America/Rio_Branco\'),
            (\'America/Rosario\'),
            (\'America/Santa_Isabel\'),
            (\'America/Santarem\'),
            (\'America/Santiago\'),
            (\'America/Santo_Domingo\'),
            (\'America/Sao_Paulo\'),
            (\'America/Scoresbysund\'),
            (\'America/Shiprock\'),
            (\'America/Sitka\'),
            (\'America/St_Barthelemy\'),
            (\'America/St_Johns\'),
            (\'America/St_Kitts\'),
            (\'America/St_Lucia\'),
            (\'America/St_Thomas\'),
            (\'America/St_Vincent\'),
            (\'America/Swift_Current\'),
            (\'America/Tegucigalpa\'),
            (\'America/Thule\'),
            (\'America/Thunder_Bay\'),
            (\'America/Tijuana\'),
            (\'America/Toronto\'),
            (\'America/Tortola\'),
            (\'America/Vancouver\'),
            (\'America/Virgin\'),
            (\'America/Whitehorse\'),
            (\'America/Winnipeg\'),
            (\'America/Yakutat\'),
            (\'America/Yellowknife\'),
            (\'Antarctica/Casey\'),
            (\'Antarctica/Davis\'),
            (\'Antarctica/DumontDUrville\'),
            (\'Antarctica/Macquarie\'),
            (\'Antarctica/Mawson\'),
            (\'Antarctica/McMurdo\'),
            (\'Antarctica/Palmer\'),
            (\'Antarctica/Rothera\'),
            (\'Antarctica/South_Pole\'),
            (\'Antarctica/Syowa\'),
            (\'Antarctica/Troll\'),
            (\'Antarctica/Vostok\'),
            (\'Arctic/Longyearbyen\'),
            (\'Asia/Aden\'),
            (\'Asia/Almaty\'),
            (\'Asia/Amman\'),
            (\'Asia/Anadyr\'),
            (\'Asia/Aqtau\'),
            (\'Asia/Aqtobe\'),
            (\'Asia/Ashgabat\'),
            (\'Asia/Ashkhabad\'),
            (\'Asia/Atyrau\'),
            (\'Asia/Baghdad\'),
            (\'Asia/Bahrain\'),
            (\'Asia/Baku\'),
            (\'Asia/Bangkok\'),
            (\'Asia/Barnaul\'),
            (\'Asia/Beirut\'),
            (\'Asia/Bishkek\'),
            (\'Asia/Brunei\'),
            (\'Asia/Calcutta\'),
            (\'Asia/Chita\'),
            (\'Asia/Choibalsan\'),
            (\'Asia/Chongqing\'),
            (\'Asia/Chungking\'),
            (\'Asia/Colombo\'),
            (\'Asia/Dacca\'),
            (\'Asia/Damascus\'),
            (\'Asia/Dhaka\'),
            (\'Asia/Dili\'),
            (\'Asia/Dubai\'),
            (\'Asia/Dushanbe\'),
            (\'Asia/Famagusta\'),
            (\'Asia/Gaza\'),
            (\'Asia/Harbin\'),
            (\'Asia/Hebron\'),
            (\'Asia/Ho_Chi_Minh\'),
            (\'Asia/Hong_Kong\'),
            (\'Asia/Hovd\'),
            (\'Asia/Irkutsk\'),
            (\'Asia/Istanbul\'),
            (\'Asia/Jakarta\'),
            (\'Asia/Jayapura\'),
            (\'Asia/Jerusalem\'),
            (\'Asia/Kabul\'),
            (\'Asia/Kamchatka\'),
            (\'Asia/Karachi\'),
            (\'Asia/Kashgar\'),
            (\'Asia/Kathmandu\'),
            (\'Asia/Katmandu\'),
            (\'Asia/Khandyga\'),
            (\'Asia/Kolkata\'),
            (\'Asia/Krasnoyarsk\'),
            (\'Asia/Kuala_Lumpur\'),
            (\'Asia/Kuching\'),
            (\'Asia/Kuwait\'),
            (\'Asia/Macao\'),
            (\'Asia/Macau\'),
            (\'Asia/Magadan\'),
            (\'Asia/Makassar\'),
            (\'Asia/Manila\'),
            (\'Asia/Muscat\'),
            (\'Asia/Nicosia\'),
            (\'Asia/Novokuznetsk\'),
            (\'Asia/Novosibirsk\'),
            (\'Asia/Omsk\'),
            (\'Asia/Oral\'),
            (\'Asia/Phnom_Penh\'),
            (\'Asia/Pontianak\'),
            (\'Asia/Pyongyang\'),
            (\'Asia/Qatar\'),
            (\'Asia/Qostanay\'),
            (\'Asia/Qyzylorda\'),
            (\'Asia/Rangoon\'),
            (\'Asia/Riyadh\'),
            (\'Asia/Saigon\'),
            (\'Asia/Sakhalin\'),
            (\'Asia/Samarkand\'),
            (\'Asia/Seoul\'),
            (\'Asia/Shanghai\'),
            (\'Asia/Singapore\'),
            (\'Asia/Srednekolymsk\'),
            (\'Asia/Taipei\'),
            (\'Asia/Tashkent\'),
            (\'Asia/Tbilisi\'),
            (\'Asia/Tehran\'),
            (\'Asia/Tel_Aviv\'),
            (\'Asia/Thimbu\'),
            (\'Asia/Thimphu\'),
            (\'Asia/Tokyo\'),
            (\'Asia/Tomsk\'),
            (\'Asia/Ujung_Pandang\'),
            (\'Asia/Ulaanbaatar\'),
            (\'Asia/Ulan_Bator\'),
            (\'Asia/Urumqi\'),
            (\'Asia/Ust-Nera\'),
            (\'Asia/Vientiane\'),
            (\'Asia/Vladivostok\'),
            (\'Asia/Yakutsk\'),
            (\'Asia/Yangon\'),
            (\'Asia/Yekaterinburg\'),
            (\'Asia/Yerevan\'),
            (\'Atlantic/Azores\'),
            (\'Atlantic/Bermuda\'),
            (\'Atlantic/Canary\'),
            (\'Atlantic/Cape_Verde\'),
            (\'Atlantic/Faeroe\'),
            (\'Atlantic/Faroe\'),
            (\'Atlantic/Jan_Mayen\'),
            (\'Atlantic/Madeira\'),
            (\'Atlantic/Reykjavik\'),
            (\'Atlantic/South_Georgia\'),
            (\'Atlantic/St_Helena\'),
            (\'Atlantic/Stanley\');');

        self::query( /** @lang MySQL */'INSERT IGNORE INTO `{tbl_prefix}timezones` (`timezone`) VALUES
            (\'Australia/ACT\'),
            (\'Australia/Adelaide\'),
            (\'Australia/Brisbane\'),
            (\'Australia/Broken_Hill\'),
            (\'Australia/Canberra\'),
            (\'Australia/Currie\'),
            (\'Australia/Darwin\'),
            (\'Australia/Eucla\'),
            (\'Australia/Hobart\'),
            (\'Australia/LHI\'),
            (\'Australia/Lindeman\'),
            (\'Australia/Lord_Howe\'),
            (\'Australia/Melbourne\'),
            (\'Australia/North\'),
            (\'Australia/NSW\'),
            (\'Australia/Perth\'),
            (\'Australia/Queensland\'),
            (\'Australia/South\'),
            (\'Australia/Sydney\'),
            (\'Australia/Tasmania\'),
            (\'Australia/Victoria\'),
            (\'Australia/West\'),
            (\'Australia/Yancowinna\'),
            (\'Brazil/Acre\'),
            (\'Brazil/DeNoronha\'),
            (\'Brazil/East\'),
            (\'Brazil/West\'),
            (\'Canada/Atlantic\'),
            (\'Canada/Central\'),
            (\'Canada/Eastern\'),
            (\'Canada/Mountain\'),
            (\'Canada/Newfoundland\'),
            (\'Canada/Pacific\'),
            (\'Canada/Saskatchewan\'),
            (\'Canada/Yukon\'),
            (\'CET\'),
            (\'Chile/Continental\'),
            (\'Chile/EasterIsland\'),
            (\'CST6CDT\'),
            (\'Cuba\'),
            (\'EET\'),
            (\'Egypt\'),
            (\'Eire\'),
            (\'EST\'),
            (\'EST5EDT\'),
            (\'Etc/GMT\'),
            (\'Etc/GMT+0\'),
            (\'Etc/GMT+1\'),
            (\'Etc/GMT+10\'),
            (\'Etc/GMT+11\'),
            (\'Etc/GMT+12\'),
            (\'Etc/GMT+2\'),
            (\'Etc/GMT+3\'),
            (\'Etc/GMT+4\'),
            (\'Etc/GMT+5\'),
            (\'Etc/GMT+6\'),
            (\'Etc/GMT+7\'),
            (\'Etc/GMT+8\'),
            (\'Etc/GMT+9\'),
            (\'Etc/GMT-0\'),
            (\'Etc/GMT-1\'),
            (\'Etc/GMT-10\'),
            (\'Etc/GMT-11\'),
            (\'Etc/GMT-12\'),
            (\'Etc/GMT-13\'),
            (\'Etc/GMT-14\'),
            (\'Etc/GMT-2\'),
            (\'Etc/GMT-3\'),
            (\'Etc/GMT-4\'),
            (\'Etc/GMT-5\'),
            (\'Etc/GMT-6\'),
            (\'Etc/GMT-7\'),
            (\'Etc/GMT-8\'),
            (\'Etc/GMT-9\'),
            (\'Etc/GMT0\'),
            (\'Etc/Greenwich\'),
            (\'Etc/UCT\'),
            (\'Etc/Universal\'),
            (\'Etc/UTC\'),
            (\'Etc/Zulu\'),
            (\'Europe/Amsterdam\'),
            (\'Europe/Andorra\'),
            (\'Europe/Astrakhan\'),
            (\'Europe/Athens\'),
            (\'Europe/Belfast\'),
            (\'Europe/Belgrade\'),
            (\'Europe/Berlin\'),
            (\'Europe/Bratislava\'),
            (\'Europe/Brussels\'),
            (\'Europe/Bucharest\'),
            (\'Europe/Budapest\'),
            (\'Europe/Busingen\'),
            (\'Europe/Chisinau\'),
            (\'Europe/Copenhagen\'),
            (\'Europe/Dublin\'),
            (\'Europe/Gibraltar\'),
            (\'Europe/Guernsey\'),
            (\'Europe/Helsinki\'),
            (\'Europe/Isle_of_Man\'),
            (\'Europe/Istanbul\'),
            (\'Europe/Jersey\'),
            (\'Europe/Kaliningrad\'),
            (\'Europe/Kiev\'),
            (\'Europe/Kirov\'),
            (\'Europe/Kyiv\'),
            (\'Europe/Lisbon\'),
            (\'Europe/Ljubljana\'),
            (\'Europe/London\'),
            (\'Europe/Luxembourg\'),
            (\'Europe/Madrid\'),
            (\'Europe/Malta\'),
            (\'Europe/Mariehamn\'),
            (\'Europe/Minsk\'),
            (\'Europe/Monaco\'),
            (\'Europe/Moscow\'),
            (\'Europe/Nicosia\'),
            (\'Europe/Oslo\'),
            (\'Europe/Paris\'),
            (\'Europe/Podgorica\'),
            (\'Europe/Prague\'),
            (\'Europe/Riga\'),
            (\'Europe/Rome\'),
            (\'Europe/Samara\'),
            (\'Europe/San_Marino\'),
            (\'Europe/Sarajevo\'),
            (\'Europe/Saratov\'),
            (\'Europe/Simferopol\'),
            (\'Europe/Skopje\'),
            (\'Europe/Sofia\'),
            (\'Europe/Stockholm\'),
            (\'Europe/Tallinn\'),
            (\'Europe/Tirane\'),
            (\'Europe/Tiraspol\'),
            (\'Europe/Ulyanovsk\'),
            (\'Europe/Uzhgorod\'),
            (\'Europe/Vaduz\'),
            (\'Europe/Vatican\'),
            (\'Europe/Vienna\'),
            (\'Europe/Vilnius\'),
            (\'Europe/Volgograd\'),
            (\'Europe/Warsaw\'),
            (\'Europe/Zagreb\'),
            (\'Europe/Zaporozhye\'),
            (\'Europe/Zurich\'),
            (\'Factory\'),
            (\'GB\'),
            (\'GB-Eire\'),
            (\'GMT\'),
            (\'GMT+0\'),
            (\'GMT-0\'),
            (\'GMT0\'),
            (\'Greenwich\'),
            (\'Hongkong\'),
            (\'HST\'),
            (\'Iceland\'),
            (\'Indian/Antananarivo\'),
            (\'Indian/Chagos\'),
            (\'Indian/Christmas\'),
            (\'Indian/Cocos\'),
            (\'Indian/Comoro\'),
            (\'Indian/Kerguelen\'),
            (\'Indian/Mahe\'),
            (\'Indian/Maldives\'),
            (\'Indian/Mauritius\'),
            (\'Indian/Mayotte\'),
            (\'Indian/Reunion\'),
            (\'Iran\'),
            (\'Israel\'),
            (\'Jamaica\'),
            (\'Japan\'),
            (\'Kwajalein\'),
            (\'Libya\'),
            (\'MET\'),
            (\'Mexico/BajaNorte\'),
            (\'Mexico/BajaSur\'),
            (\'Mexico/General\'),
            (\'MST\'),
            (\'MST7MDT\'),
            (\'Navajo\'),
            (\'NZ\'),
            (\'NZ-CHAT\'),
            (\'Pacific/Apia\'),
            (\'Pacific/Auckland\'),
            (\'Pacific/Bougainville\'),
            (\'Pacific/Chatham\'),
            (\'Pacific/Chuuk\'),
            (\'Pacific/Easter\'),
            (\'Pacific/Efate\'),
            (\'Pacific/Enderbury\'),
            (\'Pacific/Fakaofo\'),
            (\'Pacific/Fiji\'),
            (\'Pacific/Funafuti\'),
            (\'Pacific/Galapagos\'),
            (\'Pacific/Gambier\'),
            (\'Pacific/Guadalcanal\'),
            (\'Pacific/Guam\'),
            (\'Pacific/Honolulu\'),
            (\'Pacific/Johnston\'),
            (\'Pacific/Kanton\'),
            (\'Pacific/Kiritimati\'),
            (\'Pacific/Kosrae\'),
            (\'Pacific/Kwajalein\'),
            (\'Pacific/Majuro\'),
            (\'Pacific/Marquesas\'),
            (\'Pacific/Midway\'),
            (\'Pacific/Nauru\'),
            (\'Pacific/Niue\'),
            (\'Pacific/Norfolk\'),
            (\'Pacific/Noumea\'),
            (\'Pacific/Pago_Pago\'),
            (\'Pacific/Palau\'),
            (\'Pacific/Pitcairn\'),
            (\'Pacific/Pohnpei\'),
            (\'Pacific/Ponape\'),
            (\'Pacific/Port_Moresby\'),
            (\'Pacific/Rarotonga\'),
            (\'Pacific/Saipan\'),
            (\'Pacific/Samoa\'),
            (\'Pacific/Tahiti\'),
            (\'Pacific/Tarawa\'),
            (\'Pacific/Tongatapu\'),
            (\'Pacific/Truk\'),
            (\'Pacific/Wake\'),
            (\'Pacific/Wallis\'),
            (\'Pacific/Yap\'),
            (\'Poland\'),
            (\'Portugal\'),
            (\'PRC\'),
            (\'PST8PDT\'),
            (\'ROC\'),
            (\'ROK\'),
            (\'Singapore\'),
            (\'Turkey\'),
            (\'UCT\'),
            (\'Universal\'),
            (\'US/Alaska\'),
            (\'US/Aleutian\'),
            (\'US/Arizona\'),
            (\'US/Central\'),
            (\'US/East-Indiana\'),
            (\'US/Eastern\'),
            (\'US/Hawaii\'),
            (\'US/Indiana-Starke\'),
            (\'US/Michigan\'),
            (\'US/Mountain\'),
            (\'US/Pacific\'),
            (\'US/Samoa\'),
            (\'UTC\'),
            (\'W-SU\'),
            (\'WET\'),
            (\'Zulu\');');

        self::generateTranslation('tool_not_found', [
            'fr'=>'L\'outil est introuvable',
            'en'=>'Tool not found'
        ]);
        self::generateTranslation('tips_automate_launch_mode', [
            'fr'=>'Avec l\'activité des utilisateurs, les automates sont lancés en tâche de fond au chargement des pages',
            'en'=>'With user activity, automates are launched in backgound at page loading'
        ]);
        self::generateTranslation('option_automate_launch_mode', [
            'fr'=>'Lancement des automates',
            'en'=>'Automate launching'
        ]);
        self::generateTranslation('option_automate_launch_mode_crontab', [
            'fr'=>'Crontab',
            'en'=>'Crontab'
        ]);
        self::generateTranslation('option_automate_launch_mode_user_activity', [
            'fr'=>'Activité des utilisateurs',
            'en'=>'Users activity'
        ]);
        self::generateTranslation('option_automate_launch_mode_disabled', [
            'fr'=>'Désactivé',
            'en'=>'Disabled'
        ]);
        self::generateTranslation('frequence', [
            'fr'=>'Fréquence',
            'en'=>'Frequency'
        ]);
        self::generateTranslation('frequence_enabled', [
            'fr'=>'Lancement automatique',
            'en'=>'Automatic launch'
        ]);
        self::generateTranslation('cron_format_title', [
            'fr'=>'Format crontab : * * * * *',
            'en'=>'Crontab format : * * * * *'
        ]);
        self::generateTranslation('bad_format_cron', [
            'fr'=>'La fréquence doit être un format CRON valide',
            'en'=>'Frequency must be a valid CRON format'
        ]);
        self::generateTranslation('tool_already_launched', [
            'fr'=>'Cet outils est déjà en cours',
            'en'=>'This tool is already in progress'
        ]);
        self::generateTranslation('success_update_tools', [
            'fr'=>'L\'outil a bien était mis à jour',
            'en'=>'Tool has been updated'
        ]);
        self::generateTranslation('automate_label', [
            'fr'=>'Lancement automatique des outils',
            'en'=>'Automatic launch of tools'
        ]);
        self::generateTranslation('automate_description', [
            'fr'=>'Lance automatiquement les outils en fonction de leur fréquence',
            'en'=>'Automatically launches tools based on their frequency'
        ]);
        self::generateTranslation('datetime_synchro_error', [
            'fr'=>'Il existe un écart entre la date issue de PHP et la date issue de la base de donnée',
            'en'=>'There is a discrepancy between PHP and database dates'
        ]);
        self::generateTranslation('datetime_synchro', [
            'fr'=>'Correctement synchronisée avec la base de donnée',
            'en'=>'Correctly synced with database'
        ]);
        self::generateTranslation('automate_launch_disabled_in_config', [
            'fr'=>'Le lancement automatique des outils est désactivé',
            'en'=>'Automatic launch of tools is disabled'
        ]);
        self::generateTranslation('crontab_link_label', [
            'fr'=>'Ligne à copier dans Crontab',
            'en'=>'Line to copy into Crontab'
        ]);
        self::generateTranslation('copy_clipboard', [
            'fr'=>'Copier dans le presse-papier',
            'en'=>'Copy to clipboard'
        ]);
        self::generateTranslation('option_timezone', [
            'fr'=>'Timezone',
            'en'=>'Timezone'
        ]);
    }
}