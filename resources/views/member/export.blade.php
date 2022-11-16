<!DOCTYPE html>
<html>
<head>
	<title>Export Project</title>
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
	header("Content-Disposition: attachment; filename=project.xls");
	?>
 

 	<center>
		<h4>{{ Auth::user()->member->name  }}<br> Listing Project</h4>
	</center>

	<table border="1">
	<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="25%" align="left">Project</td>
                    <td width="25%" align="left">Perusahaan</td>
					<td width="10%" align="left">LOkasi</td>
					<td width="10%" align="left">Pengurus</td>
					<td width="10%" align="left">Nilai</td>
					<td width="10%" align="left">Biaya</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($members as $row)

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="25%" class="item">{{ $row->kta }}</td>
						<td width="25%" class="item">{{ $row->name }}</td>
						<td width="10%" class="item">{{ $row->address }}</td>
						<td width="10%" class="item">{{ $row->pengurus}}</td>
						<td width="10%" class="item3">{{ number_format($row->nilai/1000000) }}</td>
						<td width="10%" class="item3">{{ number_format($row->biaya/1000000) }}</td>
						</tr>

                    @endforeach
                   
			</table>
</body>
</html>