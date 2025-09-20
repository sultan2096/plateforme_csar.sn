import './bootstrap';

// Typewriter effect (word-by-word with optional letter-by-letter)
(() => {
  const heroEl = document.querySelector('[data-typewriter]');
  if (!heroEl) return;

  const text = heroEl.getAttribute('data-typewriter') || heroEl.textContent.trim();
  const mode = heroEl.getAttribute('data-typewriter-mode') || 'word'; // 'word' | 'letter'
  const wordDelay = Number(heroEl.getAttribute('data-typewriter-word-delay') || 450);
  const letterDelay = Number(heroEl.getAttribute('data-typewriter-letter-delay') || 45);
  const showCaret = (heroEl.getAttribute('data-typewriter-caret') || 'true') === 'true';

  heroEl.setAttribute('aria-live', 'polite');
  heroEl.setAttribute('aria-atomic', 'true');
  heroEl.style.whiteSpace = 'pre-wrap';

  const caret = document.createElement('span');
  caret.textContent = '▍';
  caret.style.marginLeft = '6px';
  caret.style.opacity = '0.8';
  caret.style.animation = 'tw-caret 1s steps(1,end) infinite';
  if (showCaret) heroEl.appendChild(caret);

  const setText = (t) => {
    heroEl.firstChild?.nodeType === Node.TEXT_NODE
      ? (heroEl.firstChild.nodeValue = t)
      : heroEl.insertBefore(document.createTextNode(t), heroEl.firstChild || heroEl);
  };

  const animateWordByWord = async () => {
    setText('');
    const words = text.split(/\s+/);
    let current = '';
    for (let i = 0; i < words.length; i++) {
      current += (i === 0 ? '' : ' ') + words[i];
      setText(current);
      await new Promise((r) => setTimeout(r, wordDelay));
    }
  };

  const animateLetterByLetter = async () => {
    setText('');
    for (let i = 0; i < text.length; i++) {
      setText(text.slice(0, i + 1));
      await new Promise((r) => setTimeout(r, letterDelay));
    }
  };

  const run = () => (mode === 'letter' ? animateLetterByLetter() : animateWordByWord());

  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    run();
  } else {
    document.addEventListener('DOMContentLoaded', run, { once: true });
  }
})();

// Inject caret keyframes if not present
(() => {
  const id = 'tw-caret-style';
  if (document.getElementById(id)) return;
  const style = document.createElement('style');
  style.id = id;
  style.textContent = '@keyframes tw-caret{0%{opacity:1}50%{opacity:0}100%{opacity:1}}';
  document.head.appendChild(style);
})();
