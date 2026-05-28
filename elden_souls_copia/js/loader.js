document.addEventListener('DOMContentLoaded',function(){
	const form=document.getElementById('form');
	const loader=document.getElementById('loader');

	form.addEventListener('submit',function(){
		loader.style.display='block';
	});

	telefone=document.getElementById('telefone');
	if (telefone) {
		telefone.addEventListener('input',function(e){
			let valor=e.target.value.replace(/\D/g,'');
			valor=valor.substring(0,11);
			let numeroformatado='';

			if(valor.length >0) numeroformatado+='('+valor.substring(0,2);
			if(valor.length >=3) numeroformatado+=')';
			if(valor.length>10){
				numeroformatado+=valor.substring(2,7);
				if (valor.length>=8) {
					numeroformatado+='-'+valor.substring(7,11);
				}
			}else if(valor.length>6){
				numeroformatado+=valor.substring(2,6);
				numeroformatado+='-'+valor.substring(6,10);
			}else if(valor.length>2){
				numeroformatado+=valor.substring(2);
			}

			e.target.value=numeroformatado;
		});
	}

	const cpf = document.getElementById('cpf');

	if (cpf) {
		cpf.addEventListener('input', function () {

			let valor = cpf.value;

       		valor = valor.replace(/\D/g, '');

        	valor = valor.substring(0, 11);

        	valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
			valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
			valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

			cpf.value = valor;
		});
	}

});