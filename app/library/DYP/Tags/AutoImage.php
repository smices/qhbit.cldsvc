<?php
namespace DYP\Tags;

class AutoImage
{
    static function PdtImage($params=null)
    {
        if(!is_array($params)) return "";

        $prefix = _DYP_HOST_PIC . '/thumb/d/';

        $code = "";

        if(isset($params["hash"])){
            $code .=" id=" . $params['hash'];
            unset($params['hash']);
        }

        if(isset($params["name"])){
            $code .=' title="' . $params['name'] . '"';
            $code .=' alt="' . $params['name'] . '"';
            unset($params['name']);
        }

        if(isset($params["class"])){
            $code .=' class="' . $params['class'] . '"';
            unset($params['class']);
        }

        if(isset($params["style"])){
            $code .=' style="' . $params['style'] . '"';
            unset($params['style']);
        }

        if(isset($params["path"])){
            $tmp = explode(".", $params['path']);
            $ext =array_pop($tmp);
            $fname = join("",$tmp);
            unset($params["path"]);
        }

        if(isset($params["ext"])){
            $ext =$params["ext"];
            unset($params["ext"]);
        }

        if(isset($params["url"]) && $params["url"] == true){
            $urlonly = true;
            unset($params["url"]);
        }

        $other = ",c_fill";
        if(count($params)>0){
            foreach ($params as $k => $v) {
                $other .= ','.$k.'_'.$v;
            }
        }

        $src = $prefix. $fname . $other.'.'.$ext;
        $src = str_replace('\\', '/' , $src);

        if(isset($urlonly) && $urlonly == true)
        {
            return $src;
        }

        $code = '<img src="'.$src.'" ';
        //$code = ' title="'.$name.' alt="'.$name;
        $code .=" />";

        return $code;
    }

}
