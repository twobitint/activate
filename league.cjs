const {Builder, Browser, By} = require('selenium-webdriver');
const fs = require('fs');

(async function scrape() {
  let driver = await new Builder().forBrowser(Browser.CHROME).build();

  const endpoint = 'https://playactivate.com/leagues/schedule/900391666920194560/926498926901592192';

  await driver.get(endpoint);

  const elem = await driver.findElement(By.id('app'));
  const attr = await elem.getAttribute('data-page');

  const response = JSON.parse(attr);

  const prettyAttr = JSON.stringify(response, null, 2);

  fs.writeFileSync('storage/app/private/league.json', prettyAttr);

  await driver.quit();

  // const matches = response.props.teamSchedule.matches;
  let opponents = {
    'For Fun Friends': '926498926901592192',
    'Northern Valkyries ': '903692259239657600',
    'Bridge Four': '927903890744017024',
    'Lord Farquaad Squad': '911704340694040704',
    'Chaos Commanders & Tiny Tornadoes': '904101488421240832',
    'Outwit, Outplay, Out-Slay': '910116568631869440',
    'Trophy Husbands': '908011549258416256',
    'Peak Performance Anxiety': '919987397771395200',
    'TheBadTeam': '927526338464579712',
    'Infinite Turbo': '911703398724665472',
    'The Champs 9.0': '904248911428845568',
    'Trash Pandas': '903938628776886272',
    'Tecca Chairs ': '912062541746667648',
    'Grid Locked, Laser Focused': '903934225613324416',
    'Overqualified Amateurs': '929131356498165888',
    'The Tallest Goblins': '916771032608538624',
    'Prime': '904752319487279232',
    'Trimisu': '927287661515767808',
    'Million Dollars': '912074573011222528',
    'Orlando Peacocks': '928316967599734784',
    'The Locksmiths': '904672624112566400',
    'Spatula City 2.0': '911655732451999872',
    'Gridzi': '904042670991605760',
    'Baldyguards: The Wrath of Bald': '904767235803840640',
    'Fasts': '927954580107427840',
    'Ctrl + Alt + Elite': '918967800809128064',
    'The Magicians': '909468997441814528',
    'KookySnow ': '911630349744734208',
    'deactivate . * ･ ｡ﾟ☆━੧༼ •́ ヮ •̀ ༽୨': '928037198886862976',
    'Buffalo is Buffalo': '904840397241450624',
    'Couch Potatoes': '908624029437394944',
    '\\ButtonSmashers/': '904713376968474624',
    'Skyscrapers & firecrackers ': '912001005330104320',
    'Baja BLast (Place)': '911303565006340224',
    'Four Eyes': '911746228885127296',
    'The Collective Braincell': '928428303453257728',
  };

  // for (const opponent of opponents.keys()) {

  for (const opponent of Object.keys(opponents)) {
    // get opponent matchups

    driver = await new Builder().forBrowser(Browser.CHROME).build();

    const opponentEndpoint = `https://playactivate.com/leagues/schedule/900391666920194560/${opponents[opponent]}`;

    await driver.get(opponentEndpoint);
    const opponentElem = await driver.findElement(By.id('app'));
    const opponentAttr = await opponentElem.getAttribute('data-page');

    const opponentResponse = JSON.parse(opponentAttr);

    opponents[opponent] = opponentResponse.props.teamSchedule.matches;

    await driver.quit();
  }

  const prettyOpponents = JSON.stringify(opponents, null, 2);
  fs.writeFileSync('storage/app/private/matches.json', prettyOpponents);

})();

