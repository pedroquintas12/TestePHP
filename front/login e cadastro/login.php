<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="login.css">
</head>
<body>

  <div class="container login-container">
    <h1 class="title has-text-centered">Login</h1>
    <div class="field">
      <label class="label">E-mail</label>
      <div class="control">
        <input class="input" type="email" placeholder="Seu e-mail">
      </div>
    </div>

    <div class="field">
      <label class="label">Senha</label>
      <div class="control">
        <input class="input" type="password" placeholder="Sua senha">
      </div>
    </div>

    <div class="field">
      <div class="control">
        <button class="button is-primary is-fullwidth" onclick="realizarLogin()">Entrar</button>
      </div>
    </div>

    <p class="has-text-centered">Não tem uma conta? <a href="#" onclick="irParaCadastro()">Cadastre-se</a></p>
  </div>

  <script src="login.js"></script>
</body>
</html>
