<header>
    <div>
        <span class="site-title">
            Web AIアドバイザー
        </span>
    </div>
    <div class="header-menu">
        <div>
            <form action="{{ route('clearSession') }}">
                @csrf
                <button type="submit">セッションクリア</button>
            </form>
        </div>
        <div class="header-separater"> | </div>
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
        </div>
    </div>
</header>