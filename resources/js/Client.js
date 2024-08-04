import axios from 'axios'
import qs from 'qs'

function handle (promise, resolve, reject) {
  promise
    .then(response => {
      resolve(response.data)
    })
    .catch(error => {
      window.pm2AdminApp.$bvToast.toast(error.response?.data?.message || `${error}`, {
        title: 'Ошибка',
        variant: 'danger'
      })

      reject(error)
    })
}

class Client {
  get (url, params) {
    return new Promise((resolve, reject) => {
      handle(
        axios.get(
          url,
          {
            params,
            paramsSerializer: params => {
              return qs.stringify(params, { arrayFormat: 'brackets' })
            }
          }),
        resolve,
        reject
      )
    })
  }
}

export default new Client()
