//nur test daten werden dann spä#ter API integrieren

const words = "Kürzlich gab es einen starken Regensturm, der die Straßen überflutete und für Verkehrsbehinderungen sorgte. Die Temperaturen sind jedoch angenehm kühl und erfrischend, was eine willkommene Abwechslung von der Hitze der letzten Wochen darstellt. Es wird erwartet, dass das Wetter in den nächsten Tagen sonniger wird, aber es ist immer ratsam, einen Regenschirm in der Nähe zu haben, da das Wetter in dieser Jahreszeit unvorhersehbar sein kann.".split(" ");
let intervalID;







// Liste der Button-IDs
const buttonIds = ["wordsBtn15", "wordsBtn30", "wordsBtn60"];


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
        gameTime = parseInt(id.replace("wordsBtn", ""));
    });
});

// Setze den Standard-Button auf "wordsBtn15"
selectButton("wordsBtn15");
gameTime = 15;


let TimerStarted = false;

function addClass(el,name) {
  el.className += ' '+name;
}
function removeClass(el,name) {
  el.className = el.className.replace(name,'');
}

// Brauchen wir später nicht mehr aber für jetzt ist es gut
function randomWord()
{
    return words[Math.floor(Math.random() * words.length)];

}

//Ist damit jedes Wort in einem div ist und jeder Buchstabe in einem span damit wir dann später die Buchstaben einzeln ansprechen können
function formatWord(word) {
  return `<div class="word"><span class="letter">${word.split('').join('</span><span class="letter">')}</span></div>`;
}

//Hier wird das Spiel gestartet und die Wörter in den DOM geladen
function newGame() {
    document.getElementById("words").innerHTML = "";
        document.getElementById('game').classList.add('start');

    // Hier später mittels button anstantt 200 fix einen variablen wert einsetzen

    for (let i = 0; i < 200; i++)
    {
        document.getElementById("words").innerHTML += formatWord(randomWord());
        
    }
    
    addClass(document.querySelector(".word"), "current");
    addClass(document.querySelector(".letter"), "current");
    clearInterval(intervalID);
    TimerStarted = false;
    document.getElementById("info").style.display = "none";
    
    
    

}

function gameover()
{
    clearInterval(intervalID);
    addClass(document.getElementById('game'), 'over');
    document.getElementById("info").innerHTML = "WPM: " + getWpm();

}

function getWpm() {
  const words = [...document.querySelectorAll('.word')];
  const lastTypedWord = document.querySelector('.word.current');
  const lastTypedWordIndex = words.indexOf(lastTypedWord) + 1;
  const typedWords = words.slice(0, lastTypedWordIndex);
  const correctWords = typedWords.filter(word => {
    const letters = [...word.children];
    const incorrectLetters = letters.filter(letter => letter.className.includes('incorrect'));
    const correctLetters = letters.filter(letter => letter.className.includes('correct'));
    return incorrectLetters.length === 0 && correctLetters.length === letters.length;
  });
  return correctWords.length / gameTime * 60;
}

// Hier wird dann die Eingabe des Users abgefangen und verarbeitet
document.getElementById("game").addEventListener("keyup", ev => {
    const key = ev.key;
    // Hier wird dann der aktuelle Buchstabe ausgewählt um mit diesem Zuarbeiten zu können
    const currentLetter = document.querySelector(".letter.current");
    // Das ist dafür da um den Nächsten Buchstaben zu bekommen weil wir ja immer mit dem nächsten arbeiten müssen und das " " ist dafür da das wir am ende eines Wortes ein Leerzeichen haben damit der User dann Leerzeile drücken kann und es als Richtig gewertet wird 
    const expected = currentLetter?.innerHTML || " ";
    //HJier einfach nur die Abfrage ob es ein Buchstabe ist und das es kein Leerzeichen ist
    const isLetter = key.length === 1 && key != " ";
    // Hier wird dann abgefragt ob es ein Leerzeichen ist
    //sind sozusagen einfach if anweisungen in fancy musst eich machen weil sie nice sind
    const isSpace = key === " ";

    const isBackspace = key === "Backspace";

    const currentWord = document.querySelector(".word.current");
  
    

    // check ob wir uns beim ersten Buchstaben befinden mit firstchild
    const isFirstLetter = currentLetter === currentWord.firstChild;
    if (document.querySelector('#game.over')) {
        return;
    }

    
    function startTimer(duration) {
        let timer = duration - 1;
        document.getElementById("info").style.display = "block";
         intervalID = setInterval(() => {
            if (timer < 0) {
                
                gameover();
                return;
            }
            const minutes = Math.floor(timer / 60);
            const seconds = timer % 60;
            document.getElementById("info").innerHTML = minutes + ":" + seconds;
            timer--;
            
        }, 1000);
    }
    
    
    if (!TimerStarted) {
        TimerStarted = true;
        startTimer(gameTime);
    }
    

   


    // hier die verschiebung der Buchstaben und die Auswertung davon (richtig, falsch, übersprungen) wenn es ein Buchstabe ist
    if (isLetter) {
        if (currentLetter) {
            //alert(key === expected ? "richtig" : "falsch");
            addClass(currentLetter, key === expected ? "correct" : "incorrect");
            removeClass(currentLetter, "current");
            if (currentLetter.nextSibling) {
                addClass(currentLetter.nextSibling, "current");
            }
            

        }
        // Hier werden Buchstaben die extra geschrieben wurden extra hinzugefügt und als mittels span erstellt und die Klasse extra hinzugefügt
        else {
            const incorrecLetter = document.createElement("span");
            incorrecLetter.innerHTML = key;
            incorrecLetter.className = "letter incorrect extra";

            currentWord.appendChild(incorrecLetter);
        }
    }

    

    
    if (isSpace) {
        
        if (expected !== "") {
            // Hier falls man wörter überspringt werden alle Wörter, die nicht korrekt siund (.letter:not(correct)) als skipped markiert
            const letterTomakeBad = [...document.querySelectorAll('.word.current .letter:not(.correct)')];
            letterTomakeBad.forEach(letter => {
                addClass(letter, "skipped");
            });
        }
        //Hier übliche spielchen current wird entfernt vom Wort und auf nächstes Übergeben 
        removeClass(currentWord, "current");
        addClass(currentWord.nextSibling, "current");
        if (currentLetter) {
            removeClass(currentLetter, "current");
            
        }
        addClass(currentWord.nextSibling.firstChild, "current");
    }
    
    // Alle anweisungen hier sind dafür da damit man mit backspace auch wieder zurück kann und da halt die verschiuedenen Szenarien (am anfang des wortes, am ende des wortes, in der mitte des wortes)
    if (isBackspace) {
        //Hier wenn man am anfang des Wortes nächsten wortes ist
        if (currentLetter && isFirstLetter) {
            // Hier dann vorherige Wort zu jetzigem Wort mnacehn
            removeClass(currentWord, "current");
            addClass(currentWord.previousSibling, "current");

            removeClass(currentLetter, "current");
            addClass(currentWord.previousSibling.lastChild, "current");
            removeClass(currentWord.previousSibling.lastChild, "incorrect");
            removeClass(currentWord.previousSibling.lastChild, "correct");
            removeClass(currentWord.previousSibling.lastChild, "skipped");
        }
        else if (currentLetter && !isFirstLetter) {
            // Hier wenn man in der Mitte ist
            removeClass(currentLetter, "current");
            addClass(currentLetter.previousSibling, "current");
            removeClass(currentLetter.previousSibling, "correct");
            removeClass(currentLetter.previousSibling, "incorrect");
            removeClass(currentLetter.previousSibling, "skipped");
        }
        else if (!currentLetter) {
            //Hier falls man am ende des Wortes ist
            addClass(currentWord.lastChild, "current");
            removeClass(currentWord.lastChild, "correct");
            removeClass(currentWord.lastChild, "incorrect");
            removeClass(currentWord.lastChild, "skipped");

        }
      

    }

    // Hier wird dann das scrollen gemacht
    function scrollWords(amount) {
        const wordsContainer = document.getElementById("words");
        const margin = parseInt(wordsContainer.style.marginTop || '0px');
        wordsContainer.style.marginTop = (margin + amount) + 'px';
    }

  
// Hier wird gescrollt einmal hoch und einmal runter
const wordsContainer = document.getElementById("words");
if (currentWord.getBoundingClientRect().top > 250) {
    scrollWords(-35);
    
} // Hier muss davor gecheckt werden ob es bereits gescrollt ist damit nicht direkt gescrollt wird hat mich viel zu lange gebracuht 
else if (wordsContainer.style.marginTop && parseInt(wordsContainer.style.marginTop) <= -35) {
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
    
   
    newGame();
}
);

newGame();