<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Formulário com reCAPTCHA</title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
  <form id="myForm" action="verify.php" method="POST">
    <label>Nome:
      <input type="text" name="nome" required>
    </label>
    <div class="g-recaptcha" data-sitekey="6Lfh780rAAAAAH18gfpdgV61hp4ZuD79_GY-ceOC"></div>
    <button type="submit">Enviar</button>
  </form>

  <script>
    document.getElementById('myForm').addEventListener('submit', function(e){
      var response = grecaptcha.getResponse();
      if (response.length === 0) {
        e.preventDefault();
        alert('Por favor, marque o reCAPTCHA antes de enviar o formulário.');
      }
    });
  </script>

  
</body>
</html>