<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-outline-variant rounded-md font-semibold text-xs text-on-surface-variant uppercase tracking-widest shadow-sm hover:bg-surface-container-lowest focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
