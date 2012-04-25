jQuery.validator.setDefaults({
	errorClass: "help-inline",
	errorElement: "span",
	errorPlacement: function(error, element) {
		error.appendTo( element.parent("div"));
		element.parent("div").removeClass("success");
		element.parent("div").addClass("error");
	},
	success: function(label) {
		label.parent("div").removeClass("error");
		label.parent("div").addClass("success");
	},
	submitHandler: function(form) {
		alert(form);
	   //simpleCart.checkout(form);
	}
});

$(document).ready(function() {
	$("#addressForm").validate();
 });