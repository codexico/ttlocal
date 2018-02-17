const auth = require('../api/twitter_app_auth')


const day = 1000*60*60*24

const renewToken = async () => {
  const token = await auth.getTwitterToken()
  auth.write(token)
}

const start = () => {
  renewToken()
  let tokenWorker = setInterval(
    () => renewToken()
    , day
  )
}

module.exports = {
  start
}
