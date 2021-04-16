function auth() {
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  if (username == 'admin' && password == 'admin') {
    window.open('./home-admin.html', '_self');
  }
}
