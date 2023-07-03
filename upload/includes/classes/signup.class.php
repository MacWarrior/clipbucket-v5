<?php

class signup
{
    //This Function Is Used To Check Registration is allowed or not
    function Registration()
    {
        if (ALLOW_REG == 1) {
            return true;
        }

        return false;
    }
}