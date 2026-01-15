@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}>;

<!--
<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#d5a293]-300 dark:border-[#d5a293]-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#d5a293]-500 dark:focus:border-[#d5a293]-600 focus:ring-[#d5a293]-500 dark:focus:ring-[#d5a293]-600 rounded-md shadow-sm']) }}>
-->