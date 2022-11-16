<!DOCTYPE html>
<html>
<head>
	<title>Export User</title>
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
	header("Content-Disposition: attachment; filename=user.xls");
	?>
 

 	<center>
		<h4>{{ Auth::user()->member->name  }}<br> Listing User</h4>
	</center>

	<table border="1">
				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="20%" align="left">Nama</td>
                    <td width="20%" align="left">Username</td>
					<td width="40%" align="left">Project</td>
					<td width="20%" align="left">Level</td>

				</tr>

                    @php $no = 1 @endphp
                    @foreach ($users as $row)

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="20%" class="item">{{ $row->name }}</td>
						<td width="20%" class="item">{{ $row->email }}</td>
                        <td width="40%" class="item">{{ $row->member->kta }}</td>
						<td width="20%" class="item">
							@if ($row->level == 1 ) 
								Admin
							@elseif	($row->level == 2 ) 
								Owner
							@elseif	($row->level == 3 ) 
								Manager
							@elseif	($row->level == 4 ) 
								Keuangan
							@elseif	($row->level == 5 ) 
								Operator
							@elseif	($row->level == 6 ) 
								Upah
							@elseif	($row->level == 7 ) 
								Peralatan
							@elseif	($row->level == 8 ) 
								Admin Proyek
							@endif
						</td>
						
						</tr>

                    @endforeach
                   
			</table>
</body>
</html>