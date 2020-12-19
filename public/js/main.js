
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

var itemCounters = 0;
var toPay = 0;

const addItem = () => {
	const item = document.getElementById('item');
	const newItem = item.cloneNode( true );
	item.style.display = 'block';
	
    item.setAttribute( 'id', 'item' + itemCounters);
    
    document.getElementById('unitPrice').setAttribute('id', 'unitPrice' + itemCounters);
    document.getElementById('selectedProduct').setAttribute('id', 'selectedProduct' + itemCounters);
    document.getElementById('count').setAttribute('id', 'count' + itemCounters);
    document.getElementById('unit').setAttribute('id', 'unit' + itemCounters);
    document.getElementById('fullNet').setAttribute('id', 'fullNet' + itemCounters);
    document.getElementById('vat').setAttribute('id', 'vat' + itemCounters);
    document.getElementById('fullVat').setAttribute('id', 'fullVat' + itemCounters);
    document.getElementById('fullItemCost').setAttribute('id', 'fullItemCost' + itemCounters);

    item.after(newItem);
    
    itemCounters += 1;
};

const subtractItem = (event) => {
	const parentId = event.originalTarget.parentElement.id;
	document.getElementById(parentId).remove();
	total();
};

const customerType = (event) => {
	const customer = document.getElementById('customer');
	const company = document.getElementById('company');
	const label = document.getElementById('customerSwitchLabel');
	
	if(event.target.checked == true) {
		company.style.display = 'none';
		customer.style.display = 'block';
		label.innerHTML = 'firma'
		
		document.getElementById('address').value = '';
		document.getElementById('name').value = '';
		document.getElementById('nip').value = '';
	}
	else if(event.target.checked == false) {
		company.style.display = 'block';
		customer.style.display = 'none';
		label.innerHTML = 'osoba prywatna'
		
		document.getElementById('personalAddress').value = '';
		document.getElementById('first_name').value = '';
		document.getElementById('last_name').value = '';
	}
};

const selectIssuer = (data=null) => {
	let issuerData = null;
	
	if(data) {
		issuerData = JSON.parse(data);
	}
	else {
		issuerData = JSON.parse(event.target.value);
	}
	
	const issuer = document.getElementById('issuerInfo');
	issuer.innerHTML = issuerData.name + '<br /><u>NIP</u>: '+ issuerData.nip + '<br /><u>adres</u>: ' 
		+ issuerData.address + '<br /><u>tel</u>.: +' + issuerData.telephone ;
};

const selectItem = (data, number=null) => {
	const product = JSON.parse(data);
	if(!number) {
		number = event.target.attributes.id.textContent.slice(15, );
	}

	document.getElementById('unitPrice' + number).innerHTML = '' + product.unit_price.toFixed(2) + ' PLN';
	
	document.getElementById('unit' + number).innerHTML = product.unit;
	
	const count = document.getElementById('count' + number);
	count.style.display = 'block';
	count.value = 1;
	
	document.getElementById('vat' + number).innerHTML = '' + (product.tax * 100).toFixed(2) + '%';

	document.getElementById('fullNet' + number).innerHTML = '' + product.unit_price.toFixed(2) + ' PLN';
	
	document.getElementById('fullVat' + number).innerHTML = 
		'' + (product.unit_price * product.tax).toFixed(2) + ' PLN';
		
	document.getElementById('fullItemCost' + number).innerHTML = 
		'' + (product.unit_price + product.unit_price * product.tax).toFixed(2) + ' PLN';
};

const changeQuantity = (event) => {
	const number = event.target.id.slice(5, );
	const product = JSON.parse(document.getElementById('selectedProduct' + number).value);
	
	document.getElementById('fullNet' + number).innerHTML = '' + (event.target.value * product.unit_price).toFixed(2) + ' PLN';
	
	document.getElementById('fullVat' + number).innerHTML = 
		'' + (event.target.value * product.unit_price * product.tax).toFixed(2) + ' PLN';
		
	document.getElementById('fullItemCost' + number).innerHTML = 
		'' + ((product.unit_price + product.unit_price * product.tax) * event.target.value).toFixed(2) + ' PLN';
};

const isNum = (num) => { 
	return !isNaN(parseFloat(num)) && !isNaN(num - 0) 
};

const total = () => {
	const items = document.getElementById('items').children;
	let sum = 0;
	
	for (let item of items) {
        if(item.children[1]) {
       		const text = item.children[1].children[3].children[1].innerText
       		if(text) {
       			sum += parseFloat(text.slice(0, -4))
       		}
       	}
    }

	const deliveryCost = document.getElementById('delivery').value;
	if(isNum(deliveryCost)) {
		sum += parseFloat(deliveryCost);
	}
	
    document.getElementById('totalCost').innerHTML = ' <u>Do zapłaty BRUTTO</u>: ' + sum.toFixed(2) + ' PLN';
};

const showInvoice = (event) => {
	const invoice = JSON.parse(event.target.value);
	
	document.getElementById('selectedInvoice').style.display = 'block';
	document.getElementById('invoiceDel').style.display = 'block';
	document.getElementById('removedInvoiceCode').value = invoice.code;
	
	document.getElementById('sellerMain').innerHTML = invoice.issuer.name + '<br /> NIP: ' + invoice.issuer.nip + 
		'<br />' + invoice.issuer.address + '<br /> tel.: ' + invoice.issuer.telephone;
	
	const buyer = (invoice.name ? invoice.name + '<br />NIP: ' + invoice.nip : invoice.first_name + ' ' + invoice.last_name);
	document.getElementById('buyerMain').innerHTML = buyer + (invoice.address ? '<br/ >' + invoice.address : '');
	
	document.getElementById('invoiceDate').innerHTML = invoice.date;
	document.getElementById('invoiceCode').innerHTML = invoice.code;
	
	document.getElementById('listItemsTable').innerHTML = '';
	
	for (let item of invoice.items) {
		const tr = document.createElement('tr');
		
		let th = document.createElement('th');
		
		th.innerHTML = item.name;
		tr.appendChild(th);
		
		th = document.createElement('th');
		th.innerHTML = item.unit_net_price.toFixed(2);
		tr.appendChild(th);
		
		th = document.createElement('th');
		th.innerHTML = item.unit;
		tr.appendChild(th);
		
		th = document.createElement('th');
		th.innerHTML = item.quantity;
		tr.appendChild(th);
		
		th = document.createElement('th');
		th.innerHTML = item.tax.toFixed(2);;
		tr.appendChild(th);
		
		th = document.createElement('th');
		th.innerHTML = item.tax_value.toFixed(2);
		tr.appendChild(th);
		
		th = document.createElement('th');
		th.innerHTML = item.total_cost.toFixed(2);;
		tr.appendChild(th);
		
		document.getElementById('listItemsTable').appendChild(tr);
	}
	
	document.getElementById('invoiceDelivery').innerHTML = 'Koszt dostay: ' + invoice.delivery_cost.toFixed(2) + ' PLN';
	document.getElementById('invoiceToPay').innerHTML = 'DO ZAPŁATY(BRUTTO): ' + invoice.to_pay.toFixed(2) + ' PLN';
};
