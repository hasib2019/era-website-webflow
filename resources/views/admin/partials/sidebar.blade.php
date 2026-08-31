<aside data-sidebar
    class="fixed inset-y-0 left-0 z-30 hidden h-full w-64 shrink-0 flex-col overflow-hidden border-r border-slate-200 bg-white lg:static lg:flex">
    <div class="flex h-16 shrink-0 items-center gap-2.5 border-b border-slate-200 px-5">
        <img src="{{ asset('storage/media/webflow/668c2e6e687f356e879426a1_Logo-black.svg') }}" alt="" class="h-7 w-auto">
        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Admin</span>
    </div>

    <nav class="min-h-0 flex-1 space-y-6 overflow-y-auto overscroll-contain px-3 py-5">
        @foreach (config('admin_nav') as $group => $links)
            @php
                $visible = array_filter($links, fn ($l) => auth()->user()->hasPermission($l['permission']));
            @endphp

            @if ($visible)
                <div>
                    <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ $group }}</p>
                    <ul class="space-y-0.5">
                        @foreach ($visible as $link)
                            @php
                                $family = str_replace(['.index', '.edit'], '.*', $link['route']);
                                $active = request()->routeIs($family) || request()->routeIs($link['route']);
                            @endphp
                            <li>
                                <a href="{{ route($link['route']) }}"
                                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ $active ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <span class="{{ $active ? 'text-brand-600' : 'text-slate-400' }}">
                                        @include('admin.partials.icon', ['name' => $link['icon'], 'class' => 'h-5 w-5 shrink-0'])
                                    </span>
                                    <span class="truncate">{{ $link['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </nav>
</aside>
