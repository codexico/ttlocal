const fs = require('fs')
const axios = require("axios");


const locationsFile = __dirname + '/../files/locations.json'

const getAvailable = async token => {
  const url = 'https://api.twitter.com/1.1/trends/available.json'
  const headers = {
    'Authorization': `Bearer ${token}`,
  }

  try {
    const response = await axios({
      method: 'get',
      url: url,
      headers: headers
    });
    return response.data
  } catch (error) {
    console.log(error);
  }
}

const writeAvailable = (locations) => {
  fs.writeFile(locationsFile, JSON.stringify(locations), (err) => {
    if (err) throw err;
    console.log(`The file ${locationsFile} has been saved!`);
  });
}

const loadLocations = () => {
  return JSON.parse(fs.readFileSync(locationsFile, 'utf8'));
}

module.exports = {
  get: getAvailable,
  write: writeAvailable,
  load: loadLocations,
}
