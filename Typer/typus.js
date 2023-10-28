//nur test daten werden dann spä#ter API integrieren

const words = "Kürzlich gab es einen starken Regensturm, der die Straßen überflutete und für Verkehrsbehinderungen sorgte. Die Temperaturen sind jedoch angenehm kühl und erfrischend, was eine willkommene Abwechslung von der Hitze der letzten Wochen darstellt. Es wird erwartet, dass das Wetter in den nächsten Tagen sonniger wird, aber es ist immer ratsam, einen Regenschirm in der Nähe zu haben, da das Wetter in dieser Jahreszeit unvorhersehbar sein kann.".split(" ");

function addClass(el,name) {
  el.className += ' '+name;
}
function removeClass(el,name) {
  el.className = el.className.replace(name,'');
}


function randomWord()
{
    return words[Math.floor(Math.random() * words.length)];

}

function formatWord(word) {
  return `<div class="word"><span class="letter">${word.split('').join('</span><span class="letter">')}</span></div>`;
}


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

document.getElementById("game").addEventListener("keyup", ev => {
    const key = ev.key;
    
    const currentLetter = document.querySelector(".letter.current");
    const expected = currentLetter?.innerHTML || " ";
    const isLetter = key.length === 1 && key != " ";
    const isSpace = key === " ";

    const currentWord = document.querySelector(".word.current");


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
            const letterTomakeBad = [...document.querySelectorAll('.word.current .letter:not(.correct)')];
            letterTomakeBad.forEach(letter => {
                addClass(letter, "skipped");
            });
        }
        removeClass(currentWord, "current");
        addClass(currentWord.nextSibling, "current");
        if (currentLetter)
        {
            removeClass(currentLetter, "current");
            
        }
        addClass(currentWord.nextSibling.firstChild, "current");
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