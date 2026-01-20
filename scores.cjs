const {Builder, Browser, By} = require('selenium-webdriver');
const fs = require('fs');

(async function scrape() {

    let players = [];

    if (process.argv.length > 2) {
        players = process.argv.slice(2);
    } else {
        players = require('./storage/app/private/players.json').map(p => p.name);
    }

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
