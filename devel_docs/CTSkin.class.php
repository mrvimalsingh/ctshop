<?php
/**
 * Date: 1/19/11
 * Time: 12:37 AM
 * this class manages all that is to manage about skins...
 */

class CTSkin {

    var $settings = array(
        "version" => "1.0",
        "description" => "skin class... manages all that is to manage about skins"
    );

    var $skins = array();

    function CTSkin($params = null) {
        if ($params != null) {
            foreach ($params as $k => $v) {
                $this->settings[$k] = $v;
            }
        }
        $this->skins["default_skin"] = $this->loadProperties("skin.properties");
    }

    function loadProperties($txtProperties) {
        $result = array();
        $lines = explode("\n", $txtProperties);
        $key = "";
        $isWaitingOtherLine = false;
        foreach ($lines as $i => $line) {
            if (empty($line) || (!$isWaitingOtherLine && strpos($line, "#") === 0))
                continue;

            if (!$isWaitingOtherLine) {
                $key = substr($line, 0, strpos($line, '='));
                $value = substr($line, strpos($line, '=')+1, strlen($line));
            }
            else {
                $value .= $line;
            }

            /* Check if ends with single '\' */
            if (strrpos($value, "\\") === strlen($value)-strlen("\\")) {
                $value = substr($value,0,strlen($value)-1)."\n";
                $isWaitingOtherLine = true;
            }
            else {
                $isWaitingOtherLine = false;
            }

            $result[$key] = $value;
            unset($lines[$i]);
        }

        return $result;
    }

}
