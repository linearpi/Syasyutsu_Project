@foreach ($logs as $log)
<tr>
    <td><span class="result-label log-label">📄ログ</span></td>
    <td>{{ $log['id'] }}</td>
    <td>{{ $log['paraName'] }}</td>
    <td>{{ round($log['width'], 2) }}</td>
    <td>{{ round($log['length'], 2) }}</td>
    <td>{{ round($log['height'], 2) }}</td>
    <td>{{ $log['created_at'] }}</td>
    <td class="detail-col">{{ $log['name_upper'] ?? '' }}</td>
    <td class="detail-col">{{ $log['judgment'] == 1 ? '良' : '不' }}</td>
</tr>
@endforeach
