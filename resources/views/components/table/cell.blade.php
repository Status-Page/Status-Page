{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

<td {{ $attributes->merge(['class' => 'px-6 py-4 whitespace-no-wrap text-sm leading-5 text-cool-gray-900']) }}>
    {{ $slot }}
</td>
