import './bootstrap';

const menuButton = document.getElementById('menuButton');
const mobileMenu = document.getElementById('mobileMenu');

if (menuButton && mobileMenu) {
    menuButton.addEventListener('click', () => {
        const open = mobileMenu.classList.toggle('open');
        menuButton.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.getElementById('mobileOverlay')?.classList.toggle('open', open);
        document.body.classList.toggle('menu-open', open);
    });
}

document.getElementById('mobileOverlay')?.addEventListener('click', () => {
    mobileMenu?.classList.remove('open');
    menuButton?.setAttribute('aria-expanded', 'false');
    document.getElementById('mobileOverlay')?.classList.remove('open');
    document.body.classList.remove('menu-open');
});

function updateIndiaClock() {
    const timeNode = document.getElementById('indiaTime');
    const dateNode = document.getElementById('indiaDate');
    if (!timeNode || !dateNode) return;

    const now = new Date();
    timeNode.textContent = now.toLocaleTimeString('en-IN', {
        hour: '2-digit', minute: '2-digit', second: '2-digit',
        hour12: false, timeZone: 'Asia/Kolkata'
    });
    dateNode.textContent = now.toLocaleDateString('en-IN', {
        weekday: 'short', day: 'numeric', month: 'short', year: 'numeric',
        timeZone: 'Asia/Kolkata'
    });
}

updateIndiaClock();
setInterval(updateIndiaClock, 1000);

const carousel = document.querySelector('[data-carousel]');
if (carousel) {
    const slides = [...carousel.querySelectorAll('[data-slide]')];
    const dots = [...carousel.querySelectorAll('[data-carousel-dot]')];
    let slideIndex = 0;

    const showSlide = (index) => {
        slideIndex = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => slide.classList.toggle('active', i === slideIndex));
        dots.forEach((dot, i) => dot.classList.toggle('active', i === slideIndex));
    };

    dots.forEach((dot, i) => dot.addEventListener('click', () => showSlide(i)));
    carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', () => showSlide(slideIndex - 1));
    carousel.querySelector('[data-carousel-next]')?.addEventListener('click', () => showSlide(slideIndex + 1));
    setInterval(() => showSlide(slideIndex + 1), 6000);
}

const socialToggle = document.getElementById('socialToggle');
const socialActions = document.getElementById('socialActions');

if (socialToggle && socialActions) {
    socialToggle.addEventListener('click', () => {
        const open = socialActions.classList.toggle('open');
        socialToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
}

const revealItems = document.querySelectorAll('[data-scroll-reveal]');
if (revealItems.length) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    revealItems.forEach((item) => revealObserver.observe(item));
}

const productZoom = document.querySelector('[data-product-zoom]');
if (productZoom) {
    const image = productZoom.querySelector('[data-product-zoom-image]');
    const zoomOut = document.querySelector('[data-product-zoom-out]');
    const zoomIn = document.querySelector('[data-product-zoom-in]');
    const zoomReset = document.querySelector('[data-product-zoom-reset]');
    const zoomLevel = document.querySelector('[data-product-zoom-level]');
    let scale = 1;
    const minScale = 1;
    const maxScale = 2.5;
    const step = 0.25;

    const updateZoom = () => {
        if (!image || !zoomOut || !zoomIn || !zoomReset || !zoomLevel) return;
        image.style.transform = `scale(${scale})`;
        zoomLevel.textContent = `${Math.round(scale * 100)}%`;
        zoomOut.disabled = scale <= minScale;
        zoomIn.disabled = scale >= maxScale;
        zoomReset.disabled = scale === minScale;
    };

    zoomOut?.addEventListener('click', () => {
        scale = Math.max(minScale, scale - step);
        updateZoom();
    });
    zoomIn?.addEventListener('click', () => {
        scale = Math.min(maxScale, scale + step);
        updateZoom();
    });
    zoomReset?.addEventListener('click', () => {
        scale = minScale;
        updateZoom();
    });
    updateZoom();
}

    const welcomeModal = document.getElementById('welcomeModal');
    const welcomeModalClose = document.getElementById('welcomeModalClose');
    const welcomeModalBackdrop = document.getElementById('welcomeModalBackdrop');

    function closeWelcomeModal() {
        if (!welcomeModal) return;
        welcomeModal.classList.remove('open');
        welcomeModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    if (welcomeModal) {
        window.setTimeout(() => {
            welcomeModal.classList.add('open');
            welcomeModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
        }, welcomeModal.dataset.openImmediately === 'true' ? 100 : 5000);
    }

    welcomeModalClose?.addEventListener('click', closeWelcomeModal);
    welcomeModalBackdrop?.addEventListener('click', closeWelcomeModal);
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeWelcomeModal();
    });

    const catalogFilterToggle = document.getElementById('catalogFilterToggle');
    const catalogFilters = document.getElementById('catalogFilters');
    const catalogFilterLabel = document.getElementById('catalogFilterLabel');

    if (catalogFilterToggle && catalogFilters) {
        catalogFilterToggle.addEventListener('click', () => {
            const open = catalogFilters.classList.toggle('open');
            catalogFilterToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (catalogFilterLabel) catalogFilterLabel.textContent = open ? 'Hide filters' : 'Show filters';
        });
    }

    document.addEventListener('click', (event) => {
        const opener = event.target.closest('[data-admin-modal-open]');
        if (opener) {
            const dialog = document.getElementById(opener.dataset.adminModalOpen);
            const form = dialog?.querySelector('[data-admin-modal-form]');
            if (!dialog || !form) return;

            form.reset();
            form.action = form.dataset.createAction;
            const methodField = form.querySelector('[data-method-field]');
            methodField?.removeAttribute('name');

            const recordId = opener.dataset.recordId;
            const editing = Boolean(recordId);
            if (editing) {
                form.action = `${form.dataset.updateBase}/${encodeURIComponent(recordId)}`;
                if (methodField) {
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                }

                form.querySelectorAll('[name]').forEach((field) => {
                    if (field.name === '_token' || field.name === '_method') return;
                    if (field.type === 'file') return;
                    const key = `record${field.name.split('_').map((part) => part.charAt(0).toUpperCase() + part.slice(1)).join('')}`;
                    const value = opener.dataset[key];
                    if (value === undefined) return;
                    if (field.type === 'checkbox') field.checked = value === '1';
                    else field.value = value;
                });
            }

            const title = form.querySelector('[data-modal-title]');
            const submit = form.querySelector('[data-modal-submit]');
            if (title) title.textContent = editing ? form.dataset.editTitle : form.dataset.createTitle;
            if (submit) submit.textContent = editing ? form.dataset.editSubmit : form.dataset.createSubmit;
            const imageInput = form.querySelector('[data-product-image-input]');
            if (imageInput) {
                imageInput.required = !editing;
                setProductImagePreview(
                    form,
                    editing ? opener.dataset.recordImageUrl : '',
                    editing ? 'Current product image. Upload a new image to replace it.' : 'Upload a JPG, PNG, or WebP image (max 5 MB).'
                );
            }
            const stockInput = form.querySelector('[data-product-stock-input]');
            if (stockInput) stockInput.required = !editing;
            if (!editing) updateProductSku(form);
            updateCategoryIconPreview(form);
            dialog.showModal();
            form.querySelector('input:not([type="hidden"]), select, textarea')?.focus();
            return;
        }

        const closer = event.target.closest('[data-admin-modal-close]');
        closer?.closest('dialog')?.close();
    });

    function updateCategoryIconPreview(form) {
        const input = form.querySelector('[data-category-icon-input]');
        const preview = form.querySelector('[data-category-icon-preview]');
        const message = form.querySelector('[data-category-icon-message]');
        const templates = form.querySelectorAll('[data-category-icon-template]');
        if (!input || !preview || !message) return;

        const iconName = input.value.trim().toLowerCase();
        const template = [...templates].find((item) => item.dataset.categoryIconTemplate === iconName);
        preview.replaceChildren();

        if (template) {
            preview.append(template.firstElementChild.cloneNode(true));
            message.textContent = `Previewing ${iconName}.`;
        } else {
            message.textContent = iconName ? 'No matching icon. Choose a name from the suggestions.' : 'Type an icon name to preview it.';
        }
    }

    document.querySelectorAll('[data-category-icon-input]').forEach((input) => {
        input.addEventListener('input', () => updateCategoryIconPreview(input.form));
        updateCategoryIconPreview(input.form);
    });

    function updateProductSku(form) {
        const name = form.querySelector('[data-product-name-input]');
        const sku = form.querySelector('[data-product-sku-input]');
        if (!name || !sku) return;

        const productName = name.value.trim();
        const base = productName.toUpperCase().replace(/[^A-Z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        sku.value = base ? `JPL-${base}` : (productName ? 'JPL-PRODUCT' : '');
    }

    function setProductImagePreview(form, src, status) {
        const preview = form.querySelector('[data-product-image-preview]');
        const message = form.querySelector('[data-product-image-status]');
        if (!preview || !message) return;

        if (preview.dataset.objectUrl) {
            URL.revokeObjectURL(preview.dataset.objectUrl);
            delete preview.dataset.objectUrl;
        }

        preview.src = src || '';
        if (src?.startsWith('blob:')) preview.dataset.objectUrl = src;
        preview.hidden = !src;
        message.textContent = status;
    }

    document.querySelectorAll('[data-product-name-input]').forEach((input) => {
        input.addEventListener('input', () => updateProductSku(input.form));
        updateProductSku(input.form);
    });

    document.querySelectorAll('[data-product-image-input]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) return;

            const objectUrl = URL.createObjectURL(file);
            setProductImagePreview(input.form, objectUrl, file.name);
        });
    });

    document.querySelectorAll('dialog.admin-modal').forEach((dialog) => {
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) dialog.close();
        });

        if (dialog.dataset.openOnError === 'true') dialog.showModal();
    });

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('form[data-confirm]');
        if (form && !window.confirm(form.dataset.confirm)) event.preventDefault();
    });

    const modalFromHash = document.getElementById(window.location.hash.slice(1));
    if (modalFromHash instanceof HTMLDialogElement && modalFromHash.classList.contains('admin-modal')) {
        modalFromHash.showModal();
    }

const globalLoader = document.getElementById('globalLoader');

if (globalLoader) {
    let navigationStarted = false;
    let loaderShownAt = performance.now();
    let hideTimer;

    document.body.setAttribute('aria-busy', 'true');

    const hideGlobalLoader = (immediate = false) => {
        window.clearTimeout(hideTimer);
        const minimumDisplay = 250;
        const elapsed = performance.now() - loaderShownAt;
        const delay = immediate ? 0 : Math.max(0, minimumDisplay - elapsed);

        hideTimer = window.setTimeout(() => {
            globalLoader.classList.add('is-hidden');
            globalLoader.setAttribute('aria-hidden', 'true');
            document.body.setAttribute('aria-busy', 'false');
        }, delay);
    };

    const showGlobalLoader = () => {
        navigationStarted = true;
        window.clearTimeout(hideTimer);
        loaderShownAt = performance.now();
        globalLoader.classList.remove('is-hidden');
        globalLoader.setAttribute('aria-hidden', 'false');
        document.body.setAttribute('aria-busy', 'true');
    };

    if (document.readyState === 'complete') {
        hideGlobalLoader();
    } else {
        window.addEventListener('load', () => {
            if (!navigationStarted) hideGlobalLoader();
        }, { once: true });
    }

    window.addEventListener('pageshow', (event) => {
        if (!event.persisted) return;
        navigationStarted = false;
        hideGlobalLoader(true);
    });

    window.addEventListener('beforeunload', showGlobalLoader);

    document.addEventListener('submit', (event) => {
        if (event.defaultPrevented) return;

        const form = event.target;
        if (!(form instanceof HTMLFormElement) || form.hasAttribute('data-no-loader')) return;

        const target = event.submitter?.getAttribute('formtarget') || form.getAttribute('target');
        if (target && target.toLowerCase() !== '_self') return;

        const dialog = form.closest('dialog');
        if (dialog?.open) dialog.close();
        showGlobalLoader();
    });

    document.addEventListener('click', (event) => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        if (!(event.target instanceof Element)) return;

        const link = event.target.closest('a[href]');
        if (!link || link.hasAttribute('download') || link.hasAttribute('data-no-loader')) return;

        const target = link.getAttribute('target');
        if (target && target.toLowerCase() !== '_self') return;

        const destination = new URL(link.href, window.location.href);
        if (destination.origin !== window.location.origin) return;
        if (destination.pathname === window.location.pathname && destination.search === window.location.search && destination.hash) return;

        showGlobalLoader();
    });
}
