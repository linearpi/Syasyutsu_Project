{{-- table-all-params.blade.php --}}
@foreach ($parametas as $p)
<tr>
    <td><span class="result-label param-label">⚙️パラメータ</span></td>
    <td>{{ $p['id'] }}</td>
    <td>{{ $p['name'] }}</td>
    <td>{{ $p['width'] }}</td>
    <td>{{ $p['length'] }}</td>
    <td>{{ $p['height'] }}</td>
    <td>{{ $p['created_at'] }}</td>
    <td class="detail-col">{{ $p['thresh'] ?? '' }}</td>
    <td class="detail-col">{{ $p['active'] ? 'ACTIVE' : 'INACTIVE' }}</td>
</tr>
@endforeach
