<?php
function validateData($data){
    foreach ($data as $key=>$value){
        if (is_string($value)) {
            if (/*strpos(strtolower($value), " insert ") || strpos(strtolower($value), " drop ") || strpos(strtolower($value), " select ") || strpos(strtolower($value), " ; ") || strpos(strtolower($value), " create ") ||*/ $value === "") {
                return false;
            }
        } elseif (is_array($value)) {
            $ndata = $value;
            foreach ($ndata as $key=>$value) {
                if (/*strpos(strtolower($value), " insert ") || strpos(strtolower($value), " drop ") || strpos(strtolower($value), " select ") || strpos(strtolower($value), " ; ") || strpos(strtolower($value), " create ") ||*/ $value === "") {
                    return false;
                }
            }
        }
    }
    return true;
}