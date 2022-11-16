<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Lap Kas</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Calibry', 'Arial', Calibry, Verdana, Arial, sans-serif;
				text-align: center;
				color: #030303;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 2px;
				margin-bottom: 5px;
				color: #000;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 1200px;
				margin: auto;
				padding: 1px;
				border: 1px solid #eee;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
				font-size: 12px;
				line-height: 18px;
				font-family: 'Calibry', 'Arial', Calibry, Verdana, Arial, sans-serif;
				color: #000;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 10px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 5px;
				line-height: 5px;
				color: #000;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 10px;
                padding-top: 0px;
			}

			.invoice-box table tr.heading td {
				
				border-bottom: 1px solid #ddd;
				border-top: 1px solid #ddd;
				font-weight: bold;
                text-align: left;
			}

            .invoice-box table tr td.heading2 {
				
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                text-align: right;
			}

			.invoice-box table tr.details td {
				padding-bottom: 10px;
			}

			.invoice-box table tr.item td {
				border-bottom: 0px solid #eee;
                text-align: left;
				line-height: 12px;
				padding-bottom: 0px;
			}

            .invoice-box table tr td.item3 {
				border-bottom: 0px solid #eee;
                text-align: right;
			}

            .invoice-box table tr.item2 td {
				border-bottom: 0px solid #eee;
                text-align: right;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
                line-height: 10px;
                border-top: 1px solid #ddd;
                text-align: right;
               
			}

            .invoice-box table tr td.item.last3 {
				border-bottom: none;
                line-height: 10px;
                border-top: 1px solid #ddd;
                text-align: left;
               
			}

            .invoice-box table tr.item.last2  td {
                line-height: 10px;
                border-bottom: none;
                text-align: right;
			}

			.invoice-box table tr.total td {
				border-top: 1px solid #eee;
                line-height: 18px;
				
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                text-align: right;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table>
				<tr class="information">
					<td colspan="8">
						<table>
                            <tr>
                                <td colspan="2" align="center">

									@foreach ($judul as $row1)
											@php 
												$ju=$row1->kta;
												$ju2=$row1->name;
											@endphp
									@endforeach
									
									<h3>{{ $ju2 }} <br>LAPORAN BIAYA OPERASIONAL - {{ $cashier->bank }} <br>PROYEK : {{ $ju }}</h3> 
                                    <h3>Periode : {{ $tglawal1 }} sampai {{ $tglakhir1 }} </h3> 
                            </tr>

						</table>
					</td>
				</tr>

				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="14%" align="left">Tanggal</td>
                    <td width="10%" align="left">No Kas</td>
					<td width="45%" align="left">Keterangan</td>
					
					<td width="10%" class="heading2">Jumlah</td>
					<td width="20%" class="heading2">Saldo</td>
					
				</tr>

					@php $no = 1 @endphp

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="14%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="45%" class="item">SALDO AWAL</td>
						
                        <td width="10%" class="item3">-</td>
						<td width="20%" class="item3">{{ number_format($saldo)  }}</td>
						</tr>

						@php
							$saldo_semua[]=$saldo;
						@endphp

                    @foreach ($payinvoice_details as $row)
$
						@php
							$masuk=$row->masuk;
							$keluar=$row->keluar;
							$saldo=$row->masuk-$row->keluar;
							
							$masuk_semua[]=$row->masuk;
							$keluar_semua[]=$row->keluar;
							$saldo_semua[]=$row->keluar;
							$tgl = date('d M Y', strtotime( $row->tanggal ));
							$note = substr($row->payinvoice->note,0,6);
						@endphp

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="14%" class="item">{{ $tgl }}</td>
						<td width="10%" class="item">{{ $note }}</td>
						<td width="45%" class="item">{{ $row->keterangan }}</td>
						
                        
                        <td width="10%" class="item3">{{ number_format($row->keluar) }}</td>
						<td width="20%" class="item3">{{ number_format(@array_sum($saldo_semua))  }}</td>
						</tr>

                    @endforeach
                   

				<tr class="item">
                    <td colspan="3"></td>
                   
				</tr>

				<tr class="item last">
                    <td colspan="4">SALDO AKHIR</td>
					
					
					<td colspan="1">{{ number_format(@array_sum($keluar_semua)) }}</td>
					<td colspan="1">{{ number_format(@array_sum($saldo_semua)) }}</td>
					<td></td>
				</tr>


			</table>
		</div>
	</body>
</html>
