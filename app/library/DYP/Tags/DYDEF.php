<?php
namespace DYP\Tags;

/**
 * Class DYDEF
 * Di Ye Constant Function
 * @package DYP\Tags
 */
class DYDEF
{
    static function Status($code, $json=false)
    {
        $list = array("DISABLED","NORMAL","DELETED");
        if(true == $json){
            $rs = array();
            foreach ($list as $k=>$v){
                $rs[] = array("value"=>$k, "text"=>$v);
            }
            return json_encode($rs);
        }
        return $list[$code];
    }

    static function StatusPic($code, $withname=true)
    {
        $name = self::Status($code);
        $rs = '<img src="/assets/img/status_'.$code.'.png" title="'.$name.'" alt="'.$name.'" />';
        if($withname == true)
        {
            $rs .="&nbsp;".$name;
        }
        return $rs;
    }

    static function StatusSelect($name="status", $default="1", $class=""){
        $list = json_decode(self::Status(0, true));
        $rs = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'">';
        foreach ($list as $v){
            if($v->value == $default){
                $rs .= "<option value=\"".$v->value."\" selected>".$v->text."</option>";
            }else{
                $rs .= "<option value=\"".$v->value."\">".$v->text."</option>";
            }
        }
        $rs .= '</select>';
        return $rs;
    }

    static function Level($code, $json=false)
    {
        $list = array(
            "l0"=>"Standard",
            "l1"=>"VIP 1",
            "l2"=>"VIP 2",
            "l3"=>"VIP 3",
            "l4"=>"VIP 4",
            "l5"=>"VIP 5",
        );

        if(true == $json){
            $rs = array();
            foreach ($list as $k=>$v){
                $rs[] = array("value"=>$k, "text"=>$v);
            }
            return json_encode($rs);
        }

        return $list[$code];
    }

    static function LevelPic($code, $withname=true)
    {
        $name = self::Level($code);
        $rs = '<img src="/assets/img/diamond_'.$code.'.png" title="'.$name.'" alt="'.$name.'" />';
        if($withname == true)
        {
            $rs .="&nbsp;".$name;
        }
        return $rs;
    }


    static function LevelSelect($name="level", $default="0", $class=""){
        $list = json_decode(self::Level(0, true));
        $rs = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'">';
        foreach ($list as $v){
            if($v->value == $default){
                $rs .= "<option value=\"".$v->value."\" selected>".$v->text."</option>";
            }else{
                $rs .= "<option value=\"".$v->value."\">".$v->text."</option>";
            }
        }
        $rs .= '</select>';
        return $rs;
    }

    static function Role($code, $json=false)
    {
        $list = array(
            "l0"=>"Standard",
            "l1"=>"Level 1",
            "l2"=>"Level 2",
            "l3"=>"Level 3",
            "l4"=>"Level 4",
            "l5"=>"Level 5",
            "root"=>"Root",
        );

        if(true == $json){
            $rs = array();
            foreach ($list as $k=>$v){
                $rs[] = array("value"=>$k, "text"=>$v);
            }
            return json_encode($rs);
        }

        return $list[$code];
    }

    static function RolePic($code, $withname=true)
    {
        $name = self::Role($code);
        $rs = '<img src="/assets/img/diamond_'.$code.'.png" title="'.$name.'" alt="'.$name.'" />';
        if($withname == true)
        {
            $rs .="&nbsp;".$name;
        }
        return $rs;
    }


    static function RoleSelect($name="role", $default="0", $class=""){
        $list = json_decode(self::Role(0, true));
        $rs = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'">';
        foreach ($list as $v){
            if($v->value == 'root') continue;
            if($v->value == $default){
                $rs .= "<option value=\"".$v->value."\" selected>".$v->text."</option>";
            }else{
                $rs .= "<option value=\"".$v->value."\">".$v->text."</option>";
            }
        }
        $rs .= '</select>';
        return $rs;
    }

}
