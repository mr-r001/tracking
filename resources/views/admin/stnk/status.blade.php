@if ($status === 'Data diterima')
    <span class="badge badge-primary">{{ $status }}</span>
@elseif ($status === 'Diproses')
    <span class="badge badge-success">{{ $status }}</span>
@else
    <span class="badge badge-info">{{ $status }}</span>
@endif