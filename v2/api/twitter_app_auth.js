const fs = require('fs')
const axios = require('axios')
require('dotenv').config()


const tokenFile = __dirname + '/../files/access_token.json'

const secret = () => {
  const consumerKey = process.env.consumerKey
  const consumerSecretKey = process.env.consumerSecretKey
  const encodedConsumerKey =	encodeURIComponent(consumerKey)
  const encodedConsumerSecretKey =	encodeURIComponent(consumerSecretKey)

  const concatenated = `${encodedConsumerKey}:${encodedConsumerSecretKey}`

  return Buffer.from(concatenated).toString('base64')
}

const requestConfig = () => {
  const base64Secret = secret()
  const headers = {
    'Authorization': `Basic ${base64Secret}`,
    'Content-Type': 'application/x-www-form-urlencodedcharset=UTF-8',
  }

  return {
    method: 'post',
    url: 'https://api.twitter.com/oauth2/token',
    data: 'grant_type=client_credentials',
    headers: headers,
  }
}

const getTwitterToken = async () => {
  try {
    const response = await axios(requestConfig())

    if (response.data && response.data.token_type === 'bearer') {
      return response.data.access_token
    } else {
      console.log('getTwitterToken bearer error = ', response)
    }
  } catch (error) {
    console.log('getTwitterToken error = ', error)
  }
}

const writeToken = (token) => {
  const content = JSON.stringify({access_token: token})

  fs.writeFile(tokenFile, content, (err) => {
    if (err) throw err
    console.log(`The file ${tokenFile} has been saved!`)
  })
  return token
}

const loadAccessToken = () => {
  return JSON.parse(fs.readFileSync(tokenFile, 'utf8')).access_token
}

const reloadToken = async () => {
  return writeToken(await getTwitterToken())
}

module.exports = {
  getTwitterToken,
  write: writeToken,
  load: loadAccessToken,
  reload: reloadToken,
}
