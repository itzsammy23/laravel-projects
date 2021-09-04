<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		 <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
	</head>

	<body>
		<div class="form__holder">
			<form method="post" action="" role="form" id="productForm">
				<div class="input__group">
					<input type="text" class="form__field" name="product_name" placeholder="Product name">
				</div>

				<div class="input__group">
					<input type="text" class="form__field" name="quantity" placeholder="Quantity in stock">
				</div>

				<div class="input__group">
					<input type="text" class="form__field" name="price" placeholder="Price per item">
				</div>

				<button type="submit" class="button button__blue" id="submitButton">SUBMIT</button>
			</form>
		</div>

		<div class="table__container">
			<table>
				<thead>
					<tr>
						<th>Product name</th>
						<th>Quantity in stock</th>
						<th>Price per item</th>
						<th>Date submitted</th>
						<th>Total value</th>
						<th></th>
					</tr>
				</thead>

				<tbody>

				</tbody>
			</table>
		</div>

		<div class="edit__form">
			<form method="post" action="" role="form" id="editForm">
				<div class="flex__group">
					<div class="input__group">
						<label>Product name</label>
						<input type="text" class="form__field" name="product_name" >
					</div>

					<div class="input__group">
						<label>Quantity in stock</label>
						<input type="text" class="form__field" name="quantity">
					</div>
				</div>

				<div class="input__group">
					<label>Price per item</label>
					<input type="text" class="form__field" name="price">
				</div>

				<input type="hidden" name="array_index" id="arrayIndex" value="">

				<div class="button__container">
					<button type="submit" class="button button__blue" id="editButton">Update</button>
					<button class="button button__red__alt" id="cancelEdit">Cancel</button>
				</div>
			</form>
		</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/processor.js') }}"></script>
	</body>
</html>