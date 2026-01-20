const {Builder, Browser, By} = require('selenium-webdriver');
const fs = require('fs');

(async function scrape() {

  const players = [
    'whumps',
    'rainbow_spice',
    'frostea',
    'jtep',
    'twongx',
  ];

  for (const player of players) {
    let driver = await new Builder().forBrowser(Browser.CHROME).build();

    const endpoint = `https://playactivate.com/scores/${player}/49/culver%20city/scores`;

    await driver.get(endpoint);

    const elem = await driver.findElement(By.id('app'));
    const attr = await elem.getAttribute('data-page');

    const prettyAttr = JSON.stringify(JSON.parse(attr), null, 2);

    fs.writeFileSync(`storage/app/private/scores_${player}.json`, prettyAttr);

    await driver.quit();
  }

})();
