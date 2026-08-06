@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-800/20 border-primary-800/60 text-white placeholder-primary-200/40 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm']) }}>
