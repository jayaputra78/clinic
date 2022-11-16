<!DOCTYPE html>
<html>
<head>
	<title>Export Supplier</title>
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
	header("Content-Disposition: attachment; filename=Supplier.xls");
	?>
 

 	<center>
		<h4>{{ Auth::user()->member->name  }}<br> Listing Nama Supplier </h4>
	</center>

	<table border="1">
		<tr>
			<th>id</th>
			<th>nama</th>
			<th>alamat</th>
			<th>telp</th>
			<th>kota</th>
			<th>kontak</th>
			<th>status</th>
		</tr>
		
		@php $no = 1 @endphp
        @foreach ($suppliers as $row)					
						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="14%" class="item">{{ $row->nama }}</td>
                        <td width="30%" class="item">{{ $row->alamat }}</td>
						<td width="30%" class="item">{{ $row->telp }}</td>
						<td width="15%" class="item3">{{ $row->kota }}</td>
                        <td width="15%" class="item3">{{ $row->pic }}</td>
						<td width="15%" class="item3">{{ $row->status }}</td>
						</tr>
        @endforeach 

	</table>
</body>
</html>