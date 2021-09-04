var edited_index;

$(document).ready(function () {
	//console.log("Ready");

	$.get("/get", function (response) {
		var response_data = response.data;
			if(response_data === null) {
				$("table").hide();
			} else{
				loadItems(response_data)

			}
	})

	$("#submitButton").click(function (e) {
		e.preventDefault();

		var form = $("#productForm");
		var fields = $("#productForm .form__field");
		var null_fields = checkForEmptyField(fields);

		if(null_fields.length === 0) {
			//console.log("Form filled")

			$.ajax({
				headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
				method: 'post',
				url: "/add",
				data: form.serialize(),
				success: function (response) {
					$("table tbody").html("");
						fields.val("")
						var items = response.data;

						loadItems(items)


				}
			})
		} 
	})


	$(document).on("click", ".edit__field", function () {
		var parent_index = $(this).parent().data("index");
		var index = $(".data__row").index($(this).parent());
		edited_index = index;

		var data_editable = $(".data__row").eq(index).find("td");
		var edit_fields = $("#editForm .form__field");

		for (var i = 0; i < 3; i++) {
			edit_fields.eq(i).val(data_editable.eq(i).text())
		}

		$("#arrayIndex").val(parent_index);
		$(".edit__form").show();

		$("html, body").animate({scrollTop: $(document).height()}, 800)
	})

	$("#editButton").click(function (e) {
		e.preventDefault();

		var form = $("#editForm");
		var fields = $("#editForm .form__field");
		var null_fields = checkForEmptyField(fields);

		if(null_fields.length === 0) {
			//console.log("Form filled")

			$.ajax({
				headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
				method: 'patch',
				url: "/edit",
				data: form.serialize(),
				success: function (response) {
					//console.log(response)
					$("table tbody").html("");
						var items = response.data;

						loadItems(items)

						hideEditForm()
				}
			})
		} 
	})

	$("#cancelEdit").click(function (e) {
			e.preventDefault();

			hideEditForm()
			
	})
})

function loadItems(items) {
		var main_total = 0;
		for (var i = items.length - 1; i >= 0; i--) {
				var product_name = items[i].name, in_stock = parseInt(items[i].quantity_in_stock),
				 price = parseFloat(items[i].price), date_submitted = items[i].date_submitted,
				 total_value = in_stock * price.toFixed(2);

				 $("table tbody").append(`
				 		<tr class="data__row" data-index="${i}">
				 			<td>${product_name}</td>
				 			<td>${in_stock}</td>
				 			<td>${price.toFixed(2)}</td>
				 			<td>${date_submitted}</td>
				 			<td>${total_value.toFixed(2)}</td>
				 			<td class="edit__field">Edit</td>
				 		</tr>
				 	`)

				 main_total += total_value;
		}
		//console.log(main_total)

		$("table tbody").append(`
				 		<tr>
				 			<td></td>
				 			<td></td>
				 			<td></td>
				 			<td>Total value:</td>
				 			<td>${main_total.toFixed(2)}</td>
				 			<td></td>
				 		</tr>
				 	`)

		//console.log(items)

		$("table").show();
}

function checkForEmptyField(fields) {
	var array = []
	for (var i = 0; i < fields.length; i++) {
		if (fields.eq(i).val() === "") {
					array[0] = i;
		}
	}

	return array;
}

function hideEditForm() {
	$(".edit__form").hide();
			$(".edit__form .form__field").val("")

			$("html, body").animate({scrollTop: $(".data__row").eq(edited_index).scrollTop()}, 800)
}
