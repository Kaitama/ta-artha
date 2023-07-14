<html>
<head>
    <title>SLIP GAJI {{ \Carbon\Carbon::create($year, $month)->monthName }} {{ $year }}</title>
    <style>
        .right {
            text-align: right;
        }
        table tr td {
            padding: 10px;
            margin: 0;
            border-bottom: 1px solid;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<Body>
    <h3 style="text-align: center">
        SLIP GAJI {{ \Carbon\Carbon::create($year, $month)->monthName }} {{ $year }} <br>
        {{ $user->name }}
    </h3>
    <p style="text-align: center"><strong>{{ config('app.name') }}, {{ $check->created_at->isoFormat('LL') }}</strong></p>
    <hr>

    <p>
        Periode {{ $check->created_at->firstOfMonth()->isoFormat('LL') }} sampai {{ $check->created_at->endOfMonth()->isoFormat('LL') }}
    </p>
    <table style="width: 100%; margin-top: 24px">
        <tr>
            <th colspan="2">Pokok</th>
        </tr>
        @if($check->point || $check->hours)
            <tr>
                <td>{{ $check->point ? 'Jumlah Point' : 'Total Jam Mengajar' }}</td>
                <td class="right">{{ $check->point > 0 ? $check->point : $check->hours }}</td>
            </tr>
            <tr>
                <td>Rate</td>
                <td class="right">{{ \App\Helpers\Rupiah::format($check->rate) }}</td>
            </tr>
        @endif
        <tr class="bold">
            <td>Total</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->base) }}</td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 24px">
        <tr>
            <th colspan="2">Tunjangan dan Lainnya</th>
        </tr>
        <tr>
            <td>Travel</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->travel) }}</td>
        </tr>
        <tr>
            <td>Tunjangan</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->bonus) }}</td>
        </tr>
            @php $tunjangan = $check->travel + $check->bonus; @endphp
        <tr class="bold">
            <td>Total</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($tunjangan) }}</td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 24px">
        <tr>
            <th colspan="2">Potongan</th>
        </tr>
        @if($user->cashflows()->exists())
            @php
                $type_list = (new \App\Models\Cashflow())->type_list;
            @endphp
            @foreach($user->cashflows as $flow)
                <tr>
                    <td>{{ $type_list[$flow->type] }} {{ $flow->description ? '- ' . $flow->description : '' }}</td>
                    <td class="right">{{ \App\Helpers\Rupiah::format($flow->nominal) }}</td>
                </tr>
            @endforeach
        @endif
        <tr class="bold">
            <td>Total</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->withdraw) }}</td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 24px">
        <tr>
            <th colspan="2">Absensi</th>
        </tr>
        @if($check->absence > 0)
            <tr>
                <td>Jumlah Absen</td>
                <td class="right">{{ \App\Helpers\Rupiah::format($check->absence) }}</td>
            </tr>
            <tr>
                <td>Potongan Absen</td>
                <td class="right">{{ \App\Helpers\Rupiah::format($user->roles->first()->absence_cut) }}</td>
            </tr>
        @endif
        <tr class="bold">
            <td>Total</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->absence_cut) }}</td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 24px; font-weight: bold">
        <tr>
            <th colspan="2">Gaji</th>
        </tr>
        <tr>
            <td>Gaji Kotor <br> <span style="font-size: 10pt; font-weight: normal">Pokok + Tunjangan - Potongan - Absensi</span></td>
            @php $bruto = $check->base + $tunjangan - $check->withdraw - $check->absence_cut; @endphp
            <td class="right">{{ \App\Helpers\Rupiah::format($bruto) }}</td>
        </tr>
        <tr>
            <td>Persepuluhan <br> <span style="font-size: 10pt; font-weight: normal">10% dari Gaji Kotor</span></td>
            @php $tens = $bruto * 10 / 100; @endphp
            <td class="right">{{ \App\Helpers\Rupiah::format($tens) }}</td>
        </tr>
        <tr>
            <td>Gaji Bersih <br> <span style="font-size: 10pt; font-weight: normal">Gaji Kotor - Persepuluhan</span></td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->salary) }}</td>
        </tr>

    </table>
</Body>
</html>
