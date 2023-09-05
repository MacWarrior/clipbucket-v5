<?php

class Automate
{

    private static $id_automate_histo;

    /**
     * @return array
     * @throws \Exception
     */
    public static function getAll(): array
    {
        return self::getFromIdAutomteHisto();
    }

    /**
     * @throws \Exception
     */
    public static function start_service(){
        if(config('closed')){
            return;
        }

        foreach (self::getTaskFromBDD() as $task){
            /** lancer un nouveau process dédié pour cette task */
            self::start_process($task['id_automate_task']);
        }
    }

    /**
     * @throws \Exception
     */
    private static function getTaskFromBDD( $idTask = null){
        global $db;

        $where = '';
        $whereSub = '';
        $whereSub2 = '';
        if(!empty($idTask)){
            $where = ' AND AT.id_automate_task = '. (int) $idTask;
            $whereSub = ' WHERE id_automate_task = '. (int) $idTask;
            $whereSub2 = ' AND id_automate_task = '. (int) $idTask;
        }

        /** recupere la liste des tasks periodic */
        $sql = /** @lang MySQL */' SELECT AT.* , DATE_FORMAT(COALESCE(AH.date_debut, AT.datetime_creation),\'%Y-%m-%d %H:%i:%s.%f\') AS date_execution_precedente
                , DATE_FORMAT(COALESCE(AT.datetime_previsionnel_precedente, AT.datetime_previsionnel, AT.datetime_creation),\'%Y-%m-%d %H:%i:%s.%f\') as datetime_previsionnel_force
                FROM '.tbl('automate_task').' AT 

                LEFT JOIN ( 
                    SELECT MAX(date_debut) as date_debut, id_automate_task
                    FROM '.tbl('automate_histo').' 
                    '.$whereSub.'
                    GROUP BY id_automate_task
                )AH ON AT.id_automate_task = AH.id_automate_task
            
                LEFT JOIN (
                    SELECT id_automate_task
                    FROM '.tbl('automate_histo').' 
                    WHERE id_automate_statut in (1 /* en cours */,4 /* en attente */)
                    '.$whereSub2.'
                    GROUP BY id_automate_task
                )AH_en_cours ON AT.id_automate_task = AH_en_cours.id_automate_task

                WHERE (
                        ( 
                            AT.id_automate_task_type = 1 /* periodique */ 
                            AND ( AH.id_automate_task IS NULL OR AH_en_cours.id_automate_task IS NULL ) -- exclure les en cours / en attente
                        )
                        OR
                        (
                            AT.id_automate_task_type = 2 /* one_shot */ 
                            AND AH.id_automate_task IS NULL  /* pas encore lancé */
                            AND AT.datetime_previsionnel IS NOT NULL /* avec une date previsionel obligatoire */
                            AND AT.datetime_previsionnel <= NOW() 
                        ) 
                    )
                    '.$where.'
                    ORDER BY datetime_previsionnel ASC ' ;

        $rs = $db->_select($sql);
        foreach ($rs as $key => $task){
            /** si task periodic alors verifier si la task doit ere executé */
            if( $task['id_automate_task_type'] == 1 /* periodique */ && !self::shouldCronBeExecuted($task['frequence'], $task['date_execution_precedente'], $task['datetime_previsionnel_force'], $task['id_automate_task'])){
                unset($rs[$key]);
            }
        }

        return $rs;
    }

    /**
     * @throws \Exception
     */
    private static function update_task_statut($statut){
        global $db;

        /** met a jour le statut final de la task */
        $db->update(tbl("automate_histo"), ['id_automate_statut', 'date_fin'], [(int) $statut, '|no_mc||f| NOW()'], 'id_automate_histo = '.((int) self::$id_automate_histo ));
    }

    /**
     * @throws \Exception
     */
    public static function addLog($msg, $type=4 /* default = error*/){
        global $db;

        if(empty(self::$id_automate_histo)){
            return;
        }

        /** met a jour le statut final de la task */
        $db->insert(tbl('automate_log'), ['id_automate_histo', 'data', 'id_automate_log_type'], [(int) self::$id_automate_histo, $msg, (int) $type]);
    }

    /**
     * @throws \Exception
     */
    public static function start_task($idTask){
        global $db, $whoops;

        if(config('closed')){
            return;
        }

        $tasks = self::getTaskFromBDD($idTask);

        foreach ($tasks as $task){
            self::$id_automate_histo = $db->insert(tbl('automate_histo'), ['id_automate_task', 'id_automate_statut'], [(int) $task['id_automate_task'], 1]);

            /** verifier une nouvelle fois qu'il n'y a qu'un seul histo en cours pour cet id_automate_task */
            $rs = $db->select(tbl('automate_histo'), ['id_automate_task'], /** @lang MySQL */'id_automate_task = '.mysql_clean($task['id_automate_task']).' AND id_automate_histo != '.mysql_clean(self::$id_automate_histo).' AND id_automate_statut = 1 /* en cours */');
            if(!empty($rs)){
                Automate::update_task_statut(2); /* termine */
                return ;
            }

            /**
             * surcharge des erreurs pour mettre a jour le statut de la task
             */
            $whoops->pushHandler(function($e) {
                try{
                    $trace = '';
                    if(method_exists($e,'getTraceAsString')) {
                        $trace = $e->getTraceAsString();
                    }

                    Automate::addLog($e->getMessage() . PHP_EOL. $trace);
                    Automate::update_task_statut(3); /* echec */
                }catch(\Exception $e) {}
            });

            /** execute task */
            call_user_func_array($task['class'] . '::'.$task['method'], array($idTask, $task['params']));

            /** met a jour le statut final de la task */
            Automate::update_task_statut(2); /* terminé */
        }

    }

    /**
     * Lance un process dedié a la task
     * @param int $idTask
     */
    private static function start_process($idTask){

        if(config('closed')){
            return;
        }

        $command = php_path().' '.BASEDIR . '/actions/automate.php ' .' id='.((int) $idTask);
        exec('nohup ' . $command . ' >> /dev/null 2>&1 & echo $!');
    }

    /**
     * @throws \Exception
     */
    public static function shouldCronBeExecuted($cron, $date, $date_previsionnel, $id_automate_task = null): bool
    {

        if($date < $date_previsionnel){

            if($date_previsionnel > date('Y-m-d H:i:s')){
                return false;
            }
            return true;
        }

        $data_task_date = self::getDateStat($cron, $date, $date_previsionnel, $id_automate_task);
        return $data_task_date['next_date'] <= date('Y-m-d H:i:s');
    }

    /**
     * @throws \Exception
     */
    public static function getNextDate($cron, $date, $date_previsionnel, &$last_previsionnel_date = null)
    {

        /**
         * remplacer le L du mois par le dernier jour du mois en cours si l'on est au moin le 28 du mois
         * sinon utiliser la notation 28-31
         */
        $cron = trim($cron);
        $e = explode(' ', $cron ?? '');
        if($e[2] == 'L'){
            $last_day_of_month = date('t');
            $current_day = date('j');
            if($current_day < 28){
                $e[2] = '28-31';
            } else {
                $e[2] = $last_day_of_month;
            }
            $cron = implode(' ', $e);
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s.u',$date);

        try{
            $expression = new \CronExpression($cron);
            $next_date = \DateTime::createFromFormat('Y-m-d H:i:s.u',$date_previsionnel);

            do{
                $next_date = $expression->getNext($next_date);

                if($next_date < $date->getTimestamp()){
                    $date_pre = new \DateTime();
                    $date_pre->setTimeStamp($next_date);
                    $last_previsionnel_date = $date_pre->format('Y-m-d H:i:s.u');
                }

            }while($next_date < $date->getTimestamp());

            return $next_date;
        } catch(\Exception $e) {
            return false;
        }
    }

    public static function getDateStat($frequence, $date_execution_precedente, $date_previsionnel_precedente_source, $id_automate_task = null): array
    {
        global $db;

        $next_date =null;
        $date_previsionnel_precedente = null;
        do {
            $timestamp = self::getNextDate($frequence, MAX($date_execution_precedente,$next_date), MAX($date_previsionnel_precedente,$date_previsionnel_precedente_source, $next_date), $date_previsionnel_precedente);
            $date = new \DateTime();
            $date->setTimeStamp($timestamp);
            $continue = $date->format('Y-m-d H:i:s.u') < date('Y-m-d H:i:s');
            if($continue || empty($next_date)){
                $next_date = $date->format('Y-m-d H:i:s.u');
            }
        }while($continue);

        if(
            !empty($id_automate_task)
            && (empty($date_previsionnel_precedente_source) || $date_previsionnel_precedente_source < $date_execution_precedente)
            && !empty($date_previsionnel_precedente)
        ){
            $db->update(tbl('automate_task'), ['datetime_previsionnel_precedente'],[$date_previsionnel_precedente], 'id_automate_task='.(int) $id_automate_task);
        }

        return [
            'date_execution_precedente' => $date_execution_precedente
            ,'date_previsionnel_precedente' => $date_previsionnel_precedente
            ,'next_date' => $next_date
        ];
    }

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
                        WHEN AST.id_automate_statut = 1 THEN \'text-muted\' 
                        WHEN AST.id_automate_statut = 2 THEN \'text-info\' 
                        WHEN AST.id_automate_statut = 3 THEN \'text-warning\' 
                        WHEN AST.id_automate_statut = 4 THEN \'text-danger\' 
                        WHEN AST.id_automate_statut = 5 THEN \'text-success\' 
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
                                        WHERE @id_automate_task = AH_1.id_automate_task AND AH_1.id_automate_statut = 1  '.$condition_histo_1.') AH 
                                 WHERE AH.pos = 1 ) AS last_id_automate_histo_running
                        FROM ' . tbl('automate_task ').' AS AT
                        WHERE AT.id_automate_task_type = 1 
                    ) AJ ON AJ.id_automate_task = AT.id_automate_task
                LEFT JOIN ' . tbl('automate_histo') . ' AH ON AH.id_automate_histo = COALESCE(AJ.last_id_automate_histo_running, AJ.last_id_automate_histo)
                LEFT JOIN ' . tbl('automate_statut') . ' AST ON AST.id_automate_statut = AH.id_automate_statut
               WHERE  AT.id_automate_task_type = 1 /* periodic */ '.$condition_histo.'
               
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
                        WHEN AST.id_automate_statut = 1 THEN \'text-muted\' 
                        WHEN AST.id_automate_statut = 2 THEN \'text-info\' 
                        WHEN AST.id_automate_statut = 3 THEN \'text-warning\' 
                        WHEN AST.id_automate_statut = 4 THEN \'text-danger\' 
                        WHEN AST.id_automate_statut = 5 THEN \'text-success\' 
                        ELSE \'\'
                    END statut_icon
                FROM ' . tbl('automate_task') . ' AT
                LEFT JOIN ' . tbl('automate_histo') . ' AH ON AH.id_automate_task = AT.id_automate_task
                LEFT JOIN ' . tbl('automate_statut') . ' AST ON AST.id_automate_statut = AH.id_automate_statut

               WHERE AT.id_automate_task_type = 2 /* one shot */ '.$condition_histo.'
               
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
