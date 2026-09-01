(() => {
  const mobileCss = document.createElement('link');
  mobileCss.rel = 'stylesheet';
  mobileCss.href = 'assets/css/mobile.css';
  document.head.appendChild(mobileCss);
})();

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

  const trustIcons = [
    '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="14" cy="13" r="5"/><circle cx="26" cy="9" r="5"/><circle cx="37" cy="15" r="5"/><path d="M12 31c0-8 6-14 13-14s13 6 13 14c0 6-5 9-13 9s-13-3-13-9Z"/></svg>',
    '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M15 17h18l5 17H10l5-17Z"/><path d="M19 17V9h10v8"/><circle cx="16" cy="34" r="5"/><circle cx="32" cy="34" r="5"/></svg>',
    '<svg viewBox="0 0 64 48" aria-hidden="true"><path d="M4 27h30l5 7H9l-5-7Z"/><path d="M11 18h18l5 9H7l4-9Z"/><circle cx="14" cy="35" r="5"/><circle cx="29" cy="35" r="5"/><path d="M43 31c5-5 10-7 17-6-2 7-7 12-15 14l-5-4 3-4Z"/><path d="M44 29h15"/></svg>',
    '<svg viewBox="0 0 48 48" aria-hidden="true"><rect x="7" y="14" width="34" height="25" rx="4"/><path d="M16 14l3-6h10l3 6"/><circle cx="24" cy="27" r="7"/></svg>',
    '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 41c0-16 6-27 17-33-1 14-7 24-17 29"/><path d="M24 41C22 25 16 15 7 11c0 13 5 22 17 26"/><path d="M24 40V22"/></svg>'
  ];
  document.querySelectorAll('.trust-strip > div').forEach((item, index) => {
    if (!item.querySelector('.trust-icon') && trustIcons[index]) {
      const icon = document.createElement('span');
      icon.className = 'trust-icon';
      icon.innerHTML = trustIcons[index];
      item.prepend(icon);
    }
  });

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

  const setupDates = form => {
    const start = form.querySelector('[name="start_date"]');
    const end = form.querySelector('[name="end_date"]');
    if (!start || !end) return;
    const today = new Date().toISOString().slice(0, 10);
    start.min = today;
    end.min = today;
    start.addEventListener('change', () => {
      end.min = start.value || today;
      if (end.value && end.value < start.value) end.value = start.value;
    });
  };

  const formatDate = value => {
    if (!value) return '-';
    const [y, m, d] = value.split('-');
    return `${d}/${m}/${y}`;
  };

  const form = document.querySelector('#whatsapp-form');
  if (form) {
    setupDates(form);
    form.addEventListener('submit', event => {
      event.preventDefault();
      const data = new FormData(form);
      const message = [
        'Olá! Gostaria de solicitar um orçamento para o Pantanal.', '',
        `Nome: ${data.get('name')}`,
        `Passeio: ${form.dataset.tour}`,
        `Adultos: ${data.get('adults')}`,
        `Crianças: ${data.get('children')}`,
        `Entrada: ${formatDate(data.get('start_date'))}`,
        `Saída: ${formatDate(data.get('end_date'))}`, '',
        'Podem me passar disponibilidade e valores para esse período?'
      ].join('\n');
      window.open(`https://wa.me/${form.dataset.whatsapp}?text=${encodeURIComponent(message)}`, '_blank', 'noopener');
    });
  }

  const generalForm = document.querySelector('#general-whatsapp-form');
  if (generalForm) {
    setupDates(generalForm);
    generalForm.addEventListener('submit', event => {
      event.preventDefault();
      const data = new FormData(generalForm);
      const message = [
        'Olá! Quero planejar uma viagem ao Pantanal.', '',
        `Nome: ${data.get('name')}`,
        `Experiência de interesse: ${data.get('tour')}`,
        `Adultos: ${data.get('adults')}`,
        `Crianças: ${data.get('children')}`,
        `Entrada: ${formatDate(data.get('start_date'))}`,
        `Saída: ${formatDate(data.get('end_date'))}`,
        `Preferências: ${data.get('notes') || 'Não informado'}`, '',
        'Podem montar uma sugestão de roteiro para esse período?'
      ].join('\n');
      window.open(`https://wa.me/${generalForm.dataset.whatsapp}?text=${encodeURIComponent(message)}`, '_blank', 'noopener');
    });
  }
});