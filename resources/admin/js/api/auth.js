import request from '@/admin/js/utils/request';

export function login(data) {
  return request({
    url: '/auth/login',
    method: 'post',
    data: data,
  });
}
export function adminLogin(data) {
    return request({
        url: '/auth/admin-login',
        method: 'post',
        data: data,
    })
}
export function register(data) {
    return request({
        url: '/auth/register',
        method: 'post',
        data: data,
    });
}
export function getInfo(token) {
  return request({
    url: '/user',
    method: 'get',
  });
}

export function logout() {
  return request({
    url: '/auth/logout',
    method: 'post',
  });
}

export function csrf() {
  return request({
    baseURL:'/api',
    url: '/sanctum/csrf-cookie',
    method: 'get',
  });
}
