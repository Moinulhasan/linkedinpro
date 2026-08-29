<div id="analyze-overlay" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-margin-mobile bg-on-surface/60 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-stack-lg w-full max-w-sm text-center">
        <div class="relative w-20 h-20 mx-auto mb-stack-md flex items-center justify-center">
            <div class="absolute inset-0 rounded-full border-4 border-primary/20 pulse-orb"></div>
            <div class="w-14 h-14 rounded-full bg-primary-container/15 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-3xl">memory</span>
            </div>
        </div>
        <h2 class="font-headline-md text-headline-md text-on-surface mb-1">Analyzing Your Profile</h2>
        <p class="text-on-surface-variant text-sm mb-stack-md" id="status-text">Analyzing headline impact...</p>
        <div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden">
            <div class="h-full bg-primary progress-bar-fill" id="progress-fill" style="width: 10%"></div>
        </div>
        <p class="text-xs text-on-surface-variant mt-2" id="progress-percentage">10%</p>
    </div>
</div>
