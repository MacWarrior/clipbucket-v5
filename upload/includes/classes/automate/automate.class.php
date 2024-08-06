<?php

class Automate
{
    public static function getLogs($id_automate_histo)
    {
        global $db;
        $rs = $db->select(tbl('automate_log').' AS AL
            LEFT JOIN '.tbl('automate_log_type').' ALT ON ALT.id_automate_log_type = AL.id_automate_log_type'
            , /** @lang MySQL */ 'AL.*, ALT.trad AS type, 
                    CASE 
                        WHEN ALT.id_automate_log_type = 1 THEN \'text-text-muted\' 
                        WHEN ALT.id_automate_log_type = 2 THEN \'text-info\' 
                        WHEN ALT.id_automate_log_type = 3 THEN \'text-warning\' 
                        WHEN ALT.id_automate_log_type = 4 THEN \'text-danger\' 
                        WHEN ALT.id_automate_log_type = 5 THEN \'text-success\' 
                        ELSE \'\'
                    END trad_class'
            , /** @lang MySQL */ 'AL.id_automate_histo = '.mysql_clean($id_automate_histo)
            ,false
            ,'AL.date_debut DESC'
        );
        return $rs;
    }

    public static function getFromIdAutomteHisto($id_automate_histo = null)
    {
        global $db;

        if(!empty($id_automate_histo)){
            $condition_histo = ' AND AH.id_automate_histo = '.(int) $id_automate_histo;
            $condition_histo_1 = ' AND AH_1.id_automate_histo = '.(int) $id_automate_histo;
        }

        $sql = /** @lang MySQL */ 'WITH main AS ( 
                
                SELECT AT.*
                    , DATE_FORMAT(COALESCE(AH.date_debut, AT.datetime_creation),\'%Y-%m-%d %H:%i:%s.%f\') AS date_execution_precedente
                    , DATE_FORMAT(COALESCE(AT.datetime_previsionnel_precedente, AT.datetime_previsionnel, AT.datetime_creation),\'%Y-%m-%d %H:%i:%s.%f\') as datetime_previsionnel_force
                    ,COALESCE(AH.date_debut, AT.datetime_creation) AS date_debut
                    ,CONCAT(
                        CASE WHEN FLOOR(HOUR(TIMEDIFF(AH.date_fin , AH.date_debut)) / 24) > 0 THEN FLOOR(HOUR(TIMEDIFF(AH.date_fin , AH.date_debut)) / 24) ELSE \'\' END, \' \',
                        LPAD(MOD(HOUR(TIMEDIFF(AH.date_fin , AH.date_debut)), 24), 2, \'0\'), \':\',
                        LPAD(MINUTE(TIMEDIFF(AH.date_fin , AH.date_debut)), 2, \'0\'), \':\',
                        LPAD(SECOND(TIMEDIFF(AH.date_fin , AH.date_debut)), 2, \'0\')
                    ) as diff
                    ,AST.trad AS statut
                    ,AH.id_automate_histo
                    , CASE 
                        WHEN AST.statut = \'en_cours\' THEN \'glyphicon-cog blue\' 
                        WHEN AST.statut = \'termine\' THEN \'glyphicon-ok green\' 
                        WHEN AST.statut = \'echec\' THEN \'glyphicon-alert red\' 
                        WHEN AST.statut = \'en_attente\' THEN \'glyphicon-hourglass\'
                        ELSE \'\'
                    END statut_icon
                FROM ' . tbl('automate_task') . ' AT
                LEFT JOIN (
                        SELECT AT.id_automate_task, (@id_automate_task := AT.id_automate_task),
                               ( SELECT AH.id_automate_histo
                                 FROM ( SELECT AH_1.id_automate_histo,
                                               AH_1.date_debut,
                                               row_number() OVER (PARTITION BY AH_1.id_automate_task ORDER BY AH_1.date_debut DESC) AS pos
                                        FROM ' . tbl('automate_histo').' AH_1
                                        WHERE @id_automate_task = AH_1.id_automate_task  '.$condition_histo_1.' ) AH
                                 WHERE AH.pos = 1) AS last_id_automate_histo,
                               ( SELECT AH.id_automate_histo
                                 FROM ( SELECT AH_1.id_automate_histo,
                                               AH_1.date_debut,
                                               row_number() OVER (PARTITION BY AH_1.id_automate_task ORDER BY AH_1.date_debut DESC) AS pos
                                        FROM ' . tbl('automate_histo').' AH_1
                                        WHERE @id_automate_task = AH_1.id_automate_task AND AH_1.statut = \'en_cours\'  '.$condition_histo_1.') AH 
                                 WHERE AH.pos = 1 ) AS last_id_automate_histo_running
                        FROM ' . tbl('automate_task ').' AS AT
                        WHERE AT.id_automate_task_type = 1 
                    ) AJ ON AJ.id_automate_task = AT.id_automate_task
                LEFT JOIN ' . tbl('automate_histo') . ' AH ON AH.id_automate_histo = COALESCE(AJ.last_id_automate_histo_running, AJ.last_id_automate_histo)
               WHERE  AT.type = \'periodic\' '.$condition_histo.'
               
               UNION ALL 
               
                SELECT AT.*
                    , DATE_FORMAT(COALESCE(AH.date_debut, AT.datetime_creation),\'%Y-%m-%d %H:%i:%s.%f\') AS date_execution_precedente
                    , DATE_FORMAT(COALESCE(AT.datetime_previsionnel_precedente, AT.datetime_previsionnel, AT.datetime_creation),\'%Y-%m-%d %H:%i:%s.%f\') as datetime_previsionnel_force
                    ,COALESCE(AH.date_debut, AT.datetime_creation) AS date_debut
                    ,CONCAT(
                        NULLIF(DATE_FORMAT((AH.date_fin - AH.date_debut),\'dd\'), \'00\')
                        ,\' \'
                        ,DATE_FORMAT((AH.date_fin - AH.date_debut),\'HH24:MI:ss\')
                    ) as diff
                    ,AST.trad AS statut
                    ,AH.id_automate_histo
                    , CASE 
                        WHEN AST.statut = \'en_cours\' THEN \'glyphicon-cog blue\' 
                        WHEN AST.statut = \'termine\' THEN \'glyphicon-ok green\' 
                        WHEN AST.statut = \'echec\' THEN \'glyphicon-alert red\' 
                        WHEN AST.statut = \'en_attente\' THEN \'glyphicon-hourglass\'
                        ELSE \'\'
                    END statut_icon
                FROM ' . tbl('automate_task') . ' AT
                LEFT JOIN ' . tbl('automate_histo') . ' AH ON AH.id_automate_task = AT.id_automate_task

               WHERE AT.type = \'one_shot\' '.$condition_histo.'
               
           ) SELECT * 
           FROM main
           WHERE id_automate_histo in (
                   SELECT MAX(id_automate_histo)
                   FROM main t1
                   GROUP BY class, method
           )';

        $rs = $db->_select($sql);
        foreach ($rs as $k => $v){
            $rs[$k]['frequence_trad'] = (CronSchedule::fromCronString($v['frequence'], Language::getInstance()->getLang()))->asNaturalLanguage();
        }
        return $rs;
    }

}
