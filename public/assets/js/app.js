document.addEventListener('DOMContentLoaded', () => {
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

    form.addEventListener('submit', (event) => {
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
