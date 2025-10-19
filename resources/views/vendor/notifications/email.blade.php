<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <div style="background:#2563eb; padding:20px; text-align:center; color:#fff; font-weight:bold;">
            SD-prime Pharmacy
        </div>
    </x-slot:header>

    {{-- Body --}}
    <x-mail::message>
        {{-- Greeting --}}
        @if (! empty($greeting))
            # {{ $greeting }}
        @else
            @if ($level === 'error')
                # @lang('Whoops!')
            @else
                # @lang('Hello!')
            @endif
        @endif

        {{-- Intro Lines --}}
        @foreach ($introLines as $line)
            {{ $line }}

        @endforeach

        {{-- Action Button --}}
        @isset($actionText)
            @php
                $color = match ($level) {
                    'success', 'error' => $level,
                    default => 'primary',
                };
            @endphp
            <x-mail::button :url="$actionUrl" :color="$color">
                {{ $actionText }}
            </x-mail::button>
        @endisset

        {{-- Outro Lines --}}
        @foreach ($outroLines as $line)
            {{ $line }}

        @endforeach

        {{-- Salutation --}}
        @if (! empty($salutation))
            {{ $salutation }}
        @else
            @lang('Regards'),<br>
            SD-prime Pharmacy
        @endif

        {{-- Subcopy --}}
        @isset($actionText)
            <x-slot:subcopy>
                @lang(
                    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
                    'into your web browser:',
                    ['actionText' => $actionText]
                )
                <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
            </x-slot:subcopy>
        @endisset
    </x-mail::message>

    {{-- Footer --}}
    <x-slot:footer>
        <div style="text-align:center; padding:20px; font-size:12px; color:#999;">
            © {{ date('Y') }} SD-prime Pharmacy. All rights reserved.
        </div>
    </x-slot:footer>
</x-mail::layout>
