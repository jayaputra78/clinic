<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pemakaian Bahan - Detail Per PO</title>
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
	header("Content-Disposition: attachment; filename=Lap Pemakaian Bahan Detail-PO.xls");
	?>
 
	<center>
								@foreach ($judul as $row1)
										@php 
											$ju=$row1->kta;
											$ju2=$row1->name;
										@endphp
								@endforeach

									
									<h3>{{ $ju2 }}<br>LAPORAN PEMAKAIAN BAHAN<br>PROYEK : {{ $ju }}</h3> 
	</center>
	<table border=1>
	<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="12%" align="left">Tanggal</td>
                    <td width="8%" align="left">No PO</td>
					<td width="49%" align="left">Product</td>
					<td width="10%" align="heading2">Qty</td>
					<td width="10%" class="heading2">Harga</td>	
					<td width="10%" class="heading2">Total</td>				
				</tr>

                    @php 
						$no = 1; 
						$dok = 'awal'; 
						$qty_semua1[]=0;
						$price_semua1[]=0;	
					@endphp
                    @foreach ($invoice_detail as $row)

						@if (($dok <> $row->doinvoice_id) && ($dok <> 'awal'))
							@if ($qty_semua1 > 0) 

								<tr class="item last">
								<td colspan="2" class="item"></td>

								<td colspan="1" class="item">
									
          

								</td>

								<td colspan="1" class="item">
									@if ($gambar <> "")
                                    	<a href="{{  asset('storage/images/' . $gambar . '') }}" target="_blank"><b>Sub Total</a></td>
									@else
										<b>Sub Total</td>
                                    @endif 
								
								<td colspan="1"><b>{{ @array_sum($qty_semua1) }}</td>
								<td colspan="1"><b>-</td>
								<td colspan="1"><b>{{ @array_sum($price_semua1) }}</td>
								</tr>
							@endif
							@php
								$qty_semua1=[];
								$price_semua1=[];
								
							@endphp
						@endif

						@php
							$price=$row->price;
							$qty_semua[]=$row->qty;
							$price_semua[]=$row->price*$row->qty;
							$qty_semua1[]=$row->qty;
							$price_semua1[]=$row->price*$row->qty;
							$tgl = date('d M Y', strtotime( $row->tanggal ));
							$dok = $row->doinvoice_id;
							$gambar = $row->doinvoice->image1;
						@endphp
						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="12%" class="item">{{ $tgl }}</td>
						<td width="8%" class="item">{{ $row->doinvoice->id }}</td>
						<td width="49%" class="item">{{ $row->product->description }}</td>
						<td width="10%" class="item3">{{ $row->qty }}</td>
						<td width="10%" class="item3">{{ $row->price }}</td>
                        <td width="10%" class="item3">{{ $row->price*$row->qty }}</td>
						</tr>


                    @endforeach
                   


				<tr class="item last">
								<td colspan="4" class="item"><b>
									@if ($gambar <> "")
										<b><a href="{{  asset('storage/images/' . $gambar . '') }}" target="_blank">Sub Total</a></td>
									@else
										<b>Sub Total</td>
                                    @endif 
								</td>
								<td colspan="1"><b>{{ @array_sum($qty_semua1) }}</td>
								<td colspan="1"><b>-</td>
								<td colspan="1"><b>{{ @array_sum($price_semua1) }}</td>
				</tr>


				<tr class="item last">
                    <td colspan="4" class="item"><b>TOTAL</td>
					<td colspan="1"><b>{{ @array_sum($qty_semua) }}</td>
					<td colspan="1"><b>-</td>
					<td colspan="1"><b>{{ @array_sum($price_semua) }}</td>
				</tr>


			</table>
</body>
</html>