
const selectExistingProduct = (event) => {
	const product = JSON.parse(event.target.value);
	
	const newProductInputs = document.getElementById('newProductData');
	newProductInputs.style.display = 'none';
	document.getElementById('newProductCheckBox').checked = false;
	
	const productInputs = document.getElementById('existingProductData');
	productInputs.style.display = 'block';
	
	document.getElementById('name').value = product.name;
	document.getElementById('description').value = product.description;
	document.getElementById('unit_price').value = product.unit_price.toFixed(2);
	document.getElementById('unit').value = product.unit;
	document.getElementById('tax').value = (product.tax * 100).toFixed(2);
	document.getElementById('id').value = product.id;
	
};

const newProduct = (event) => {
	
	const newProductInputs = document.getElementById('newProductData');
	
	if(event.target.checked == true) {
		const productInputs = document.getElementById('existingProductData');
		productInputs.style.display = 'none';
		
		document.getElementById('existingProduct').value = 'begin';
		newProductInputs .style.display = 'block';
	}
	else if(event.target.checked == false) {
		newProductInputs .style.display = 'none';
	}
};
