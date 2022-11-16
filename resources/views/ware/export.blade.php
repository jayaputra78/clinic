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
	header("Content-Disposition: attachment; filename=GudangTujuan.xls");
	?>
 

 	<center>
		<h4>{{ Auth::user()->member->name  }}<br> Listing Gudang</h4>
	</center>

	<table border="1">
	<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="40%" align="left">Nama Gudang</td>
                    <td width="10%" align="left">Status</td>
					<td width="30%" align="left">Keterangan</td>
					<td width="20%" align="left">Member</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($warehouses as $row)

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="40%" class="item">{{ $row->nama }}</td>
						<td width="10%" class="item">{{ $row->status }}</td>
                        <td width="30%" class="item">{{ $row->keterangan }}</td>
						<td width="20%" class="item">{{ $row->member->kta }}</td>
						</tr>

                    @endforeach
                   
			</table>
</body>
</html>