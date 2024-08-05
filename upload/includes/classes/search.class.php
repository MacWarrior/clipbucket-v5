<?php
class Search
{
    public static function date_margin($date_column = 'date_added', $date_margin = null): string
    {
        switch ($date_margin) {
            case 'today':
                return ' CURDATE() = DATE(' . $date_column . ') ';

            case 'yesterday':
                return ' CONCAT(YEAR(CURDATE()),DAYOFYEAR(CURDATE())-1) = CONCAT(YEAR(' . $date_column . '),DAYOFYEAR(' . $date_column . ')) ';

            case 'this_week':
            case 'week':
            case 'thisweek':
                return ' YEARWEEK(' . $date_column . ')=YEARWEEK(curdate())';

            case 'this_month':
            case 'month':
            case 'thismonth':
                return ' CONCAT(YEAR(CURDATE()),MONTH(CURDATE())) = CONCAT(YEAR(' . $date_column . '),MONTH(' . $date_column . ')) ';

            case 'this_year':
            case 'year':
            case 'thisyear':
                return 'YEAR(CURDATE()) = YEAR(' . $date_column . ')';

            case 'all_time':
            case 'alltime':
            case 'all':
            default:
                return ' ' . $date_column . ' IS NOT NULL ';

            case 'last_week':
            case 'lastweek':
                return ' YEARWEEK(' . $date_column . ')=YEARWEEK(curdate())-1 ';

            case 'last_month':
            case 'lastmonth':
                return ' CONCAT(YEAR(CURDATE()),MONTH(CURDATE())-1) = CONCAT(YEAR(' . $date_column . '),MONTH(' . $date_column . ')) ';

            case 'last_year':
            case 'lastyear':
                return 'YEAR(CURDATE())-1 = YEAR(' . $date_column . ') ';
        }
    }
}
