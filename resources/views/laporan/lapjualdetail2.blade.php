<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Lap Pemakaian Bahan</title>

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
				line-height: 7px;
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
                line-height: 8px;
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
					<td colspan="10">
						<table>
                            <tr>
                                <td colspan="2" align="center">

								@foreach ($judul as $row1)
										@php 
											$ju=$row1->kta;
											$ju2=$row1->name;
										@endphp
								@endforeach

									
									<h3>{{ $ju2 }} <br>LAPORAN PEMBAYARAN UPAH <br>PROYEK : {{ $ju }}</h3> 

                            </tr>

						</table>
					</td>
				</tr>

				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="13%" align="left">Tanggal</td>
                    <td width="8%" align="left">Order</td>
					<td width="38%" align="left">Product</td>
					<td width="5%" align="heading2">Hari</td>
					<td width="5%" align="heading2">Pekerja</td>
					<td width="10%" class="heading2">Upah/Hari</td>	
					<td width="10%" class="heading2">Total</td>	
					<td width="10%" class="heading2">Saldo</td>				
				</tr>

                    @php 
						$no = 1; 
						$dok = 'awal'; 
						$qty_semua1[]=0;
						$price_semua1[]=0;	
						$hari_semua1[]=0;
						$pekerja_semua1[]=0;
					@endphp
                    @foreach ($invoice_detail as $row)

						@if (($dok <> $row->doinvoice->supplier->nama) && ($dok <> 'awal'))
							@if ($qty_semua1 > 0) 

								<tr class="item last">
								<td colspan="4" class="item"><b>SUB TOTAL  {{ $dok }}</td>
								<td colspan="1"><b>{{ number_format(@array_sum($hari_semua1)) }}</td>
								<td colspan="1"><b>{{ number_format(@array_sum($pekerja_semua1)) }}</td>
								<td colspan="1"><b>-</td>
								<td colspan="1"><b>{{ number_format(@array_sum($price_semua1)) }}</td>
								<td colspan="1"><b>-</td>
								</tr>
								<tr class="item">
									<td colspan="6"></td>
								</tr>
							@endif
							@php
								$qty_semua1=[];
								$price_semua1=[];
							@endphp
						@endif

						@php
							$price=$row->price;
							$hari_semua[]=$row->hari;
							$pekerja_semua[]=$row->pekerja;
							$qty_semua[]=$row->qty;
							$price_semua[]=$row->price*$row->qty;
							$qty_semua1[]=$row->qty;
							$price_semua1[]=$row->price*$row->qty;
							$hari_semua1[]=$row->hari;
							$pekerja_semua1[]=$row->pekerja;
							$tgl = date('d M Y', strtotime( $row->tanggal ));
							$dok = $row->doinvoice->supplier->nama;
							$gambar = $row->doinvoice->image1;
						@endphp
						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="13%" class="item">{{ $tgl }}</td>
						<td width="8%" class="item">
									@if ($gambar <> "")
										<b><a href="{{  asset('storage/images/' . $gambar . '') }}" target="_blank">{{ $row->doinvoice->id }}</a></td>
									@else
										<b>{{ $row->doinvoice->id }}</td>
                                    @endif 		
						</td>
						<td width="38%" class="item">{{ $row->product->description }}</td>
						<td width="5%" class="item3">{{ number_format($row->hari) }}</td>
						<td width="5%" class="item3">{{ number_format($row->pekerja) }}</td>	
						<td width="10%" class="item3">{{ number_format($row->price) }}</td>
                        <td width="10%" class="item3">{{ number_format($row->price*$row->qty) }}</td>
						<td width="10%" class="item3">{{ number_format(@array_sum($price_semua)) }}</td>
						</tr>


                    @endforeach
                   

				<tr class="item">
                    <td colspan="7"></td>
                   
				</tr>


				<tr class="item last">
								<td colspan="4" class="item"><b>SUB TOTAL  {{ $dok }}</td>
								<td colspan="1"><b>{{ number_format(@array_sum($hari_semua1)) }}</td>
								<td colspan="1"><b>{{ number_format(@array_sum($pekerja_semua1)) }}</td>
								<td colspan="1"><b>-</td>
								<td colspan="1"><b>{{ number_format(@array_sum($price_semua1)) }}</td>
								<td colspan="1"><b>-</td>
				</tr>

				<tr class="item">
                    <td colspan="7"></td>
                   
				</tr>

				<tr class="item last">
                    <td colspan="4" class="item"><b>TOTAL</td>
					<td colspan="1"><b>{{ number_format(@array_sum($hari_semua)) }}</td>
					<td colspan="1"><b>{{ number_format(@array_sum($pekerja_semua)) }}</td>
					<td colspan="1"><b>-</td>
					<td colspan="1"><b>{{ number_format(@array_sum($price_semua)) }}</td>
					<td colspan="1"><b>-</td>
				</tr>


			</table>
		</div>
	</body>
</html>
