<!DOCTYPE html>
<html>
<head>
	<title>Export Kategori</title>
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
	header("Content-Disposition: attachment; filename=product.xls");
	?>
 

 	<center>
		<h4>{{ Auth::user()->member->name  }}<br> Listing Product</h4>
	</center>

	<table border="1">
	<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="10%" align="left">Kode</td>
                    <td width="80%" align="left">Nama Product</td>
					<td width="10%" align="left">Satuan</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($group as $row)

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="10%" class="item">{{ $row->title }}</td>
						<td width="80%" class="item">{{ $row->description }}</td>
						<td width="10%" class="item">{{ $row->satuan }}</td>
						</tr>

                    @endforeach
                   
			</table>
</body>
</html>