@foreach($logs as $log)
    @php
        $dt = isset($log['created_at']) ? explode(' ', $log['created_at']) : [null, null];
        $datePart = $dt[0] ?? '';
        $timePart = $dt[1] ?? '';

        $year  = $datePart ? (int)substr($datePart, 0, 4) : 0;
        $month = $datePart ? (int)substr($datePart, 5, 2) : 0;
        $day   = $datePart ? (int)substr($datePart, 8, 2) : 0;

        $dateStr = ($year && $month && $day)
            ? sprintf("%04d_%02d_%02d_%s", $year, $month, $day, str_replace(':','',$timePart ?? ''))
            : null;

        $displayParaName  = !empty($log['paraName']) ? $log['paraName'] : $dateStr;
    @endphp

    <tr>
        <td><span class="result-label log-label">📄ログ</span></td>
        <td>{{ $log['id'] }}</td>
        <td>{!! $displayParaName ? str_replace('_','_<wbr>', e($displayParaName)) : '&nbsp;' !!}</td>
        <td>{{ round($log['width'],2) }}</td>
        <td>{{ round($log['length'],2) }}</td>
        <td>{{ round($log['height'],2) }}</td>
        <td>{{ $log['created_at'] }}</td>
        <td class="detail-col">{{ $log['name_upper'] ?: ($dateStr ? $dateStr.'_a' : '—') }}</td>
        <td class="detail-col">{{ $log['name_side']  ?: ($dateStr ? $dateStr.'_b' : '—') }}</td>
    </tr>
@endforeach
