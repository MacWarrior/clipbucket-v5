<?php

class files
{
    function _error($mensagem, $tipo)
    {
        if ($tipo == E_USER_ERROR) {
            $topo = 'Error!';
        } else {
            $topo = 'Notification';
        }

        echo '<span style="background-color: #FFD7D7"><font face=verdana size=2><font color=red><b>' . $topo . '</b></font>: ' . $mensagem . '</font></span><br><br>';

        if ($tipo == E_USER_ERROR) {
            exit;
        }
    }

}
