<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 22/02/2015
 * Time: 11:59 AM
 */

namespace backend\models;


class HtmlHelpers {

    public static function dropDownList($model, $parent_model_id, $id, $value, $string)
    {
        $rows = $model::find()->where([$parent_model_id => $id])->all();

        $droptions = "<option value=''>Seleccione...</option>";

        if(count($rows)>0){
            // $droptions .= '<option value="">Todos</option>';
            foreach($rows as $row){
                $droptions .= '<option value='.$row->$value.'>'.$row->$string.'</option>';
            }
        }
        else{
            //$droptions .= "<option>No se han encontrado resultados.</option>";
                // $row->$value=null;
                $droptions .= '<option value="">Sin Registros.</option>';
        }

        return $droptions;  
    }

}