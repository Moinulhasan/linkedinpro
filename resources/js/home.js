const pdfInput = document.querySelector('#pdf-input');
const pdfTrigger = document.querySelector('#pdf-trigger');
const pdfLabel = document.querySelector('#pdf-label');
const submitButton = document.querySelector('#analyze-submit');
const analyzeForm = document.querySelector('#analyze-form');
const analyzeError = document.querySelector('#analyze-error');
const analyzeOverlay = document.querySelector('#analyze-overlay');

pdfTrigger?.addEventListener('click', () => pdfInput.click());

pdfInput?.addEventListener('change', () => {
    const file = pdfInput.files[0];
    pdfLabel.textContent = file ? file.name : 'Upload PDF';
    submitButton.disabled = !file;
});

analyzeForm?.addEventListener('submit', async (event) => {
    event.preventDefault();

    submitButton.disabled = true;
    analyzeError?.classList.add('hidden');

    try {
        const response = await fetch(analyzeForm.action, {
            method: 'POST',
            body: new FormData(analyzeForm),
            headers: { Accept: 'application/json' },
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Something went wrong. Please try again.');
        }

        analyzeOverlay.classList.remove('hidden');
        window.pollAuditStatus(data.status_url);
    } catch (error) {
        submitButton.disabled = false;
        if (analyzeError) {
            analyzeError.textContent = error.message;
            analyzeError.classList.remove('hidden');
        }
    }
});
