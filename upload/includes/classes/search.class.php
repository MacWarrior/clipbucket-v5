<?php
class cbsearch
{
    public static function date_margin($date_column = 'date_added', $date_margin = null): string
    {
        switch ($date_margin) {
            case 'today':
                return ' curdate() = date(' . $date_column . ') ';

            case 'yesterday':
                return ' CONCAT(YEAR(curdate()),DAYOFYEAR(curdate())-1) = CONCAT(YEAR(' . $date_column . '),DAYOFYEAR(' . $date_column . ')) ';

            case 'this_week':
            case 'week':
            case 'thisweek':
                return ' YEARWEEK(' . $date_column . ')=YEARWEEK(curdate())';

            case 'this_month':
            case 'month':
            case 'thismonth':
                return ' CONCAT(YEAR(curdate()),MONTH(curdate())) = CONCAT(YEAR(' . $date_column . '),MONTH(' . $date_column . ')) ';

            case 'this_year':
            case 'year':
            case 'thisyear':
                return 'YEAR(curdate()) = YEAR(' . $date_column . ')';

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
                return ' CONCAT(YEAR(curdate()),MONTH(curdate())-1) = CONCAT(YEAR(' . $date_column . '),MONTH(' . $date_column . ')) ';

            case 'last_year':
            case 'lastyear':
                return 'YEAR(curdate())-1 = YEAR(' . $date_column . ') ';
        }
    }
}
