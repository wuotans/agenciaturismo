document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('[data-header]');
  const menu = document.querySelector('[data-menu]');
  const toggle = document.querySelector('[data-menu-toggle]');

  const syncHeader = () => {
    if (header) header.classList.toggle('scrolled', window.scrollY > 40);
  };
  syncHeader();
  window.addEventListener('scroll', syncHeader, { passive: true });

  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const open = menu.classList.toggle('open');
      document.body.classList.toggle('menu-open', open);
      toggle.textContent = open ? 'Fechar' : 'Menu';
    });
    menu.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
      menu.classList.remove('open');
      document.body.classList.remove('menu-open');
      toggle.textContent = 'Menu';
    }));
  }

  const reveals = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));
  } else {
    reveals.forEach(el => el.classList.add('is-visible'));
  }

  const form = document.querySelector('#whatsapp-form');
  if (form) {
    const start = form.querySelector('[name="start_date"]');
    const end = form.querySelector('[name="end_date"]');
    const today = new Date().toISOString().slice(0, 10);
    start.min = today;
    end.min = today;
    start.addEventListener('change', () => {
      end.min = start.value || today;
      if (end.value && end.value < start.value) end.value = start.value;
    });

    form.addEventListener('submit', event => {
      event.preventDefault();
      const data = new FormData(form);
      const number = form.dataset.whatsapp;
      const tour = form.dataset.tour;
      const date = value => {
        const [y, m, d] = value.split('-');
        return `${d}/${m}/${y}`;
      };
      const message = [
        'Olá! Gostaria de solicitar um orçamento para o Pantanal.',
        '',
        `Nome: ${data.get('name')}`,
        `Passeio: ${tour}`,
        `Adultos: ${data.get('adults')}`,
        `Crianças: ${data.get('children')}`,
        `Entrada: ${date(data.get('start_date'))}`,
        `Saída: ${date(data.get('end_date'))}`,
        '',
        'Podem me passar disponibilidade e valores para esse período?'
      ].join('\n');
      window.open(`https://wa.me/${number}?text=${encodeURIComponent(message)}`, '_blank', 'noopener');
    });
  }
});