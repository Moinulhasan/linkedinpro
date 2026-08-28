const report = document.querySelector('.audit-report');

if (report) {
    const headings = report.querySelectorAll('h2');

    if (headings.length > 1) {
        const slugify = (text) => text
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');

        const toc = document.createElement('nav');
        toc.className = 'audit-toc';

        headings.forEach((heading) => {
            const id = slugify(heading.textContent);
            heading.id = id;

            const link = document.createElement('a');
            link.href = `#${id}`;
            link.textContent = heading.textContent;
            toc.appendChild(link);
        });

        report.parentElement.insertBefore(toc, report);
    }
}

window.pollAuditStatus = function pollAuditStatus(statusUrl) {
    const statuses = [
        'Analyzing headline impact...',
        'Evaluating network strength...',
        'Scanning media richness...',
        'Assessing keyword density...',
        'Compiling final strategy...',
    ];

    const statusEl = document.getElementById('status-text');
    const progressFill = document.getElementById('progress-fill');
    const progressPercentage = document.getElementById('progress-percentage');

    let step = 0;
    let progress = 10;

    const bumpProgress = () => {
        step = Math.min(step + 1, statuses.length - 1);
        progress = Math.min(90, progress + Math.random() * 15 + 5);

        statusEl.style.opacity = 0;
        setTimeout(() => {
            statusEl.textContent = statuses[step];
            progressFill.style.width = `${progress}%`;
            progressPercentage.textContent = `${Math.round(progress)}%`;
            statusEl.style.opacity = 1;
        }, 300);
    };

    const progressTimer = setInterval(bumpProgress, 2500);

    const poll = async () => {
        const response = await fetch(statusUrl);
        const data = await response.json();

        if (data.status === 'completed' && data.redirect) {
            clearInterval(progressTimer);
            progressFill.style.width = '100%';
            progressPercentage.textContent = '100%';
            window.location.href = data.redirect;
            return;
        }

        if (data.status === 'failed') {
            clearInterval(progressTimer);
            statusEl.textContent = data.error || 'Something went wrong during analysis.';
            return;
        }

        setTimeout(poll, 3000);
    };

    poll();
};

if (window.auditStatusUrl) {
    window.pollAuditStatus(window.auditStatusUrl);
}
