<?php
class View
{
    public static function Render($route,array $data = array(), array $template = array())
    {
        $_route = explode('/',$route);
        if(sizeof($_route) < 1) throw new Exception("Missing route for the view", 1);
        if(!is_readable(VIEW_PATH.(isset($_route[1]) ? $_route[0]."/".$_route[1] : $_route[0]).".php")) throw new Exception("Error loading the view file", 1);
        if(isset($template["route"]))
        {
            $_template = explode('/',$template["route"]);
            if(sizeof($_template) == 2)
            {
                if(!is_readable(VIEW_PATH . $_template[0] . "/" . $_template[1]. ".php")) throw new Exception("Error reading the template file", 1);
                $templateString = self::loadFileasString(VIEW_PATH . $_template[0] . "/" . $_template[1]. ".php");
                $templateString = preg_replace("/#TITLE#/ms", isset($template["title"]) ? $template["title"] : "" ,$templateString);
                $templateString = preg_replace("/#BODY#/ms",self::loadFileasString(VIEW_PATH.(isset($_route[1]) ? $_route[0]."/".$_route[1] : $_route[0]).".php",$data),$templateString);
                echo $templateString;
            }
            else
                throw new Exception("Error loading the template, need more parameters",1);
        }
        else
            include_once VIEW_PATH.(isset($_route[1]) ? $_route[0]."/".$_route[1] : $_route[0]).".php";
    }
    private static function loadFileasString($route,array $data = array())
    {
        ob_start();
        include_once($route);
        return ob_get_clean();
    }
    public static function addJavascript($src)
    {
        echo '<script type="text/javascript" charset="utf-8" src="/'.BASE_DIR.'/'.$src.'"></script>';
    }
    public static function addStyle($src)
    {
        echo '<link rel="stylesheet" href="/'.BASE_DIR.'/'.$src.'">';
    }
}
?>