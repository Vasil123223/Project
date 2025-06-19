const field = document.querySelector('.field');
const scoreElem = document.getElementById('score');
const highscoreElem = document.getElementById('highscore');
const timerElem = document.getElementById('timer');
const gameOverElem = document.getElementById('gameOver');

let size = 2;
let counter = 1;
let score = 0;
let highscore = localStorage.getItem('highscore') || 0;
let timeLeft = 30;
let timer;

highscoreElem.textContent = highscore;

startTimer();
newGame();

function newGame() {
  counter = 1;
  field.innerHTML = '';
  const arr = shuffle(createArray(1, size * size));
  const chunks = chunk(arr, size);
  const cells = drawField(chunks);
  attachHandlers(cells);
}

function createArray(from, to) {
  const arr = [];
  for (let i = from; i <= to; i++) arr.push(i);
  return arr;
}

function shuffle(arr) {
  const copy = arr.slice();
  for (let i = copy.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [copy[i], copy[j]] = [copy[j], copy[i]];
  }
  return copy;
}

function chunk(arr, size) {
  const res = [];
  while (arr.length) res.push(arr.splice(0, size));
  return res;
}

function drawField(data) {
  const cells = [];
  for (let row of data) {
    const tr = document.createElement('tr');
    for (let val of row) {
      const td = document.createElement('td');
      td.textContent = val;
      tr.appendChild(td);
      cells.push(td);
    }
    field.appendChild(tr);
  }
  return cells;
}

function attachHandlers(cells) {
  for (let cell of cells) {
    cell.addEventListener('click', function () {
      if (parseInt(this.textContent) === counter) {
        this.classList.add('active');
        score += 10;
        updateScore();
        counter++;
        if (counter > size * size) {
          size++;
          timeLeft += 5;
          setTimeout(newGame, 500);
        }
      } else {
        this.style.backgroundColor = 'tomato';
        setTimeout(() => {
          this.style.backgroundColor = '';
        }, 300);
      }
    });
  }
}

function updateScore() {
  scoreElem.textContent = score;
  if (score > highscore) {
    highscore = score;
    localStorage.setItem('highscore', highscore);
    highscoreElem.textContent = highscore;
  }
}

function startTimer() {
  timer = setInterval(() => {
    timeLeft--;
    timerElem.textContent = timeLeft;
    if (timeLeft <= 0) {
      clearInterval(timer);
      field.innerHTML = '';
      gameOverElem.style.display = 'block';
    }
  }, 1000);
}
