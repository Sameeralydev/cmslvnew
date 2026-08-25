<header class="admin-topbar fixed left-0 right-0 top-0 z-20 h-16 bg-[#24448d] text-white shadow lg:left-[240px]">
    <div class="admin-topbar-inner flex h-full items-center gap-4 px-4">
        <button type="button" class="text-2xl leading-none" aria-label="Toggle menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        <a href="{{ route('admin.dashboard', absolute: false) }}" class="admin-brand flex h-9 min-w-[340px] items-center rounded-tl-full rounded-tr-2xl bg-[#3f70c9] px-5 text-2xl font-bold tracking-wide shadow-inner">
            TNT SOL
        </a>

        <form class="admin-search mx-auto hidden w-full max-w-[420px] items-center overflow-hidden rounded-full bg-white text-neutral-700 shadow-sm md:flex">
            <input class="min-w-0 flex-1 border-0 px-4 py-2 text-base outline-none" placeholder="Search By Admit No, Name, Father Name..." type="search">
            <button class="flex h-11 w-14 items-center justify-center bg-[#3f70c9] text-xl text-white" type="submit" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <div class="admin-topbar-icons ml-auto flex items-center gap-5 text-2xl">
            <button type="button" class="admin-header-action" data-header-menu="calculator" aria-label="Calculator" title="Calculator"><i class="fa-solid fa-calculator"></i></button>
            <button type="button" class="admin-header-action" data-header-menu="notifications" aria-label="Notifications" title="Notifications"><i class="fa-regular fa-bell"></i></button>
            <button type="button" class="admin-header-action" data-header-menu="messages" aria-label="Messages" title="Messages"><i class="fa-regular fa-comment"></i></button>
            <button type="button" class="admin-header-action" data-header-menu="calendar" aria-label="Calendar" title="Calendar"><i class="fa-regular fa-calendar-days"></i></button>
            <button type="button" class="admin-header-action relative" data-header-menu="tasks" aria-label="Tasks" title="Tasks">
                <i class="fa-regular fa-square-check"></i>
                <span class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-orange-500 text-xs font-bold">1</span>
            </button>
            <button type="button" class="admin-header-action" data-header-menu="birthdays" aria-label="Birthdays" title="Birthdays"><i class="fa-solid fa-cake-candles"></i></button>
            <button type="button" class="admin-header-action admin-profile-action" data-header-menu="profile" aria-label="Profile" title="Profile">
                <i class="fa-regular fa-user"></i>
            </button>
        </div>
    </div>
    <div id="admin-header-popover" class="admin-header-popover" hidden></div>
</header>
