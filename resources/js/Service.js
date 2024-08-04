import Client from './Client'

class Service {
  list () {
    return Client.get('?method=list')
  }

  restart (process) {
    return Client.get(`?method=restart&process=${process}`)
  }

  stop (process) {
    return Client.get(`?method=stop&process=${process}`)
  }

  start (process) {
    return Client.get(`?method=start&process=${process}`)
  }
}

export default new Service()
