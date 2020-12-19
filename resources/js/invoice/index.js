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
