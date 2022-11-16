<!DOCTYPE html>
<html>
<head>
	<title>Laporan Hutang</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('gte/production/images/logo.ico') }}">
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Lap Hutang.xls");
	?>
 
	<center>
		<h4>Laporan Hutang Per tanggal {{ $tglawal1 }}  </h4>
	</center>
 
	<table border=1>

				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="20%" align="left">Supplier</td>
                    <td width="20%" align="left">Alamat</td>
					<td width="20%" class="heading2">Tagihan</td>
					<td width="20%" class="heading2">Bayar</td>
					<td width="20%" class="heading2">Saldo</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($suppliers as $row)

						@php

							$saldo=$row->saldo;
							$saldo_semua[]=$row->saldo;
							$total=$row->total;
							$total_semua[]=$row->total;
							$bayar=$row->bayar;
							$bayar_semua[]=$row->bayar;

						@endphp
						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="35%" class="item">{{ $row->nama }}</td>
						<td width="30%" class="item">{{ $row->kota }}</td>
						<td width="13%" class="item3">{{ $row->total }}</td>
                        <td width="13%" class="item3">{{ $row->bayar }}</td>
						<td width="13%" class="item3">{{ $row->saldo }}</td>
						</tr>

                    @endforeach
                   

				<tr class="item last">
                    <td colspan="3">TOTAL</td>

					<td colspan="1">{{ @array_sum($total_semua) }}</td>
					<td colspan="1">{{ @array_sum($bayar_semua) }}</td>
					<td colspan="1">{{ @array_sum($saldo_semua) }}</td>
				</tr>


			</table>
</body>
</html>