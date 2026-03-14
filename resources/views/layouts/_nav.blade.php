{{--
    Top navigation bar.
    Shown on all authenticated pages via the app layout.
    Uses responsive hamburger for mobile (CSS peer trick + minimal inline JS for aria-expanded only).
--}}
<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between h-14">

            {{-- Brand / logo --}}
            <a href="{{ route('home') }}" class="font-bold text-indigo-600 text-lg tracking-tight">
                GroundedTime
            </a>

            {{-- Desktop menu --}}
            <div class="hidden md:flex items-center gap-4 text-sm font-medium text-gray-600">
                @auth
                    <a href="{{ route('restrictions.index') }}" class="hover:text-indigo-600 transition-colors">
                        {{ __('messages.nav.restrictions') }}
                    </a>
                    <a href="{{ route('children.index') }}" class="hover:text-indigo-600 transition-colors">
                        {{ __('messages.nav.children') }}
                    </a>
                    <a href="{{ route('family.show') }}" class="hover:text-indigo-600 transition-colors">
                        {{ __('messages.nav.family') }}
                    </a>
                    <a href="{{ route('settings.index') }}" class="hover:text-indigo-600 transition-colors">
                        {{ __('messages.nav.settings') }}
                    </a>
                    {{-- Logout form (POST for CSRF protection) --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-600 transition-colors">
                            {{ __('messages.nav.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-indigo-600 transition-colors">
                        {{ __('messages.nav.login') }}
                    </a>
                    <a href="{{ route('register') }}" class="hover:text-indigo-600 transition-colors">
                        {{ __('messages.nav.register') }}
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger (checkbox-driven, zero JS) --}}
            <label for="mobile-menu-toggle"
                   class="md:hidden cursor-pointer p-2 rounded hover:bg-gray-100"
                   aria-label="Toggle mobile menu"
                   aria-controls="mobile-menu"
                   aria-expanded="false">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </label>
        </div>

        {{-- Mobile menu (hidden by default, toggled via CSS peer trick) --}}
        <input type="checkbox" id="mobile-menu-toggle" class="hidden peer">
        <div id="mobile-menu" class="md:hidden hidden peer-checked:block pb-3 text-sm font-medium text-gray-600 space-y-2">
            @auth
                <a href="{{ route('restrictions.index') }}" class="block py-1 hover:text-indigo-600">
                    {{ __('messages.nav.restrictions') }}
                </a>
                <a href="{{ route('children.index') }}" class="block py-1 hover:text-indigo-600">
                    {{ __('messages.nav.children') }}
                </a>
                <a href="{{ route('family.show') }}" class="block py-1 hover:text-indigo-600">
                    {{ __('messages.nav.family') }}
                </a>
                <a href="{{ route('settings.index') }}" class="block py-1 hover:text-indigo-600">
                    {{ __('messages.nav.settings') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block py-1 hover:text-red-600">
                        {{ __('messages.nav.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-1 hover:text-indigo-600">
                    {{ __('messages.nav.login') }}
                </a>
                <a href="{{ route('register') }}" class="block py-1 hover:text-indigo-600">
                    {{ __('messages.nav.register') }}
                </a>
            @endauth
        </div>
    </div>
</nav>

{{--
    Keep aria-expanded in sync with the checkbox state.
    The CSS peer trick handles visual toggling; this single listener
    keeps the accessible state accurate for screen readers.
--}}
<script>
(function () {
    var toggle = document.getElementById('mobile-menu-toggle');
    var label  = document.querySelector('label[for="mobile-menu-toggle"]');
    if (!toggle || !label) { return; }
    toggle.addEventListener('change', function () {
        label.setAttribute('aria-expanded', toggle.checked ? 'true' : 'false');
    });
}());
</script>
