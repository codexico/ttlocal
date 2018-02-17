const fs = require('fs')
const axios = require('axios');


const getTrendsPlace = async (token, woeid = 1) => {
  const url = `https://api.twitter.com/1.1/trends/place.json?id=${woeid}`
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
    console.log('getTrendsPlace error = ', error);
  }
}

const writePlaceTrends = (trends) => {
  const file = `${__dirname}/../files/${trends[0].locations[0].woeid}.json`
  const content = JSON.stringify(trends)

  fs.writeFile(file, content, (err) => {
    if (err) throw err;
    console.log(`The file ${file} has been saved!`);
  });
}

module.exports = {
  get: getTrendsPlace,
  write: writePlaceTrends,
}
