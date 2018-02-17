const auth = require('../api/twitter_app_auth')
const trends_available = require('../api/trends_available')


const day = 1000 * 60 * 60 * 24

const renewAvailable = async (access_token) => {
  const locations = await trends_available.get(access_token)
  trends_available.write(locations)
}

const start = () => {
  renewAvailable(auth.load())
  let locationsWorker = setInterval(
    () => renewAvailable(auth.load())
    , day
  )
}

module.exports = {
  start
}
