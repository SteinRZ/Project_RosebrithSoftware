with(document.registro){
	onsubmit = function(e){
		e.preventDefault();
		ok = true;
	
		if(ok && pswd.value==""){
			ok=false;
			alert("Debe escribir su contraseña");
			password.focus();
		}
		if(ok && confirmpswd.value==""){
			ok=false;
			alert("Debe reconfirmar su contraseña");
			confirmpswd.focus();
		}

		if(ok && pswd.value!= confirmpswd.value){
			ok=false;
			alert("Las contraseñas no coinciden");
			confirmpswd.focus();
		}


		if(ok){ submit(); }
	}
}