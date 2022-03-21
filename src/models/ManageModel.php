<?php
class DB
{
    function Insert($table, $arrayData)
    {
        $fields = "";
        $values = "";
        $i = 1;
        $str_fix = "NOW()";
        foreach ($arrayData as $key => $value) {

            if ($i != 1) {
                $fields .= ", ";
                $values .= ", ";
            }
            $fields .= "$key";
            if (strpos($value, $str_fix) !== false) {
                $values .= "$value";
            } else {
                $values .= "'$value'";
            }
            $i++;
        }
        $sql = "INSERT INTO $table($fields) VALUES($values)";
        return $sql;
    }
    function Update($table, $arrayData, $condition)
    {
        $fields = "";
        $i = 1;
        $str_fix = "NOW()";
        foreach ($arrayData as $key => $value) {
            if ($i != 1) {
                $fields .= ", ";
            }
            if (strpos($value, $str_fix) !== false) {
                $fields .= "$key = " . "$value";
            } else {
                $fields .= "$key = " . "'$value'";
            }

            $i++;
        }
        $sql = "UPDATE $table SET $fields WHERE $condition";
        return $sql;
    }

    function Delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        return $sql;
    }
}
