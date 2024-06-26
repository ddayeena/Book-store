export function setAdminToken(token) {
  localStorage.setItem('adminToken', token);
}

export function getAdminToken() {
  return localStorage.getItem('adminToken');
}

export function setUserToken(token) {
  localStorage.setItem('userToken', token);
}

export function getUserToken() {
  return localStorage.getItem('userToken');
}

export function isAdminAuthenticated() {
  return !!getAdminToken();
}

export function isUserAuthenticated() {
  return !!getUserToken();
}

export function logoutAdmin() {
  localStorage.removeItem('adminToken');
  localStorage.removeItem('admin');
}

export function logoutUser() {
  localStorage.removeItem('userToken');
  localStorage.removeItem('user');
}

export function setAdmin(admin) {
  localStorage.setItem('admin', JSON.stringify(admin));
}

export function getAdmin() {
  return JSON.parse(localStorage.getItem('admin'));
}

export function setUser(user) {
  localStorage.setItem('user', JSON.stringify(user));
}

export function getUser() {
  return JSON.parse(localStorage.getItem('user'));
}