<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Cetal Invoice</title>

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
				max-width: 800px;
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

			.invoice-box table tr td.item.last4 {
				border-bottom: none;
                line-height: 10px;
                border-top: 1px solid #ddd;
                text-align: center;
               
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
		<div class="invoice-box" style="background-image: url(baru/images/sertifikat_bg.jpg)">

		<table>
				<tr class="information">
					<td>
						<table>
                            <tr>
                                <td colspan="3" align="center">
                                    <h1></h1> 
                                    <h3></h3> 
                            </tr>
                            <tr>
							<td width="60%"><br/><br /></td>

							<td width="30%">Date  : <b><i> {{ $invoice->created_at->format('d M Y')  }} </b></i>  
							<br /> <h2>No.<span color="red">AA</span>A00000{{ $invoice->id }} </h2>
							<br />		
							</td>

							<td width="10%"></td>
							</tr>
							
							<tr>
							<td colspan="3" align="center">
									<br><br><br><br>
									<h2 align="center"> {{ $invoice->customer->name }}</h2> 
									{{ $invoice->customer->address }}
									<br><br>
							</td></tr>
							
							<tr>
							<td colspan="3" align="center">
								Telah dilakukan <b>Tally oleh Perusahaan Tally Mandiri </b> dengan perincian sebagai berikut : 
									<br><br>
									===================================================================
									<br><br>

									Jenis Tally : <b>{{ $invoice->jenis }}</b><br/>
                                    Perusahaan Tally : <b> {{ Auth::user()->member->name  }}</b><br/>
									No Faktur : #{{ $invoice->id }}<br/>
									Tanggal  : {{ $invoice->created_at->format('d M Y')  }} <br />
									No Container : <b>{{ $invoice->note }}</b>
									@if($invoice->jenis == "MUAT")
									<br />Tujuan/Gudang :{{ $invoice->client->name }} / {{ $invoice->ware->nama }}
									<br />Link Video : <a href="{{  asset('storage/images/video/' . $invoice->video1  . '') }}" target="_blank">{{ $invoice->video1 }} </a>
									@endif
									<br>
									Jumlah Par : <b>{{ number_format($invoice->modal) }} Par</b><br>
									Jumlah Tally : <b>{{ number_format($invoice->tally) }} Par</b><br>
									<br>
									Jumlah Produk Rusak : <br>
									Jumlah Produk Hilang : <br>

									
									<br>
									<br><b><u>Foto Segel dan Container <b></u><br><br>

									<table>
										<td class="item last3" widh="17%"></td>
										<td class="item last3" width="22%"> 
							
										@if($invoice->image1)
											<a href='{{  asset('storage/images/' . $invoice->image1 . '') }}' target="_blank"><img src={{ 'storage/images/' . $invoice->image1 . ''  }} width='115' height='50' halign='center'>
											<br></a><span class="item">
											@if($invoice->jenis == "BONGKAR")	
												<br>Sebelum Segel
											@else
												<br>Cont. Kosong
											@endif  
											</span>
										@endif  

										</td><td class="item last3" width="22%">

										@if($invoice->image3)
											<a href='{{  asset('storage/images/' . $invoice->image3 . '') }}' target="_blank"><img src={{ 'storage/images/' . $invoice->image3 . ''  }} width='115' height='50' halign='center'>
											<br></a><span class="item">
											@if($invoice->jenis == "BONGKAR")	
												<br>Sesudah Segel
											@else
												<br>Cont. Muat
											@endif  	
											</span>
										@endif  

										</td><td class="item last3" width="22%">

										@if($invoice->image2)
											<a href='{{  asset('storage/images/' . $invoice->image2 . '') }}' target="_blank"><img src={{ 'storage/images/' . $invoice->image2 . ''  }} width='115' height='50' halign='center'>
											<br></a><span class="item"><br>Foto Segel</span>
										@endif  
										</td>
										<td class="item last3" widh="17%"></td>
										</table>

										<br>===================================================================
										<br></b><i>Sertifikat ini legal dan memiliki nomor seri yang bersifat online dan bisa digunakan untuk <br>keperluan klaim asuransi dan lainnya</i>
										<br><br>
							</td>
							</tr>

							<tr>
							<td width="60%"></td>
							<td width="30%" class="item last4"> Pontianak, {{ $invoice->created_at->format('d M Y')  }},
								 <br> <br> <img src="data:image/png;base64, {!! $qrcode !!}"> <br>
								<br>{{ Auth::user()->member->name  }}
								</td>
							<td width="10%"></td>
							</tr>

							<tr><td colspan="3"><hr><i>{{ Auth::user()->member->name  }}, Address : {{ Auth::user()->member->address  }}, Telp : {{ Auth::user()->member->phone  }}</td></tr>
						</table>
					</td>
				</tr>
			</table>


				</tr>

			</table>
		</div>
	</body>
</html>
