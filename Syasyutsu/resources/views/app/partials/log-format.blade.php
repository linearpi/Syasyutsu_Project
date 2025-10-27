@php
    $dt = isset($log['created_at']) ? explode(' ', $log['created_at']) : [null, null];
    $datePart = $dt[0] ?? '';
    $timePart = $dt[1] ?? '';

    $year  = $datePart ? (int)substr($datePart, 0, 4) : 0;
    $month = $datePart ? (int)substr($datePart, 5, 2) : 0;
    $day   = $datePart ? (int)substr($datePart, 8, 2) : 0;

    $datePath = ($year && $month && $day) ? "{$year}-{$month}-{$day}" : null;
    $dateStr  = ($year && $month && $day)
        ? sprintf("%04d_%02d_%02d_%s", $year, $month, $day, str_replace(':','',$timePart ?? ''))
        : null;

    $displayParaName  = !empty($log['paraName'])   ? $log['paraName']   : $dateStr;
    $displayNameUpper = !empty($log['name_upper']) ? $log['name_upper'] : ($dateStr ? $dateStr.'_a' : null);
    $displayNameSide  = !empty($log['name_side'])  ? $log['name_side']  : ($dateStr ? $dateStr.'_b' : null);

    $imageUrlUpper = ($displayNameUpper && $datePath)
        ? route('image.serve', ['date'=>$datePath,'filename'=>$displayNameUpper]) : null;
    $imageUrlSide  = ($displayNameSide && $datePath)
        ? route('image.serve', ['date'=>$datePath,'filename'=>$displayNameSide])  : null;
@endphp
