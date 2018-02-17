const auth = require('./cron/twitter_app_auth')
const trends_available = require('./cron/trends_available')
const trends_place = require('./cron/trends_place')


// start auth scheduler
auth.start()

// start locations scheduler
trends_available.start()

// start places scheduler
trends_place.start()
