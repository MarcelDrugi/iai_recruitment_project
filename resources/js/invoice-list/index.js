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
