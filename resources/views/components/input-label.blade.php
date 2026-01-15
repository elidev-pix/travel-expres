@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#d5a293] dark:text-[#d5a293]']) }}>
    {{ $value ?? $slot }}
</label>
