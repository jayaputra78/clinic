<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Lap Rugilaba </title>

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
				font-size: 14px;
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
				font-weight: bold;
                text-align: left;
			}

            .invoice-box table tr td.heading2 {
				
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                text-align: right;
			}

			.invoice-box table tr.heading3 td {
				
				font-weight: bold;
                text-align: left;
			}

			.invoice-box table tr.heading4 td {

				border-top: 1px solid #ddd;
				font-weight: bold;
                text-align: left;
			}

			.invoice-box table tr.details td {
				padding-bottom: 10px;
			}

			.invoice-box table tr.item td {
				border-bottom: 0px solid #eee;
                text-align: left;
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
					<td colspan="5">
						<table>
                            <tr>
                                <td colspan="2" align="center">
									<h3>
									@if ($level > 4 )
										{{ Auth::user()->member->name  }}<br>{{ Auth::user()->member->kta  }}
									@else
										PT. ANDHIKA PRIMA PUTRA
									@endif
									

									@foreach ($judul as $row1)
											@php 
												$ju=$row1->kta;
											@endphp
									@endforeach
									
									<br>LAPORAN RUGILABA BULANAN<br>PROYEK : {{ $ju }}</h3> 
                                    <h3>Periode : {{ $tglawal1 }} sampai {{ $tglakhir1 }} </h3> 

                            </tr>

						</table>
					</td>
				</tr>




				<tr class="heading">
					
                    <td width="10%" align="left">Kode</td>
                    <td width="38%" align="left">Keterangan</td>
					
					
					
                    <td width="17%" class="heading2">Awal</td>
					<td width="17%" class="heading2">Bulan ini</td>
					<td width="17%" class="heading2">Akhir</td>
					
				</tr>


				<tr class="heading3">
					
                    <td width="10%" align="left" colspan="5">PENDAPATAN</td>				
					
				</tr>
				
					@php $no = 1 @endphp
                    @foreach ($account_p as $row)
$
						@php
							$awal=$row->awal;
							$bulan=$row->bulan;
							$saldo=$row->awal+$row->bulan;
							
							$awal_semua[]=-$row->awal;
							$bulan_semua[]=-$row->bulan;
							$saldo_semua[]=-$row->akhir1;

							$awal2_semua[]=-$row->awal;
							$bulan2_semua[]=-$row->bulan;
							$saldo2_semua[]=-$row->akhir1;
						@endphp
						<tr class="item">
                        
                       
						<td width="10%" class="item">{{ $row->account }}</td>
						<td width="38%" class="item">{{ $row->keterangan }}</td>
						
						
                        <td width="17%" class="item3">{{ number_format(-$row->awal) }}</td>
                        <td width="17%" class="item3">{{ number_format(-$row->bulan) }}</td>
						<td width="17%" class="item3">{{ number_format(-$row->akhir1)  }}</td>
						</tr>

                    @endforeach
                   

				<tr class="item">
                    <td colspan="5"></td>
                   
				</tr>

				<tr class="heading4">
                    <td colspan="2">TOTAL PENDAPATAN</td>
					
					<td colspan="1" class="item3">{{ number_format(@array_sum($awal_semua)) }}</td>
					<td colspan="1" class="item3">{{ number_format(@array_sum($bulan_semua)) }}</td>
					<td colspan="1" class="item3">{{ number_format(@array_sum($saldo_semua)) }}</td>
					<td></td>
				</tr>


				<!-- bIAYA -->

				<tr class="heading3">
					
                    <td width="10%" align="left" colspan="5">BIAYA-BIAYA</td>				
					
				</tr>
				
					@php $no = 1 @endphp
                    @foreach ($account_b as $row)
$
						@php
							$awal1=$row->awal;
							$bulan1=$row->bulan;
							$saldo1=$row->awal+$row->bulan;
							
							$awal1_semua[]=$row->awal;
							$bulan1_semua[]=$row->bulan;
							$saldo1_semua[]=$row->akhir1;

							$awal2_semua[]=-$row->awal;
							$bulan2_semua[]=-$row->bulan;
							$saldo2_semua[]=-$row->akhir1;
						@endphp
						<tr class="item">
                        
                       
						<td width="10%" class="item">{{ $row->account }}</td>
						<td width="50%" class="item">{{ $row->keterangan }}</td>
						
						
                        <td width="13%" class="item3">{{ number_format($row->awal) }}</td>
                        <td width="13%" class="item3">{{ number_format($row->bulan) }}</td>
						<td width="13%" class="item3">{{ number_format($row->akhir1)  }}</td>
						</tr>

                    @endforeach
                   

				<tr class="item">
                    <td colspan="5"></td>
                   
				</tr>

				<tr class="heading4">
                    <td colspan="2">TOTAL BIAYA</td>
					
					<td colspan="1" class="item3">{{ number_format(@array_sum($awal1_semua)) }}</td>
					<td colspan="1" class="item3">{{ number_format(@array_sum($bulan1_semua)) }}</td>
					<td colspan="1" class="item3">{{ number_format(@array_sum($saldo1_semua)) }}</td>
					<td></td>
				</tr>


				<tr class="heading4">
                    <td colspan="2">TOTAL RUGI/LABA</td>
					
					<td colspan="1" class="item3">{{ number_format(@array_sum($awal2_semua)) }}</td>
					<td colspan="1" class="item3">{{ number_format(@array_sum($bulan2_semua)) }}</td>
					<td colspan="1" class="item3">{{ number_format(@array_sum($saldo2_semua)) }}</td>
					<td></td>
				</tr>

			</table>
		</div>
	</body>
</html>
