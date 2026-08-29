<div class="w-full glass-panel ambient-shadow rounded-2xl p-stack-md relative group overflow-hidden">
    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_2s_infinite]"></div>
    <form id="analyze-form" action="{{ route('profile-audits.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
        @csrf
        <div class="relative flex items-center bg-surface-container-lowest/50 rounded-xl px-4 py-3 border border-outline-variant/30 opacity-50 cursor-not-allowed mb-3">
            <span class="material-symbols-outlined text-outline mr-3">link</span>
            <input class="w-full bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface placeholder:text-outline-variant p-0 cursor-not-allowed" placeholder="Paste LinkedIn Profile URL... (Coming Soon)" type="url" disabled>
        </div>

        <input type="file" name="pdf" id="pdf-input" accept="application/pdf" class="hidden">
        <div id="dropzone" class="border-2 border-dashed border-outline-variant/50 rounded-xl p-8 text-center cursor-pointer transition-colors hover:border-primary/60 hover:bg-surface-container-lowest/30">
            <span class="material-symbols-outlined text-4xl text-outline mb-2 block" id="dropzone-icon">upload_file</span>
            <p class="text-on-surface font-medium" id="dropzone-text">Drag &amp; drop your LinkedIn PDF here</p>
            <p class="text-on-surface-variant text-sm mt-1" id="dropzone-subtext">or click to browse</p>
        </div>

        <button id="analyze-submit" class="w-full mt-3 bg-primary hover:bg-surface-tint text-on-primary font-body-md text-body-md font-semibold px-8 py-3 rounded-xl transition-all shadow-md active:scale-95 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed" type="submit" disabled>
            Analyze
            <span class="material-symbols-outlined ml-2 text-sm">arrow_forward</span>
        </button>
    </form>
    <p id="analyze-error" class="hidden text-error text-sm mt-3 relative z-10"></p>
</div>
