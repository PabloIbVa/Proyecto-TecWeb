const validation = new JustValidate("#signup");

validation
  .addField("#name", [{ rule: "required" }])
  .addField("#email", [
    { rule: "required" },
    { rule: "email" },
    {
      validator: (value) => () => {
        return fetch("validar-email.php?email=" + encodeURIComponent(value)) // Ajusta esta ruta si es necesario
          .then((response) => response.json())
          .then((json) => json.available);
      },
      errorMessage: "El correo ya está en uso",
    },
  ])
  .addField("#password", [
    { rule: "required" },
    { rule: "password" }, // solo si JustValidate lo soporta, si no, usa minLength y custom validator
  ])
  .addField("#confirm-password", [
    {
      validator: (value, fields) => {
        return value === fields["#password"].elem.value;
      },
      errorMessage: "Las contraseñas no coinciden",
    },
  ])
  .onSuccess((event) => {
    event.target.submit(); // o document.querySelector("#signup").submit();
  });
