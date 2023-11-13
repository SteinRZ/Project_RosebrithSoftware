function validarContraseñas(pswd, confirmpswd) {
  if (pswd === confirmpswd) {
    return true;
  } else {
    return false;
  }
}

const formularioRegistro = document.querySelector("form[name='registro']");

formularioRegistro.addEventListener("submit", function(event) {
  event.preventDefault();

  const pswd = formularioRegistro.querySelector("input[name='pswd']").value;
  const confirmpswd = formularioRegistro.querySelector("input[name='confirmpswd']").value;

  const valido = validarContraseñas(pswd, confirmpswd);

  if (!valido) {
    alert("Las contraseñas no coinciden");
  }
});