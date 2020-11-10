import axios from 'axios'
import Cookies from 'js-cookie'
import Swal from 'sweetalert2'
import i18n from '../i18n/i18n'
import router from '@/router'
import authConfig from '@/auth_config.json'


// axios.create({
//   headers: {
//     'Content-Type': 'application/x-www-form-urlencoded',
//     'Accept': 'application/json'}
// })

const token = Cookies.get('token')
const userInfo = Cookies.get('user')

axios.defaults.baseURL = authConfig.domain


axios.interceptors.response.use(response => response, error => {
  const { status } = error.response
  const { config, response } = error
  const originalRequest = config
  originalRequest.headers.Authorization = `Bearer ${token}`

  if (status && userInfo && status === 401 && response.config.url === '/api/user') {
    axios.get('/api/refresh')
      .then((response) => {
        console.log('token', response.data)
        originalRequest.headers.Authorization = `Bearer ${response.data}`
        Cookies.remove('token')
        Cookies.set('token', response.data)
      })
    router.push(router.currentRoute.query.to || '/panel/login')
  }

  if (!userInfo) {
    Cookies.remove('user')
    Cookies.remove('token')
    router.push(router.currentRoute.query.to || '/panel/login')
  }

  return Promise.reject(error)
})


export default axios

