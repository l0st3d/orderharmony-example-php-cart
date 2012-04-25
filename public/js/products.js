$(document).ready(function() {
	$.getJSON('http://orderharmony.cloudcontrolled.com/index.php', function(data) {

		//First add all the rows
		$('#products').append('<ul class="thumbnails" id="products-list"></ul>');

		//Add All the products
		$.each(data.products, function(key, val) {

			//Add product holder
			$('#products-list').append('<li class="span4" id="product-'+key+'"></li>');
			var product = $('#product-'+key);

			//Add product content
			product.append(' \
				<div class="class="thumbnail"> \
					<div class="caption"> \
						<h5>'+val.product.name+'</h5> \
					</div> \
					<img src="http://placehold.it/360x268" alt=""> \
					<div class="caption" style="height: 150px;"> \
						<p>'+ val.product.description +' </p> \
						<p> \
							<a href="javascript:;" onclick="simpleCart.add( \'name='+ val.product.name +'\' , \'price=35.95\' , \'quantity=1\' );" class="btn btn-success"> \
								<i class="icon-plus-sign icon-white"></i> Add \
							</a> \
						</p> \
					</div> \
				<div>');
		});

		//Remove the loader
		$('#products-loader').remove();
		$('#products-loader-header').remove();
	})
	.error(function() { alert("error"); });

 });