<html>
<head>
    <title>SLIP GAJI {{ \Carbon\Carbon::create($year, $month)->monthName }} {{ $year }}</title>
    <style>
        body {
            font-family: 'Arial', Verdana, sans-serif;
        }
        .right {
            text-align: right;
        }
        table tr td {
            padding: 2px;
            margin: 0;
            /*border-bottom: 1px solid;*/
        }
        .bold {
            font-weight: bold;
        }
        .tbl-signature {
            background-image: url("{{ url('img/signature.png') }}");
            background-repeat: no-repeat;
            background-position: bottom left;
            background-size: 160px;
        }
    </style>
</head>
<Body>

    <h4>
        PERGURUAN ADVENT II MEDAN <br>
        SLIP GAJI {{ strtoupper(\Carbon\Carbon::create($year, $month)->monthName) }} {{ $year }}
    </h4>

    <table style="width: 100%" cellspacing="0">
        <tr>
            <td style="width: 40%">Nama</td>
            <td style="width: 0.01%">:</td>
            <td colspan="2">{{ $user->name }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td colspan="2">Medan, {{ $check->created_at->isoFormat('LL') }}</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        @if($check->point || $check->hours)
            <tr>
                <td>{{ $check->point ? 'Point' : 'Jam Mengajar' }}</td>
                <td>:</td>
                <td class="right">{{ $check->point ?? $check->hours }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Rate</td>
                <td>:</td>
                <td class="right"  style="border-bottom: 1px solid gray">{{ \App\Helpers\Rupiah::format($check->rate) }}</td>
                <td  style="border-bottom: 1px solid gray"></td>
            </tr>
        @endif
        <tr>
            <td>Gaji Pokok</td>
            <td>:</td>
            <td colspan="2" class="right">{{ \App\Helpers\Rupiah::format($check->base) }}</td>
        </tr>
        <tr>
            <td>Tunjangan</td>
            <td>:</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->bonus) }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Travel</td>
            <td>:</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->travel) }}</td>
            <td></td>
        </tr>
        @php
            $gapok = $check->base + $check->bonus + $check->travel;
        @endphp
        <tr>
            <td>Total Gaji Pokok</td>
            <td>:</td>
            <td colspan="2" class="right" style="border-top: 1px solid gray;">{{ \App\Helpers\Rupiah::format($gapok) }}</td>
        </tr>
        <tr>
            <td>Pinjaman & Sosial</td>
            <td>:</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->withdraw) }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Potongan Absen</td>
            <td>:</td>
            <td class="right">{{ \App\Helpers\Rupiah::format($check->absence_cut) }}</td>
            <td></td>
        </tr>
        @php
            $potongan = $check->withdraw + $check->absence_cut;
        @endphp
        <tr>
            <td>Total Potongan</td>
            <td>:</td>
            <td colspan="2" class="right" style="border-top: 1px solid gray;">{{ \App\Helpers\Rupiah::format($potongan) }}</td>
        </tr>
        @php
            $gator = $gapok - $potongan;
        @endphp
        <tr>
            <td>Gaji Kotor</td>
            <td>:</td>
            <td colspan="2" class="right" style="border-top: 1px solid gray">{{ \App\Helpers\Rupiah::format($gator) }}</td>
        </tr>
        <tr>
            <td>Persepuluhan</td>
            <td>:</td>
            <td class="right" colspan="2">{{ \App\Helpers\Rupiah::format($persepuluhan = $gator * 10 / 100) }}</td>
        </tr>
        <tr>
            <td>Gaji Diterima</td>
            <td>:</td>
            <td class="right" colspan="2" style="border-top: 2px double black">{{ \App\Helpers\Rupiah::format($gator - $persepuluhan) }}</td>
        </tr>
    </table>

    <div style="margin-top: 32px">
        <table style="width: 100%;" class="tbl-signature">
            <tr>
                <td>Diserahkan Oleh:</td>
                <td class="right">Diterima Oleh</td>
            </tr>
            <tr>
                <td colspan="2" style="height: 70px"></td>
            </tr>
            <tr>
                <td>{{ $kasir }}</td>
                <td class="right">{{ $user->name }}</td>
            </tr>
        </table>
    </div>

</Body>
</html>
