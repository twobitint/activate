const {Builder, Browser, By} = require('selenium-webdriver');
const fs = require('fs');

(async function scrape() {
  let driver = await new Builder().forBrowser(Browser.CHROME).build();

  const endpoint = 'https://playactivate.com/leagues/schedule/900391666920194560/926498926901592192';

  await driver.get(endpoint);

  const elem = await driver.findElement(By.id('app'));
  const attr = await elem.getAttribute('data-page');

  const prettyAttr = JSON.stringify(JSON.parse(attr), null, 2);

  fs.writeFileSync('storage/app/private/league.json', prettyAttr);

  await driver.quit();
})();

