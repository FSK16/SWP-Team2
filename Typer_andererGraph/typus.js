let words = "Kürzlich gab es einen starken Regensturm, der die Straßen überflutete und für Verkehrsbehinderungen sorgte. Die Temperaturen sind jedoch angenehm kühl und erfrischend, was eine willkommene Abwechslung von der Hitze der letzten Wochen darstellt. Es wird erwartet, dass das Wetter in den nächsten Tagen sonniger wird, aber es ist immer ratsam, einen Regenschirm in der Nähe zu haben, da das Wetter in dieser Jahreszeit unvorhersehbar sein kann.".split(" ");
let intervalID;
let wrongCounter = 0;
let timer_wo_limit;
let woerter;
let gameTime = 15;
let TimerStarted = false;
var wordsstands = [];
const buttonIds = ["wordsBtn15", "wordsBtn30", "wordsBtn60", "wordsBtn200woerter", "wordsBtn300woerter", "wordsBtn400woerter", "wordsBtn10woerter" ];
let isGameFocused = false;
const game = document.getElementById('game');





game.addEventListener('focus', () => {
    isGameFocused = true;
    console.log("Game is focused");
});

game.addEventListener('blur', () => {
    isGameFocused = false;
    console.log("Game is not focused");
});

document.getElementById("languageSelect").addEventListener("change", function() {
    const selectedLanguage = this.value;
    let count = 5;
    fetchWords(selectedLanguage, count);
    newGame();
});

async function fetchWords(lang, count) {
    const url = 'http://localhost:3000/' + lang + '/' + count;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        words = data.string.split(" ");
    } catch (error) {
        console.log('There was a problem with the fetch operation: ' + error.message);
    }
}

function resetButtonColors() {
    buttonIds.forEach(id => {
        document.getElementById(id).style.color = "rgba(255, 255, 255, .5)";
    });
}

function selectButton(id) {
    resetButtonColors();
    document.getElementById(id).style.color = "var(--primaryColor)";
}

buttonIds.forEach(id => {
    document.getElementById(id).addEventListener("click", ev => {
        selectButton(id);
        if(id.includes("woerter")) {            
            woerter = getNumberofSring(id);
            if (woerter == null) {
                alert("Keine Wortanzahl gefunden!");
            }
            gameTime = null;
        } else {
            gameTime = parseInt(id.replace("wordsBtn", ""));
            woerter = null;
        }
        newGame();
    });
});

selectButton("wordsBtn15");

function addClass(el,name) {
  el.className += ' '+name;
}

function removeClass(el,name) {
  el.className = el.className.replace(name,'');
}

function randomWord() {
    return words[Math.floor(Math.random() * words.length)];
}

function formatWord(word) {
    return `<div class="word" style="user-select: none;"><span class="letter">${word.split('').join('</span><span class="letter">')}</span></div>`;
}

async function newGame() {
    resetDisplay();
    await fetchWords();
    resetGameVariables();
    generateWords();
    positionCursor();
    startGameTimer();
    resetStats();


    
}

function resetDisplay() {
    document.getElementById("info").style.display = "";
    document.getElementById("info").innerHTML = "";
    document.getElementById("words").innerHTML = "";
    document.getElementById('game').classList.add('start');
}

function resetGameVariables() {
    wrongCounter = 0;
    clearInterval(intervalID);
    TimerStarted = false;
}

function generateWords() {
    if(woerter == null) {
        for (let i = 0; i < 200; i++) {
            appendWordToDisplay(randomWord());
        }
    }
    if(gameTime == null) {
        for (let i = 0; i < woerter; i++) {
            appendWordToDisplay(randomWord());
        }
    }
    addClass(document.querySelector(".word"), "current");
    addClass(document.querySelector(".letter"), "current");
}

function appendWordToDisplay(word) {
    document.getElementById("words").innerHTML += formatWord(word);
}

function positionCursor() {
    const firstLetter = document.querySelector(".letter:first-child");
    const cursor = document.getElementById("cursor");

    cursor.style.top = firstLetter.getBoundingClientRect().top + 2 + "px";
    cursor.style.left = firstLetter.getBoundingClientRect().left + "px";
}

function startGameTimer() {
    if (gameTime == null) {
        startTimeWithOutLimit();
    } else {
        startTimer(gameTime);
    }
}
// Funktion zum Beenden des Spiels
function gameover() {
    if(words != null) {
        stoppTimeWithOutLimit();
    }
    clearInterval(intervalID);
    addClass(document.getElementById('game'), 'over');

    var wpm = getWpm().toFixed(2);
    var accuray = getAccuracy().toFixed(2) + "%";
    document.getElementById('result_wpm').innerHTML = wpm;
    document.getElementById('result_acc').innerHTML = accuray;
    var typescount = wordsstands.length;
    //document.getElementById('wpm_input').value = wpm;
    //document.getElementById('acc_input').value = accuray;
    document.getElementById('numberwords_3').innerHTML = typescount;
    document.getElementById('numberwords_2').innerHTML = typescount/2;
    var graph_id = document.getElementById('result_graph');
    var pixel_per_tipp = 850/typescount;
    var currentpixel = 4;
    var graph = { circles: "", lines: "" };
    var kreise = [];
    var punktanzahl = 0;
    var currentpixel = 0; // Du musst currentpixel initialisieren
    wordsstands.forEach((stats) => {
        if (stats === "correct") {
            graph.circles += `<circle cx="${currentpixel}" cy="5" r="4" fill="green" />`;
            kreise.push({ x1: currentpixel, y1: 5 });
        }
        if (stats === "false") {
            graph.circles += `<circle cx="${currentpixel}" cy="195" r="4" fill="red" />`;
            kreise.push({ x1: currentpixel, y1: 195 });
        }
        punktanzahl++;
        currentpixel += pixel_per_tipp;
    });
    
    for (var i = 0; i < punktanzahl - 1; i++) {
        var startPoint = kreise[i];
        var nextPoint = kreise[i + 1];
        graph.lines += `<line x1="${startPoint.x1}" y1="${startPoint.y1}" x2="${nextPoint.x1}" y2="${nextPoint.y1}" stroke="green" stroke-width="5" />`;
    }
    
    graph_id.innerHTML = graph.circles + graph.lines;
    







    






    openPopUp('popup_finished', 1000, 545, '#333741')
}

// Funktion zur Berechnung der Wörter pro Minute (WPM)
function getWpm() {
    if(gameTime != null) {
        return getTotalCharacters()  / 5 / gameTime * 60;
    }
    if(words != null) {
        return getTotalCharacters()  / 5 / timer_wo_limit * 60;
    }
}

// Funktion zur Berechnung der Gesamtanzahl der Zeichen
function getTotalCharacters() {
    const words = [...document.querySelectorAll('.word.current, .word.completed')];
    const totalCharacters = words.reduce((total, word) => {
        const letters = [...word.children];
        const typedLetters = letters.filter(letter => letter.className.includes('correct') || letter.className.includes('incorrect'));
        return total + typedLetters.length;
    }, 0);
    return totalCharacters;
}
//Caps lock check funktion 
function checkCapsLock(event) {
    const capLockNotify = document.getElementById('capLockNotify');
    if (event.getModifierState("CapsLock")) {
        capLockNotify.style.display = 'block'; 
    } else {
        capLockNotify.style.display = 'none'; 
    }
}


// Funktion zur Berechnung der korrekten Zeichen
function getCorrectCharacters() {
    const words = [...document.querySelectorAll('.word.current, .word.completed')];
    const correctCharacters = words.reduce((total, word) => {
        const letters = [...word.children];
        const correctLetters = letters.filter(letter => letter.classList.contains('correct'));
        return total + correctLetters.length;
    }, 0);
    return correctCharacters;
}

// Funktion zur Berechnung der Genauigkeit
function getAccuracy() {
    return -wrongCounter / getCorrectCharacters() * 100 + 100; 
}

// Event-Listener für die Tastatureingabe
document.getElementById("game").addEventListener("keyup", ev => {
    const key = ev.key;
    const currentLetter = document.querySelector(".letter.current");
    const expected = currentLetter?.innerHTML || " ";
    const isLetter = key.length === 1 && key != " ";
    const isSpace = key === " ";
    const isBackspace = key === "Backspace";
    const currentWord = document.querySelector(".word.current");
    const isFirstLetter = currentLetter === currentWord.firstChild;

    window.addEventListener('keydown', checkCapsLock);
    window.addEventListener('keyup', checkCapsLock);

    

    if (document.querySelector('#game.over')) {
        console.log('Game is over');
        return;
    }

    // Überprüfung, ob das Wortlimit erreicht ist
    if(gameTime == null) {
        const words = [...document.querySelectorAll('.word')];
        
        const lastWord = document.querySelector(".word:last-child");
        const lastLetter = lastWord.querySelector(".letter:last-child");
        
        if (currentLetter === lastLetter && currentWord == lastWord) {
            console.log('Das Spiel ist fertig');
            gameover();
            return;
        }
    }

    // Timer-Funktion
    if(woerter == null) {
        function startTimer(duration) {
            let timer = duration;
            document.getElementById("info").style.display = "block";
        
            let minutes = Math.floor(timer / 60);
            let seconds = timer % 60;
            document.getElementById("info").innerHTML = minutes + ":" + seconds;
       
            intervalID = setInterval(() => {
            if (isGameFocused)
            {
                timer--;
                if (timer <= 0) {
                    gameover();
                    return;
                }
            
                
                minutes = Math.floor(timer / 60);
                seconds = timer % 60;
                document.getElementById("info").innerHTML = minutes + ":" + seconds;
            }
        }, 1000);
}
        if (!TimerStarted) {
            TimerStarted = true;
            startTimer(gameTime);
        }
    }

    // Verarbeitung der Tastatureingabe
    if (isLetter) {
        if (currentLetter) {
            if (key !== expected) {
                wordsstands.push("false");
                wrongCounter++;
            }
            else if (key === expected)
            {
                wordsstands.push("correct");
            }
            addClass(currentLetter, key === expected ? "correct" : "incorrect");
            removeClass(currentLetter, "current");
            if (currentLetter.nextSibling) {
                addClass(currentLetter.nextSibling, "current");
            }
        } else {
            const incorrecLetter = document.createElement("span");
            incorrecLetter.innerHTML = key;
            incorrecLetter.className = "letter incorrect extra";
            currentWord.appendChild(incorrecLetter);
        }
    }

    if (isSpace) {
        if (expected !== "") {
            const letterTomakeBad = [...document.querySelectorAll('.word.current .letter:not(.correct)')];
            letterTomakeBad.forEach(letter => {
                addClass(letter, "skipped");
            });
        }
        addClass(currentWord, "completed");
        removeClass(currentWord, "current");
        addClass(currentWord.nextSibling, "current");
        if (currentLetter) {
            removeClass(currentLetter, "current");
        }
        addClass(currentWord.nextSibling.firstChild, "current");
    }

    // Verarbeitung der Backspace-Taste
    if (isBackspace) {
        if (currentLetter && isFirstLetter) {
            removeClass(currentWord, "current");
            addClass(currentWord.previousSibling, "current");
            removeClass(currentLetter, "current");
            addClass(currentWord.previousSibling.lastChild, "current");
            removeClass(currentWord.previousSibling.lastChild, "incorrect");
            removeClass(currentWord.previousSibling.lastChild, "correct");
            removeClass(currentWord.previousSibling.lastChild, "skipped");
        } else if (currentLetter && !isFirstLetter) {
            removeClass(currentLetter, "current");
            addClass(currentLetter.previousSibling, "current");
            removeClass(currentLetter.previousSibling, "correct");
            removeClass(currentLetter.previousSibling, "incorrect");
            removeClass(currentLetter.previousSibling, "skipped");
        } else if (!currentLetter) {
            addClass(currentWord.lastChild, "current");
            removeClass(currentWord.lastChild, "correct");
            removeClass(currentWord.lastChild, "incorrect");
            removeClass(currentWord.lastChild, "skipped");
        }
    }

    // Funktion zum Scrollen der Wörter
    function scrollWords(amount) {
        const wordsContainer = document.getElementById("words");
        const margin = parseInt(wordsContainer.style.marginTop || '0px');
        wordsContainer.style.marginTop = (margin + amount) + 'px';
    }

    // Scrollen der Wörter
    const wordsContainer = document.getElementById("words");
    if (currentWord.getBoundingClientRect().top > 250) {
        scrollWords(-35);
    } else if (wordsContainer.style.marginTop && parseInt(wordsContainer.style.marginTop) <= -35) {
        if (currentWord.getBoundingClientRect().top < 200) {
            scrollWords(35);
        }
    }
      

    // einmal cursor bewegen bitte

    const nextLetter = document.querySelector(".letter.current");
    const cursor = document.getElementById("cursor");
    const nextWort = document.querySelector(".word.current");
    
    // kleine funktion um code schgöner zu machen musste ich ausprobieren :-)
    cursor.style.top = (nextLetter || nextWort).getBoundingClientRect().top + 2 + "px";
    // Am ende angelangt muss cursor ganz nach hinten ans Wort 
    cursor.style.left = (nextLetter || nextWort).getBoundingClientRect()[nextLetter ? 'left' : 'right'] + "px";
   

});

// um Tastatur dicitonary verwenden für ansteuerung

document.getElementById("newGameBtn").addEventListener("click", ev => { 
    document.getElementById('game').classList.remove('over');
   
    newGame();
}
);

function getNumberofSring(string) {
    var number = parseInt(string.match(/\d+/));
    console.log(number);
    return number;
}

function startTimeWithOutLimit()
{
timer_wo_limit = 0; // Starte den Timer bei 0 Sekunden
document.getElementById("info").style.display = "block";

intervalID = setInterval(() => {
    // Hier wird keine Bedingung überprüft, ob der Timer abgelaufen ist.
    // Der Timer läuft unbegrenzt weiter.

    minutes = Math.floor(timer_wo_limit / 60);
    seconds = timer_wo_limit % 60;
    document.getElementById("info").innerHTML = minutes + ":" + seconds;
    timer_wo_limit++;
}, 1000);
}

function stoppTimeWithOutLimit() {
    clearInterval(intervalID); // Stoppt das Interval mit der angegebenen ID
}

newGame();

function openPopUp(windowid,  width, height, color)
{
    var popup = document.getElementById(windowid);
    var verdunkelung = document.getElementById('overlay');
    verdunkelung.style.display = 'block';

    popup.style.transition = 'opacity 0.5s ease';
    popup.style.width = width + 'px';
    popup.style.height = height + 'px';
    popup.style.backgroundColor = color;

    setTimeout(function () {
        popup.style.opacity = '1';
      }, 10);
    setTimeout(function () {
    popup.classList.add('popup_show');
    }, 0);

}
function closePopUp(windowid)
{
    var popup = document.getElementById(windowid);
    var verdunkelung = document.getElementById('overlay');
    popup.style.transition = 'opacity 0.2s ease';
    popup.style.width = '';
    popup.style.height = '';
    popup.style.backgroundColor = '';
    setTimeout(function () {
      popup.style.opacity = '0';
    }, 10);
  
    verdunkelung.style.display = 'none';
    setTimeout(function () {
      popup.classList.remove('popup_show');
    }, 200);
}
function switchPopup(windowid_old, windowid_new, width, height, color)
{
    var popup_old = document.getElementById(windowid_old);
    var popup_new  = document.getElementById(windowid_new);

    popup_old.style.transition = 'opacity 0.2s ease';
    popup_old.style.width = '';
    popup_old.style.height = '';
    popup_old.style.backgroundColor = '';
    setTimeout(function () {
        popup_old.style.opacity = '0';
    }, 10);
  
    setTimeout(function () {
        popup_old.classList.remove('popup_show');
    }, 200);

    popup_new.style.transition = 'opacity 0.5s ease';
    popup_new.style.width = width + 'px';
    popup_new.style.height = height + 'px';
    popup_new.style.backgroundColor = color;
    
    setTimeout(function () {
        popup_new.style.opacity = '1';
      }, 10);
    setTimeout(function () {
    popup_new.classList.add('popup_show');
    }, 0);
}
function resetStats()
{
    document.getElementById('result_wpm').innerHTML = '';
    document.getElementById('acc_input').value = '';
    document.getElementById('wpm_input').value = '';
    document.getElementById('result_acc').innerHTML = '';
}