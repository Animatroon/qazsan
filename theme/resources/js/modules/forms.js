const API = window.qazaqstanApi || { root: '/wp-json/qazaqstan/v1/', nonce: '' };

async function postJson(endpoint, data) {
  const res = await fetch(API.root + endpoint, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': API.nonce },
    body: JSON.stringify(data),
  });
  return res.json();
}

function collectForm(form) {
  const data = {};
  new FormData(form).forEach((value, key) => { data[key] = value; });
  return data;
}

function setStatus(form, message, isError = false) {
  const el = form.querySelector('.contact-form__status, .booking-form__status');
  if (!el) return;
  el.textContent = message;
  el.className = el.className.replace('hidden', '').replace('error', '').replace('success', '').trim();
  el.classList.add(isError ? 'error' : 'success');
}

function clearErrors(form) {
  form.querySelectorAll('.field-error').forEach(e => e.remove());
  form.querySelectorAll('.booking-form__input--error, .contact-form__input--error').forEach(el => {
    el.classList.remove('booking-form__input--error', 'contact-form__input--error');
  });
}

function showErrors(form, errors) {
  clearErrors(form);
  Object.entries(errors).forEach(([field, msg]) => {
    const input = form.querySelector(`[name="${field}"]`);
    if (!input) return;
    input.classList.add(input.closest('.booking-form__group') ? 'booking-form__input--error' : 'contact-form__input--error');
    const err = document.createElement('p');
    err.className = 'field-error text-[13px] text-red-500 mt-1';
    err.textContent = msg;
    input.parentNode.insertBefore(err, input.nextSibling);
  });
}

function setLoading(btn, loading) {
  btn.disabled = loading;
  btn.dataset.origText = btn.dataset.origText || btn.textContent;
  btn.textContent = loading ? '...' : btn.dataset.origText;
}

function initBookingForms() {
  document.querySelectorAll('[data-booking-form]').forEach(form => {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      clearErrors(form);
      const btn = form.querySelector('[type="submit"]');
      setLoading(btn, true);
      try {
        const data = collectForm(form);
        const res = await postJson('booking', data);
        if (res.success) {
          setStatus(form, res.message);
          form.reset();
        } else if (res.errors) {
          showErrors(form, res.errors);
        } else {
          setStatus(form, res.message || 'Ошибка. Попробуйте ещё раз.', true);
        }
      } catch {
        setStatus(form, 'Ошибка соединения. Позвоните нам напрямую.', true);
      } finally {
        setLoading(btn, false);
      }
    });
  });
}

function initAppealForms() {
  document.querySelectorAll('[data-appeal-form]').forEach(form => {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      clearErrors(form);
      const btn = form.querySelector('[type="submit"]');
      setLoading(btn, true);
      try {
        const data = collectForm(form);
        const res = await postJson('appeal', data);
        if (res.success) {
          setStatus(form, res.message);
          form.reset();
        } else if (res.errors) {
          showErrors(form, res.errors);
        } else {
          setStatus(form, res.message || 'Ошибка. Попробуйте ещё раз.', true);
        }
      } catch {
        setStatus(form, 'Ошибка соединения.', true);
      } finally {
        setLoading(btn, false);
      }
    });
  });
}

function initApplyForms() {
  document.querySelectorAll('[data-apply-form]').forEach(form => {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      clearErrors(form);
      const btn = form.querySelector('[type="submit"]');
      setLoading(btn, true);
      try {
        const data = collectForm(form);
        const res = await postJson('apply', data);
        if (res.success) {
          setStatus(form, res.message);
          form.reset();
        } else if (res.errors) {
          showErrors(form, res.errors);
        } else {
          setStatus(form, res.message || 'Ошибка.', true);
        }
      } catch {
        setStatus(form, 'Ошибка соединения.', true);
      } finally {
        setLoading(btn, false);
      }
    });
  });
}

export function initForms() {
  initBookingForms();
  initAppealForms();
  initApplyForms();
}
