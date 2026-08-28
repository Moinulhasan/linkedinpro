@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-outline-variant focus:border-primary focus:ring-primary rounded-md shadow-sm']) }}>
