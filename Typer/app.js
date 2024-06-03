const { fakerDE_AT, fakerEN, fakerEN_GB, fakerDE_CH, fakerDE, fakerFR } = require('@faker-js/faker');
const express = require('express');
const cors = require('cors');               
const app = express();
app.use(cors()); 
//PORT
const port = 3000;

app.get('/:lang/:count', (req, res) => {
    const count = parseInt(req.params.count);
    const lang = req.params.lang;
    let faker;


    switch (lang) {
        case 'de_at':
            faker = fakerDE_AT;
            break;
        case 'en':
            faker = fakerEN;
            break;
        case 'en_gb':
            faker = fakerEN_GB;
            break;
        case 'de_ch':
            faker = fakerDE_CH;
            break;
        case 'de':
            faker = fakerDE;
            break;
        case 'fr':
            faker = fakerFR;
            break;
        default:
            res.status(400).json({ error: 'Invalid language' });
            return;
    }

    const words = faker.word.words(count);
    res.json({ string: words });
});

app.listen(port, () => {
    console.log(`Example app listening at http://localhost:${port}`);
});