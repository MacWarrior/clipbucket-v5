<?php

const THIS_PAGE = 'progress';
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'SSE.class.php';
userquery::getInstance()->admin_login_check();

SSE::processSSE(function () {
    try {
        $tools = AdminTool::getTools([
            ' tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM '.tbl('tools_histo_status').' WHERE language_key_title = \'in_progress\' ) '
        ]);
        $erros_tools = AdminTool::getTools([
            ' tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM '.tbl('tools_histo_status').' WHERE language_key_title = \'on_error\' ) '
        ]);
    } catch (Exception $e) {
        exit();
    }

    $sleep = 1;
    if (empty($tools)) {
        $sleep = 10;
    }

    $output = 'data: ';
    $returned_tools=[];
    $tools= $tools + $erros_tools;
    foreach ($tools as $tool) {
        $returned_tools[] = [
            'id'             => $tool['id_tool'],
            'status'         => $tool['language_key_title'],
            'status_title'   => lang($tool['language_key_title']),
            'pourcent'       => sprintf('%.2f', $tool['pourcentage_progress']),
            'elements_done'  => $tool['elements_done'],
            'elements_total' => $tool['elements_total']
        ];
    }
    $output .= json_encode($returned_tools);
    return ['output'=>$output, 'sleep'=>$sleep];
}, 10);