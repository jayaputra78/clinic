<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pembayaran Upah - Per Mandor</title>
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
	header("Content-Disposition: attachment; filename=Lap Pembayaran Upah Detail-Mandor.xls");
	?>
 
	<center>
								@foreach ($judul as $row1)
										@php 
											$ju=$row1->kta;
											$ju2=$row1->name;
										@endphp
								@endforeach

									
									<h3>{{ $ju2 }}<br>LAPORAN PEMBAYARAN UPAH<br>PROYEK : {{ $ju }}</h3> 
	</center>
	<table border=1>
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
								<td colspan="1"><b>{{ @array_sum($hari_semua1) }}</td>
								<td colspan="1"><b>{{ @array_sum($pekerja_semua1) }}</td>
								<td colspan="1"><b>-</td>
								<td colspan="1"><b>{{ @array_sum($price_semua1) }}</td>
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
						<td width="5%" class="item3">{{ $row->hari }}</td>
						<td width="5%" class="item3">{{ $row->pekerja }}</td>	
						<td width="10%" class="item3">{{ $row->price }}</td>
                        <td width="10%" class="item3">{{ $row->price*$row->qty }}</td>
						<td width="10%" class="item3">{{ @array_sum($price_semua) }}</td>
						</tr>


                    @endforeach
                   

				<tr class="item">
                    <td colspan="7"></td>
                   
				</tr>


				<tr class="item last">
								<td colspan="4" class="item"><b>SUB TOTAL  {{ $dok }}</td>
								<td colspan="1"><b>{{ @array_sum($hari_semua1) }}</td>
								<td colspan="1"><b>{{ @array_sum($pekerja_semua1) }}</td>
								<td colspan="1"><b>-</td>
								<td colspan="1"><b>{{ @array_sum($price_semua1) }}</td>
								<td colspan="1"><b>-</td>
				</tr>

				<tr class="item">
                    <td colspan="7"></td>
                   
				</tr>

				<tr class="item last">
                    <td colspan="4" class="item"><b>TOTAL</td>
					<td colspan="1"><b>{{ @array_sum($hari_semua) }}</td>
					<td colspan="1"><b>{{ @array_sum($pekerja_semua) }}</td>
					<td colspan="1"><b>-</td>
					<td colspan="1"><b>{{ @array_sum($price_semua) }}</td>
					<td colspan="1"><b>-</td>
				</tr>


			</table>
</body>
</html>