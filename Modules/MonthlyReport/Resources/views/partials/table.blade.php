@php
$totalQtyEnd = 0;
@endphp

@if ($parts->isEmpty())
<tr>
    <td colspan="17" align="center">Data kosong</td>
</tr>
@else
@foreach ($parts as $part)
@php
$totalQtyEnd += $part->qty_end;
@endphp
<tr class="part-row" data-category="{{ $part->part_category_name }}">
    <td width="5%">{{ $loop->iteration }}</td>
    <td width="15%">{{ $part->part_no }}</td>
    <td width="20%">{{ $part->part_name }}</td>
    <td width="20%">{{ $part->part_category_name }}</td>
    <td width="20%">{{ $part->no_urut }}</td>
    <td width="20%">{{ $part->part_no }}.{{ $part->no_urut }}</td>
    <td width="20%">{{ $part->qty_end }}</td>
    <td width="20%">{{ $part->rop }}</td>
    <td width="20%">{{ $part->forecast }}</td>
    <td width="20%">{{ $part->max }}</td>
    <td width="20%">{{ $part->asal }}</td>
    <td width="20%">{{ $part->wear_and_tear_code }}</td>
    <td width="20%">{{ $part->invoice }}</td>
    <td width="20%">{{ $part->po }}</td>
    <td width="20%">{{ $part->po_date }}</td>
    <td width="20%">{{ $part->rec_date }}</td>
    <td width="20%">
        @php
        $currentDate = now();
        $partDate = \Carbon\Carbon::parse($part->created_at);
        $ageInMonths = $currentDate->diffInMonths($partDate);

        if ($ageInMonths > 24) {
            echo 'Dead Stock';
        } elseif ($ageInMonths >= 6 && $ageInMonths <= 24) {
            echo 'Slow Moving';
        } else {
            echo 'Active';
        }
        @endphp
    </td>
</tr>
@endforeach
<tr>
    <td colspan="6"></td>
    <td colspan="2"><strong>Total Qty End:</strong></td>
    <td colspan="2">{{ $totalQtyEnd }}</td>
    <td colspan="9"></td>
</tr>
@endif

@if ($parts->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $parts->links() }}
</div>
@endif 