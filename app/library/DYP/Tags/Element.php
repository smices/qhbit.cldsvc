<?php
namespace DYP\Tags;

class Element
{
    const FMT_ARRAY = 0;
    const FMT_JSON  = 1;
    const FMT_HTML  = 2;


    /**
     * Element Status Definitely
     * @return array
     */
    static function status(){
        $statusAr = [0=>'DISABLE', 1=>'ENABLE', 2=>'DELETE'];
        return $statusAr;
    }//end


    static function getStatusText($id){
        return self::status()[$id];
    }//end

    /**
     * Out Form fmt Element Status
     *
     * @param int    $default
     * @param string $extra
     * @param string $name
     * @param string $id
     *
     * @return string
     */
    static function frmStatus($default=1, $extra='', $name="status", $id="status"){
        $ar = self::status();

        $str = '<select name="'.$name.'" id="'.$id.'" '.$extra.'>'.PHP_EOL;
        foreach ($ar as $k=>$v){
            if($default == $k){
                $str .= "<option value='$k' selected='selected'>$v</option>".PHP_EOL;
            }else{
                $str .= "<option value='$k'>$v</option>".PHP_EOL;
            }
        }
        return $str.'</select>'.PHP_EOL;
    }//end


}//end
