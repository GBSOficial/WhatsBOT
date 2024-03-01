const switcher = document.querySelector('.button-toggle');

switcher.addEventListener('click', function () {
  document.body.classList.toggle('dark-mode');

  if (document.body.classList.contains('dark-mode')) {
    this.textContent = "☀️";
    document.body.style.setProperty("--color-fundo", "#ffffff");
    document.body.style.setProperty("--color-text", "#000000");
    document.body.style.setProperty("--color-logo", "#000000");
    document.getElementById("sun-icon").style.display = "none";
    document.getElementById("moon-icon").style.display = "inline";
  } else {
    this.textContent = "🌙";
    document.body.style.setProperty("--color-fundo", "#000000");
    document.body.style.setProperty("--color-text", "#ffffff");
    document.body.style.setProperty("--color-logo", "#ffffff");
    document.getElementById("sun-icon").style.display = "inline";
    document.getElementById("moon-icon").style.display = "none";
  }
});