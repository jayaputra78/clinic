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
                                    <h1>BERITA ACARA {{ $invoice->jenis }}</h1> 
                                    <h3>{{ Auth::user()->member->name  }}</h3> 
                            </tr>
                            <tr>
								<td>
									No BA : #{{ $invoice->nodo }}<br/>
									Tanggal  : {{ $invoice->created_at->format('d M Y')  }} <br />
									No Container : {{ $invoice->note }} - {{ $invoice->jenis }}
								</td>

								<td>
									Kepada : {{ $invoice->customer->name }}<br />
									No Telp : {{ $invoice->customer->phone }} <br />
									Alamat : {{ $invoice->customer->address }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="14%" align="left">Kode</td>
                    <td width="55%" align="left">Nama</td>
                    <td width="10%" class="heading2">Qty</td>
					<td width="10%" class="heading2">Kemasan (Kg)</td>
					<td width="10%" class="heading2">Total (Kg)</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($invoice->detail as $row)
						
						@php $status1 = $row->status; @endphp
						
						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="14%" class="item">{{ $row->product->title }}</td>
						
						@if ( $status1 == "RUSAK" )
                                            <td width="55%" class="item">{{ $row->product->description }} ( {{ $row->status }} )  
                                            <br><br>

                                               <a href='{{  asset('storage/images/' . $row->image1 . '') }}' target='_blank'>_
                                                <img src="{{  asset('storage/images/' . $row->image1 . '') }}" id="gambar_upload1" alt="..." class="profile.img_1" width='50' height='40' halign='center'>
                                                </a>

                                                <a href='{{  asset('storage/images/' . $row->image2 . '') }}' target='_blank'>_
                                                <img src="{{  asset('storage/images/' . $row->image2 . '') }}" id="gambar_upload2" alt="..." class="profile.img_2" width='50' height='40' halign='center'>
                                                </a>                                            
                                            </td>
                        @else 
                                            <td width="55%" class="item">{{ $row->product->description }} </td>
                        @endif

						</td>
                        <td width="10%" class="item3">{{ $row->qty }}</td>
						<td width="10%" class="item3">{{ number_format($row->berat) }}</td>
						<td width="10%" class="item3">{{ number_format($row->qty*$row->berat) }}</td>
                       <!-- <td width="15%" class="item3">
								@if($row->image1)
			 						<a href='{{  asset('storage/images/' . $row->image1 . '') }}' target="_blank"><img src={{ 'storage/images/' . $row->image1 . ''  }} width='20' height='20' halign='center'></a>
		 						@endif
						</td>
                        <td width="15%" class="item3">
								@if($row->image2)
									<a href='{{  asset('storage/images/' . $row->image2 . '') }}' target="_blank"><img src={{ 'storage/images/' . $row->image2 . ''  }} width='20' height='20' halign='center'></a>
								@endif   
						</td> -->
						</tr>
                    @endforeach
                   
				@if ($no < 8)

					<tr class="item">
						<td width="1%"  align="left">.</td>
						<td width="14%" align="left"></td>
						<td width="55%" align="left"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
					</tr>
					@php $no = $no+1 @endphp

				@endif

				@if ($no < 8)

					<tr class="item">
						<td width="1%"  align="left">.</td>
						<td width="14%" align="left"></td>
						<td width="55%" align="left"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
					</tr>
					</tr>
					@php $no = $no+1 @endphp

				@endif


				@if ($no < 8)

					<tr class="item">
						<td width="1%"  align="left">.</td>
						<td width="14%" align="left"></td>
						<td width="55%" align="left"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
					</tr>
					</tr>
					@php $no = $no+1 @endphp

				@endif


				@if ($no < 8)

					<tr class="item">
						<td width="1%"  align="left">.</td>
						<td width="14%" align="left"></td>
						<td width="55%" align="left"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
					</tr>
					</tr>
					@php $no = $no+1 @endphp

				@endif


                <tr class="total">
					<td colspan="3" class="item3"> Total</td>
					<td class="item3">{{ number_format($invoice->modal) }}</td>
					<td class="item3"></td>
					<td class="item3">{{ number_format($invoice->berat) }}</td>
				</tr>

                <tr class="item last">
        <!--            <td colspan="2" class="item last3">Diterima Oleh, <br><br><br><br><br><br>( ............ )</td>
					<td colspan="2" class="item last3"> Dikirim Oleh, <br><br><br><br><br><br>( ............ )</td> -->
					<td class="item" colspan="4"> 

					<table>
					<td class="item" width="22%"> 
		
					@if($invoice->image1)
						<a href='{{  asset('storage/images/' . $invoice->image1 . '') }}' target="_blank"><img src={{ 'storage/images/' . $invoice->image1 . ''  }} width='115' height='50' halign='center'>
						<br></a><span class="item">Sebelum Segel</span>
					@endif  

					</td><td class="item3" width="22%">

					@if($invoice->image3)
						<a href='{{  asset('storage/images/' . $invoice->image3 . '') }}' target="_blank"><img src={{ 'storage/images/' . $invoice->image3 . ''  }} width='115' height='50' halign='center'>
						<br></a><span class="item">Sesudah Segel</span>
					@endif  

					</td><td class="item3" width="22%">

					@if($invoice->image2)
						<a href="{{ asset('storage/images/' . $invoice->image2 . '') }}" target="_blank"><img src="{{ 'storage/images/' . $invoice->image2 . ''  }}" width="115" height="50" halign="center">
						<br></a><span class="item">Segel</span>
					@endif  
					</td>
					</table>
				<!--	<td colspan="2"> -->
					<td colspan="2" class="item last4"> Pengirim : <br> <br> <img src="data:image/png;base64, {!! $qrcode !!}"> <br></td>	
				<!--	Dihitung Oleh, <br><br><br><br><br><br>( ............ )</td> -->
				</tr>

			</table>
		</div>
	</body>
</html>
