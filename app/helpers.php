<?php
if (!function_exists('convertToCurrrentTimezone')) {
   function convertToCurrrentTimezone($date, $format = 'Y-m-d H:i:s')
   {
    $utcDateTime = new DateTime($date, new DateTimeZone('UTC'));

    // Convert it to your desired timezone (e.g., Phnom Penh)
    $targetTimezone = new DateTimeZone('Asia/Phnom_Penh');
    $phnomPenhDateTime = clone $utcDateTime;
    $phnomPenhDateTime->setTimezone($targetTimezone);
    
    // Get the converted time in the desired format
    $convertedTime = $phnomPenhDateTime->format('H');

    return $convertedTime;
   }
}

if(!function_exists('getParam')) {
    function getParam($request, $param)
    {
        foreach ($request as $key => $value) {
            if ($key == $param) {
                return $value;
            }
        }
        return null;
    }
}

if(!function_exists('findModel')) {
    function findModel($model, $id)
    {
        $found = $model::find($id);

        if ($found) {
            return $found;
        }
        
        throw new Exception("Record ".$id." not found in model ".$model."");
    }
}