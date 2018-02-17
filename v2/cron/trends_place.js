const auth = require('../api/twitter_app_auth')
const trends_available = require('../api/trends_available')
const trends_place = require('../api/trends_place')


// 75 Requests/15-min = 12s = 216k/month
const rateLimit = (1000 * 60 * 15)/75

const rotateLocations = async (n = 0, locations, access_token) => {
  if (locations.length === n) { // restart
    locations = trends_available.load()
    access_token = auth.load()
    n = 0
  }

  try {
    const trends = await trends_place.get(access_token, locations[n].woeid)
    trends_place.write(trends)
  } catch (error) {
    console.log("error = ", error);
    // if token error -> reload access token
    access_token = await auth.reload()
  }

  setTimeout(
    () => rotateLocations(++n)
    , rateLimit
  )
}

const start = () => {
  rotateLocations(0, trends_available.load(), auth.load())
}

module.exports = {
  start
}
