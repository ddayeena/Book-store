export function setToken(token) {
  localStorage.setItem('token', token);
}

export function getToken() {
  return localStorage.getItem('token');
}

export function isAuthenticated() {
  return !!getToken();
}

export function logout() {
  localStorage.removeItem('token');
  localStorage.removeItem('user');
}

export function setUser(user) {
  localStorage.setItem('user', JSON.stringify(user));
}

export function getUser() {
  return JSON.parse(localStorage.getItem('user'));
}
