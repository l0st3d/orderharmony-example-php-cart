simpleCart.cartHeaders = [ "Name", "Price",  "decrement" , "Quantity" , "increment" , "Remove",  "Total" ];
simpleCart.checkoutTo = Custom;
simpleCart.customCheckout = function(form) {
	alert(form.find('input[name=email]').val());
};