@php
    // created_at 分解
    $createdAt = (string)($log->created_at ?? '');
    $dt = $createdAt ? explode(' ', $createdAt) : [null, null];
    $datePart = $dt[0] ?? '';
    $timePart = $dt[1] ?? '';

    $year  = $datePart ? (int)substr($datePart, 0, 4) : 0;
    $month = $datePart ? (int)substr($datePart, 5, 2) : 0;
    $day   = $datePart ? (int)substr($datePart, 8, 2) : 0;

    $datePath = ($year && $month && $day) ? "{$year}-{$month}-{$day}" : null;
    $dateStr  = ($year && $month && $day)
        ? sprintf("%04d_%02d_%02d_%s", $year, $month, $day, str_replace(':','',$timePart ?? ''))
        : null;

    // 表示名補完
    $displayParaName  = !empty($log->paraName)   ? $log->paraName   : $dateStr;
    $displayNameUpper = !empty($log->name_upper) ? $log->name_upper : ($dateStr ? $dateStr.'_a' : null);
    $displayNameSide  = !empty($log->name_side)  ? $log->name_side  : ($dateStr ? $dateStr.'_b' : null);

    // 画像URL
    $imageUrlUpper = ($displayNameUpper && $datePath)
        ? route('image.serve', ['date'=>$datePath,'filename'=>$displayNameUpper]) : null;
    $imageUrlSide  = ($displayNameSide && $datePath)
        ? route('image.serve', ['date'=>$datePath,'filename'=>$displayNameSide])  : null;
@endphp

<tr id="row_{{ $log->id }}"
    data-upper="{{ $imageUrlUpper ?? '' }}"
    data-side="{{ $imageUrlSide ?? '' }}">
    <td>{{ $log->id }}</td>

    <td>{!! $displayNameUpper ? str_replace('_','_<wbr>', e($displayNameUpper)) : '&nbsp;' !!}</td>
    <td>{!! $displayNameSide  ? str_replace('_','_<wbr>', e($displayNameSide))  : '&nbsp;' !!}</td>
    <td>{!! $displayParaName  ? str_replace('_','_<wbr>', e($displayParaName))  : '&nbsp;' !!}</td>

    <td>
        @if($displayParaName)
            <form action="/search/parameta/name" method="GET">
                @csrf
                <input type="hidden" name="q" value="{{ $displayParaName }}">
                <input type="hidden" name="method" value="name" />
                <input type="submit" value="この値で検索">
            </form>
        @else
            <span style="color: gray;">—</span>
        @endif
    </td>

    <td>{{ $log->width   ? round($log->width,2)   : '' }}</td>
    <td>{{ $log->length  ? round($log->length,2)  : '' }}</td>
    <td>{{ $log->height  ? round($log->height,2)  : '' }}</td>

    <td style="background-color: {{ $log->judgment == 1 ? 'blue' : 'red' }};">
        {{ $log->judgment == 1 ? '良' : '不' }}
    </td>

    <td>{{ $createdAt }}</td>

    <td id="cell_upper_{{ $log->id }}">
        @if($imageUrlUpper)
            <a href="{{ $imageUrlUpper }}" data-lightbox="abc" data-title="{{ $displayNameUpper }}">
                <img id="img_upper_{{ $log->id }}" src="{{ $imageUrlUpper }}" width="60px" alt="upper">
            </a>
        @else
            <span style="color: gray;">なし</span>
        @endif
    </td>

    <td id="cell_side_{{ $log->id }}">
        @if($imageUrlSide)
            <a href="{{ $imageUrlSide }}" data-lightbox="abc" data-title="{{ $displayNameSide }}">
                <img id="img_side_{{ $log->id }}" src="{{ $imageUrlSide }}" width="60px" alt="side">
            </a>
        @else
            <span style="color: gray;">なし</span>
        @endif
    </td>

<td class="image-dl">
    <form method="get" action="{{ route('export/image') }}">
        <input type="hidden" name="log_id" value="{{ $log->id }}" />
        <div style="max-width: 145px;">
            <input type="submit" value="画像ダウンロード" style="width: 100%; padding: 5px;">
        </div>
    </form>
</td>
</tr>
