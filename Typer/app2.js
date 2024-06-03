const express = require('express');
const cors = require('cors');
const axios = require('axios');
const app = express();

app.use(cors());

const PORT = process.env.PORT || 3000;


const wordApis = {
    english: 'https://random-word-api.herokuapp.com/word?lang=en',
    spanish: 'https://random-word-api.herokuapp.com/word?lang=es'
};


async function getRandomWord(language, count = 1) {
    const apiUrl = `${wordApis[language]}&number=${count}`;
    if (apiUrl) {
        try {
            const response = await axios.get(apiUrl);
            const words = response.data; 
            return words;
        } catch (error) {
            console.error(error);
            return null;
        }
    } else {
        return null;
    }
}


app.get('/random-word', async (req, res) => {
    const language = req.query.language;
    const number = req.query.number;
    const words = await getRandomWord(language, number);
    if (words) {
        res.json({ words: words });
    } else {
        res.status(404).json({ error: "Language not supported or API error" });
    }
});


app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});