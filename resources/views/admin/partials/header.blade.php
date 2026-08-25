<header class="admin-topbar fixed left-0 right-0 top-0 z-20 h-16 bg-[#24448d] text-white shadow lg:left-[296px]">
    <div class="admin-topbar-inner flex h-full items-center gap-4 px-4">
        {{-- Sidebar Toggle Button --}}
        <button type="button" id="sidebarToggleBtn" class="text-2xl leading-none text-white transition hover:opacity-80 focus:outline-none" aria-label="Toggle menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        {{-- System / App Brand Name --}}
        <a href="{{ route('admin.dashboard', absolute: false) }}" class="admin-brand flex h-9 min-w-[260px] items-center rounded-tl-full rounded-tr-2xl bg-[#3f70c9] px-5 text-xl font-bold tracking-wide text-white no-underline shadow-inner">
            TNT SOL
        </a>

        {{-- Top Navigation Search Bar (Exact Pill Style) --}}
        <form class="admin-search-wrapper mx-auto hidden w-full max-w-[440px] items-center md:flex" action="{{ route('admin.adm.students.index', absolute: false) }}" method="GET">
            <div class="search-pill-container flex h-9 w-full items-center overflow-hidden rounded-full bg-white shadow-sm">
                <input
                    type="text"
                    name="search"
                    class="search-pill-input min-w-0 flex-1 border-0 bg-transparent px-4 text-[13.5px] text-neutral-700 outline-none placeholder:text-neutral-400"
                    placeholder="Search By Admit No, Name, Father Name..."
                    autocomplete="off"
                />
                <button
                    type="submit"
                    class="search-pill-btn flex h-full w-12 items-center justify-center bg-[#2F5DA8] text-sm text-white transition hover:bg-[#254c8c]"
                    aria-label="Search"
                >
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>

        {{-- Right Side Topbar Widgets & Icons --}}
        <div class="admin-topbar-icons ml-auto flex items-center gap-4 text-xl">
            {{-- Mobile / Device Icon Button --}}
            <a
                href="{{ route('admin.academics.homework.index', absolute: false) }}"
                class="branch-header-btn flex h-8 w-8 items-center justify-center rounded bg-white text-base text-[#24448d] shadow-sm transition hover:bg-slate-100"
                title="Homework App"
            >
                <i class="fa-solid fa-mobile-screen"></i>
            </a>

            <a href="{{ route('admin.system-notification.index', absolute: false) }}" class="text-white hover:text-amber-300 transition" title="Notifications">
                <i class="fa-regular fa-bell"></i>
            </a>
            <a href="{{ route('admin.adm.chat.index', absolute: false) }}" class="text-white hover:text-amber-300 transition" title="Messages">
                <i class="fa-regular fa-comment"></i>
            </a>
            <a href="{{ route('admin.adm.calendar.index', absolute: false) }}" class="text-white hover:text-amber-300 transition" title="Calendar">
                <i class="fa-regular fa-calendar-days"></i>
            </a>
            <a href="{{ route('admin.adm.leave-requests.index', absolute: false) }}" class="relative text-white hover:text-amber-300 transition" title="Tasks">
                <i class="fa-regular fa-square-check"></i>
                <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-orange-500 text-[10px] font-bold text-white">1</span>
            </a>
            <a href="{{ route('admin.adm.achievements.index', absolute: false) }}" class="text-white hover:text-amber-300 transition" title="Birthdays / Events">
                <i class="fa-solid fa-cake-candles"></i>
            </a>
            <a href="{{ route('profile.edit', absolute: false) }}" class="flex h-8 w-8 items-center justify-center rounded-full border border-white/40 bg-white/90 text-sm text-slate-500 transition hover:bg-white" title="Profile">
                <i class="fa-regular fa-user"></i>
            </a>
        </div>
    </div>
</header>
