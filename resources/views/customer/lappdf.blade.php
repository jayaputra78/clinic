<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Listing Supplier</title>

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
				max-width: 1200px;
				margin: auto;
				padding: 1px;
				border: 1px solid #eee;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
				font-size: 12px;
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
				line-height: 12px;
				padding-bottom: 0px;
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
                line-height: 14px;
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
					<td colspan="9">
						<table>
                            <tr>
                                <td colspan="2" align="center">
									<h3>
									{{ Auth::user()->member->name  }}<br>
									LISTING SUPPLIER<br>
                                    </h3> 
                            </tr>

						</table>
					</td>
				</tr>

				<tr class="heading">
					<td width="1%"  align="left">No</td>
                    <td width="20%" align="left">Nama</td>
                    <td width="40%" align="left">Alamat</td>
					<td width="10%" align="left">Telp</td>
					<td width="10%" align="left">Kota</td>
					<td width="10%" align="left">Kontak</td>
                    <td width="10%" class="left">Status</td>
				</tr>

                    @php $no = 1 @endphp
                    @foreach ($suppliers as $row)

						<tr class="item">
                        <td width="1%"  class="item">{{ $no++ }} </td>
                        <td width="20%" class="item">{{ $row->nama }}</td>
						<td width="40%" class="item">{{ $row->alamat }}</td>
                        <td width="10%" class="item">{{ $row->telp }}</td>
						<td width="10%" class="item">{{ $row->kota }}</td>
						<td width="10%" class="item">{{ $row->pic }}</td>
						<td width="10%" class="item">{{ $row->status }}</td>
						</tr>

                    @endforeach
                   
			</table>
		</div>
	</body>
</html>
