const {Builder, Browser, By} = require('selenium-webdriver');
const fs = require('fs');

(async function scrape() {
  let driver = await new Builder().forBrowser(Browser.CHROME).build();

  const endpoint = 'https://playactivate.com/scores/whumps/49/culver%20city/scan/scores';

  await driver.get(endpoint);

  const elem = await driver.findElement(By.id('app'));
  const attr = await elem.getAttribute('data-page');

  const prettyAttr = JSON.stringify(JSON.parse(attr), null, 2);

  fs.writeFileSync('storage/app/private/hoops.json', prettyAttr);

  await driver.quit();
})();

