const pdfInput = document.querySelector('#pdf-input');
const dropzone = document.querySelector('#dropzone');
const dropzoneIcon = document.querySelector('#dropzone-icon');
const dropzoneText = document.querySelector('#dropzone-text');
const dropzoneSubtext = document.querySelector('#dropzone-subtext');
const submitButton = document.querySelector('#analyze-submit');
const analyzeForm = document.querySelector('#analyze-form');
const analyzeError = document.querySelector('#analyze-error');
const analyzeOverlay = document.querySelector('#analyze-overlay');

const setSelectedFile = (file) => {
    if (!file) return;

    dropzoneIcon.textContent = 'task';
    dropzoneText.textContent = file.name;
    dropzoneSubtext.textContent = 'Click or drop to replace';
    submitButton.disabled = false;
};

dropzone?.addEventListener('click', () => pdfInput.click());

pdfInput?.addEventListener('change', () => setSelectedFile(pdfInput.files[0]));

['dragenter', 'dragover'].forEach((eventName) => {
    dropzone?.addEventListener(eventName, (event) => {
        event.preventDefault();
        dropzone.classList.add('border-primary', 'bg-surface-container-lowest/30');
    });
});

['dragleave', 'dragend'].forEach((eventName) => {
    dropzone?.addEventListener(eventName, (event) => {
        event.preventDefault();
        dropzone.classList.remove('border-primary', 'bg-surface-container-lowest/30');
    });
});

dropzone?.addEventListener('drop', (event) => {
    event.preventDefault();
    dropzone.classList.remove('border-primary', 'bg-surface-container-lowest/30');

    const file = event.dataTransfer.files[0];
    if (!file) return;

    if (file.type !== 'application/pdf') {
        if (analyzeError) {
            analyzeError.textContent = 'Please drop a PDF file.';
            analyzeError.classList.remove('hidden');
        }
        return;
    }

    pdfInput.files = event.dataTransfer.files;
    setSelectedFile(file);
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
