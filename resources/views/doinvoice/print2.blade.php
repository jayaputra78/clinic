<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Cetal Kwitansi</title>

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
				border-top: 1px solid #ddd;
				font-weight: bold;
                text-align: left;
				background-color: #ebe8eb;
			}

            .invoice-box table tr td.heading2 {
				
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                text-align: right;
			}

			.invoice-box table tr td.heading2a {
				
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                text-align: left;
				
			}

			.invoice-box table tr td.heading2b {
				
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                text-align: left;
				background-color: #ebe8eb;
			}

			.invoice-box table tr.heading3 td {
				
				border-bottom: 1px solid #ddd;
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

			.invoice-box table tr td.item4 {
				border-bottom: 0px solid #eee;
				text-align: center;
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

			.invoice-box table tr td.item.last4 {
				border-bottom: none;
                line-height: 10px;
                border-top: 1px solid #ddd;
                text-align: center;
               
			}

			.invoice-box table tr.total td {
				border-top: 1px solid #eee;
                line-height: 18px;
				
				border-bottom: 1px solid #ddd;
				font-weight: bold;
                text-align: right;
				background-color: #ebe8eb;
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
                                <td colspan="3" align="left">
									<?php $stat = $doinvoice->status; ?>
									<h3>{{ Auth::user()->member->name  }}</h3>
									@if ($stat == "ACC") 
                                    	<h1>KWITANSI {{ $doinvoice->jenis }} </h1> 
									@else
										<h1>PERMINTAAN {{ $doinvoice->jenis }}</h1> 
									@endif
                                    <h3>No. #00{{ $doinvoice->id }}/{{ $bln }}.AN/{{ $thn }}  </h3> 
                            </tr>
                            <tr>
								<td width="25%">Telah Terima Dari </td>
								<td width="2%">: </td>
								<td width="73%" class="heading2a">{{ $doinvoice->supplier->nama }}</td>
							</tr>

							<tr>
								<td width="25%">Banyaknya Uang Rp </td>
								<td width="2%">: </td>
								<td width="73%" class="heading2b"># Rp. {{ number_format($doinvoice->total) }} #</td>
							</tr>


							<tr>
								<td width="25%">Terbilang </td>
								<td width="2%">: </td>
								<td width="73%" class="heading2a">								
									
								<?php echo "#".terbilang($doinvoice->total)." Rupiah #";

									function terbilang($angka){

										$bilne=array("","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan","Sepuluh","Sebelas");

										if($angka < 12){

											return " ".$bilne[$angka];

											

										}elseif ($angka < 20){

											return terbilang($angka - 10) . "Belas";

										}elseif ($angka < 100){

											return terbilang($angka / 10) . " Puluh" . terbilang($angka % 10);

										}elseif ($angka < 200){

											return " seratus" . terbilang($angka - 100);

										}elseif ($angka < 1000){

											return terbilang($angka / 100) . " Ratus" . terbilang($angka % 100);

										}elseif ($angka < 2000){

											return " seribu" . terbilang($x - 1000);

										}elseif ($angka < 1000000){

											return terbilang($angka / 1000) . " Ribu" . terbilang($angka % 1000);

										}elseif ($angka < 1000000000){

											return terbilang($angka / 1000000) . " Juta" . terbilang($angka % 1000000);

										}elseif ($angka < 1000000000000){

											return terbilang($angka / 1000000000) . " Milyar" . terbilang(fmod($angka,1000000000));

										}elseif ($angka < 1000000000000000) {

											return terbilang($angka/1000000000000) . " Trilyun" . terbilang(fmod($angka,1000000000000));

										}    
									}

									?>
								</td>
							</tr>

							<tr>
								<td width="25%">Untuk Pembayaran </td>
								<td width="2%">: </td>
								<td width="73%" class="heading2a">{{ $doinvoice->note }} {{ Auth::user()->member->kta  }}</td>
							</tr>

						</table>
					</td>
				</tr>

				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="59%" align="left">Keterangan /Pekerjaan /Persen</td>
                    <td width="10%" class="heading2">Pekerja</td>
					<td width="10%" class="heading2">Hari</td>
					<td width="10%" class="heading2">Upah</td>
                    <td width="10%" class="heading2">Total</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($doinvoice->detail as $row)
					

                        @php
							$qty=$row->qty;
							$price=$row->price;
							
							$qty_semua[]=$row->qty;
							$price_semua[]=$row->price;
							$pekerja_semua[]=$row->pekerja;
							$hari_semua[]=$row->hari;
							$saldo_semua[]=$row->qty*$row->price;
						@endphp

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="59%" class="item">{{ $row->product->description }}  <br>{{ $row->pekerjaan }} ( {{ $row->persen }} % )
                                @if($row->image1)
			 						<br><br><a href='{{  asset('storage/images/' . $row->image1 . '') }}' target="_blank"><img src={{ 'storage/images/' . $row->image1 . ''  }} width='20' height='20' halign='center'></a>
		 						@endif
                                 @if($row->image2)
									<a href='{{  asset('storage/images/' . $row->image2 . '') }}' target="_blank"><img src={{ 'storage/images/' . $row->image2 . ''  }} width='20' height='20' halign='center'></a>
								@endif   
                        </td>
                        <td width="10%" class="item3">{{ number_format($row->pekerja) }}</td>
						<td width="10%" class="item3">{{ number_format($row->hari)  }}</td>
						<td width="10%" class="item3">{{ number_format($row->price) }}</td>
                        <td width="10%" class="item3">{{ number_format($row->price*$row->qty) }}</td>
						</tr>
                    @endforeach
                   
				@if ($no < 8)

					<tr class="item">
						<td width="1%"  align="left">.</td>
						<td width="59%" align="left"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
					</tr>
					@php $no = $no+1 @endphp

				@endif

				@if ($no < 8)

					<tr class="item">
						<td width="1%"  align="left">.</td>
						<td width="59%" align="left"></td>
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
						<td width="59%" align="left"></td>
						<td width="10%" align="left"></td>
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
						<td width="59%" align="left"></td>
						<td width="10%" align="left"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
						<td width="10%" class="item"></td>
					</tr>
					</tr>
					@php $no = $no+1 @endphp

				@endif


                <tr class="total">
					<td colspan="2" class="item3"> Total</td>
					<td class="item3">{{ number_format(@array_sum($pekerja_semua))  }}</td>
					<td class="item3">{{ number_format(@array_sum($hari_semua))  }}</td>
                    <td class="item3"></td>
					<td class="item3">{{ number_format(@array_sum($saldo_semua)) }}</td>

				</tr>
				</table>
				<table>
                <tr class="item last4">
					<!--
					<td colspan="1" class="item4" width="33%"><br><br>Dibuat Oleh, <br><br> <img src="data:image/png;base64, {!! $qrcodepembuat !!}"><br><br> ( {{  $doinvoice->user->name }} ) </td>
					<td colspan="1" class="item4" width="33%"><br><br>Diketahui Oleh, <br> <br> <img src="data:image/png;base64, {!! $qrcodeacc !!}"> <br><br> ( {{ $doinvoice->member->pengurus }} ) </td>
					<td colspan="1" class="item4" width="33%"><br>{{ $doinvoice->supplier->kota  }}, {{ $doinvoice->created_at->format('d M Y')  }}<br> Penerima, <br> <br> <img src="data:image/png;base64, {!! $qrcodepenerima !!}"> <br><br> ( {{ $doinvoice->supplier->nama }} )</td>
								-->
					<td colspan="1" class="item4" width="33%"><br><br>Dibuat Oleh, <br><br> <img src="data:image/png;base64, {!! $qrcodepembuat !!}"><br><br> ( {{  $doinvoice->user->name }} ) </td>
					<td colspan="1" class="item4" width="33%"><br><br>Diketahui Oleh, <br> <br>  <br><br> <br><br>( {{ $doinvoice->member->pengurus }} ) </td>
					<td colspan="1" class="item4" width="33%"><br>{{ $doinvoice->supplier->kota  }}, {{ $doinvoice->created_at->format('d M Y')  }}<br> Penerima, <br> <br> <br><br><br><br> ( {{ $doinvoice->supplier->nama }} )</td>

				</tr>

			</table>
		</div>
	</body>
	<script type="text/javascript">
		function inputTerbilang() {
		//membuat inputan otomatis jadi mata uang
		$('.mata-uang').mask('0.000.000.000', {reverse: true});

		//mengambil data uang yang akan dirubah jadi terbilang
		var input = document.getElementById("terbilang-input").value.replace(/\./g, "");

		//menampilkan hasil dari terbilang
		document.getElementById("terbilang-output").value = terbilang(input).replace(/  +/g, ' ');
		} 
	</script>
</html>
