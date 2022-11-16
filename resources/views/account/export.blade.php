<!DOCTYPE html>
<html>
<head>
	<title>Export Cashier</title>
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
	header("Content-Disposition: attachment; filename=Kode Rekening.xls");
	?>
 

 	<center>
		<h4>{{ Auth::user()->member->name  }}<br> Listing Kode Kasir</h4>
	</center>

	<table border="1">
				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="10%" align="left">Kode</td>
                    <td width="30%" align="left">Rekening</td>
					<td width="30%" align="left">Group</td>
					<td width="20%" align="left">Kelompok</td>
					<td width="10%" align="left">Saldo</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($accounts as $row)

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="10%" class="item">{{ $row->account }}</td>
						<td width="30%" class="item">{{ $row->keterangan }}</td>
                        <td width="30%" class="item">{{ $row->chart->keterangan }}</td>
						<td width="20%" class="item">
							@if ($row->kelompok == 1 ) 
								AKTIVA
							@elseif	($row->kelompok == 2 ) 
								PASSIVA
							@elseif	($row->kelompok == 3 ) 
								MODAL
							@elseif	($row->kelompok == 4 ) 
								PENDAPATAN
							@elseif	($row->kelompok == 5 ) 
								BIAYA
							@elseif	($row->kelompok == 51 ) 
								BIAYA
							@elseif	($row->kelompok == 6 ) 
								BIAYA
							@endif
						</td>
						<td width="10%" class="item3">{{ number_format($row->akhir) }}</td>
						</tr>

                    @endforeach
                   
			</table>
</body>
</html>