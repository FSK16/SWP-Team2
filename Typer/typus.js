//nur test daten werden dann spä#ter API integrieren

const words = "Kürzlich gab es einen starken Regensturm, der die Straßen überflutete und für Verkehrsbehinderungen sorgte. Die Temperaturen sind jedoch angenehm kühl und erfrischend, was eine willkommene Abwechslung von der Hitze der letzten Wochen darstellt. Es wird erwartet, dass das Wetter in den nächsten Tagen sonniger wird, aber es ist immer ratsam, einen Regenschirm in der Nähe zu haben, da das Wetter in dieser Jahreszeit unvorhersehbar sein kann.".split(" ");

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

    // Hier später mittels button anstantt 200 fix einen variablen wert einsetzen

    for (let i = 0; i < 200; i++)
    {
        document.getElementById("words").innerHTML += formatWord(randomWord());
        
    }
    
    addClass(document.querySelector(".word"), "current");
    addClass(document.querySelector(".letter"), "current");

    

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

    if (isLetter) {
        if (currentLetter)
        {
            //alert(key === expected ? "richtig" : "falsch");
            addClass(currentLetter, key === expected ? "correct" : "incorrect");
            removeClass(currentLetter, "current");
            if (currentLetter.nextSibling)
            {
                addClass(currentLetter.nextSibling, "current");
            }
            
        } else {
            const incorrecLetter = document.createElement("span");
            incorrecLetter.innerHTML = key;
            incorrecLetter.className = "letter incorrect extra";

            currentWord.appendChild(incorrecLetter);
            }
    }

    

    
    if (isSpace)
    {
        
        if (expected !== "")
        {
            // Hier falls man wörter überspringt werden alle Wörter, die nicht korrekt siund (.letter:not(correct)) als skipped markiert
            const letterTomakeBad = [...document.querySelectorAll('.word.current .letter:not(.correct)')];
            letterTomakeBad.forEach(letter => {
                addClass(letter, "skipped");
            });
        }
        //Hier übliche spielchen current wird entfernt vom Wort und auf nächstes Übergeben 
        removeClass(currentWord, "current");
        addClass(currentWord.nextSibling, "current");
        if (currentLetter)
        {
            removeClass(currentLetter, "current");
            
        }
        addClass(currentWord.nextSibling.firstChild, "current");
    }
    // Alle anweisungen hier sind dafür da damit man mit backspace auch wieder zurück kann und da halt die verschiuedenen Szenarien (am anfang des wortes, am ende des wortes, in der mitte des wortes)
    if (isBackspace)
    {
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
        else if (currentLetter && !isFirstLetter)
        {
            // Hier wenn man in der Mitte ist
            removeClass(currentLetter, "current");
            addClass(currentLetter.previousSibling, "current");
            removeClass(currentLetter.previousSibling, "correct");
            removeClass(currentLetter.previousSibling, "incorrect");
            removeClass(currentLetter.previousSibling, "skipped");
        }
        else if (!currentLetter)
        {
            //Hier falls man am ende des Wortes ist
            addClass(currentWord.lastChild, "current");
            removeClass(currentWord.lastChild, "correct");
            removeClass(currentWord.lastChild, "incorrect");
            removeClass(currentWord.lastChild, "skipped");

            }
      

    }


    // einmal cursor bewegen bitte

    const nextLetter = document.querySelector(".letter.current");
    const cursor = document.getElementById("cursor");
    const nextWort = document.querySelector(".word.current");

    // kleine funktion um code schgöner zu machen musste ich ausprobieren :-)
    cursor.style.top = (nextLetter || nextWort).getBoundingClientRect().top + "px";
    // Am ende angelangt muss cursor ganz nach hinten ans Wort 
    cursor.style.left = (nextLetter || nextWort).getBoundingClientRect()[nextLetter ? 'left' : 'right'] + "px";
   

});



newGame();