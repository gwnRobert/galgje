<!DOCTYPE html>
<html>
<head>
  <title>Galgje</title>
  <style>#game-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

#game-content {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  margin-bottom: 20px;
}

#word-display {
  margin-right: 20px;
}

#hangman-container {
  width: 200px;
  height: 200px;
}

#hangman {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

#keyboard {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

.key {
  width: 30px;
  height: 30px;
  border: 1px solid black;
  margin: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}
</style>
</head>
<body id="body">
  <h1>Galgje</h1>
  <div id="word-container">
    <h2>Kies een woord:</h2>
    <button onclick="chooseWordManually()">Zelf woord invoeren</button>
    <button onclick="chooseRandomWord()">Willekeurig woord</button>
  </div>

  <div id="game-container" style="display: none;">
    <div id="game-content">
      <div id="word-display"></div>
      <div id="hangman-container">
        <img id="hangman" src="hangman_0.png" alt="Hangman">
      </div>
    </div>
    <h3>Fouten: <span id="mistakes">0</span>/6</h3>
    <div id="keyboard">
      <!-- Letters A to Z -->
    </div>
    <!--<button onclick="resetGame()">Opnieuw spelen</button>-->
  </div>

  <script>const words = ['apple', 'banana', 'cherry', 'date', 'elderberry']; // Example word list

let chosenWord = '';
let displayedWord = '';
let mistakes = 0;

function chooseWordManually() {
  const input = prompt('Voer een woord in:');
  if (input && input.trim() !== '') {
    chosenWord = input.trim().toLowerCase();
    initializeGame();
  }
}

function chooseRandomWord() {
  chosenWord = words[Math.floor(Math.random() * words.length)];
  initializeGame();
}

function initializeGame() {
  document.getElementById('word-container').style.display = 'none';
  document.getElementById('game-container').style.display = 'block';
  document.getElementById('word-display').textContent = getDisplayedWord();
  createKeyboard();
}

function getDisplayedWord() {
  displayedWord = '';
  for (let i = 0; i < chosenWord.length; i++) {
    if (chosenWord[i] === ' ') {
      displayedWord += ' ';
    } else {
      displayedWord += '_';
    }
  }
  return displayedWord;
}

function createKeyboard() {
  const keyboard = document.getElementById('keyboard');
  for (let i = 0; i < 26; i++) {
    const letter = String.fromCharCode(97 + i);
    const key = document.createElement('div');
    key.className = 'key';
    key.textContent = letter;
    key.addEventListener('click', () => checkLetter(letter));
    keyboard.appendChild(key);
  }
}




function checkLetter(letter) {
  if (chosenWord.includes(letter)) {
    for (let i = 0; i < chosenWord.length; i++) {
      if (chosenWord[i] === letter) {
        displayedWord = displayedWord.substring(0, i) + letter + displayedWord.substring(i + 1);
      }
    }
    document.getElementById('word-display').textContent = displayedWord;
    if (!displayedWord.includes('_')) {
      endGame(true);
    }
  } else {
    mistakes++;
    document.getElementById('mistakes').textContent = mistakes;
    document.getElementById('hangman').src = `hangman_${mistakes}.png`;
    if (mistakes === 6) {
      endGame(false);
    }
  }
}

function endGame(isWin) {
  const message = isWin ? 'Gefeliciteerd! Je hebt gewonnen!' : 'Helaas, je hebt verloren!';
  const keyboard = document.getElementById('keyboard');
  keyboard.classList.add('hidden');
  const restartButton = document.createElement('button');
  restartButton.textContent = 'Opnieuw spelen';
  restartButton.addEventListener('click', resetGame);
  document.getElementById('game-container').appendChild(restartButton);
  document.getElementById('word-display').textContent = message;
}

function resetGame() {
  chosenWord = '';
  displayedWord = '';
  mistakes = 0;
  document.getElementById('hangman').src = 'hangman_0.png';
  document.getElementById('mistakes').textContent = 0;
  document.getElementById('keyboard').innerHTML = '';
  document.getElementById('keyboard').classList.remove('hidden');
  document.getElementById('word-container').style.display = 'block';
  document.getElementById('game-container').style.display = 'none';
}
</script>
</body>
</html>
