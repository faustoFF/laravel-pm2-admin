const Url = require('url-parse')
const pm2 = require('pm2')
const http = require('http')

const host = '0.0.0.0'
const port = 8000

const requestListener = function (req, res) {
  console.log(req.url)

  res.setHeader('Content-Type', 'application/json')

  const query = Object.fromEntries(new URLSearchParams(new Url(req.url).query))

  const responseCallback = (err, result) => {
    if (err) {
      console.error(err)

      res.writeHead(400)
      res.end(JSON.stringify({ message: err.message }))
    } else {
      res.writeHead(200)
      res.end(JSON.stringify(result))

      pm2.disconnect()
    }
  }

  switch (query.method) {
    case 'list':
      pm2.connect(() => {
        pm2.list(responseCallback)
      })

      break

    case 'start':
      pm2.connect(() => {
        pm2.start(query.process || '', responseCallback)
      })

      break

    case 'stop':
      pm2.connect(() => {
        pm2.stop(query.process || '', responseCallback)
      })

      break

    case 'restart':
      pm2.connect(() => {
        pm2.restart(query.process || '', responseCallback)
      })

      break

    default:
      res.writeHead(400)
      res.end(JSON.stringify({ message: 'Bad Request' }))
  }
}

const server = http.createServer(requestListener)
server.listen(port, host, () => {
  console.log(`Server is running on http://${host}:${port}`)
})
