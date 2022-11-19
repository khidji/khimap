const eyeElements =
  document.querySelectorAll('.eye--open') ?? document.querySelectorAll('.eye--close');
const inputElements = document.querySelectorAll('input');
const formElement = document.querySelector('form');
const blurElement = document.querySelector('.blur');
const passwordElement = Array.from(document.querySelectorAll('input[type="password"]'));
const passwordDontMatchElement = document.querySelector('.error--password');

for (const eyeElement of eyeElements) {
  eyeElement.addEventListener('click', () => {
    eyeElement.classList.toggle('eye--open');
    eyeElement.classList.toggle('eye--close');

    const passwordInput = eyeElement.parentElement.querySelector('input');

    passwordInput.type === 'text'
      ? (passwordInput.type = 'password')
      : (passwordInput.type = 'text');
  });
}

for (const input of inputElements) {
  input.addEventListener('input', () => {
    if (passwordElement[0].value && passwordElement[0].value === passwordElement[1].value) {
      if (passwordDontMatchElement) {
        passwordDontMatchElement.remove();
      }
    }

    input.classList.remove('error');
    const parent = input.closest('div');

    if (parent.nextElementSibling.classList.contains('error')) {
      parent.nextElementSibling.remove();
    }
  });
}

blurElement.style.height = formElement.getBoundingClientRect().height + 'px';
